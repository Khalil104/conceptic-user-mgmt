## Module d'Authentification 2FA (Sanctum)

Ce module gère le cycle complet d'authentification sécurisée pour l'API Laravel User Management. Il ne se contente pas d'une simple vérification mot de passe, mais impose un second facteur de validation par email.

## 🛠️ Stack Technique

* **Laravel Sanctum** : Gestion des Personal Access Tokens.
* **Mailtrap** : Simulation d'envoi d'emails transactionnels.
* **UUID** : Identifiants non-séquentiels pour la sécurité.
* **OTP Logic** : Codes à usage unique avec expiration temporelle.

## 🔄 Workflow d'Authentification

### 1️⃣ Phase de Connexion (`/api/login`)

L'utilisateur soumet son email et son mot de passe.

* **Succès** : Le serveur génère un code à 6 chiffres, l'enregistre en base de données et l'envoie par email. Aucun token d'accès n'est fourni à cette étape.
* **Réponse** : `2FA_REQUIRED`.

### 2️⃣ Phase de Vérification (`/api/verify-2fa`)

L'utilisateur saisit le code reçu par mail.

* **Logique** : Le serveur vérifie la correspondance du code, l'identité de l'utilisateur (`user_id`) et la validité temporelle (10 min).
* **Sécurité** : Le code est immédiatement supprimé après validation (Usage unique).
* **Réponse** : Génération et retour du `plainTextToken` final.

---

## 📬 Configuration Email (Développement)

Pour tester la réception des codes, configurez votre fichier `.env` avec vos identifiants **Mailtrap** :

```env
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=votre_user
MAIL_PASSWORD=votre_pass
MAIL_FROM_ADDRESS="abdoulsare@conceptic.io"

```

---

## 🧪 Scénario de Test Postman

### A. Initialisation

1. **POST** `/api/login`
* Body : `{"email": "...", "password": "..."}`
* Notez l' `user_id` et récupérez le code dans Mailtrap.


### B. Validation 2FA

2. **POST** `/api/verify-2fa`
* Header : `Accept: application/json`
* Body : `{"user_id": "UUID_RECU", "code": "123456"}`
* Copiez le `token` reçu en retour.


### C. Accès Sécurisé

3. **GET** `/api/me` (ou `/api/dashboard`)
* Auth : **Bearer Token**
* Collez le token. Un statut **200 OK** confirme la réussite.

---

## 📁 Schéma de Données (2FA)

La table `verification_codes` assure la persistance temporaire des accès :

| Colonne | Type | Description |
| --- | --- | --- |
| `user_id` | UUID | Clé étrangère vers l'utilisateur |
| `code` | String | Code OTP à 6 chiffres |
| `expires_at` | Timestamp | Date limite de validité |

---

## 🚀 Sécurité Implémentée

* **Protection contre le Rejeu** : Suppression automatique du code après une seule utilisation.
* **Stateless Auth** : Les jetons sont stockés en base et vérifiés à chaque requête sans session PHP.
* **Standardisation HTTP** : Codes de retour explicites (401, 422, 410).