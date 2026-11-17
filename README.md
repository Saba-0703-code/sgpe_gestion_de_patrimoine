# 🏛️ SGPE — Système de Gestion du Patrimoine de l'État

> **Application web de gestion centralisée du patrimoine de l'État**
> ** Accès à la plateforme : https://sgpe-gestion-de-patrimoine.onrender.com**
> Architecture microservices • Laravel 12 / PHP 8.4 • PostgreSQL • Docker

---

## 📋 Sommaire

- [Présentation du projet](#-présentation-du-projet)
- [Architecture](#️-architecture)
- [Structure du projet](#️-structure-du-projet)
- [Technologies utilisées](#️-technologies-utilisées)
- [Prérequis](#-prérequis)
- [Installation et démarrage](#-installation-et-démarrage)
- [Services et ports](#-services-et-ports)
- [Base de données](#️-base-de-données)
- [API Endpoints](#-api-endpoints)
- [Pages de l'application](#️-pages-de-lapplication)
- [Développement](#-développement)
- [Auteur](#-auteur)

---

## 🎯 Présentation du projet

Le **Système de Gestion du Patrimoine de l'État (SGPE)** est une application permettant de :

- 📦 **Gérer l'inventaire** des biens matériels et immatériels de l'État
- 🔄 **Suivre les mouvements** et les affectations des biens entre les différents services
- 👥 **Administrer les utilisateurs** et leurs droits d'accès
- 📊 **Générer des rapports** et des exports de données

---

## 🏗️ Architecture

Le projet utilise une **architecture microservices** composée de 5 composants indépendants :

| Service | Rôle | Schéma de données |
| --- | --- | --- |
| **service-biens** | Gestion de l'inventaire des biens | `biens` |
| **service-gestion** | Suivi des affectations et mouvements | `gestion` |
| **service-admin** | Authentification et gestion des utilisateurs | `admin` |
| **api-gateway** | Point d'entrée unique et routage des requêtes | — |
| **client-web** | Interface utilisateur web en HTML/CSS/JS | — |

---

## 📂 Structure du projet

```
gestion_patrimoine/
├── api-gateway/              # Passerelle API
├── client-web/               # Interface web utilisateur
│   ├── login.html            # Page de connexion
│   ├── dashboard.html        # Tableau de bord
│   ├── biens.html            # Liste des biens
│   ├── bien-detail.html      # Fiche détail d'un bien
│   ├── affectations.html     # Gestion des affectations
│   ├── utilisateurs.html     # Gestion des utilisateurs
│   └── rapports.html         # Rapports et exports
├── service-biens/            # Service de gestion des biens
│   ├── app/
│   │   ├── Http/Controllers/ # Contrôleurs API
│   │   ├── Models/           # Modèles de données
│   │   └── Providers/
│   ├── database/migrations/  # Migrations de la base de données
│   ├── routes/api.php        # Routes API
│   ├── Dockerfile
│   └── .env
├── service-gestion/          # Service de gestion des affectations
│   ├── app/
│   │   ├── Http/Controllers/
│   │   └── Models/
│   ├── database/migrations/
│   ├── routes/api.php
│   ├── Dockerfile
│   └── .env
├── service-admin/            # Service d'administration
│   ├── app/
│   │   ├── Http/Controllers/
│   │   └── Models/
│   ├── database/migrations/
│   ├── routes/api.php
│   ├── Dockerfile
│   └── .env
├── docs/                     # Documentation du projet
│   ├── analyse_besoin.md
│   ├── Conception_et_Modelisation_UML.md
│   ├── fiche_technique.md
│   └── guide_utilisation.md
├── docker-compose.yml        # Configuration Docker
├── .gitignore
└── README.md
```

---

## 🛠️ Technologies utilisées

| Composant | Technologie |
| --- | --- |
| **Backend** | Laravel 12 • PHP 8.4 |
| **Base de données** | PostgreSQL 17 |
| **Conteneurisation** | Docker & Docker Compose |
| **Passerelle API** | Nginx |
| **Frontend** | HTML5 • CSS3 • JavaScript (Fetch API) |
| **Contrôle de version** | Git & GitHub |
| **Hébergement base de données** | Render (PostgreSQL) |

---

## 📝 Prérequis

- Docker Desktop (Windows/macOS/Linux)
- Git
- Au moins 4 Go de RAM disponible

> ⚠️ **PHP et Composer ne sont pas requis sur votre ordinateur** — tout s'exécute dans les conteneurs Docker.

---

## 🚀 Installation et démarrage

### Étape 1 — Cloner le dépôt

```bash
git clone <url-du-depot-github>
cd gestion_patrimoine
```

### Étape 2 — Configurer les variables d'environnement

Dupliquez `.env.example` en `.env` dans chaque dossier de service et renseignez les paramètres de connexion à la base de données.

### Étape 3 — Démarrer tous les services

```bash
docker-compose up -d
```

### Étape 4 — Installer les dépendances

```bash
# Service Biens
docker-compose exec service-biens composer install --no-interaction

# Service Gestion
docker-compose exec service-gestion composer install --no-interaction

# Service Admin
docker-compose exec service-admin composer install --no-interaction
```

### Étape 5 — Exécuter les migrations

> ⚠️ Les schémas `affectations` et `utilisateurs` ont été corrigés : si les bases
> existent déjà, réinitialisez-les (`migrate:fresh`) avant de migrer.

```bash
docker-compose exec service-biens php artisan migrate:fresh
docker-compose exec service-gestion php artisan migrate:fresh
docker-compose exec service-admin php artisan migrate:fresh
```

### Étape 6 — Accéder à l'application

- 🌐 **Interface web** : [http://localhost:8080](http://localhost:8080)
- 🔌 **API Gateway** : [http://localhost:8000](http://localhost:8000)

---
## 🌐 Accès à la plateforme

| Environnement | Lien |
|---|---|
| 🚀 **En ligne (Render)** | **https://sgpe-gestion-de-patrimoine.onrender.com** |
| 💻 En local | http://localhost:8080 |

---

## 🔌 Services et ports

| Service | Port local | Description |
| --- | --- | --- |
| client-web | **8080** | Interface utilisateur web |
| api-gateway | **8000** | Passerelle API |
| service-biens | **8001** | API — Gestion des biens |
| service-gestion | **8002** | API — Gestion des affectations |
| service-admin | **8003** | API — Administration |
| sgpe-db-biens | **5431** | Base de données (schéma biens) |
| sgpe-db-gestion | **5432** | Base de données (schéma gestion) |
| sgpe-db-admin | **5433** | Base de données (schéma admin) |

---

## 🗄️ Base de données

### En local (développement)

- 3 bases PostgreSQL distinctes, chacune dédiée à un microservice

### Sur Render (hébergement)

- 1 base PostgreSQL unique avec **3 schémas** isolés : `biens`, `gestion`, `admin`
- Chaque service ne voit que son propre schéma
- ⚠️ Render limite à 1 base de données gratuite par compte

### Informations de connexion Render

Retrouvez ces valeurs dans la section **"Connections"** de votre base de données Render :

```
Hôte : <hostname-render>
Port : 5432
Base de données : biens
Utilisateur : adminuser
Mot de passe : <votre-mot-de-passe>
```

---

## 🔗 API Endpoints

Toutes les API passent par la passerelle : `http://localhost:8000/api/<service>/...`
avec `<service>` ∈ `biens`, `gestion`, `admin`. Les routes `/api/biens`, `/api/gestion/*`
et `/api/admin/*` requièrent un token Bearer (Sanctum) obtenu via `POST /api/admin/login`.

### 📦 Biens — `/api/biens`

| Méthode | Route | Description |
| --- | --- | --- |
| GET | `/biens` | Lister tous les biens |
| POST | `/biens` | Créer un nouveau bien |
| GET | `/biens/{id}` | Afficher les détails d'un bien |
| PUT/PATCH | `/biens/{id}` | Modifier un bien |
| DELETE | `/biens/{id}` | Supprimer un bien |

### 🔄 Gestion — `/api/gestion`

| Méthode | Route | Description |
| --- | --- | --- |
| GET | `/affectations` | Lister toutes les affectations |
| POST | `/affectations` | Enregistrer une nouvelle affectation |
| GET | `/affectations/{id}` | Voir les détails |
| PUT/PATCH | `/affectations/{id}` | Modifier une affectation |
| DELETE | `/affectations/{id}` | Supprimer une affectation |

### 👤 Admin — `/api/admin`

| Méthode | Route | Description |
| --- | --- | --- |
| POST | `/login` | Connexion utilisateur (rate-limité) |
| GET | `/moi` | Utilisateur connecté |
| POST | `/logout` | Déconnexion |
| GET | `/utilisateurs` | Lister les utilisateurs |
| POST | `/utilisateurs` | Créer un utilisateur (admin) |
| GET | `/utilisateurs/{id}` | Voir un utilisateur |
| PUT/PATCH | `/utilisateurs/{id}` | Modifier (admin ou soi-même) |
| DELETE | `/utilisateurs/{id}` | Supprimer un utilisateur (admin) |

---

## 🖥️ Pages de l'application

| Page | Fichier | Rôle |
| --- | --- | --- |
| Connexion | `login.html` | Authentification utilisateur |
| Tableau de bord | `dashboard.html` | Vue d'ensemble et statistiques |
| Inventaire des biens | `biens.html` | Liste et recherche des biens |
| Fiche bien | `bien-detail.html` | Détail et historique d'un bien |
| Affectations | `affectations.html` | Gestion des mouvements de biens |
| Utilisateurs | `utilisateurs.html` | Gestion des comptes et rôles |
| Rapports | `rapports.html` | Statistiques et exports de données |

---

## 👨‍💻 Développement

### Branches Git

- `main` — Code stable et prêt pour la production
- `service-biens` — Développement du service de gestion des biens
- `service-gestion` — Développement du service de gestion des affectations
- `service-admin` — Développement du service d'administration

### Commandes utiles

```bash
# Démarrer l'environnement
docker-compose up -d

# Voir l'état des services
docker-compose ps

# Voir les logs
docker-compose logs -f

# Accéder au conteneur d'un service
docker-compose exec service-biens sh

# Exécuter les migrations
docker-compose exec service-biens php artisan migrate

# Arrêter les services
docker-compose down

# Arrêter et supprimer les volumes (réinitialisation des données)
docker-compose down -v
```

---

## 📚 Documentation complémentaire

- 📄 **Analyse du besoin** → `docs/analyse_besoin.md`
- 📄 **Conception UML** → [`docs/Conception_et_Modelisation_UML.md`](docs/Conception_et_Modelisation_UML.md)
- 📄 **Fiche technique** → `docs/fiche_technique.md`
- 📄 **Guide d'utilisation** → `docs/guide_utilisation.md`
- 📄 **Déploiement Render** → `docs/deploiement-render.md` + `render.yaml`

---

## ⚠️ Notes importantes

- L'offre gratuite de Render limite à **une seule base de données PostgreSQL** par compte. En développement local, vous pouvez utiliser 3 bases distinctes.
- La base de données Render expire au bout de 30 jours si vous ne passez pas sur un plan payant. Pensez à sauvegarder vos données régulièrement.
- Pour la démonstration en soutenance, l'application fonctionne parfaitement en local avec Docker.

---

## ✅ État d'avancement du projet

| Composant | Statut |
| --- | --- |
| Structure du projet et Docker | ✅ Terminé |
| Modèles et migrations | ✅ Terminé |
| Contrôleurs API de base | ✅ Terminé |
| Pages web et interface | ✅ Terminé |
| Connexion à la base de données | ✅ Terminé |
| Documentation | ✅ Terminé |
| Connexion Frontend ↔ Backend   Terminé

---

## 👤 Auteur

<p align="center">
  <img src="docs/media/auteur.png" alt="Photo de Saba Felicio" width="180">
</p>

             ***Saba Felicio*** 

---

> *"Ce projet est réalisé dans le cadre d'un travail académique. Il démontre une architecture microservices complète, conteneurisée."*
