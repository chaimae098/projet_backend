<div align="center">

# Mini-LinkedIn API

**Plateforme de recrutement · Laravel 11 · JWT Auth**

**Documentation API:** [Consulter la documentation complete](./API_DOCUMENTATION.md)

[![Laravel](https://img.shields.io/badge/Laravel-11-FF2D20?style=flat-square&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=flat-square&logo=php&logoColor=white)](https://php.net)
[![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=flat-square&logo=mysql&logoColor=white)](https://mysql.com)
[![JWT](https://img.shields.io/badge/JWT-Auth-000000?style=flat-square&logo=jsonwebtokens&logoColor=white)](https://github.com/php-open-source-saver/jwt-auth)
[![Postman](https://img.shields.io/badge/Postman-Collection-FF6C37?style=flat-square&logo=postman&logoColor=white)](./postman)

**Réalisé par :**

| Nom | Établissement |
|-----|--------------|
| **Kazoury Chaimae** | ENSAM Casablanca — Génie Informatique & IA |
| **Benlakhbaizi Lina** | ENSAM Casablanca — Génie Informatique & IA |
| **Lagdem Fatima-Ezzahra** | ENSAM Casablanca — Génie Informatique & IA |

*Projet réalisé dans le cadre du module **Technologies Backend — Framework Laravel***

</div>

---

## À propos du projet

Une API REST complète simulant une plateforme de recrutement de type **Mini-LinkedIn**. Elle met en relation des **candidats** et des **recruteurs**, supervisés par un **administrateur**. Le projet mobilise l'ensemble des concepts du cours : modélisation Eloquent, authentification JWT, autorisation par rôles, et le système d'**Events & Listeners** pour le découplage de la logique applicative.

### Fonctionnalités principales

- **Authentification robuste** — JWT (JSON Web Tokens), blacklist au logout, TTL configurable
- **Système de rôles** — Accès différencié pour `candidat`, `recruteur` et `admin`
- **Gestion de profils** — Profils enrichis avec compétences et niveaux (`débutant`, `intermédiaire`, `expert`)
- **Job Board** — Création, modification, pagination et filtrage avancé des offres d'emploi
- **Workflow de candidature** — Postulation, suivi de statut (`en_attente`, `acceptee`, `refusee`)
- **Architecture événementielle** — Events & Listeners pour le logging des activités critiques
- **Administration** — Modération des utilisateurs et activation/désactivation des offres

---

## Stack Technique

**Backend & API**
![Laravel](https://img.shields.io/badge/Laravel-11-FF2D20?style=flat-square&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=flat-square&logo=php&logoColor=white)
![JWT](https://img.shields.io/badge/JWT--Auth-000000?style=flat-square&logo=jsonwebtokens&logoColor=white)

**Base de données & ORM**
![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=flat-square&logo=mysql&logoColor=white)
![Eloquent](https://img.shields.io/badge/Eloquent_ORM-FF2D20?style=flat-square&logo=laravel&logoColor=white)

**Outils**
![Postman](https://img.shields.io/badge/Postman-FF6C37?style=flat-square&logo=postman&logoColor=white)
![Git](https://img.shields.io/badge/Git-F05032?style=flat-square&logo=git&logoColor=white)
![Composer](https://img.shields.io/badge/Composer-885630?style=flat-square&logo=composer&logoColor=white)

---

## Prérequis

- PHP >= 8.3
- Composer
- MySQL >= 8.0
- Extensions PHP : `openssl`, `pdo`, `mbstring`, `tokenizer`, `xml`, `ctype`, `json`

---

## Installation

**1. Cloner le dépôt**
```bash
git clone https://github.com/votre-username/projet_backend.git
cd projet_backend
```

**2. Installer les dépendances**
```bash
composer install
```

**3. Configurer l'environnement**
```bash
cp .env.example .env
# Renseigner DB_DATABASE, DB_USERNAME, DB_PASSWORD dans .env
php artisan key:generate
php artisan jwt:secret
```

**4. Publier la configuration JWT**
```bash
php artisan vendor:publish --provider="PHPOpenSourceSaver\JWTAuth\Providers\LaravelServiceProvider"
```

**5. Migrations et Seeders**
```bash
# Crée 2 admins, 5 recruteurs (2-3 offres chacun), 10 candidats avec profils et compétences
php artisan migrate:fresh --seed
```

**6. Lancer le serveur**
```bash
php artisan serve
# API disponible sur http://127.0.0.1:8000/api
```

---

## Structure du projet

```
mini-linkedin-api/
│
├── app/
│   ├── Events/
│   │   ├── CandidatureDeposee.php          # Déclenché à la postulation
│   │   └── StatutCandidatureMis.php        # Déclenché au changement de statut
│   │
│   ├── Listeners/
│   │   ├── LogCandidatureDeposee.php       # Écrit dans candidatures.log
│   │   └── LogStatutCandidatureMis.php     # Écrit dans candidatures.log
│   │
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AuthController.php          # register, login, logout, me
│   │   │   ├── ProfilController.php        # CRUD profil + compétences
│   │   │   ├── OffreController.php         # CRUD offres + filtres
│   │   │   ├── CandidatureController.php   # Postulation + statut
│   │   │   └── AdminController.php         # Gestion users & offres
│   │   │
│   │   └── Middleware/
│   │       └── RoleMiddleware.php          # Contrôle d'accès par rôle
│   │
│   └── Models/
│       ├── User.php
│       ├── Profil.php
│       ├── Competence.php
│       ├── Offre.php
│       └── Candidature.php
│
├── database/
│   ├── migrations/                         # Toutes les migrations de tables
│   ├── factories/                          # Factories pour les tests
│   └── seeders/
│       ├── DatabaseSeeder.php
│       ├── CompetenceSeeder.php
│       ├── UserSeeder.php
│       └── OffreSeeder.php
│
├── routes/
│   └── api.php                             # Toutes les routes de l'API
│
├── storage/
│   └── logs/
│       ├── laravel.log
│       └── candidatures.log                # ← Généré par les Events & Listeners
│
├── postman/
│   └── Projet_backend.postman_collection_final.json   # ← Collection de tests Postman
│
├── .env.example
└── README.md
```

---

## Commandes utiles

```bash
# Réinitialiser la base de données et relancer les seeders
php artisan migrate:fresh --seed

# Exécuter uniquement le seeder des compétences
php artisan db:seed --class=CompetenceSeeder

# Vider le cache de configuration
php artisan config:clear && php artisan cache:clear

# Lister toutes les routes enregistrées
php artisan route:list

# Vérifier les compétences disponibles (IDs pour Postman)
php artisan tinker
>>> App\Models\Competence::all()->pluck('nom', 'id');

# Trouver le propriétaire d'une offre
>>> App\Models\User::find(App\Models\Offre::find(1)->user_id)->email;

# Obtenir les emails des admins
>>> App\Models\User::where('role','admin')->pluck('email');

# Tester manuellement un Event
>>> event(new App\Events\CandidatureDeposee(App\Models\Candidature::first()));

# Surveiller le fichier de log en temps réel
tail -f storage/logs/candidatures.log
```

---

## Données de test (après --seed)

| Rôle | Quantité | Password |
|------|----------|----------|
| Admin | 2 | `password` |
| Recruteur | 5 | `password` |
| Candidat | 10 | `password` |

Chaque recruteur possède 2 à 3 offres. Chaque candidat a un profil complet avec des compétences.

---

## Documentation de l'API

> Toutes les routes protégées nécessitent le header : `Authorization: Bearer {token}`

### Authentification — Public

| Méthode | Endpoint | Description | Body requis |
|---------|----------|-------------|-------------|
| `POST` | `/api/register` | Créer un compte | `name`, `email`, `password`, `role` (`candidat` ou `recruteur`) |
| `POST` | `/api/login` | Connexion | `email`, `password` |
| `POST` | `/api/logout` | Déconnexion (token blacklisté) | — |
| `GET` | `/api/me` | Utilisateur connecté | — |

**Exemple register :**
```json
POST /api/register
{
  "name": "recruiter",
  "email": "recruteur@ensam.casa",
  "password": "secret",
  "role": "recruteur"
}
```
**Réponse 201 :**
```json
{
  "token": "eyJ...",
  "user": {
    "name": "recruteur",
    "email": "recruteur@ensam.casa",
    "role": "recruteur",
    "id": 30
  }
}
```

**Erreurs couvertes par les tests :**

| Test | Scénario | Code attendu |
|------|----------|-------------|
| `error_register` | Champs manquants (name, email, password, role) | `422` |
| `register_admin` | Tentative d'inscription avec `role: admin` | `422` — rôle invalide |
| `error_login_candidat` | Mot de passe incorrect | `401 Unauthorized` |

---

### Profil — Candidat uniquement

| Méthode | Endpoint | Description | Body requis |
|---------|----------|-------------|-------------|
| `POST` | `/api/profil` | Créer son profil (une seule fois) | `titre`, `bio`, `localisation`, `disponible` |
| `GET` | `/api/profil` | Consulter son profil avec compétences | — |
| `PUT` | `/api/profil` | Modifier ses informations | champs à modifier |
| `POST` | `/api/profil/competences` | Ajouter une compétence | `competence_id`, `niveau` |
| `DELETE` | `/api/profil/competences/{id}` | Retirer une compétence | — |

**Niveaux acceptés :** `débutant`, `intermédiaire`, `expert`

**Exemple créer profil :**
```json
POST /api/profil
{
  "titre": "Developpeur Full Stack",
  "bio": "passionne par le developpement et la resolution",
  "localisation": "Casablanca",
  "disponible": true
}
```
**Réponse 201 :**
```json
{
  "titre": "Developpeur Full Stack",
  "bio": "passionne par le developpement et la resolution",
  "localisation": "Casablanca",
  "disponible": true,
  "user_id": 29,
  "id": 4
}
```

**Exemple modifier profil :**
```json
PUT /api/profil
{
  "titre": "leader",
  "localisation": "rabat",
  "disponible": false
}
```

**Exemple ajouter compétence :**
```json
POST /api/profil/competences
{ "competence_id": 1, "niveau": "expert" }
```
**Réponse 200 :** `{ "message": "Compétences ajoutées" }`

**Erreurs couvertes par les tests :**

| Test | Scénario | Code attendu |
|------|----------|-------------|
| `error_profil_candidat` | Token recruteur utilisé sur route candidat | `403` — "Accès refusé. Rôle requis : candidat" |
| `error_profil_competences` | Niveau invalide (`"not mentionned"`) | `422` — "The selected niveau is invalid." |
| `error_competences` | Suppression d'une compétence inexistante (id: 99) | `404` — "Cette compétence ne figure pas sur votre profil." |

---

### Offres d'emploi

| Méthode | Endpoint | Auth | Description |
|---------|----------|------|-------------|
| `GET` | `/api/offres` | Public | Liste paginée des offres actives (10/page) |
| `GET` | `/api/offres/{id}` | Public | Détail d'une offre |
| `POST` | `/api/offres` | Recruteur | Créer une offre |
| `PUT` | `/api/offres/{id}` | Recruteur (owner) | Modifier son offre |
| `DELETE` | `/api/offres/{id}` | Recruteur (owner) | Supprimer son offre |

**Filtres et pagination sur GET /api/offres :**
```
GET /api/offres?localisation=Casablanca&type=CDI&page=2
```
> 10 offres par page — triées par `created_at` décroissant.  
> `type` accepte : `CDI`, `CDD`, `stage`

**Exemple créer offre :**
```json
POST /api/offres
{
  "titre": "dev",
  "description": "mission de 6 mois ..",
  "localisation": "casablanca",
  "type": "CDI"
}
```
**Réponse 201 :**
```json
{
  "titre": "dev",
  "description": "mission de 6 mois ..",
  "localisation": "casablanca",
  "type": "CDI",
  "user_id": 30,
  "actif": true,
  "id": 5
}
```

**Exemple modifier offre :**
```json
PUT /api/offres/5
{ "titre": "dev", "type": "CDD" }
```

**Erreurs couvertes par les tests :**

| Test | Scénario | Code attendu |
|------|----------|-------------|
| `error_offres` | Token candidat utilisé pour créer une offre | `403` — "Accès refusé. Rôle requis : recruteur" |
| `invalid_offre` | Type invalide (`"nothing"`) ou token expiré | `401 Unauthenticated` |
| `error_offresput` | Modification d'une offre appartenant à un autre recruteur | `403` — "Action interdite : vous n'êtes pas le propriétaire." |
| `error_delete_offres` | Suppression d'une offre appartenant à un autre recruteur | `403` — "Action interdite." |

---

### Candidatures

| Méthode | Endpoint | Auth | Description |
|---------|----------|------|-------------|
| `POST` | `/api/offres/{id}/candidater` | Candidat | Postuler à une offre |
| `GET` | `/api/mes-candidatures` | Candidat | Ses propres candidatures avec détail des offres |
| `GET` | `/api/offres/{id}/candidatures` | Recruteur (owner) | Candidatures reçues pour son offre |
| `PATCH` | `/api/candidatures/{id}/statut` | Recruteur (owner) | Changer le statut d'une candidature |

**Exemple postuler :**
```json
POST /api/offres/6/candidater
{ "message": "Je suis intéréssée" }
```
**Réponse 201 :**
```json
{
  "offre_id": 6,
  "profil_id": 4,
  "message": "Je suis intéréssée",
  "statut": "en_attente",
  "id": 3
}
```

**Exemple changer statut :**
```json
PATCH /api/candidatures/3/statut
{ "statut": "acceptee" }
```
> `statut` accepte : `en_attente`, `acceptee`, `refusee`

**Erreurs couvertes par les tests :**

| Test | Scénario | Code attendu |
|------|----------|-------------|
| `error_candidature` | Postuler deux fois à la même offre | `422` — "Vous avez déjà postulé à cette offre." |
| `error_candidatureid` | Recruteur consultant les candidatures d'une offre qui ne lui appartient pas | `403` — "Action non autorisee" |
| `error_candidaturestatut` | Recruteur non-propriétaire changeant le statut | `403` — "Action non autorisée" |

---

### Administration — Admin uniquement

| Méthode | Endpoint | Description |
|---------|----------|-------------|
| `GET` | `/api/admin/users` | Liste complète paginée de tous les utilisateurs (20/page) |
| `DELETE` | `/api/admin/users/{id}` | Supprimer un compte utilisateur |
| `PATCH` | `/api/admin/offres/{id}` | Activer / désactiver une offre (toggle) |

**Exemple liste utilisateurs — Réponse 200 :**
```json
{
  "current_page": 1,
  "data": [
    { "id": 30, "name": "recruteur", "email": "recruteur@ensam.casa", "role": "recruteur" },
    { "id": 29, "name": "Chaimae", "email": "chaimae@ensam.casa", "role": "candidat" }
  ],
  "total": 30,
  "last_page": 2
}
```

**Réponse toggle offre — PATCH /api/admin/offres/6 :**
```json
{
  "message": "Offre désactivée.",
  "offre": { "id": 6, "actif": false }
}
```

**Erreurs couvertes par les tests :**

| Test | Scénario | Code attendu |
|------|----------|-------------|
| `error_admin` | Token candidat sur route admin | `403` — "Accès refusé. Rôle requis : admin" |

---

### Codes de réponse HTTP

| Code | Signification |
|------|--------------|
| `200` | Succès |
| `201` | Ressource créée |
| `401` | Non authentifié — token manquant, invalide ou expiré |
| `403` | Accès refusé — mauvais rôle ou ressource d'un autre utilisateur |
| `422` | Données invalides — erreur de validation |

---

## Système d'Events & Listeners

Le système découple la logique de logging des controllers. Quand une action se produit, un **Event** est dispatché et un **Listener** y réagit indépendamment sans que le Controller n'ait besoin de connaître cette réaction.

### Enregistrement dans `app/Providers/EventServiceProvider.php`

```php
protected $listen = [
    CandidatureDeposee::class => [
        LogCandidatureDeposee::class,
    ],
    StatutCandidatureMis::class => [
        LogStatutCandidatureMis::class,
    ],
];
```

### CandidatureDeposee

| | |
|--|--|
| **Déclenché par** | `POST /api/offres/{id}/candidater` |
| **Classe Event** | `App\Events\CandidatureDeposee` |
| **Listener** | `App\Listeners\LogCandidatureDeposee` |
| **Fichier log** | `storage/logs/candidatures.log` |

**Format du log :**
```
[2026-04-20 22:54:48] Candidature déposée — Candidat: Chaimae — Offre: dev
```

**Testé via :** `CandidatureDeposee event` (POST `/api/offres/8/candidater` avec `{ "message": "motivated" }`)  
La réponse inclut les relations `profil` et `offre` complètes, confirmant le bon dispatch de l'Event.

### StatutCandidatureMis

| | |
|--|--|
| **Déclenché par** | `PATCH /api/candidatures/{id}/statut` |
| **Classe Event** | `App\Events\StatutCandidatureMis` |
| **Listener** | `App\Listeners\LogStatutCandidatureMis` |
| **Fichier log** | `storage/logs/candidatures.log` |

**Format du log :**
```
[2026-04-20 22:59:06] Statut mis à jour — Ancien: en_attente — Nouveau: acceptee
```

**Testé via :** `StatutCandidatureMis event` (PATCH `/api/candidatures/4/statut` avec `{ "statut": "acceptee" }`)

### Tester les Events manuellement

```bash
php artisan tinker

# Tester CandidatureDeposee
>>> event(new App\Events\CandidatureDeposee(App\Models\Candidature::first()));

# Tester StatutCandidatureMis
>>> $c = App\Models\Candidature::first();
>>> event(new App\Events\StatutCandidatureMis($c, 'en_attente', 'acceptee'));

# Vérifier le fichier de log
>>> file_get_contents(storage_path('logs/candidatures.log'));
```

---

## Collection Postman

La collection complète de tests est disponible dans :

```
postman/Projet_backend.postman_collection_final
```

**Import :**
1. Ouvrir Postman → **Import** → sélectionner `Projet_backend.postman_collection_final.json`
2. Créer un environnement avec la variable `token`
3. Sur le request **Login**, onglet **Scripts → Post-response**, ajouter :
```javascript
const res = pm.response.json();
if (res.token) pm.environment.set("token", res.token);
```
4. Sur chaque request protégée → Auth → **Bearer Token** → `{{token}}`

### Récapitulatif des tests couverts

| Catégorie | Test | Méthode | Endpoint | Résultat attendu |
|-----------|------|---------|----------|-----------------|
| Auth | `register` | POST | `/api/register` | `201` — token + user |
| Auth | `register_recruiter` | POST | `/api/register` | `201` — role recruteur |
| Auth | `error_register` | POST | `/api/register` | `422` — champs manquants |
| Auth | `register_admin` | POST | `/api/register` | `422` — rôle admin invalide |
| Auth | `login_candidat` | POST | `/api/login` | `200` — token + user |
| Auth | `error_login_candidat` | POST | `/api/login` | `401` — mauvais mot de passe |
| Auth | `me` | GET | `/api/me` | `200` — profil utilisateur |
| Profil | `profil_candidat` (POST) | POST | `/api/profil` | `201` — profil créé |
| Profil | `profil_candidat` (GET) | GET | `/api/profil` | `200` — profil + compétences |
| Profil | `profil_candidat` (PUT) | PUT | `/api/profil` | `200` — profil modifié |
| Profil | `error_profil_candidat` | POST | `/api/profil` | `403` — rôle candidat requis |
| Profil | `competences_profil` | POST | `/api/profil/competences` | `200` — compétence ajoutée |
| Profil | `error_profil_competences` | POST | `/api/profil/competences` | `422` — niveau invalide |
| Profil | `remove_competence` | DELETE | `/api/profil/competences/1` | `200` — compétence retirée |
| Profil | `error_competences` | DELETE | `/api/profil/competences/99` | `404` — compétence absente |
| Offres | `offres` | GET | `/api/offres` | `200` — liste paginée |
| Offres | `offre_id` | GET | `/api/offres/2` | `200` — détail offre |
| Offres | `offres_post` | POST | `/api/offres` | `201` — offre créée |
| Offres | `error_offres` | POST | `/api/offres` | `403` — rôle recruteur requis |
| Offres | `invalid_offre` | POST | `/api/offres` | `401` — token invalide/expiré |
| Offres | `offres_put` | PUT | `/api/offres/5` | `200` — offre modifiée |
| Offres | `error_offresput` | PUT | `/api/offres/4` | `403` — non propriétaire |
| Offres | `delete_offres` | DELETE | `/api/offres/5` | `200` — offre supprimée |
| Offres | `error_delete_offres` | DELETE | `/api/offres/4` | `403` — non propriétaire |
| Candidatures | `candidater_offres` | POST | `/api/offres/6/candidater` | `201` — candidature créée |
| Candidatures | `error_candidature` | POST | `/api/offres/6/candidater` | `422` — déjà postulé |
| Candidatures | `mes_candidatures` | GET | `/api/mes-candidatures` | `200` — liste + détail offres |
| Candidatures | `candidatures_id` | GET | `/api/offres/6/candidatures` | `200` — candidatures reçues |
| Candidatures | `error_candidatureid` | GET | `/api/offres/4/candidatures` | `403` — non propriétaire |
| Candidatures | `offres_statut` | PATCH | `/api/candidatures/3/statut` | `200` — statut mis à jour |
| Candidatures | `error_candidaturestatut` | PATCH | `/api/candidatures/3/statut` | `403` — non autorisé |
| Admin | `admin` | GET | `/api/admin/users` | `200` — tous les utilisateurs |
| Admin | `error_admin` | GET | `/api/admin/users` | `403` — rôle admin requis |
| Admin | `delete_user` | DELETE | `/api/admin/users/1` | `200` — utilisateur supprimé |
| Admin | `patch_admin` | PATCH | `/api/admin/offres/6` | `200` — offre désactivée |
| Events | `CandidatureDeposee event` | POST | `/api/offres/8/candidater` | `201` — event dispatché, log écrit |
| Events | `StatutCandidatureMis event` | PATCH | `/api/candidatures/4/statut` | `200` — event dispatché, log écrit |

> Pour visualiser l'ensemble des requêtes, des corps de réponse et des cas d'erreur, consultez directement le fichier `postman/Projet_backend.postman_collection_final.json`.

---

<div align="center">

*ENSAM Casablanca — Département Génie Informatique et IA*  
*Module Technologies Backend — Framework Laravel*

**Kazoury Chaimae · Benlakhbaizi Lina · Lagdem Fatima-Ezzahra**

</div>
