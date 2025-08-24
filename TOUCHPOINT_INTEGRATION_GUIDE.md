# Guide d'intégration TouchPoint by InTouch

## 🚀 Configuration

### Variables d'environnement (.env)
```bash
# TouchPoint by InTouch Configuration
INTOUCH_API_KEY=your_api_key_from_developers.intouchgroup.net
INTOUCH_WEBHOOK_SECRET=your_webhook_secret_from_intouch
INTOUCH_BASE_URI=https://api.touchpoint.intouchgroup.net/v1

# Frontend URL pour les redirections
FRONTEND_URL=http://localhost:3000
```

### Obtenir les clés API
1. Créer un compte sur `developers.intouchgroup.net`
2. Compléter le KYC (NINEA, pièce d'identité, etc.)
3. Après validation, accéder au portail développeur
4. Générer les clés API dans la section "Keys"

## 🧪 Tests avec Insomnia/Postman

### 1. Routes publiques (sans authentification)

#### Moyens de paiement disponibles
```http
GET http://localhost:8000/api/payment-methods
Accept: application/json
```

**Réponse attendue :**
```json
{
  "success": true,
  "data": {
    "mobile_money": [
      {
        "id": 1,
        "name": "Orange Money",
        "provider": "touchpoint",
        "code": "om_sn",
        "fee_percentage": "2.00"
      },
      {
        "id": 2,
        "name": "Wave",
        "provider": "touchpoint", 
        "code": "wave_sn",
        "fee_percentage": "1.50"
      }
    ]
  }
}
```

### 2. Authentification API

#### Inscription
```http
POST http://localhost:8000/api/register
Content-Type: application/json

{
  "name": "Test User",
  "email": "test@example.com",
  "password": "password",
  "password_confirmation": "password",
  "role": "apprenant"
}
```

#### Connexion
```http
POST http://localhost:8000/api/login
Content-Type: application/json

{
  "email": "test@example.com",
  "password": "password"
}
```

**Réponse :**
```json
{
  "success": true,
  "token": "1|abc123xyz789...",
  "user": {
    "id": 1,
    "name": "Test User",
    "email": "test@example.com"
  }
}
```

### 3. Routes protégées (avec token)

#### Initialiser un paiement
```http
POST http://localhost:8000/api/payments/initialize
Authorization: Bearer 1|abc123xyz789...
Content-Type: application/json

{
  "purchase_id": 1,
  "payment_method_id": 1,
  "customer_name": "Amadou Diallo",
  "customer_email": "amadou@example.com",
  "phone_number": "771234567"
}
```

#### Vérifier le statut d'un paiement
```http
GET http://localhost:8000/api/payments/TXN_ABC123XYZ789/status
Authorization: Bearer 1|abc123xyz789...
```

#### Historique des transactions
```http
GET http://localhost:8000/api/payments/transactions
Authorization: Bearer 1|abc123xyz789...
```

### 4. Webhook TouchPoint (simulation)

```http
POST http://localhost:8000/api/webhooks/touchpoint
Authorization: Bearer your_webhook_secret_here
Content-Type: application/json

{
  "ref_command": "TXN_ABC123XYZ789",
  "status": "SUCCESS",
  "transaction_id": "TP_789456123",
  "amount": 250,
  "currency": "XOF"
}
```

## 🔄 Flux complet de paiement

### Étape 1 : Création d'une commande
```php
$purchase = Purchase::create([
    'user_id' => auth()->id(),
    'formation_id' => $formationId,
    'montant_total' => $formation->prix * 100, // En centimes
    'statut' => 'pending',
]);
```

### Étape 2 : Initialisation du paiement
L'API TouchPoint sera appelée avec :
```json
{
  "item_name": "Formation: Laravel Avancé",
  "item_price": 250,
  "currency": "XOF",
  "ref_command": "TXN_ABC123XYZ789",
  "target_payment": "Orange Money",
  "success_url": "http://localhost:8000/api/payments/TXN_ABC123XYZ789/success",
  "cancel_url": "http://localhost:8000/api/payments/TXN_ABC123XYZ789/cancel",
  "ipn_url": "http://localhost:8000/api/webhooks/touchpoint"
}
```

### Étape 3 : Redirection utilisateur
L'utilisateur est redirigé vers la page TouchPoint pour finaliser le paiement.

### Étape 4 : Notification webhook
TouchPoint envoie une notification de succès/échec à votre webhook.

### Étape 5 : Mise à jour automatique
- Transaction marquée comme "completed"
- Purchase mis à jour
- Inscription créée automatiquement
- Utilisateur redirigé vers la page de succès

## 🛠️ Commandes utiles

### Migrations et seeders
```bash
php artisan migrate
php artisan db:seed --class=PaymentMethodSeeder
```

### Vérifier les routes
```bash
php artisan route:list --path=api/payment
```

### Logs en temps réel
```bash
tail -f storage/logs/laravel.log
```

### Démarrer le serveur
```bash
php artisan serve
```

## 🔒 Sécurité

- ✅ Clés API stockées côté serveur uniquement
- ✅ Validation des signatures webhook
- ✅ HTTPS obligatoire en production
- ✅ Authentification Sanctum pour les routes protégées
- ✅ Validation des données utilisateur

## 🐛 Dépannage

### Erreur 404 sur les routes API
- Vérifier que `api: __DIR__.'/../routes/api.php'` est présent dans `bootstrap/app.php`
- Vérifier que le serveur Laravel fonctionne sur `http://localhost:8000`

### Erreur d'authentification
- Vérifier que le token est inclus dans l'header `Authorization: Bearer TOKEN`
- Vérifier que l'utilisateur existe et est connecté

### Erreur webhook TouchPoint
- Vérifier que `INTOUCH_WEBHOOK_SECRET` correspond au secret configuré chez InTouch
- Vérifier les logs Laravel pour les détails de l'erreur

## 📞 Support

- Documentation officielle : `developers.intouchgroup.net`
- Support InTouch : Contacter via le portail développeur
- Logs Laravel : `storage/logs/laravel.log`
