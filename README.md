# Projet Café des Chiens - ESGI

## 📋 Description

Ce projet est un site de réservation de garde de chien en ligne pour le Café des Chiens, basé au Versoud, à côté de Grenoble en Isère.
Il a été réalisé dans le cadre du projet annuel pour le cursus de Mastère 1 en Ingénierie du Web à l'ESGI de Grenoble.

Ce projet a été réalisé par Baptiste SAUVAGE, Anita CHAUDHARY et Nicolas OSBORNE.

### 🛠️ Technologies & librairies utilisées

- **Symfony**
- **Twig**
- **SCSS/SASS**
- **Atomic Design**

## 📋 Prérequis

Pour exécuter ce projet, assurez-vous d'avoir déjà installé les outils suivants :

- Composer
- Symfony
- npm ou yarn

## 🚀 Guide d'installation

Pour lancer l'application complète, ouvrez un terminal et exécutez les commandes suivantes :

### 1️⃣ Cloner le dépôt

```bash
- git clone https://github.com/baptwild/coffee-dog.git
- cd coffee-dog

```

### 2️⃣ Configurer les variables d'environnement :

Dans un fichier .env.local à la racine du projet, renseigner l'accès au serveur pour la base de données (mySQL ou autre) :

```bash
DATABASE_URL="mysql://<user>:<password>@127.0.0.1:3306/<db_name>?serverVersion=8.3.0&charset=utf8mb4"
```

### 3️⃣ Installer les dépendances :

```bash
- composer install
```

```bash
- symfony console doctrine:database:create
- symfony console doctrine:migrations:migrate
```

```bash
- npm install
ou
- yarn install
```

### 4️⃣ Lancer le projet :

Dans un premier terminal, lancer le backend avec l'application Symfony :

```bash
- symfony server:start
```

Et dans un second terminal, lancer la compilation des assets (SASS avec Webpack Encore) :

```bash
- npm run watch
ou
- yarn watch
```

## 🌐 Accéder à l'application

L'application sera accessible à l'URL : https://127.0.0.1:8000
