# CONCEPTIC_USER_MGMT — Résumé exportable pour IA

## Objectif
Fournir un contexte exportable (architecture, modèles, spécificités) pour qu'un autre modèle d'IA reprenne le projet et continue le raisonnement.

**Contexte général**: API REST Laravel + panel web minimal pour gestion utilisateurs, 2FA par mail, restauration de compte, notifications, logs d'activité.

**Fichiers clés**:
- **Projet**: [composer.json](composer.json#L1-L200)
- **Routes Web**: [routes/web.php](routes/web.php#L1-L400)
- **Modèle Utilisateur**: [app/Models/User.php](app/Models/User.php#L1-L400)
- **Codes de vérification**: [app/Models/VerificationCode.php](app/Models/VerificationCode.php#L1-L200)
- **Logs d'activité**: [app/Models/ActivityLog.php](app/Models/ActivityLog.php#L1-L200)
- **Service Auth**: [app/Services/AuthService.php](app/Services/AuthService.php#L1-L400)
- **Repository Auth**: [app/Repositories/AuthRepository.php](app/Repositories/AuthRepository.php#L1-L400)
- **Trait Auth perso**: [app/Traits/HasCustomAuth.php](app/Traits/HasCustomAuth.php#L1-L200)
- **Observer Utilisateur**: [app/Observers/UserObserver.php](app/Observers/UserObserver.php#L1-L400)

---

**Architecture & Pattern**:
- **Framework**: Laravel 11 (backend API & web), PHP ^8.2. Voir [composer.json](composer.json#L1-L200).
- **Pattern**: séparation Service <-> Repository. Les controllers délèguent aux `Services` qui utilisent `Repositories` pour l'accès aux modèles.
- **Authentification**: Laravel Sanctum pour API tokens; sessions pour web (considéré dans `HasCustomAuth`).
- **Notifications / Mails**: Envoi d'emails pour activation, 2FA (`TwoFactorCodeMail`), restauration (`RestoreAccountCode`).
- **Observability**: `UserObserver` crée des `ActivityLog` pour create/update/delete/restore.

---

**Modèles principaux (concis)**:
- **User**: UUID primary key, `SoftDeletes`, `name`, `email`, `password`, `activate_token`, `status`, `role`. (voir [app/Models/User.php](app/Models/User.php#L1-L400))
- **VerificationCode**: `user_id`, `code` (6 chiffres), `expires_at` (cast datetime). Usage: 2FA et restauration. (voir [app/Models/VerificationCode.php](app/Models/VerificationCode.php#L1-L200))
- **ActivityLog**: `user_id`, `action`, `description`, `changes` (array), `ip_address`, `user_agent`. Lié à `User`. (voir [app/Models/ActivityLog.php](app/Models/ActivityLog.php#L1-L200))

---

**Flux importants**:
- **Inscription**: `AuthService::createUser()` → génère `activate_token` → envoie `ActivationMail` → persist User.
- **Connexion (2 étapes)**: `AuthService::login()` → vérifie mot de passe via `AuthRepository::verifyPassword` → si OK génère code 2FA, persiste `VerificationCode`, envoie `TwoFactorCodeMail` → client vérifie via `AuthService::verify2fa()` → si OK crée token Sanctum et supprime code.
- **Restauration**: `requestRestoration()` génère et envoie code, `confirmRestoration()` valide code, restaure user, notifie.
- **Token API**: via Sanctum `createToken('auth_token')` retourné à l'API après 2FA.
- **Session Web**: fallback via `session('user_id')` pour blade/pages (voir `HasCustomAuth`).

---

**Spécificités / règles métier**:
- Utilisation de **UUID** comme ID utilisateur (non-incrémental).
- Comptes **soft-deleted** pour désactivation, possibilité de restauration via code.
- 2FA est implémenté par email (code 6 chiffres, expiration 10 minutes par défaut dans `AuthRepository::createVerificationCode`).
- Logs d'activité capturant changements avant/après via `UserObserver`.
- Mot de passe stocké hashed (casting `password => hashed`).
- Structure modulable: Services contiennent logique métier, Repositories gèrent l'accès DB.

---

**Points à vérifier/compléter pour reprise par un autre modèle IA**:
- `routes/api.php` est vide — définir endpoints API REST (mirroring de routes web ou endpoints JSON dédiés).
- Contrôleurs API (`App\Http\Controllers\Api\*`) — vérifier implémentation et adapter responses JSON.
- Gestion des erreurs centralisée (format de réponse API) — standardiser (ex: `success`, `message`, `status`, `data`).
- Tests unitaires et d'intégration: `tests/` présents, mais couverture à vérifier.
- Politique de sécurité: rate-limiting sur endpoints 2FA/restore, validation stricte des inputs.

---

**Exportable context (format clé-valeur pour ingestion IA)**:
- project_name: "conceptic_user_mgmt"
- framework: "laravel"
- php_version: "^8.2"
- auth: {
  method: "sanctum + session",
  two_factor: {
    type: "email_code",
    code_length: 6,
    expiry_minutes: 10
  },
  restore_flow: true
}
- models: ["User", "VerificationCode", "ActivityLog"]
- patterns: ["Service-Repository", "Observer pattern for activity logs", "SoftDeletes for user lifecycle"]
- next_actions_suggestions: ["Définir routes API", "Ajouter validation & rate-limiting 2FA", "Écrire tests d'intégration pour flows auth", "Documenter les webhooks/notifications"]

---
