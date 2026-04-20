# Mini-LinkedIn API 
Une API de plateforme de recrutement permettant de mettre en relation des candidats et des recruteurs. Ce projet a été développé avec Laravel 11 dans le cadre du module Technologies Backend.

## Fonctionnalités
* Authentification Robuste : Gestion des utilisateurs avec JWT (JSON Web Tokens).
* Système de Rôles : Accès différencié pour Candidat, Recruteur et Admin.
* Gestion de Profils : Profils enrichis avec compétences et niveaux (Débutant à Expert).
* Job Board : Création, modification et filtrage avancé des offres d'emploi.
* Workflow de Candidature : Postulation et suivi du statut (en attente, acceptée, refusée).
* Architecture Événementielle : Utilisation d'Events & Listeners pour le logging des activités critiques.
* Administration : Modération des utilisateurs et des offres.

##  Stack Technique
- Framework : Laravel 11

- Authentification : JWT-Auth

- Base de données : MySQL 

- Outils : Eloquent ORM, Migrations, Factories & Seeders

## Installation
Cloner le dépôt

```Bash
git clone https://github.com/votre-username/mini-linkedin-api.git
cd mini-linkedin-api
```

Installer les dépendances

```Bash
composer install
```

Configuration de l'environnement

```Bash
cp .env.example .env
# Configurez votre base de données dans le fichier .env
php artisan key:generate
php artisan jwt:secret
```

Migrations et Seeders (Crée 2 admins, 5 recruteurs, 10 candidats)

```Bash
php artisan migrate --seed
```

Lancer le serveur

```Bash
php artisan serve
```

## API Endpoints

###  Authentification
| Méthode | Endpoint | Accès | Description |
| :--- | :--- | :--- | :--- |
| `POST` | `/api/register` | Public | Créer un compte (Candidat/Recruteur) |
| `POST` | `/api/login` | Public | Connexion et obtention du Token JWT |

###  Gestion du Profil (Candidats)
* `POST /api/profil` : Créer son profil (une seule fois).
* `GET /api/profil` : Consulter son propre profil avec compétences.
* `PUT /api/profil` : Modifier ses informations de profil.
* `POST /api/profil/competences` : Ajouter une compétence avec son niveau.
* `DELETE /api/profil/competences/{id}` : Retirer une compétence du profil.

###  Offres d'Emploi
* `GET /api/offres` : Liste des offres actives (Supporte pagination, tri, et filtres `localisation`/`type`).
* `GET /api/offres/{id}` : Voir les détails d'une offre spécifique.
* `POST /api/offres` : Créer une offre (**Recruteur uniquement**).
* `PUT /api/offres/{id}` : Modifier son offre (**Propriétaire uniquement**).
* `DELETE /api/offres/{id}` : Supprimer son offre (**Propriétaire uniquement**).

###  Candidatures
* `POST /api/offres/{id}/candidater` : Postuler à une offre (**Candidat uniquement**).
* `GET /api/mes-candidatures` : Liste des candidatures envoyées par le candidat.
* `GET /api/offres/{id}/candidatures` : Liste des candidatures reçues pour une offre (**Recruteur propriétaire**).
* `PATCH /api/candidatures/{id}/statut` : Modifier le statut (en_attente, acceptee, refusee).

###  Administration
| Méthode | Endpoint | Description |
| :--- | :--- | :--- |
| `GET` | `/api/admin/users` | Liste complète de tous les utilisateurs |
| `DELETE` | `/api/admin/users/{id}` | Supprimer définitivement un compte utilisateur |
| `PATCH` | `/api/admin/offres/{id}` | Activer ou désactiver une offre d'emploi |

##  Système d'Événements & Listeners

Le projet utilise le système de **découplage par Events & Listeners** de Laravel pour gérer les logs d'activité. Toutes les traces sont enregistrées dans le fichier suivant :  
`storage/logs/candidatures.log`

### Événements implémentés :
* **CandidatureDeposee** : Déclenché lorsqu'un candidat postule. Le listener extrait et enregistre :
    * La date de l'action.
    * Le nom complet du candidat.
    * Le titre de l'offre concernée.
* **StatutCandidatureMis** : Déclenché lors de la modification du statut par un recruteur. Il enregistre :
    * La date de modification.
    * L'ancien statut (ex: `en_attente`).
    * Le nouveau statut (ex: `acceptee`).

---

##  Tests & Postman

Une collection Postman complète est fournie pour tester l'intégralité de l'API. Elle se trouve dans le dossier : `/postman`.

**La collection couvre les scénarios suivants :**
* **Authentification** : Inscription, connexion et gestion des **Bearer Tokens** (JWT).
* **Sécurité** : Tests des accès restreints (Erreurs `401 Unauthorized` et `403 Forbidden`).
* **Validation** : Tests des formulaires et erreurs de données (`422 Unprocessable Entity`).
* **Cycle de vie** : Flux complet allant de la création d'une offre à la sélection finale d'un candidat.
