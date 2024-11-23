# Projet de Gestion

## Description

Ce projet est une application de gestion. L'application est développée en PHP, avec une base de données SQLite pour stocker les informations.

### Fonctionnalités

- **Gestion des Produits** : Ajout, modification, suppression, et consultation des produits.
- **Gestion des Prestation** : Organisation des produits en différentes prestations.
- **Suivi des ventes** : Affichage des ventes totales journalières, hebdomadaires, mensuelles, et annuelles.
- **Génération de Facture** : Création et impression de facture.
- **Gestion de Prestataire** : Ajout, modification, suppression, et consultation des prestataires.

## Installation

### Prérequis

- Serveur web compatible avec PHP (ex. : XAMPP, WAMP, MAMP).
- SQLite installé.
- Navigateur web moderne (Chrome, Firefox, etc.).

### Étapes d'installation

1. **Clonez le dépôt**

2. **Accédez au répertoire du projet**

    ```bash
        cd Logiciel_Gestion
    ```

3. **Configurez la base de données**

    Assurez-vous que le fichier de base de données SQLite (`Gestion.db`) est présent dans le répertoire `BDD/`. Si ce n'est pas le cas, importez le fichier de base de données fourni ou créez-le selon le schéma de base de données fourni ci-dessous.

4. **Configurer le serveur web**

    Placez le projet dans le répertoire racine de votre serveur web (ex. : `htdocs` pour XAMPP).

5. **Accédez à l'application**

    Ouvrez votre navigateur et accédez à `http://localhost/Logiciel_Gestion/index.php`.