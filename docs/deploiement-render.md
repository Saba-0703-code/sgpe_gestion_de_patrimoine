# Déploiement sur Render (offre gratuite)

Architecture déployée :

| Composant | Type Render | URL |
|---|---|---|
| sgpe-biens | Web service (Docker) | https://sgpe-biens.onrender.com |
| sgpe-gestion | Web service (Docker) | https://sgpe-gestion.onrender.com |
| sgpe-admin | Web service (Docker) | https://sgpe-admin.onrender.com |
| sgpe-web | Static site | https://sgpe-web.onrender.com |
| sgpe-db | PostgreSQL | interne Render |

Le fichier `render.yaml` à la racine décrit tout l'infrastructure (Blueprint).

## Étapes

### 1. Pousser le code sur GitHub

Le repo doit être sur GitHub pour que Render le builders.

### 2. Créer le Blueprint

Render Dashboard → **New → Blueprint** → sélectionner le repo.
Render crée la base `sgpe-db`, les 3 services et le site statique.
`ADMIN_PASSWORD` sera demandé à la création (ne pas laisser vide).

### 3. Créer les 3 schémas PostgreSQL

Render gratuit = 1 seule base. Les 3 services partagent `sgpe-db`
chacun dans son schéma (`biens`, `gestion`, `admin`).

Une fois `sgpe-db` créé, ouvrir **Connect → External Database URL**
ou utiliser `psql` en local :

```sql
CREATE SCHEMA IF NOT EXISTS biens;
CREATE SCHEMA IF NOT EXISTS gestion;
CREATE SCHEMA IF NOT EXISTS admin;
```

### 4. Lancer les migrations

Les services Render gratuits n'ont pas de shell. Deux options :

**Option A — depuis votre machine** (recommandé) :

```powershell
# Récupérer les credentials de sgpe-db (Render Dashboard > Connect)
$env:DB_HOST="<host>.render.com"; $env:DB_PORT="5432"
$env:DB_DATABASE="<db>"; $env:DB_USERNAME="<user>"; $env:DB_PASSWORD="<password>"

cd service-biens;    $env:DB_SCHEMA="biens";    php artisan migrate:fresh
cd ..\service-gestion; $env:DB_SCHEMA="gestion"; php artisan migrate:fresh
cd ..\service-admin;   $env:DB_SCHEMA="admin";   php artisan migrate:fresh
cd ..\service-admin;   php artisan db:seed --class=AdminUserSeeder
```

**Option B — Render Shell** (payant) : `php artisan migrate` dans chaque service.

### 5. Connecter le domaine du site statique

`sgpe-web.onrender.com` doit correspondre à `CORS_ALLOWED_ORIGINS`
(déjà configuré dans render.yaml). Si Render attribue un autre nom,
mettre à jour la variable sur les 3 services **et** les URLs dans
`client-web/js/api.js` (bloc `REMOTE`).

## Limites du gratuit

- **Cold start** : les services se mettent en veille après ~15 min
  d'inactivité. Le premier appel peut prendre 30-60 s.
- **Base PostgreSQL gratuite** : expire après 30 jours — exporter
  les données régulièrement.
- **Vérification des tokens** : `service-biens`/`gestion` valident le
  token auprès de `service-admin` (timeout 30 s pour absorber le cold start).
- Si les URLs `*.onrender.com` sont déjà prises, Render ajoute un suffixe :
  adapter `REMOTE` dans `client-web/js/api.js` ou définir
  `window.SGPE_REMOTE_URLS` avant le chargement.

## Comptes de test

Après le seed : `admin@sgpe.tg` / mot de passe défini via `ADMIN_PASSWORD`
(ou `ChangeMe!2026` par défaut — **à changer**).
