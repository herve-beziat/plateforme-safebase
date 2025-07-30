# 🛡️ SafeBase – Application de sauvegarde de bases de données

SafeBase est une application web développée avec le framework Symfony.  
Elle permet aux utilisateurs de sauvegarder automatiquement leurs bases de données MySQL/MariaDB, de consulter l’historique des sauvegardes et de restaurer une version précédente en cas de besoin.

---

## ⚙️ Prérequis

Avant de commencer, assurez-vous d’avoir installé les outils suivants :

- PHP 8.2+
- Composer
- Docker & Docker Compose
- Symfony CLI (optionnel)
- Git

---

## 🚀 Installation du projet

### 1. Cloner le dépôt

```bash
git clone https://github.com/ton-utilisateur/safebase.git
cd safebase
```

### 2. Installer les dépendances PHP

```bash
composer install
```

---

## 🐳 Lancer le projet avec Docker

### 1. Lancer les conteneurs

```bash
docker-compose up --build -d
```

Ce fichier `docker-compose.yml` lance les services suivants :
- `web` : Conteneur PHP/Apache avec Symfony
- `db` : Base de données MariaDB
- `phpmyadmin` : Interface graphique de gestion MySQL

### 2. Accéder à l'application

- **Application Symfony** : [http://localhost:8000](http://localhost:8000)
- **phpMyAdmin** : [http://localhost:8081](http://localhost:8081)  
  - Identifiant : `root`  
  - Mot de passe : `root`  
  - Hôte : `db`

---

## 🛠️ Commandes utiles

### 📦 Symfony

```bash
php bin/console make:entity
php bin/console doctrine:migrations:diff
php bin/console doctrine:migrations:migrate
php bin/console cache:clear
```

### 🐚 Docker

```bash
docker exec -it safebase_web bash     # Accéder au conteneur PHP
docker-compose down                   # Arrêter les conteneurs
```

---

## 🗂️ Structure du projet (extrait)

```
safebase/
├── docker/
│   └── php/
│       └── Dockerfile
├── public/
├── src/
├── templates/
├── .env
├── .env.docker
├── docker-compose.yml
├── README.md
```

---

## ✍️ Auteur

Projet réalisé par **Hervé BEZIAT**  
Dans le cadre du **Titre professionnel DCA – Développeur Concepteur d’Applications**
