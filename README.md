<div align="center">

# Mini-LinkedIn API

**Plateforme de recrutement · Laravel 11 · JWT Auth**

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

- PHP >= 8.2
- Composer
- MySQL >= 8.0
- Extensions PHP : `openssl`, `pdo`, `mbstring`, `tokenizer`, `xml`, `ctype`, `json`

---

## Installation

**1. Cloner le dépôt**
```bash
git clone https://github.com/votre-username/mini-linkedin-api.git
cd mini-linkedin-api
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
│   └── mini-linkedin.postman_collection.json
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
  "name": "Alice Martin",
  "email": "alice@test.com",
  "password": "secret123",
  "role": "candidat"
}
```
**Réponse 201 :**
```json
{ "token": "eyJ...", "user": { "id": 1, "name": "Alice Martin", "role": "candidat" } }
```

**Erreurs possibles :**
```
422 → email déjà pris
422 → role:admin → non autorisé à l'inscription
401 → identifiants incorrects lors du login
```

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

**Exemple ajouter compétence :**
```json
POST /api/profil/competences
{ "competence_id": 3, "niveau": "expert" }
```

**Erreurs possibles :**
```
403 → token recruteur utilisé sur une route candidat
404 → compétence non présente sur le profil (DELETE)
422 → niveau invalide
```

---

### Offres d'emploi

| Méthode | Endpoint | Auth | Description |
|---------|----------|------|-------------|
| `GET` | `/api/offres` | Public | Liste paginée des offres actives |
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
  "titre": "Développeur Backend Laravel",
  "description": "Rejoignez notre équipe.",
  "localisation": "Casablanca",
  "type": "CDI"
}
```

**Erreurs possibles :**
```
403 → token candidat sur route recruteur
403 → modification d'une offre appartenant à un autre recruteur
422 → type invalide (hors CDI/CDD/stage)
```

---

### Candidatures

| Méthode | Endpoint | Auth | Description |
|---------|----------|------|-------------|
| `POST` | `/api/offres/{id}/candidater` | Candidat | Postuler à une offre |
| `GET` | `/api/mes-candidatures` | Candidat | Ses propres candidatures |
| `GET` | `/api/offres/{id}/candidatures` | Recruteur (owner) | Candidatures reçues |
| `PATCH` | `/api/candidatures/{id}/statut` | Recruteur (owner) | Changer le statut |

**Exemple postuler :**
```json
POST /api/offres/1/candidater
{ "message": "Je suis très motivé par ce poste." }
```

**Exemple changer statut :**
```json
PATCH /api/candidatures/1/statut
{ "statut": "acceptee" }
```
> `statut` accepte : `en_attente`, `acceptee`, `refusee`

**Erreurs possibles :**
```
422 → offre inactive
403 → recruteur non propriétaire de l'offre
```

---

### Administration — Admin uniquement

| Méthode | Endpoint | Description |
|---------|----------|-------------|
| `GET` | `/api/admin/users` | Liste complète paginée de tous les utilisateurs |
| `DELETE` | `/api/admin/users/{id}` | Supprimer un compte (hors son propre compte) |
| `PATCH` | `/api/admin/offres/{id}` | Activer / désactiver une offre (toggle) |

**Réponse toggle offre :**
```json
{ "message": "Offre désactivée.", "offre": { "id": 1, "actif": false } }
```

**Erreurs possibles :**
```
403 → token non-admin
403 → tentative de suppression de son propre compte
```

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
[2025-04-20 14:32:00] Candidature déposée — Candidat: Alice Martin — Offre: Développeur Backend Laravel
```

### StatutCandidatureMis

| | |
|--|--|
| **Déclenché par** | `PATCH /api/candidatures/{id}/statut` |
| **Classe Event** | `App\Events\StatutCandidatureMis` |
| **Listener** | `App\Listeners\LogStatutCandidatureMis` |
| **Fichier log** | `storage/logs/candidatures.log` |

**Format du log :**
```
[2025-04-20 14:35:00] Statut mis à jour — Ancien: en_attente — Nouveau: acceptee
```

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

La collection est disponible dans `postman/mini-linkedin.postman_collection.json`.

**Import :**
1. Ouvrir Postman → **Import** → sélectionner le fichier JSON
2. Créer un environnement avec la variable `token`
3. Sur le request **Login**, onglet **Scripts → Post-response**, ajouter :
```javascript
const res = pm.response.json();
if (res.token) pm.environment.set("token", res.token);
```
4. Sur chaque request protégée → Auth → **Bearer Token** → `{{token}}`

**La collection couvre :**
- Inscription et connexion (candidat, recruteur, admin)
- CRUD profil et compétences
- CRUD offres avec filtres et pagination
- Candidatures et changement de statut
- Routes admin
- Cas d'erreur : `401`, `403`, `422`

---

## Branches Git

| Branche | Fonctionnalité |
|---------|---------------|
| `main` | Code stable et final |
| `feature/auth` | Authentification JWT |
| `feature/profil` | Profil candidat et compétences |
| `feature/offres` | CRUD offres d'emploi |
| `feature/candidatures` | Système de candidatures |
| `feature/admin` | Routes d'administration |
| `feature/events` | Events & Listeners |

---

<div align="center">

*ENSAM Casablanca — Département Génie Informatique et IA*  
*Module Technologies Backend — Framework Laravel*

**Kazoury Chaimae · Benlakhbaizi Lina · Lagdem Fatima-Ezzahra**

</div>
