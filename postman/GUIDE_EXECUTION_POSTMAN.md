# Guide d'execution Postman - projet_backend

Ce guide explique l'ordre exact pour tester les API du projet avec la collection Postman.

## 1) Prerequis

1. Avoir importe ces deux fichiers:
- `postman/projet_backend.postman_collection.json`
- `postman/projet_backend.postman_environment.json`

2. Selectionner l'environnement **projet_backend local** dans Postman.

3. Verifier la variable `base_url` dans l'environnement:
- valeur conseillee: `http://127.0.0.1:8000/api`

4. Lancer l'API localement (quand l'environnement PHP est compatible).

## 2) Ordre d'execution recommande

Suivre cet ordre pour que les variables (`token`, `offre_id`, `profil_id`, `candidature_id`) se remplissent automatiquement.

### Etape A - Authentification

1. **Auth / Login**
- Requete: `POST {{base_url}}/login`
- Body exemple:
```json
{
  "email": "test@example.com",
  "password": "password"
}
```
- Attendu: `200`
- Resultat: la variable `token` est enregistree automatiquement.

2. **Auth / Me**
- Requete: `GET {{base_url}}/me`
- Header: `Authorization: Bearer {{token}}`
- Attendu: `200` + utilisateur courant.

### Etape B - Offres publiques

3. **Offres publiques / Lister les offres**
- Requete: `GET {{base_url}}/offres`
- Attendu: `200`

4. **Offres publiques / Details d'une offre**
- Requete: `GET {{base_url}}/offres/{{offre_id}}`
- Attendu: `200` si `offre_id` existe.

### Etape C - Profil utilisateur

5. **Profil / Creer mon profil**
- Requete: `POST {{base_url}}/profil`
- Header: `Authorization: Bearer {{token}}`
- Body exemple:
```json
{
  "titre": "Developpeur Backend",
  "bio": "Profil de test",
  "localisation": "Casablanca",
  "disponible": true
}
```
- Attendu: `201` (ou `422` si deja cree)
- Resultat: `profil_id` est mis a jour automatiquement si creation.

6. **Profil / Voir mon profil**
- Requete: `GET {{base_url}}/profil`
- Attendu: `200`

7. **Profil / Mettre a jour mon profil**
- Requete: `PUT {{base_url}}/profil`
- Attendu: `200`

8. **Profil / Ajouter une competence au profil**
- Requete: `POST {{base_url}}/profil/competences`
- Body exemple:
```json
{
  "competence_id": {{competence_id}},
  "niveau": "expert"
}
```
- Attendu: `200` si la competence existe.

9. **Profil / Retirer une competence du profil**
- Requete: `DELETE {{base_url}}/profil/competences/{{competence_id}}`
- Attendu: `200`

### Etape D - Offres protegees

10. **Offres protegees / Creer une offre**
- Requete: `POST {{base_url}}/offres`
- Header: `Authorization: Bearer {{token}}`
- Body exemple:
```json
{
  "titre": "Developpeur Laravel",
  "description": "Offre de test via Postman",
  "localisation": "Paris",
  "type": "CDI"
}
```
- Attendu: `201`
- Resultat: `offre_id` est mis a jour automatiquement.

11. **Offres protegees / Mettre a jour une offre**
- Requete: `PUT {{base_url}}/offres/{{offre_id}}`
- Attendu: `200` si proprietaire, sinon `403`.

12. **Offres protegees / Supprimer une offre**
- Requete: `DELETE {{base_url}}/offres/{{offre_id}}`
- Attendu: `200` si proprietaire, sinon `403`.

### Etape E - Candidatures

13. **Candidatures / Postuler a une offre**
- Requete: `POST {{base_url}}/offres/{{offre_id}}/candidater`
- Header: `Authorization: Bearer {{token}}`
- Body exemple:
```json
{
  "message": "Je souhaite rejoindre votre equipe.",
  "profil_id": {{profil_id}}
}
```
- Attendu: `201`
- Resultat: `candidature_id` est mis a jour automatiquement.

14. **Candidatures / Changer le statut d'une candidature**
- Requete: `PATCH {{base_url}}/candidatures/{{candidature_id}}/statut`
- Body exemple:
```json
{
  "statut": "acceptee"
}
```
- Attendu: `200` si autorise, sinon `403`.

15. **Candidatures / Lister les candidatures d'une offre**
- Requete: `GET {{base_url}}/offres/{{offre_id}}/candidatures`

16. **Candidatures / Mes candidatures**
- Requete: `GET {{base_url}}/mes-candidatures`

### Etape F - Admin

17. **Admin / Lister les utilisateurs**
- Requete: `GET {{base_url}}/admin/users`
- Header: `Authorization: Bearer {{token}}`
- Attendu: `200` avec compte admin, sinon `403`.

## 3) Cas d'erreur utiles a verifier

1. Sans token sur route protegee -> `401`.
2. Token invalide/expire -> `401`.
3. Mettre a jour/supprimer offre d'un autre utilisateur -> `403`.
4. `type` offre hors liste (`CDI`, `CDD`, `stage`) -> `422`.
5. `statut` candidature hors liste (`en_attente`, `acceptee`, `refusee`) -> `422`.

## 4) Limitations actuelles du projet a connaitre

1. Le projet demande PHP `^8.3` (si PHP local < 8.3, l'application ne demarre pas correctement).
2. Certaines routes candidatures sont declarees mais leurs methodes ne sont pas encore implementees dans le controleur.
3. La route admin depend d'un middleware role/admin qui semble incomplet dans l'etat actuel.

## 5) Conseils pratiques

1. Commencer toujours par **Login** pour regenerer `token`.
2. Si une variable est vide (`offre_id`, `profil_id`, `candidature_id`), relancer la requete de creation correspondante.
3. Ouvrir la console Postman en cas d'erreur pour voir le JSON de retour complet.
