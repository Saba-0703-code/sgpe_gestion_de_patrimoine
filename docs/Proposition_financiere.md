# Proposition financière de système de gestion du patrimoine d’État (SGPE)

**Sommaire**

1.  **Présentation et hypothèses**

2.  **Coûts de conception et analyse du besoin**

3.  **Coûts de développement par module**

4.  **Coûts d’infrastructure (hébergement)**

5.  **Formation et documentation**

6.  **Maintenance actuelle**

7.  **Tableau récapitulatif global**

8.  **Planning de paiement**

9.  **Comparaison : situation actuelle et la solution proposée**

10. **Hypothèses, limites et risques**

1.  **Présentation et hypothèses**

**Objet de la proposition**

Cette proposition chiffrée porte sur la réalisation du **Système de Gestion du Patrimoine de l'État (SGPE)** : analyse, conception (UML + Figma), développement en architecture microservices (Laravel + PostgreSQL), conteneurisation Docker, documentation et formation initiale.

**Hypothèse et le chiffrage**

| **Hypothèse**                  | **Détail**                                                                                                            |
|--------------------------------|-----------------------------------------------------------------------------------------------------------------------|
| Périmètre                      | 3 microservices (Biens, Gestion, Admin) + API Gateway + interface web                                                 |
| Environnement de démonstration | Hébergement gratuit (Render, Railway ou Fly.io) : coût **0 FCFA** pour la démo                                        |
| Environnement de production    | Serveur cloud sécurisé, sauvegardes quotidiennes                                                                      |
| Équipe                         | 1 développeur principal + 1 appui conception/design (projet individuel pédagogique : coûts estimés à titre indicatif) |
| Durée de réalisation           | Phase de développement : ~10 à 15 novembre sans sommeil (nuit blanche)                                                |
| Coûts non inclus               | Acquisition de données terrain (recensement physique), intégration comptable (version 2)                              |

## 2. Coûts de conception et d'analyse

| **N°** | **Prestation**                         | **Description**                                                                          | **Montant (FCFA)** |
|--------|----------------------------------------|------------------------------------------------------------------------------------------|--------------------|
| C1     | Analyse du besoin                      | Rédaction du cahier des charges, acteurs, exigences fonctionnelles et non fonctionnelles | 250 000            |
| C2     | Conception UML                         | Cas d'utilisation, classes, séquences, composants, paquets                               | 200 000            |
| C3     | Architecture microservices             | Découpage des services, schéma d'architecture, choix technologiques                      | 150 000            |
| C4     | Design Figma                           | Maquettes des 9 écrans, charte graphique, navigation                                     | 250 000            |
| C5     | Fiche technique et guide d'utilisation | Documentation complète du système                                                        | 150 000            |
|        | **Sous-total Conception**              |                                                                                          | **1 000 000**      |

**3. Coûts de développement par module**

| **N°** | **Module / Service**            | **Technologies**                             | **Tâches principales**                                                   | **Montant (FCFA)** |
|--------|---------------------------------|----------------------------------------------|--------------------------------------------------------------------------|--------------------|
| D1     | **Service-Biens** (port 8001)   | Laravel + PostgreSQL                         | CRUD des biens, recherche, filtres, géolocalisation, import CSV          | 450 000            |
| D2     | **Service-Gestion** (port 8002) | Laravel + PostgreSQL                         | Mouvements/affectations, documents, échéances, alertes                   | 400 000            |
| D3     | **Service-Admin** (port 8003)   | Laravel + PostgreSQL                         | Authentification, utilisateurs, rôles, journal, rapports                 | 400 000            |
| D4     | **API Gateway** (port 8000)     | Laravel / Nginx                              | Routage, vérification JWT, limitation de requêtes                        | 200 000            |
| D5     | **Client Web** (port 8080)      | Blade / Vue                                  | Interface des 9 écrans, appels API, tableau de bord                      | 350 000            |
| D6     | **Base de données**             | PostgreSQL ×3                                | Modélisation, migrations, seed de données de test                        | 150 000            |
| D7     | **Conteneurisation Docker**     | Docker + docker-compose.yml                  | 3 bases PostgreSQL conteneurisées, réseau, volumes, scripts de lancement | 150 000            |
| D8     | **Tests et recette**            | Tests fonctionnels, correction des anomalies | Scénarios de test par module, validation des écrans                      | 200 000            |
|        | **Sous-total Développement**    |                                              |                                                                          | **2 300 000**      |

## **4. Coûts d'infrastructure (hébergement)**

###  **4.1 Version de démonstration** 

| **Poste**                                     | **Coût mensuel** | **Coût annuel** |
|-----------------------------------------------|------------------|-----------------|
| Hébergeur gratuit (Render / Railway / Fly.io) | 0                | 0               |
| **Total démo**                                | **0**            | **0**           |

**4.2 Version de production (administration réelle)**

| **Poste**                                   | **Détail**                         | **Coût annuel (FCFA)** |
|---------------------------------------------|------------------------------------|------------------------|
| Serveur cloud (VPS)                         | 2 vCPU, 4 Go RAM, stockage 80 Go   | 720 000                |
| Nom de domaine + certificat SSL             | sgpe.gouv.tg ou équivalent, HTTPS  | 80 000                 |
| Sauvegardes automatiques quotidiennes       | Volume séparé + rétention 30 jours | 120 000                |
| Surveillance et supervision (logs, alertes) | Outil de monitoring basique        | 80 000                 |
| **Total infrastructure annuelle**           |                                    | **1 000 000**          |

**5. Formation et documentation**

| **N°** | **Prestation**                           | **Description**                                                       | **Montant (FCFA)** |
|--------|------------------------------------------|-----------------------------------------------------------------------|--------------------|
| F1     | Session de formation administrateurs     | 1 session (1 journée) : gestion des comptes, paramétrage, sauvegardes | 100 000            |
| F2     | Session de formation utilisateurs        | 1 session (1 journée) : saisie des biens, mouvements, rapports        | 100 000            |
| F3     | Guide d'utilisation imprimé et numérique | Manuel illustré pas à pas pour chaque profil                          | 50 000             |
|        | **Sous-total Formation**                 |                                                                       | **250 000**        |

**6. Maintenance annuelle**

| **Poste**                       | **Description**                          | **Coût annuel (FCFA)** |
|---------------------------------|------------------------------------------|------------------------|
| Maintenance corrective          | Correction des anomalies signalées       | 250 000                |
| Maintenance évolutive légère    | Petites évolutions, ajustements d'écrans | 200 000                |
| Mises à jour de sécurité        | PHP, Laravel, PostgreSQL, images Docker  | 100 000                |
| **Maintenance annuelle totale** |                                          | **550 000**            |

**<u>NB</u> : La maintenance démarre après la mise en production ; une garantie de 3 mois est incluse dans le coût de développement.**

**7. Tableau récapitulatif global**

**7.1 Investissement initial (une seule fois)**

| **Rubrique**                       | **Montant (FCFA)** | **% du total** |
|------------------------------------|--------------------|----------------|
| Conception et analyse (C1–C5)      | 1 000 000          | 27 %           |
| Développement (D1–D8)              | 2 300 000          | 62 %           |
| Formation et documentation (F1–F3) | 250 000            | 7 %            |
| Infrastructure de démonstration    | 0                  | 0 %            |
| **TOTAL INVESTISSEMENT INITIAL**   | **3 550 000**      | **100 %**      |

**7.2 Coûts récurrents (chaque année, en production)**

| **Rubrique**                                                      | **Montant annuel (FCFA)** |
|-------------------------------------------------------------------|---------------------------|
| Infrastructure cloud (serveur, domaine, sauvegardes, supervision) | 1 000 000                 |
| Maintenance corrective et évolutive                               | 550 000                   |
| **TOTAL ANNUEL RÉCURRENT**                                        | **1 550 000**             |

**7.3 Coût total sur 3 ans (production)**

| **Poste**                                | **Montant (FCFA)** |
|------------------------------------------|--------------------|
| Investissement initial                   | 3 550 000          |
| Coûts récurrents × 3 ans (1 550 000 × 3) | 4 650 000          |
| **TOTAL SUR 3 ANS**                      | **8 200 000**      |

**8. Planning de paiement**

| **Échéance**                                 | **% du montant initial** | **Montant (FCFA)** | **Condition de versement**                        |
|----------------------------------------------|--------------------------|--------------------|---------------------------------------------------|
| À la signature / démarrage                   | 30 %                     | 1 065 000          | Lancement de l'analyse et de la conception        |
| À la livraison de la version bêta validée    | 40 %                     | 1 420 000          | Tous les modules fonctionnels en démonstration    |
| À la mise en production + formation terminée | 30 %                     | 1 065 000          | Recette validée, guide remis, utilisateurs formés |
| **Total**                                    | **100 %**                | **3 550 000**      |                                                   |

**9. Comparaison : situation actuelle vs solution proposée**

| **Critère**                                   | **Gestion actuelle (papier / Excel dispersés)** | **SGPE proposé**                             |
|-----------------------------------------------|-------------------------------------------------|----------------------------------------------|
| Connaissance du patrimoine                    | Inventaires incomplets, doublons                | Inventaire centralisé et exhaustif           |
| Recherche d'un bien                           | Plusieurs minutes à plusieurs heures            | Résultats en quelques secondes               |
| Suivi des mouvements                          | Aucune traçabilité fiable                       | Historique complet horodaté                  |
| Coût de stockage des documents                | Armoires, scans manuels                         | Documents numériques liés aux fiches         |
| Erreurs et pertes de biens                    | Fréquentes, difficiles à constater              | Alertes et contrôles automatiques            |
| Rapports pour la direction                    | Saisie manuelle des tableaux                    | Rapports PDF/Excel générés en quelques clics |
| Coût annuel estimé (temps des agents, pertes) | Élevé et invisible                              | Maîtrisé et visible (1 550 000 FCFA/an)      |

**10. Hypothèses, limites et risques**

**Hypothèse prise en compte**

- Les données existantes peuvent être importées depuis des fichiers Excel/CSV

- Les postes de travail disposent d'un navigateur web moderne

- Une connexion Internet est disponible dans les services utilisateurs

**Limites de cette version**

| **Limite**                              | **Explication**                                                  |
|-----------------------------------------|------------------------------------------------------------------|
| Pas de paiement en ligne                | Les encaissements restent gérés par la comptabilité publique     |
| Pas d'application mobile hors connexion | Le recensement terrain se fera via le site web mobile responsive |
| Pas d'intégration comptable automatique | Prévue en version 2                                              |
| Hébergement gratuit limité en démo      | Limites de débit et mise en veille des offres gratuites          |

**Risques et mesures d’atténuation**

| **Risque**                          | **Mesure d'atténuation**                                                         |
|-------------------------------------|----------------------------------------------------------------------------------|
| Données initiales incomplètes       | Phase de recensement et import progressif avant généralisation                   |
| Résistance au changement            | Formation des utilisateurs + guide illustré + accompagnement initial             |
| Coupure Internet sur certains sites | Sauvegardes régulières ; future version hors connexion en v2                     |
| Évolution des besoins               | Architecture microservices modulaire : ajout d'un service sans tout reconstruire |
