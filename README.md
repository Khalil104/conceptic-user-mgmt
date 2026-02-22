# 🚀 Laravel User Management API

Ce projet est une API REST de gestion d'utilisateurs développée avec **Laravel 11**. Elle implémente une architecture propre avec le **Pattern Repository/Service**, une validation stricte via les **Form Requests** et une documentation OpenAPI ex Swagger complète.

## 📋 Fonctionnalités

* **CRUD Complet** : Création, lecture, mise à jour et suppression d'utilisateurs.
* **Validation avancée** : Gestion des doublons d'emails et formats de données.
* **Architecture Pro** : Découplage de la logique (Controller -> Service -> Repository).
* **Documentation Interactive** : Swagger UI intégré.
* **Qualité Logicielle** : Tests unitaires et fonctionnels avec rapport de couverture.

---

## 🛠️ Prérequis

* **PHP** >= 8.2 (avec extension **PCOV** pour la couverture de tests)
* **Composer**
* **PostgreSQL** ou **SQLite**(pour les tests)  
* **Git**

---

## ⚙️ Installation & Configuration

### 1. Cloner et Installer

```bash
git clone https://github.com/Web104/laravel-app.git
cd laravel-app
composer install

```

### 2. Environnement

```bash
cp .env.example .env
php artisan key:generate

```

*Note : Assurez-vous que les dossiers de stockage existent (requis pour Swagger sur Windows) :*

```bash
mkdir storage\framework\views

```

### 3. Base de données

Configurez votre `.env`, puis :

```bash
php artisan migrate --seed

``` 

---

## 📑 Documentation de l'API

L'API est documentée avec **Swagger (L5-Swagger)**. En cas de modification des annotations, suivez ces étapes :

### Générer la documentation

Si vous rencontrez l'erreur `Required @OA\PathItem() not found`, nettoyez le cache avant de générer :

```bash
php artisan config:clear
php artisan l5-swagger:generate

```

### Accéder aux interfaces

* **Swagger UI (Interactif)** : `http://127.0.0.1:8000/api/documentation`
* **Postman** : Importez le fichier généré situé dans `storage/api-docs/api-docs.json`.

---

## 🧪 Tests & Qualité

Le projet inclut des tests unitaires (Models) et fonctionnels (API).

### Exécuter les tests

```bash
php artisan test

```

### Couverture de code (Code Coverage)

Pour générer le rapport de couverture (nécessite l'extension `pcov` ou `xdebug`) :

```bash
# Rapport dans le terminal
php artisan test --coverage

# Rapport HTML détaillé (recommandé pour audit).
php artisan test --coverage-html=tests/coverage

```

*Le rapport sera disponible dans `tests/coverage/index.html`.*

---

### Accéder aux interfaces

* **Swagger UI (Interactif)** : Rendez-vous sur `http://127.0.0.1:8000/api/documentation` pour tester l'API directement depuis le navigateur.
* **Postman** : Pour importer les requêtes, ouvrez Postman > Import > Sélectionnez le fichier `storage/api-docs/api-docs.json`. Cela créera automatiquement une collection prête à l'emploi.

---

## 📁 Structure du Projet

* **Controllers** : `app/Http/Controllers/Api` (Annotations Swagger en Attributes PHP 8.2)
* **Services** : `app/Services` (Logique métier - **Couverture 100%**)
* **Repositories** : `app/Repositories` (Abstraction de la base de données)
* **Tests** : `tests/Feature` et `tests/Unit`

---

## 🚀 Troubleshooting (Problèmes fréquents)

* **Erreur 500 sur Swagger UI** : Lancez `php artisan view:clear` et vérifiez que le dossier `storage/framework/views` existe.
* **Assets Swagger manquants** : Exécutez `php artisan vendor:publish --provider="L5Swagger\L5SwaggerServiceProvider"`.
* **Tests échoués** : Vérifiez que votre fichier `phpunit.xml` utilise bien une base de données en mémoire (`sqlite` / `:memory:`).

---

