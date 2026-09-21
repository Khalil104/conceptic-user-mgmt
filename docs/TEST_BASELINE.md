# Baseline des tests — Avant refonte v2

- **Date :** 2025-09-21
- **Branche :** test
- **Tag de référence :** v1.0.0-legacy

## Résumé Exécutif

La couverture de code globale est en zone de grand danger (1.80%). Sur les 9 tests exécutés, 6 ont échoué (66.6% d'échec), ce qui explique pourquoi la quasi-totalité de l'application n'est pas couverte. De plus, plusieurs classes critiques présentent des indices de risque (CRAP) extrêmement élevés.

## Couverture par Composants (Détails)

| Composant | Lignes Couvertes | Fonctions/Méthodes | Classes/Traits | Statut |
|---|---|---|---|---|
| Global (Total) | 1.80% (14/778) | 2.70% (3/111) | 3.85% (1/26) | 🔴 Danger |
| Models | 60.00% (3/5) | 33.33% (1/3) | 33.33% (1/3) | 🟡 Warning |
| Providers | 50.00% (3/6) | 50.00% (1/2) | 0.00% (0/1) | 🔴 Danger |
| Observers | 22.22% (8/36) | 20.00% (1/5) | 0.00% (0/1) | 🔴 Danger |
| Http (Controllers/Requests) | 0.00% (0/399) | 0.00% (0/36) | 0.00% (0/9) | 🔴 Danger |
| Services | 0.00% (0/185) | 0.00% (0/18) | 0.00% (0/3) | 🔴 Danger |
| Repositories | 0.00% (0/46) | 0.00% (0/19) | 0.00% (0/2) | 🔴 Danger |
| Exports | 0.00% (0/35) | 0.00% (0/4) | 0.00% (0/1) | 🔴 Danger |
| Notifications | 0.00% (0/30) | 0.00% (0/10) | 0.00% (0/2) | 🔴 Danger |
| Mail | 0.00% (0/28) | 0.00% (0/12) | 0.00% (0/3) | 🔴 Danger |
| Traits | 0.00% (0/8) | 0.00% (0/2) | 0.00% (0/1) | 🔴 Danger |

------------------------------
## Top 5 des Risques du Projet (Indice CRAP)
L'indice CRAP mesure la complexité d'un code couplé à son manque de tests. Plus le score est élevé, plus le code est une "bombe à retardement" difficile à maintenir.

   1. App\Http\Controllers\Api\AuthController : 1640 (Score critique maximal — Priorité absolue)
   2. App\Services\AuthService : 506 (Risque très élevé)
   3. App\Http\Controllers\Api\UserController : 420 (Risque élevé)
   4. App\Services\UserService : 240 (Risque modéré-élevé)
   5. App\Repositories\UserRepository : 182

## Méthodes à haut risque

* updateField dans UserService (CRAP: 90 — Non couverte)
* verify2fa dans AuthController / AuthService (CRAP: 42 et 30 — Non couvertes)
* login dans AuthController (CRAP: 30 — Non couverte)

## Résultat des Tests

* Total des tests : 9 tests (11 assertions)
* Échecs : 6 échoués
* Succès : 3 réussis
* Temps d'exécution : 1.33 seconde

## Objectif v2

- Couverture Services : 100%
- Couverture Repositories : ≥ 90%
- Couverture globale : ≥ 80%
- Nombre de tests : ≥ 50