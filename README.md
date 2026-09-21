# Conceptic User Management API - Branche `test`

> Cette branche est conservée volontairement à des fins d'évaluation et de comparaison.
>
> Elle représente une version intermédiaire du projet avant la refonte majeure réalisée dans la branche `refactor/v2`.
>
> Pour une documentation complète, la version finale de l'architecture, les choix techniques détaillés et les évolutions apportées, veuillez consulter les branches **`refactor/v2`** ou **`master`**.

## Présentation

Cette application est une API REST de gestion d'utilisateurs développée avec Laravel.

Les principaux objectifs de cette version sont :

- Implémenter un CRUD utilisateur complet.
- Appliquer le pattern Repository / Service.
- Utiliser les Form Requests pour la validation.
- Documenter l'API avec Swagger.
- Mettre en place une stratégie de tests automatisés.

## Fonctionnalités

- Création, consultation, modification et suppression d'utilisateurs.
- Validation des données côté serveur.
- Documentation Swagger/OpenAPI.
- Tests unitaires et fonctionnels.
- Rapport de couverture de code.

## Installation rapide

```bash
git clone https://github.com/Khalil104/conceptic-user-mgmt.git

cd conceptic-user-mgmt

composer install

cp .env.example .env

php artisan key:generate

php artisan migrate --seed
```

## Documentation API

Génération de la documentation :

```bash
php artisan config:clear
php artisan l5-swagger:generate
```

Accès à Swagger :

```text
http://127.0.0.1:8000/api/documentation
```

## Tests

Exécution des tests :

```bash
php artisan test
```

Génération du rapport de couverture :

```bash
php artisan test --coverage-html=tests/coverage
```

Le rapport sera disponible dans :

```text
tests/coverage/index.html
```

## À propos de cette branche

Cette branche est principalement utilisée pour :

- Évaluer l'évolution du projet.
- Comparer l'ancienne et la nouvelle architecture.
- Mesurer les améliorations apportées lors de la refonte.

Les détails techniques complets, la documentation maintenue et la version recommandée du projet sont disponibles dans les branches **`refactor/v2`** et **`master`**.