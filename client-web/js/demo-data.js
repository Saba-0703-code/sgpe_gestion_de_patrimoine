// js/demo-data.js — Données de test pour la démo
const DEMO_DATA = {
    biens: [
        { id: 1, designation: "Véhicule administratif TOYOTA", categorie: "Mobilier roulant", etat: "Bon", localisation: "Lomé", date_achat: "2023-05-15", valeur: "8 500 000 FCFA" },
        { id: 2, designation: "Ordinateur portable HP", categorie: "Matériel informatique", etat: "Neuf", localisation: "Siège Central", date_achat: "2024-01-10", valeur: "450 000 FCFA" },
        { id: 3, designation: "Bureau administratif N°12", categorie: "Mobilier de bureau", etat: "Moyen", localisation: "Annexe A", date_achat: "2018-11-03", valeur: "125 000 FCFA" },
        { id: 4, designation: "Imprimante multifonction CANON", categorie: "Matériel informatique", etat: "Bon", localisation: "Service Comptabilité", date_achat: "2022-08-22", valeur: "280 000 FCFA" },
        { id: 5, designation: "Parcelle urbaine — Secteur 3", categorie: "Immobilier", etat: "Bon", localisation: "Adidogomé", date_achat: "2015-03-01", valeur: "45 000 000 FCFA" },
    ],
    utilisateurs: [
        { id: 1, nom: "Admin", prenom: "SGPE", email: "admin@gouv.tg", role: "Administrateur", statut: "Actif" },
        { id: 2, nom: "Kouassi", prenom: "Amara", email: "a.kouassi@gouv.tg", role: "Gestionnaire", statut: "Actif" },
        { id: 3, nom: "Mensah", prenom: "Afi", email: "a.mensah@gouv.tg", role: "Utilisateur", statut: "Actif" },
    ],
    statistiques: {
        total_biens: 1247,
        valeur_totale: "2 450 000 000 FCFA",
        en_bonne_etat: 1089,
        a_reviser: 158,
        categories: 12
    }
};

// Initialiser les données au premier chargement
if (!localStorage.getItem('biens')) {
    localStorage.setItem('biens', JSON.stringify(DEMO_DATA.biens));
}
