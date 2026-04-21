# Documentation API - Mini-LinkedIn

Documentation complete des endpoints exposes par l'API Laravel.

## Base URL

- Locale: `http://127.0.0.1:8000/api`

## Authentification

Les routes protegees necessitent ce header:

```http
Authorization: Bearer {token}
```

## Roles et controle d'acces

- `candidat`: gestion profil, postulation, suivi des candidatures personnelles
- `recruteur`: gestion des offres dont il est proprietaire, gestion des candidatures recues
- `admin`: gestion globale des utilisateurs et moderation des offres

## Format des reponses d'erreur

Exemples courants:

- `401 Unauthenticated`: token manquant, invalide ou expire
- `403 Forbidden`: role insuffisant ou action non autorisee
- `422 Unprocessable Entity`: erreur de validation des donnees
- `404 Not Found`: ressource introuvable

## Endpoints

## 1) Authentification (Public + protege)

### POST /register
Cree un compte candidat ou recruteur.

Body:

```json
{
  "name": "recruiter",
  "email": "recruteur@ensam.casa",
  "password": "secret",
  "role": "recruteur"
}
```

Reponse `201`:

```json
{
  "token": "eyJ...",
  "user": {
    "id": 30,
    "name": "recruteur",
    "email": "recruteur@ensam.casa",
    "role": "recruteur"
  }
}
```

Validation importante:

- `role` autorise: `candidat` ou `recruteur`

### POST /login
Connecte un utilisateur.

Body:

```json
{
  "email": "recruteur@ensam.casa",
  "password": "secret"
}
```

Reponse `200`: token JWT + donnees utilisateur.

### POST /logout (auth)
Invalide le token (blacklist JWT).

Reponse `200`:

```json
{
  "message": "Deconnexion reussie"
}
```

### GET /me (auth)
Retourne les informations de l'utilisateur connecte.

Reponse `200`: objet utilisateur.

## 2) Profil (Candidat uniquement)

### POST /profil
Cree le profil du candidat.

Body:

```json
{
  "titre": "Developpeur Full Stack",
  "bio": "Passionne par le developpement et la resolution de problemes",
  "localisation": "Casablanca",
  "disponible": true
}
```

Reponse `201`: profil cree.

### GET /profil
Recupere le profil du candidat connecte avec ses competences.

Reponse `200`: profil + relation `competences`.

### PUT /profil
Met a jour partiellement le profil.

Body exemple:

```json
{
  "titre": "Tech Lead",
  "localisation": "Rabat",
  "disponible": false
}
```

Reponse `200`: profil mis a jour.

### POST /profil/competences
Ajoute une competence au profil.

Body:

```json
{
  "competence_id": 1,
  "niveau": "expert"
}
```

Niveaux autorises:

- `debutant`
- `intermediaire`
- `expert`

Reponse `200`:

```json
{
  "message": "Competences ajoutees"
}
```

### DELETE /profil/competences/{competence}
Retire une competence du profil.

Reponse `200`: confirmation de suppression.

Erreur metier possible:

- `404`: competence non associee au profil

## 3) Offres d'emploi

### GET /offres (public)
Liste paginee des offres actives.

Parametres de requete supportes:

- `localisation`
- `type` (`CDI`, `CDD`, `stage`)
- `page`

Exemple:

```http
GET /offres?localisation=Casablanca&type=CDI&page=2
```

Reponse `200`: liste paginee (10 offres/page), triee par date decroissante.

### GET /offres/{offre} (public)
Recupere le detail d'une offre.

Reponse `200`: objet offre.

### POST /offres (recruteur)
Cree une nouvelle offre.

Body:

```json
{
  "titre": "Developpeur Backend Laravel",
  "description": "Mission de 6 mois...",
  "localisation": "Casablanca",
  "type": "CDI"
}
```

Reponse `201`: offre creee (avec `actif: true`).

### PUT /offres/{offre} (recruteur proprietaire)
Met a jour une offre appartenant au recruteur connecte.

Body exemple:

```json
{
  "titre": "Developpeur Backend",
  "type": "CDD"
}
```

Reponse `200`: offre mise a jour.

### DELETE /offres/{offre} (recruteur proprietaire)
Supprime une offre appartenant au recruteur connecte.

Reponse `200`: confirmation de suppression.

Erreurs metier frequentes:

- `403`: offre non possedee par le recruteur
- `422`: donnees invalides (ex: type incorrect)

## 4) Candidatures

### POST /offres/{offre}/candidater (candidat)
Postule a une offre.

Body:

```json
{
  "message": "Je suis interessee"
}
```

Reponse `201`:

```json
{
  "offre_id": 6,
  "profil_id": 4,
  "message": "Je suis interessee",
  "statut": "en_attente",
  "id": 3
}
```

Regle metier:

- un candidat ne peut pas postuler 2 fois a la meme offre (`422`)

### GET /mes-candidatures (candidat)
Liste les candidatures du candidat connecte avec details des offres.

Reponse `200`: collection des candidatures.

### GET /offres/{offre}/candidatures (recruteur proprietaire)
Liste les candidatures recues pour une offre du recruteur.

Reponse `200`: collection des candidatures de l'offre.

Erreur metier possible:

- `403`: offre non possedee par le recruteur

### PATCH /candidatures/{candidature}/statut (recruteur proprietaire)
Change le statut d'une candidature.

Body:

```json
{
  "statut": "acceptee"
}
```

Valeurs possibles pour `statut`:

- `en_attente`
- `acceptee`
- `refusee`

Reponse `200`: candidature mise a jour.

Erreur metier possible:

- `403`: recruteur non autorise a modifier cette candidature

## 5) Administration (Admin uniquement)

### GET /admin/users
Liste paginee de tous les utilisateurs.

Reponse `200`: pagination (20 utilisateurs/page).

### DELETE /admin/users/{user}
Supprime un utilisateur.

Reponse `200`: confirmation de suppression.

### PATCH /admin/offres/{offre}
Active/desactive une offre (toggle).

Reponse `200`:

```json
{
  "message": "Offre desactivee.",
  "offre": {
    "id": 6,
    "actif": false
  }
}
```

## Recapitulatif rapide des routes

### Public

- `POST /register`
- `POST /login`
- `GET /offres`
- `GET /offres/{offre}`

### Authentifie (tous roles)

- `POST /logout`
- `GET /me`

### Candidat

- `POST /profil`
- `GET /profil`
- `PUT /profil`
- `POST /profil/competences`
- `DELETE /profil/competences/{competence}`
- `POST /offres/{offre}/candidater`
- `GET /mes-candidatures`

### Recruteur

- `POST /offres`
- `PUT /offres/{offre}`
- `DELETE /offres/{offre}`
- `GET /offres/{offre}/candidatures`
- `PATCH /candidatures/{candidature}/statut`

### Admin

- `GET /admin/users`
- `DELETE /admin/users/{user}`
- `PATCH /admin/offres/{offre}`

## Collection Postman

Collection de tests disponible dans:

- `postman/Projet_backend.postman_collection_final.json`

Configuration recommandee dans Postman:

1. Creer une variable d'environnement `token`
2. Executer `POST /login`
3. Stocker automatiquement le token:

```javascript
const res = pm.response.json();
if (res.token) pm.environment.set("token", res.token);
```

4. Pour les routes protegees, utiliser `Bearer {{token}}`

## Notes techniques

- Auth basee sur JWT (`php-open-source-saver/jwt-auth`)
- Middleware utilise:
  - `auth:api`
  - `role:candidat`
  - `role:recruteur`
  - `role:admin`
- Les logs metier des candidatures sont ecrits dans `storage/logs/candidatures.log` via Events & Listeners
