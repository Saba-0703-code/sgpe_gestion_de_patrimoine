# Analyse du Besoin

**Objectif :** Comprendre clairement le problème, ce que le système doit faire, pour qui, et quelles sont les contraintes.

**1. Contexte du projet**

L'État dispose d'un patrimoine important et varié : bâtiments administratifs, écoles, hôpitaux, terrains, véhicules, équipements, œuvres, archives… Ce patrimoine est actuellement géré de manière dispersée : chaque ministère ou département a ses propres listes, souvent sur papier ou dans des fichiers Excel déconnectés les uns des autres.

**Les problèmes rencontrés :**

Personne ne connaît exactement ce que possède l'État

Les biens sont parfois utilisés sans suivi officiel

Il est difficile de savoir dans quel état ils sont

Les ventes, dons ou dégradations ne sont pas toujours enregistrés

Aucune vision d'ensemble ne permet de prendre de bonnes décisions

**La solution attendue :**

Un système informatique centralisé qui permet de recenser, suivre, valoriser et contrôler l'ensemble du patrimoine de l'État, avec une traçabilité complète et une information fiable et accessible.

**2. Problématique**

Comment mettre en place un système d'information fiable, sécurisé et évolutif permettant de gérer efficacement le patrimoine de l'État, tout en assurant la traçabilité des biens et la transparence de leur gestion ?

**3. Objectifs du système**

Concevoir et développer un Système de Gestion du Patrimoine de l'État (SGPE) qui offre une vue centralisée et à jour de l'ensemble des biens de l'État, depuis leur acquisition jusqu'à leur cession.

**Objectifs spécifiques**

| **N°** | **Objectif**                                                                   |
|--------|--------------------------------------------------------------------------------|
| OS1    | Permettre un recensement exhaustif et une identification unique de chaque bien |
| OS2    | Assurer le suivi du cycle de vie complet d'un bien                             |
| OS3    | Centraliser la gestion des documents juridiques liés aux biens                 |
| OS4    | Garantir la sécurité et la traçabilité des actions effectuées dans le système  |
| OS5    | Fournir des données et rapports fiables pour la prise de décision              |
| OS6    | Proposer une architecture modulaire pour faciliter les évolutions futures      |

**4. Identification des acteurs**

| **Acteur**                     | **Rôle**                                                               | **Besoin principal**                                                           |
|--------------------------------|------------------------------------------------------------------------|--------------------------------------------------------------------------------|
| **Administrateur système**     | Gère les comptes utilisateurs, les rôles et les paramètres du système  | S'assurer que seules les personnes autorisées accèdent aux bonnes informations |
| **Gestionnaire de patrimoine** | Saisit, consulte et met à jour les fiches des biens de son département | Pouvoir créer, modifier et suivre facilement les biens dont il a la charge     |
| **Agent de contrôle / Audit**  | Vérifie la cohérence des données et génère des rapports                | Disposer d'une vue fiable et rapide pour contrôler et analyser le patrimoine   |
| **Consultateur / Public**      | Consulter les informations générales en lecture seule                  | Accéder aux informations du patrimoine sans pouvoir les modifier               |

**5. Périmètre du système**

- Recensement et identification de tous les types de biens de l'État (immobiliers, mobiliers, financiers, culturels)

- Suivi du cycle de vie complet : acquisition → affectation/utilisation → entretien → cession/réforme

- Gestion des documents et des échéances liés aux biens

- Gestion des utilisateurs et des droits d'accès par profil

- Tableaux de bord et rapports statistiques exportables

- Historique des mouvements et traçabilité complète des actions

- Géolocalisation des biens immobiliers

- Recherche et filtrage des biens selon plusieurs critères

- Interface web responsive accessible depuis ordinateur et tablette

**6. Exigences fonctionnelles**

**Module 1 : Inventaire et Identification**

| **N°** | **Fonctionnalité**              | **Description**                                                        | **Acteur concerné**       |
|--------|---------------------------------|------------------------------------------------------------------------|---------------------------|
| F1.1   | Créer une fiche de bien         | Saisir les informations complètes d'un nouveau bien                    | Gestionnaire              |
| F1.2   | Consulter une fiche de bien     | Afficher les détails d'un bien précis                                  | Tous                      |
| F1.3   | Modifier une fiche de bien      | Corriger ou mettre à jour les informations                             | Gestionnaire              |
| F1.4   | Supprimer une fiche de bien     | Retirer un bien (avec justification et traçabilité)                    | Administrateur            |
| F1.5   | Rechercher un bien              | Trouver un bien par référence, nom, type ou localisation               | Tous                      |
| F1.6   | Filtrer et trier                | Afficher les biens selon des critères (état, type, date, département…) | Tous                      |
| F1.7   | Localiser un bien               | Voir la position d'un bien immobilier sur une carte interactive        | Gestionnaire / Contrôleur |
| F1.8   | Joindre des documents et photos | Ajouter des fichiers, images ou scans à la fiche d'un bien             | Gestionnaire              |
| F1.9   | Importer des biens en masse     | Intégrer un inventaire complet depuis un fichier Excel/CSV             | Administrateur            |

**Module 2 : Cycle de vie du bien**

| **N°** | **Fonctionnalité**                 | **Description**                                                                                    | **Acteur concerné**       |
|--------|------------------------------------|----------------------------------------------------------------------------------------------------|---------------------------|
| F2.1   | Enregistrer une acquisition        | Enregistrer l'entrée d'un bien dans le patrimoine (valeur, date, fournisseur)                      | Gestionnaire              |
| F2.2   | Affecter un bien                   | Attribuer un bien à un service, un ministère ou une personne                                       | Gestionnaire              |
| F2.3   | Enregistrer un mouvement           | Suivre les changements d'affectation ou de localisation avec date et motif                         | Gestionnaire              |
| F2.4   | Planifier un entretien             | Programmer des interventions de maintenance périodique                                             | Gestionnaire              |
| F2.5   | Suivre l'état du bien              | Mettre à jour l'état physique du bien (neuf → bon → moyen → dégradé)                               | Gestionnaire / Contrôleur |
| F2.6   | Enregistrer une cession ou réforme | Retirer définitivement un bien du patrimoine (vente, don, démolition, perte) avec décision motivée | Administrateur            |
| F2.7   | Consulter l'historique complet     | Voir toutes les étapes de la vie d'un bien depuis son acquisition                                  | Tous                      |

**Module 3 : Documents et Alertes**

| **N°** | **Fonctionnalité**        | **Description**                                                             | **Acteur concerné**           |
|--------|---------------------------|-----------------------------------------------------------------------------|-------------------------------|
| F3.1   | Classer des documents     | Attacher des titres fonciers, baux, contrats, décisions aux biens concernés | Gestionnaire                  |
| F3.2   | Consulter les documents   | Voir et télécharger les fichiers joints aux biens                           | Tous                          |
| F3.3   | Enregistrer une échéance  | Noter la date de fin de validité d'un document                              | Gestionnaire                  |
| F3.4   | Être alerté des échéances | Notifications visuelles pour les documents qui expirent bientôt             | Gestionnaire / Administrateur |
| F3.5   | Archiver un document      | Déplacer un document dans les archives sans le supprimer définitivement     | Administrateur                |

**Module 4 : Administration et Sécurité**

| **N°** | **Fonctionnalité**                 | **Description**                                                                    | **Acteur concerné** |
|--------|------------------------------------|------------------------------------------------------------------------------------|---------------------|
| F4.1   | Créer un compte utilisateur        | Ajouter un nouvel utilisateur dans le système                                      | Administrateur      |
| F4.2   | Gérer les rôles et droits          | Définir ce que chaque profil peut faire (Lecteur, Gestionnaire, Contrôleur, Admin) | Administrateur      |
| F4.3   | Désactiver un compte               | Empêcher l'accès sans perdre l'historique des actions                              | Administrateur      |
| F4.4   | Consulter l'historique des actions | Journal complet : qui a fait quoi, quand et depuis quelle adresse IP               | Administrateur      |
| F4.5   | S'authentifier                     | Se connecter avec identifiant et mot de passe sécurisé                             | Tous                |
| F4.6   | Modifier son mot de passe          | Permettre à l'utilisateur de changer son mot de passe                              | Tous                |

**Module 5 : Rapports et Tableau de bord**

| **N°** | **Fonctionnalité**                           | **Description**                                                                                | **Acteur concerné**         |
|--------|----------------------------------------------|------------------------------------------------------------------------------------------------|-----------------------------|
| F5.1   | Voir le tableau de bord                      | Nombre total de biens, valeur globale, répartition par type/état/département, alertes en cours | Tous                        |
| F5.2   | Générer un rapport                           | Exporter des données en PDF ou Excel selon différents critères                                 | Contrôleur / Administrateur |
| F5.3   | Consulter les statistiques                   | Valeur du patrimoine, évolution dans le temps, taux d'occupation, biens sans titre             | Contrôleur / Administrateur |
| F5.4   | Consulter la liste des biens par département | Filtrer et exporter le patrimoine par service responsable                                      | Contrôleur / Administrateur |

**7. Exigences non fonctionnelles**

| **N°** | **Critère**                   | **Exigence**                                                                                                                                            | **Justification**                                                                               |
|--------|-------------------------------|---------------------------------------------------------------------------------------------------------------------------------------------------------|-------------------------------------------------------------------------------------------------|
| NF1    | **Sécurité**                  | Authentification obligatoire ; mots de passe hachés ; chaque action est tracée dans un journal ; déconnexion automatique après inactivité               | Le système contient des informations sensibles et stratégiques                                  |
| NF2    | **Disponibilité**             | Accessible 24h/24 hors maintenance planifié ; sauvegarde quotidienne automatique des bases de données ; conservation des données pendant 10 ans minimum | Les informations du patrimoine doivent être consultables à tout moment et conservées légalement |
| NF3    | **Performance**               | Chargement des pages en moins de 3 secondes même avec 50 000+ biens ; résultats de recherche affichés en moins de 2 secondes                            | L'utilisateur ne doit pas être ralenti dans son travail quotidien                               |
| NF4    | **Convivialité**              | Interface claire en français ; navigation intuitive ; pas de formation complexe nécessaire ; aide contextuelle disponible                               | Les utilisateurs ne sont pas tous des spécialistes informatiques                                |
| NF5    | **Fiabilité des données**     | Vérification des informations saisies ; pas de suppression définitive sans confirmation ; historique non modifiable après validation                    | Les données servent de référence officielle et doivent être fiables                             |
| NF6    | **Évolutivité**               | Architecture microservices permettant d'ajouter ou de modifier un module sans perturber les autres ; code documenté et structuré                        | Le système devra s'enrichir de nouvelles fonctionnalités au fil du temps                        |
| NF7    | **Portabilité & Déploiement** | Conteneurisation complète avec Docker ; fichier de configuration unique ; documentation d'installation détaillée ; fonctionne sur tout serveur moderne  | Faciliter le déploiement dans différents environnements et garantir la pérennité du système     |
| NF8    | **Accessibilité**             | Contraste suffisant ; textes lisibles ; navigation possible au clavier ; compatible avec les outils d'assistance                                        | Respecter les principes d'accessibilité des services publics                                    |
| NF9    | **Confidentialité**           | Les données ne sont accessibles qu'aux personnes autorisées ; les documents privés ne sont pas indexés publiquement                                     | Protéger les informations stratégiques et juridiques de l'État                                  |

**8. Contraintes du projet**

<table>
<colgroup>
<col style="width: 22%" />
<col style="width: 77%" />
</colgroup>
<thead>
<tr class="header">
<th><strong>Type</strong></th>
<th><strong>Contrainte</strong></th>
</tr>
<tr class="odd">
<th><strong>Délai de réalisation</strong></th>
<th>Du 10 novembre 2026 au 15 novembre 2026, livraison complète incluse</th>
</tr>
<tr class="header">
<th><strong>Modalité pédagogique</strong></th>
<th>Travail individuel</th>
</tr>
<tr class="odd">
<th><strong>Technologies imposées</strong></th>
<th>Back-end : Laravel (PHP) · Base de données : PostgreSQL · Déploiement : Docker + docker-compose.yml · Architecture : Microservices</th>
</tr>
<tr class="header">
<th><strong>Outils de conception</strong></th>
<th>Modélisation : UML (Cas d'utilisation, Classes, Séquence, Composants) · Maquettage : Figma</th>
</tr>
<tr class="odd">
<th><strong>Livrables obligatoires</strong></th>
<th><p>1. Lien de la plateforme hébergée gratuitement ·</p>
<p>2. Lien GitHub avec README détaillé et normalisé ·</p>
<p>3. Documents de conception (analyse, UML, design, proposition financière, fiche technique, guide d'utilisation)</p></th>
</tr>
<tr class="header">
<th><strong>Coût de déploiement</strong></th>
<th>Version déployée sur un hébergeur gratuit pour démonstration</th>
</tr>
<tr class="odd">
<th><strong>Propriété</strong></th>
<th>Solution conçue pour être appropriée et maintenable par l'administration publique</th>
</tr>
</thead>
<tbody>
</tbody>
</table>
