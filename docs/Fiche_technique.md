# Fiche technique de la gestion du patrimoine d’État

**Sommaire**

1.  Présentation du projet

2.  Environnement technologique

3.  Architecture du système

4.  Structure des bases de données

5.  Structure du projet et organisation des dossiers

6.  Configuration Docker

7.  Sécurité

8.  Guide de démarrage

9.  Annexes

## **1. Présentation du projet**

### **1.1 Objet**

Le **Système de Gestion du Patrimoine de l'État (SGPE)** est une application web permettant de centraliser, suivre et gérer l'inventaire des biens meubles et immeubles appartenant à l'État. L'architecture est basée sur des microservices pour assurer la modularité, l'évolutivité et l'indépendance des différents domaines fonctionnels.

### **1.2 Périmètre fonctionnel**

- Gestion de l'inventaire des biens

- Suivi des mouvements et affectations

- Gestion documentaire et échéances

- Administration des utilisateurs et des droits

- Génération de rapports et exports

## **2. Environnement technologique**

### **2.1 Stack globale**

| **Couche**            | **Technologie**           | **Version** | **Justification**                                                                               |
|-----------------------|---------------------------|-------------|-------------------------------------------------------------------------------------------------|
| **Langage Backend**   | **PHP**                   | **8.4**     | Dernière version stable : performances améliorées, sécurité renforcée, fonctionnalités modernes |
| **Framework Backend** | **Laravel**               | **12.x**    | Version LTS supportée, conventions modernes, compatibilité native avec PHP 8.4                  |
| **Base de données**   | PostgreSQL                | 17+         | Version stable recommandée pour les nouvelles installations                                     |
| **Conteneurisation**  | Docker + Docker Compose   | 27+         | Uniformité de l'environnement, déploiement simplifié                                            |
| **Serveur Web**       | Nginx                     | 1.27+       | Léger, performant, gestion des redirections et SSL                                              |
| **Interface Web**     | Blade + HTML5 + CSS3 + JS | —           | Intégré à Laravel                                                                               |
| **Accès distant**     | API REST / JSON           | —           | Standard d'échange entre les services                                                           |

**2.2 Extensions PHP requises pour Laravel 12 + PHP 8.4**

| **Extension** | **Rôle**                         | **Requise par**                              |
|---------------|----------------------------------|----------------------------------------------|
| bcmath        | Calculs mathématiques précis     | Laravel 12                                   |
| ctype         | Vérification de caractères       | Laravel 12                                   |
| curl          | Requêtes HTTP externes           | API Gateway, communication entre services    |
| dom           | Traitement XML/HTML              | Bibliothèques diverses                       |
| fileinfo      | Détection de type de fichiers    | Téléversement de documents                   |
| json          | Traitement des données JSON      | Laravel 12 (intégré à PHP 8.4)               |
| mbstring      | Gestion des chaînes multibytes   | Support UTF-8 international                  |
| openssl       | Chiffrement, HTTPS, JWT          | Sécurité, authentification                   |
| pdo           | Interface de connexion aux bases | Accès aux données                            |
| pdo_pgsql     | Pilote PostgreSQL pour PDO       | Connexion à nos 3 bases de données           |
| tokenizer     | Analyse syntaxique du code       | Compilation des vues Blade                   |
| xml           | Traitement des données XML       | Bibliothèques diverses                       |
| zip           | Gestion des archives ZIP         | Export de rapports, téléversements multiples |

**2.3 Exigences du serveur**

| **Composant**          | **Développement**                            | **Production**                     |
|------------------------|----------------------------------------------|------------------------------------|
| Processeur             | 2 cœurs                                      | 4 cœurs minimum                    |
| Mémoire RAM            | 4 Go                                         | 8 Go minimum                       |
| Espace disque          | 15 Go                                        | 50 Go minimum                      |
| Système d'exploitation | Windows 10+/Ubuntu 24.04                     | Ubuntu 24.04 LTS recommandé        |
| PHP                    | **8.4**                                      | **8.4**                            |
| Laravel                | **12.x**                                     | **12.x**                           |
| PostgreSQL             | 17+                                          | 17+                                |
| Réseau                 | Accès [<u>localhost</u>](https://localhost/) | Connexion Internet sécurisée HTTPS |

## **3. Architecture du système**

### **3.1 Schéma d'architecture**

```text
         Utilisateur (Navigateur)
                │
                ▼  Port 8080
        ┌──────────────────┐
        │  Client Web      │
        │  (Interface)     │
        └────────┬─────────┘
                 │
                 ▼  Port 8000
        ┌──────────────────┐
        │  API Gateway     │ ← Routage, authentification, limitation
        └──┬────────┬─────┘
           │         │         │
    Port 8001   Port 8002   Port 8003
   ┌──────▼───┐ ┌──▼───────┐ ┌▼──────────┐
   │ Service  │ │ Service  │ │ Service   │
   │ BIENS    │ │ GESTION  │ │ ADMIN     │
   └────┬─────┘ └────┬─────┘ └────┬──────┘
        │            │            │
   ┌────▼─────┐ ┌───▼──────┐ ┌───▼───────┐
   │ Base 1   │ │ Base 2   │ │ Base 3    │
   │ db_biens │ │ db_gestion│ │ db_admin  │
   │ PostgreSQL│ │PostgreSQL│ │PostgreSQL│
   └──────────┘ └──────────┘ └───────────┘
```

**3.2 Description des microservices**

| **Microservice**    | **Port** | **Base de données** | **Responsabilité**                                                                 |
|---------------------|----------|---------------------|------------------------------------------------------------------------------------|
| **Service-Biens**   | 8001     | db_biens            | CRUD biens, classification, recherche, filtres, import/export inventaire           |
| **Service-Gestion** | 8002     | db_gestion          | Mouvements/affectations, documents joints, échéances et alertes                    |
| **Service-Admin**   | 8003     | db_admin            | Utilisateurs, rôles et permissions, authentification, journal d'activité, rapports |
| **API Gateway**     | 8000     | —                   | Point d'entrée unique, routage des requêtes, validation JWT, limitation de débit   |
| **Client Web**      | 8080     | —                   | Interface utilisateur, appelle l'API Gateway uniquement                            |

### **3.3 Principe de communication**

- **Communication synchrone** via HTTP/REST entre le client web et la passerelle

- **Communication interne** : la passerelle transmet au bon service selon le chemin de l'URL

- **Aucune communication directe entre microservices** — chaque service est autonome

- **Format d'échange** : JSON

## **4. Structure des bases de données**

### **4.1 Base : db_biens : Service-Biens**

**Table : biens**

| Colonne            | Type          | Contraintes      | Description                                |
|--------------------|---------------|------------------|--------------------------------------------|
| id                 | SERIAL        | PRIMARY KEY      | Identifiant unique                         |
| reference          | VARCHAR(50)   | UNIQUE, NOT NULL | Référence du bien                          |
| designation        | VARCHAR(255)  | NOT NULL         | Nom/description du bien                    |
| type_bien          | VARCHAR(50)   | NOT NULL         | Immobilier, Mobilier, Financier, Culturel  |
| date_acquisition   | DATE          | NOT NULL         | Date d'achat ou de réception               |
| valeur             | DECIMAL(15,2) | NOT NULL         | Valeur en FCFA                             |
| etat               | VARCHAR(30)   | NOT NULL         | Neuf, Bon, Moyen, Dégradé, Réformé         |
| adresse            | TEXT          | —                | Localisation physique                      |
| departement        | VARCHAR(100)  | NOT NULL         | Service/Département d'affectation          |
| utilisateur_actuel | INT           | —                | Référence vers service-admin (clé logique) |
| created_at         | TIMESTAMP     | DEFAULT NOW()    | Date de création                           |
| updated_at         | TIMESTAMP     | DEFAULT NOW()    | Date de modification                       |

Table : types_biens : Référentiel des catégories de biens

| Colonne     | Type         | Contraintes      |
|-------------|--------------|------------------|
| id          | SERIAL       | PRIMARY KEY      |
| code        | VARCHAR(20)  | UNIQUE, NOT NULL |
| libelle     | VARCHAR(100) | NOT NULL         |
| description | TEXT         | —                |

### **4.2 Base: db_gestion Service-Gestion**

**Table : mouvements**

| **Colonne**         | **Type**     | **Contraintes** | **Description**                             |
|---------------------|--------------|-----------------|---------------------------------------------|
| id                  | SERIAL       | PRIMARY KEY     | Identifiant unique                          |
| bien_reference      | VARCHAR(50)  | NOT NULL        | Référence du bien (clé métier)              |
| type_mouvement      | VARCHAR(50)  | NOT NULL        | Affectation, Retour, Cession, Prêt, Réforme |
| service_origine     | VARCHAR(100) | —               | Service de départ                           |
| service_destination | VARCHAR(100) | NOT NULL        | Service d'arrivée                           |
| date_mouvement      | TIMESTAMP    | DEFAULT NOW()   | Date et heure du mouvement                  |
| auteur              | VARCHAR(100) | NOT NULL        | Utilisateur ayant enregistré                |
| motif               | TEXT         | —               | Commentaire                                 |

**Table: documents**

| **Colonne**     | **Type**     | **Contraintes** | **Description**                       |
|-----------------|--------------|-----------------|---------------------------------------|
| id              | SERIAL       | PRIMARY KEY     | Identifiant unique                    |
| bien_reference  | VARCHAR(50)  | NOT NULL        | Bien associé                          |
| nom_fichier     | VARCHAR(255) | NOT NULL        | Nom du fichier stocké                 |
| chemin_stockage | TEXT         | NOT NULL        | Chemin d'accès                        |
| type_document   | VARCHAR(50)  | NOT NULL        | Facture, Titre, Contrat, Photo, Autre |
| date_echeance   | DATE         | —               | Date de renouvellement si applicable  |
| statut_echeance | VARCHAR(30)  | —               | À jour, À renouveler, Expiré          |
| ajoute_le       | TIMESTAMP    | DEFAULT NOW()   | Date d'upload                         |

### **4.3 Base: db_admin: Service-Admin**

**Table : utilisateurs**

| **Colonne**        | **Type**     | **Contraintes**  | **Description**                                   |
|--------------------|--------------|------------------|---------------------------------------------------|
| id                 | SERIAL       | PRIMARY KEY      | Identifiant unique                                |
| nom                | VARCHAR(100) | NOT NULL         | Nom de famille                                    |
| prenom             | VARCHAR(100) | NOT NULL         | Prénom                                            |
| email              | VARCHAR(255) | UNIQUE, NOT NULL | Adresse email                                     |
| mot_de_passe       | VARCHAR(255) | NOT NULL         | Hashé (bcrypt)                                    |
| role               | VARCHAR(50)  | NOT NULL         | Administrateur, Gestionnaire, Contrôleur, Lecteur |
| departement        | VARCHAR(100) | NOT NULL         | Service d'appartenance                            |
| statut             | VARCHAR(30)  | DEFAULT 'Actif'  | Actif, En attente, Bloqué                         |
| derniere_connexion | TIMESTAMP    | —                | Heure de dernière connexion                       |
| created_at         | TIMESTAMP    | DEFAULT NOW()    | Date de création du compte                        |

Table: journal_activite

| **Colonne**    | **Type**     | **Contraintes** | **Description**              |
|----------------|--------------|-----------------|------------------------------|
| id             | SERIAL       | PRIMARY KEY     | Identifiant unique           |
| utilisateur_id | INT          | NOT NULL        | Utilisateur concerné         |
| action         | VARCHAR(100) | NOT NULL        | Nature de l'action           |
| cible          | VARCHAR(100) | —               | Élément modifié/consulté     |
| details        | JSONB        | —               | Informations complémentaires |
| ip_adresse     | INET         | —               | Adresse IP de l'utilisateur  |
| date_action    | TIMESTAMP    | DEFAULT NOW()   | Horodatage                   |

**5. Structure du projet et organisation des dossiers**

```text
sgpe-gestion-patrimoine/
 │
 ├── 📄 docker-compose.yml
 ├── 📄 .env.exemple
 ├── 📄 README.md
 ├── 📄 .gitignore ← Fichiers exclus de Git
 │
 ├── 📁 service-biens/
 │        ├── 📄 Dockerfile
│         ├── 📄 composer.json
│         ├── 📄 .env.example
│         ├── 📁 app/
│         │      ├── 📁 Http/Controllers/ ← Contrôleurs API
│         │      ├── 📁 Models/ ← Modèles de données
 │        │      └── 📁 Provider
│         ├── 📁 database/migrations/
 │        ├── 📁 routes/
│         │            └── api.php ← Points d'entrée API
 │        └── 📁 config/
├── 📁 service-gestion/ ← Microservice — Mouvements et │       ├── 📄 Dockerfile
│       ├── 📄 composer.json
│       ├── 📁 app/
│       ├── 📁 database/migrations/
│       └── 📁 routes/api.php
├── 📁 service-admin/
│      ├── 📄 Dockerfile
│      ├── 📄 composer.json
│      ├── 📁 app/
│      ├── 📁 database/migrations/
│      └── 📁 routes/api.php
├── 📁 api-gateway/ ← Passerelle de routage
│      ├── 📄 Dockerfile
│      └── 📁 config/
└── 📁 client-web/
         ├── 📄 Dockerfile
         ├── 📁 resources/views/
         ├── 📁 public/
         └── 📁 routes/web.php
```

## **6. Configuration Docker**

### **6.1 Fichier docker-compose.yml**

```yaml
version: '3.8'
# Réseau privé pour la communication entre conteneurs
networks:
  sgpe-reseau:
    driver: bridge
# Volumes persistants pour les bases de données
volumes:
  db_biens_data:
  db_gestion_data:
  db_admin_data:
services:
  # ==========================================
  # BASE DE DONNÉES 1 — Service Biens
  # ==========================================
  db-biens:
    image: postgres:16-alpine
    container_name: sgpe-db-biens
    restart: unless-stopped
    environment:
      POSTGRES_DB: db_biens
      POSTGRES_USER: sgpe_user
      POSTGRES_PASSWORD: secret_pour_developpement
    volumes:
      - db_biens_data:/var/lib/postgresql/data
      - ./service-biens/database/init:/docker-entrypoint-initdb.d
    ports:
      - "5431:5432"
    networks:
      - sgpe-reseau
    healthcheck:
      test: ["CMD-SHELL", "pg_isready -U sgpe_user -d db_biens"]
      interval: 10s
      timeout: 5s
      retries: 5
  # ==========================================
  # BASE DE DONNÉES 2 — Service Gestion
  # ==========================================
  db-gestion:
    image: postgres:16-alpine
    container_name: sgpe-db-gestion
    restart: unless-stopped
    environment:
      POSTGRES_DB: db_gestion
      POSTGRES_USER: sgpe_user
      POSTGRES_PASSWORD: secret_pour_developpement
    volumes:
      - db_gestion_data:/var/lib/postgresql/data
      - ./service-gestion/database/init:/docker-entrypoint-initdb.d
    ports:
      - "5432:5432"
    networks:
      - sgpe-reseau
    healthcheck:
      test: ["CMD-SHELL", "pg_isready -U sgpe_user -d db_gestion"]
      interval: 10s
      timeout: 5s
      retries: 5
  # ==========================================
  # BASE DE DONNÉES 3 — Service Admin
  # ==========================================
  db-admin:
    image: postgres:16-alpine
    container_name: sgpe-db-admin
    restart: unless-stopped
    environment:
      POSTGRES_DB: db_admin
      POSTGRES_USER: sgpe_user
      POSTGRES_PASSWORD: secret_pour_developpement
    volumes:
      - db_admin_data:/var/lib/postgresql/data
      - ./service-admin/database/init:/docker-entrypoint-initdb.d
    ports:
      - "5433:5432"
    networks:
      - sgpe-reseau
    healthcheck:
      test: ["CMD-SHELL", "pg_isready -U sgpe_user -d db_admin"]
      interval: 10s
      timeout: 5s
      retries: 5
  # ==========================================
  # MICROSERVICE 1 — Service-Biens
  # ==========================================
  service-biens:
    build:
      context: ./service-biens
      dockerfile: Dockerfile
    container_name: sgpe-service-biens
    restart: unless-stopped
    working_dir: /var/www/html
    volumes:
      - ./service-biens:/var/www/html
      - ./service-biens/php/local.ini:/usr/local/etc/php/conf.d/local.ini
    ports:
      - "8001:8000"
    environment:
      DB_HOST: db-biens
      DB_PORT: 5432
      DB_DATABASE: db_biens
      DB_USERNAME: sgpe_user
      DB_PASSWORD: secret_pour_developpement
    depends_on:
      db-biens:
        condition: service_healthy
    networks:
      - sgpe-reseau
  # ==========================================
  # MICROSERVICE 2 — Service-Gestion
  # ==========================================
  service-gestion:
    build:
      context: ./service-gestion
      dockerfile: Dockerfile
    container_name: sgpe-service-gestion
    restart: unless-stopped
    working_dir: /var/www/html
    volumes:
      - ./service-gestion:/var/www/html
    ports:
      - "8002:8000"
    environment:
      DB_HOST: db-gestion
      DB_PORT: 5432
      DB_DATABASE: db_gestion
      DB_USERNAME: sgpe_user
      DB_PASSWORD: secret_pour_developpement
    depends_on:
      db-gestion:
        condition: service_healthy
    networks:
      - sgpe-reseau
  # ==========================================
  # MICROSERVICE 3 — Service-Admin
  # ==========================================
  service-admin:
    build:
      context: ./service-admin
      dockerfile: Dockerfile
    container_name: sgpe-service-admin
    restart: unless-stopped
    working_dir: /var/www/html
    volumes:
      - ./service-admin:/var/www/html
    ports:
      - "8003:8000"
    environment:
      DB_HOST: db-admin
      DB_PORT: 5432
      DB_DATABASE: db_admin
      DB_USERNAME: sgpe_user
      DB_PASSWORD: secret_pour_developpement
    depends_on:
      db-admin:
        condition: service_healthy
    networks:
      - sgpe-reseau
  # ==========================================
  # API GATEWAY — Porte d'entrée unique
  # ==========================================
  api-gateway:
    build:
      context: ./api-gateway
      dockerfile: Dockerfile
    container_name: sgpe-api-gateway
    restart: unless-stopped
    ports:
      - "8000:80"
    volumes:
      - ./api-gateway/nginx.conf:/etc/nginx/nginx.conf:ro
    depends_on:
      - service-biens
      - service-gestion
      - service-admin
    networks:
      - sgpe-reseau
  # ==========================================
  # CLIENT WEB — Interface utilisateur
  # ==========================================
  client-web:
    build:
      context: ./client-web
      dockerfile: Dockerfile
    container_name: sg
```
