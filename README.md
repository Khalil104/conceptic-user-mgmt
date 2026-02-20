# 🚀 Laravel User Management API

Ce projet est une API REST de gestion d'utilisateurs développée avec **Laravel 11**. Elle implémente une architecture propre avec le **Pattern Repository/Service**, une validation stricte via les **Form Requests**.

## 📋 Fonctionnalités

* **CRUD Complet** : Création, lecture, mise à jour et suppression d'utilisateurs.
* **Validation avancée** : Gestion des doublons d'emails et formats de données.
* **Architecture Pro** : Découplage de la logique (Controller -> Service -> Repository).
* **Authentification** : Prêt pour Sanctum.

---

## 🛠️ Prérequis

Avant de commencer, assurez-vous d'avoir installé :

* **PHP** >= 8.2
* **Composer**
* **PostgreSQL**
* **Git**

---

## ⚙️ Installation

### 1. Cloner le projet

```bash
git clone https://github.com/Web104/laravel-app.git
cd laravel-app

```

### 2. Installer les dépendances

```bash
composer install

```

### 3. Configuration de l'environnement

Copie le fichier d'exemple et génère la clé d'application :

```bash
cp .env.example .env
php artisan key:generate

```

### 4. Configuration de la base de données

Ouvrez votre fichier `.env` et configurez vos accès :

```env
DB_CONNECTION=pqsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=nom_de_votre_base
DB_USERNAME=root
DB_PASSWORD=votre_mot_de_passe

```

### 5. Migration et Données de test

Lancez les migrations pour créer les tables et (optionnel) peuplez la base :

```bash
php artisan migrate
# Pour créer des utilisateurs de test (si configuré) :
php artisan db:seed 

```

---

## 🚀 Exécution

### Lancer le serveur local

```bash
php artisan serve

```

L'API sera accessible sur : `http://127.0.0.1:8000`

---

## 📑 Utilisation de l'API (Endpoints)

| Méthode | Endpoint | Description |
| --- | --- | --- |
| **GET** | `/api/users` | Liste tous les utilisateurs |
| **POST** | `/api/users` | Créer un utilisateur |
| **GET** | `/api/users/{id}` | Détails d'un utilisateur |
| **PUT** | `/api/users/{id}` | Modifier un utilisateur |
| **DELETE** | `/api/users/{id}` | Supprimer un utilisateur |

> **⚠️ Note importante pour Postman :** > Pour toutes les requêtes, ajoutez le header suivant pour recevoir les erreurs au format JSON :
> `Accept: application/json`

---

## 🧪 Tests

Pour vérifier que la validation fonctionne (ex: envoyer un JSON vide) :

1. Ouvrez Postman.
2. Créez une requête `POST` sur `http://127.0.0.1:8000/api/users`.
3. Ajoute le header `Accept: application/json`.
4. Envoyez sans corps (body) : Vous devriez recevoir une erreur **422 Unprocessable Entity**.

---

## 📁 Structure du Projet

* **Controllers** : `app/Http/Controllers/Api`
* **Requests** : `app/Http/Requests` (Validation)
* **Services** : `app/Services` (Logique métier)
* **Repositories** : `app/Repositories` (Accès BDD)

---