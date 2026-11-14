# 📖 Guide d'utilisation — Système de Gestion du Patrimoine de l'État (SGPE)

> **Version :** 1.0.0
> **Date :** 14 novembre 2026
> **Auteur :** Saba Felicio

---

## 📋 Sommaire

- [1. Présentation du système](#1-présentation-du-système)
- [2. Accès à l'application](#2-accès-à-lapplication)
- [3. Gestion des biens](#3-gestion-des-biens)
- [4. Gestion des affectations](#4-gestion-des-affectations)
- [5. Gestion des utilisateurs](#5-gestion-des-utilisateurs)
- [6. Tableau de bord](#6-tableau-de-bord)
- [7. Rapports et exports](#7-rapports-et-exports)
- [8. Gestion des erreurs](#8-gestion-des-erreurs)
- [9. Bonnes pratiques](#9-bonnes-pratiques)

---

## 1. 🏛️ Présentation du système

Le **Système de Gestion du Patrimoine de l'État (SGPE)** est une application web permettant de centraliser et de suivre l'ensemble des biens et équipements de l'État.

### 🎯 Fonctionnalités principales
- 📦 **Inventaire complet** des biens (matériel informatique, mobilier, véhicules, etc.)
- 🔄 **Suivi des mouvements** et des affectations entre services
- 👥 **Gestion des comptes utilisateurs** et des droits d'accès
- 📊 **Génération de rapports** et exports de données

---

## 2. 🔐 Accès à l'application

### 2.1 Se connecter
1. Ouvrez votre navigateur et allez sur : [http://localhost:8080](http://localhost:8080)
2. Saisissez votre **adresse email**
3. Saisissez votre **mot de passe**
4. Cliquez sur **Se connecter**

### 2.2 Se déconnecter
- Cliquez sur votre nom en haut à droite de l'écran
- Sélectionnez **Déconnexion**
- Vous êtes redirigé vers la page de connexion

> ⚠️ **En cas d'échec de connexion :**
> - Vérifiez que vous avez bien saisi vos identifiants
> - Vérifiez que votre compte est bien **Actif**
> - Contactez l'administrateur si le problème persiste

---

## 3. 📦 Gestion des biens

### 3.1 Consulter la liste des biens
- À la connexion, le tableau de bord s'affiche
- Cliquez sur **Inventaire des biens** dans le menu
- La liste complète des biens s'affiche sous forme de tableau

### 3.2 Rechercher un bien
- Saisissez un mot-clé dans la barre de recherche
- Vous pouvez chercher par : désignation, numéro de série, marque...
- La liste se met à jour automatiquement

### 3.3 Ajouter un nouveau bien
1. Cliquez sur **➕ Ajouter un bien**
2. Remplissez le formulaire :
   - **Désignation** — Nom ou identification du bien (obligatoire)
   - **Catégorie** — Matériel informatique, Mobilier, Véhicule, etc. (obligatoire)
   - **Marque / Modèle** — Informations complémentaires
   - **Numéro de série** — Identifiant unique du bien
   - **Date d'achat** — Date d'acquisition
   - **Valeur** — Prix d'achat en FCFA
   - **État** — Neuf / Bon / Moyen / Dégradé / Hors service
   - **Emplacement** — Lieu où se trouve le bien
   - **Responsable** — Personne qui utilise ou gère le bien
   - **Notes** — Observations complémentaires
3. Cliquez sur **Enregistrer**
4. ✅ Message de confirmation : *"Bien créé avec succès"*

### 3.4 Voir les détails d'un bien
- Dans la liste, cliquez sur l'icône 👁️ sur la ligne du bien
- La fiche détaillée s'ouvre avec toutes les informations

### 3.5 Modifier un bien
1. Ouvrez la fiche du bien
2. Cliquez sur **✏️ Modifier**
3. Mettez à jour les informations nécessaires
4. Cliquez sur **Enregistrer**
5. ✅ Message : *"Bien mis à jour avec succès"*

### 3.6 Supprimer un bien
1. Dans la liste, cliquez sur l'icône 🗑️
2. Confirmez la suppression en cliquant sur **OK**
3. ✅ Message : *"Bien supprimé avec succès"*

> ⚠️ **Attention :** La suppression est définitive. Vérifiez avant de confirmer.

---

## 4. 🔄 Gestion des affectations

### 4.1 Qu'est-ce qu'une affectation ?
Une affectation correspond au déplacement ou à la mise à disposition d'un bien auprès d'un service ou d'une personne, sur une période donnée.

### 4.2 Enregistrer une nouvelle affectation
1. Allez dans le menu **Affectations**
2. Cliquez sur **➕ Nouvelle affectation**
3. Remplissez le formulaire :
   - **Bien concerné** — Sélectionnez le bien dans la liste
   - **Service destinataire** — Service qui reçoit le bien
   - **Responsable** — Personne qui prend en charge le bien
   - **Date d'affectation** — Date de début de l'affectation
   - **Date de fin** — Date de restitution (optionnelle)
   - **Motif** — Raison de l'affectation
   - **État** — En cours / Terminée / Annulée
4. Cliquez sur **Enregistrer**

### 4.3 Suivre les affectations
- La liste affiche toutes les affectations en cours et passées
- Utilisez les filtres pour voir :
  - Seulement les affectations **En cours**
  - Seulement les affectations **Terminées**
  - Par service ou par bien

### 4.4 Modifier ou clôturer une affectation
- Cliquez sur une affectation pour l'ouvrir
- Mettez à jour les informations ou changez l'état en **Terminée**
- Enregistrez les modifications

---

## 5. 👥 Gestion des utilisateurs

> 🔒 **Accès réservé aux administrateurs uniquement**

### 5.1 Liste des utilisateurs
- Allez dans **Utilisateurs**
- La liste affiche tous les comptes du système

### 5.2 Créer un utilisateur
1. Cliquez sur **➕ Ajouter un utilisateur**
2. Remplissez le formulaire :
   - **Nom et Prénom**
   - **Email** — Sera utilisé pour la connexion (unique)
   - **Mot de passe** — Minimum 6 caractères
   - **Téléphone**
   - **Rôle** :
     - `Admin` — Accès complet
     - `Gestionnaire` — Gestion des biens et affectations
     - `Utilisateur` — Consultation seulement
   - **Statut** — Actif / Inactif
3. Cliquez sur **Créer l'utilisateur**

### 5.3 Modifier un compte
- Cliquez sur l'utilisateur dans la liste
- Modifiez les informations nécessaires
- Le mot de passe n'est modifié que si vous saisissez une nouvelle valeur

### 5.4 Désactiver un compte
- Au lieu de supprimer un compte, passez son statut à **Inactif**
- L'utilisateur ne peut plus se connecter mais l'historique de ses actions est conservé

---

## 6. 📊 Tableau de bord

Dès votre connexion, le tableau de bord vous présente :

| Indicateur | Signification |
|---|---|
| **Total des biens** | Nombre total d'enregistrements dans l'inventaire |
| **En utilisation** | Biens actuellement affectés à un service |
| **Disponibles** | Biens libres et prêts à être affectés |
| **Utilisateurs actifs** | Nombre de comptes en activité |

Ces chiffres se mettent à jour automatiquement après chaque modification.

---

## 7. 📈 Rapports et exports

### 7.1 Générer un rapport
1. Allez dans **Rapports**
2. Sélectionnez le type de rapport souhaité :
   - 📋 **Inventaire complet** — Liste de tous les biens
   - 📊 **Par catégorie** — Répartition par type de bien
   - 🏢 **Par service** — Biens par service d'affectation
   - 📅 **Mouvements** — Historique des affectations sur une période
3. Cliquez sur **Générer**

### 7.2 Exporter les données
- **Exporter en CSV** — Pour ouvrir dans Excel ou un tableur
- **Exporter en PDF** — Pour impression ou archivage

> 💡 Les exports génèrent un fichier téléchargeable automatiquement.

---

## 8. ⚠️ Gestion des erreurs

| Problème | Cause probable | Solution |
|---|---|---|
| **Impossible de se connecter** | Mauvais identifiants ou compte inactif | Vérifiez votre email et mot de passe / Contactez l'admin |
| **Enregistrement refusé** | Champ obligatoire vide ou valeur incorrecte | Vérifiez les messages d'erreur sous chaque champ |
| **Données qui ne s'affichent pas** | Connexion au serveur momentanément indisponible | Réessayez quelques instants plus tard |
| **Recherche infructueuse** | Mot-clé trop précis ou inexact | Élargissez vos critères de recherche |

---

## 9. ✅ Bonnes pratiques

- 🔒 **Sécurité** — Ne partagez jamais votre mot de passe
- 💾 **Enregistrement** — Pensez à valider chaque saisie
- 🔍 **Doublons** — Vérifiez avant de créer un bien déjà enregistré
- 📝 **Précision** — Renseignez le plus de détails possible sur chaque bien
- 🔄 **Mises à jour** — Modifiez immédiatement l'emplacement ou l'état d'un bien dès qu'il change
- 🚪 **Déconnexion** — Déconnectez-vous systématiquement après utilisation

---

## 📞 Support et assistance

En cas de difficulté ou pour signaler un problème :
- **Documentation technique :** Voir `fiche_technique.md`
- **Analyse du besoin :** Voir `analyse_besoin.md`
- **Conception UML :** Voir `conception_uml.md`

---

> *"Ce système est maintenu dans un cadre académique. Vos retours et vos suggestions d'amélioration sont les bienvenus."*
