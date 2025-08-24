# 📚 Documentation API - Plateforme d'Apprentissage en Ligne

## 🌟 Vue d'ensemble

Cette API Laravel permet de gérer une plateforme d'apprentissage en ligne complète avec :
- 🔐 Authentification Sanctum
- 💳 Paiements TouchPoint (Orange Money, Wave)
- 📚 Gestion des formations et cours
- 📱 Feed vidéos et engagement social
- 👥 Système de suivi et favoris
- 💬 Messagerie entre utilisateurs

**Base URL :** `http://localhost:8001/api`

---

## 🔐 Authentification

### Inscription
```http
POST /register
```

**Headers :**
```
Content-Type: application/json
Accept: application/json
```

**Body :**
```json
{
  "name": "Nom Utilisateur",
  "email": "email@example.com",
  "password": "password123",
  "password_confirmation": "password123",
  "role": "apprenant"
}
```

**Réponse (201) :**
```json
{
  "success": true,
  "message": "User registered successfully",
  "user": {
    "id": 10,
    "name": "Nom Utilisateur",
    "email": "email@example.com",
    "role": "apprenant",
    "created_at": "2025-08-24T15:13:58.000000Z"
  },
  "token": "2|CEEUQpEe8NAPAAe19VPhPQyhrKFridkbJKwEar9Rb74c67f0"
}
```

### Connexion
```http
POST /login
```

**Body :**
```json
{
  "email": "email@example.com",
  "password": "password123"
}
```

**Réponse (200) :**
```json
{
  "success": true,
  "message": "Login successful",
  "user": {
    "id": 9,
    "name": "Test User",
    "email": "test@example.com",
    "role": "apprenant"
  },
  "token": "1|HNrfiWSplOqOjKx3EvHAaW5jCq1zXg37EZj8Wp3y143f9601"
}
```

### Déconnexion
```http
POST /logout
```

**Headers :**
```
Authorization: Bearer {token}
```

**Réponse (200) :**
```json
{
  "success": true,
  "message": "Logged out successfully"
}
```

### Utilisateur connecté
```http
GET /user
```

**Headers :**
```
Authorization: Bearer {token}
```

**Réponse (200) :**
```json
{
  "id": 9,
  "name": "Test User",
  "email": "test@example.com",
  "role": "formateur",
  "bio": "Bio de l'utilisateur",
  "avatar_url": "/images/avatars/test.jpg"
}
```

---

## 👤 Gestion du Compte Utilisateur

### Changer de rôle (Apprenant → Formateur)
```http
POST /user/change-to-formateur
```

**Headers :**
```
Authorization: Bearer {token}
Content-Type: application/json
```

**Body :**
```json
{
  "bio": "Je souhaite devenir formateur pour partager mes connaissances",
  "motivation": "Passionné par l'enseignement"
}
```

**Réponse (200) :**
```json
{
  "success": true,
  "message": "Successfully upgraded to instructor",
  "user": {
    "id": 9,
    "name": "Test User",
    "role": "formateur",
    "bio": "Je souhaite devenir formateur pour partager mes connaissances"
  }
}
```

### Supprimer le compte
```http
DELETE /user/delete-account
```

**Headers :**
```
Authorization: Bearer {token}
Content-Type: application/json
```

**Body :**
```json
{
  "password": "password123",
  "deletion_reason": "Je n'utilise plus la plateforme",
  "confirmation": true
}
```

**Réponse (200) :**
```json
{
  "success": true,
  "message": "Account for Test User has been successfully deleted"
}
```

---

## 📚 Catégories

### Lister les catégories
```http
GET /categories
```

**Réponse (200) :**
```json
[
  {
    "id": 1,
    "nom": "Développement Web",
    "slug": "developpement-web",
    "description": "Formations sur le développement web frontend et backend",
    "couleur": "#3B82F6",
    "icone": "code",
    "created_at": "2025-08-24T14:57:23.000000Z"
  }
]
```

### Créer une catégorie (Admin)
```http
POST /categories
```

**Headers :**
```
Authorization: Bearer {admin_token}
Content-Type: application/json
```

**Body :**
```json
{
  "nom": "Nouvelle Catégorie",
  "description": "Description de la catégorie",
  "couleur": "#FF5722",
  "icone": "icon-name"
}
```

### Modifier une catégorie (Admin)
```http
PUT /categories/{id}
```

### Supprimer une catégorie (Admin)
```http
DELETE /categories/{id}
```

---

## 🎓 Formations

### Lister les formations publiées
```http
GET /formations
```

**Headers :**
```
Authorization: Bearer {token}
```

**Réponse (200) :**
```json
[
  {
    "id": 1,
    "titre": "Laravel Avancé - De Zéro à Expert",
    "description": "Formation complète Laravel",
    "prix": 25000,
    "statut": "publie",
    "formateur": {
      "id": 2,
      "name": "Amadou Diallo",
      "avatar_url": "/images/avatars/amadou.jpg"
    },
    "categorie": {
      "id": 1,
      "nom": "Développement Web",
      "couleur": "#3B82F6"
    }
  }
]
```

### Détail d'une formation
```http
GET /formations/{id}
```

**Headers :**
```
Authorization: Bearer {token}
```

**Réponse (200) :**
```json
{
  "formation": {
    "id": 1,
    "titre": "Laravel Avancé - De Zéro à Expert",
    "description": "Formation complète Laravel",
    "prix": 25000,
    "formateur": {
      "id": 2,
      "name": "Amadou Diallo",
      "bio": "Expert Laravel",
      "avatar_url": "/images/avatars/amadou.jpg"
    },
    "categorie": {
      "id": 1,
      "nom": "Développement Web"
    },
    "objectives": [
      {
        "id": 1,
        "description": "Maîtriser les concepts avancés de Laravel",
        "ordre": 1
      }
    ]
  },
  "stats": {
    "total_students": 2,
    "total_videos": 8,
    "total_duration": "10980",
    "sections_count": 3
  },
  "user_access": {
    "has_purchased": false,
    "is_enrolled": false,
    "is_owner": false
  },
  "sections_with_videos": [
    {
      "id": 1,
      "titre": "Introduction",
      "description": "Bases de Laravel",
      "ordre": 1,
      "videos_count": 3,
      "total_duration": 3600,
      "videos": [
        {
          "id": 1,
          "titre": "Installation de Laravel",
          "duree": 1200,
          "ordre": 1,
          "url": "/videos/laravel-install.mp4"
        }
      ]
    }
  ]
}
```

### Mes formations (Formateur)
```http
GET /my-formations
```

**Headers :**
```
Authorization: Bearer {formateur_token}
```

### Créer une formation (Formateur)
```http
POST /formations
```

**Headers :**
```
Authorization: Bearer {formateur_token}
Content-Type: application/json
```

**Body :**
```json
{
  "titre": "Nouvelle Formation",
  "description": "Description de la formation",
  "prix": 15000,
  "categorie_id": 1
}
```

### Publier une formation
```http
POST /formations/{id}/publish
```

### Dépublier une formation
```http
POST /formations/{id}/unpublish
```

---

## 📱 Feed Vidéos

### Lister les feed vidéos
```http
GET /feed-videos
```

**Headers :**
```
Authorization: Bearer {token}
```

**Réponse (200) :**
```json
{
  "current_page": 1,
  "data": [
    {
      "id": 7,
      "titre": "Tendances Design 2024",
      "description": "Les dernières tendances en design",
      "url_video": "/videos/feed/design-trends.mp4",
      "miniature": "/images/feed/design-trends.jpg",
      "duree": 420,
      "user": {
        "id": 3,
        "name": "Fatou Sall",
        "avatar_url": "/images/avatars/fatou.jpg"
      },
      "categorie": {
        "id": 3,
        "nom": "Design",
        "couleur": "#F59E0B"
      },
      "likes_count": 9,
      "views_count": 370,
      "shares_count": 6,
      "created_at": "2025-08-24T14:57:23.000000Z"
    }
  ],
  "per_page": 15,
  "total": 13
}
```

### Mes feed vidéos
```http
GET /my-feed-videos
```

### Créer une feed vidéo
```http
POST /feed-videos
```

**Headers :**
```
Authorization: Bearer {token}
Content-Type: application/json
```

**Body :**
```json
{
  "titre": "Ma nouvelle vidéo",
  "description": "Description de la vidéo",
  "url_video": "/videos/ma-video.mp4",
  "miniature": "/images/ma-video.jpg",
  "duree": 300,
  "categorie_id": 1,
  "est_public": true
}
```

### Liker une vidéo
```http
POST /feed-videos/{id}/like
```

**Headers :**
```
Authorization: Bearer {token}
```

**Réponse (200) :**
```json
{
  "message": "Vidéo likée",
  "liked": true
}
```

### Voir une vidéo (comptabiliser vue)
```http
POST /feed-videos/{id}/view
```

### Partager une vidéo
```http
POST /feed-videos/{id}/share
```

**Body :**
```json
{
  "platform": "facebook"
}
```

---

## 💳 Paiements TouchPoint

### Moyens de paiement disponibles
```http
GET /payment-methods
```

**Réponse (200) :**
```json
{
  "success": true,
  "data": {
    "mobile_money": [
      {
        "id": 1,
        "name": "Orange Money",
        "provider": "touchpoint",
        "type": "mobile_money",
        "code": "om_sn",
        "currency": "XOF",
        "fee_percentage": "2.00",
        "fee_fixed": 0,
        "is_active": true,
        "config": {
          "target_payment": "Orange Money",
          "min_amount": 100,
          "max_amount": 1000000
        },
        "logo_url": "/images/payment-methods/orange-money.png"
      },
      {
        "id": 2,
        "name": "Wave",
        "provider": "touchpoint",
        "type": "mobile_money",
        "code": "wave_sn",
        "currency": "XOF",
        "fee_percentage": "1.50",
        "fee_fixed": 0,
        "is_active": true,
        "config": {
          "target_payment": "Wave",
          "min_amount": 100,
          "max_amount": 1000000
        },
        "logo_url": "/images/payment-methods/wave.png"
      }
    ]
  }
}
```

### Initialiser un paiement
```http
POST /payments/initialize
```

**Headers :**
```
Authorization: Bearer {token}
Content-Type: application/json
```

**Body :**
```json
{
  "purchase_id": 1,
  "payment_method_id": 1,
  "customer_name": "John Doe",
  "customer_email": "john@example.com",
  "phone_number": "221771234567"
}
```

**Réponse (200) :**
```json
{
  "success": true,
  "message": "Payment initialized successfully",
  "data": {
    "transaction_id": "TXN_123456789",
    "payment_url": "https://api.touchpoint.intouchgroup.net/payment/...",
    "amount": 25000,
    "currency": "XOF",
    "status": "pending"
  }
}
```

### Vérifier le statut d'un paiement
```http
GET /payments/{transactionId}/status
```

**Headers :**
```
Authorization: Bearer {token}
```

**Réponse (200) :**
```json
{
  "success": true,
  "data": {
    "transaction_id": "TXN_123456789",
    "status": "completed",
    "amount": 25000,
    "currency": "XOF",
    "payment_method": "Orange Money",
    "completed_at": "2025-08-24T15:30:00.000000Z"
  }
}
```

### Annuler un paiement
```http
POST /payments/{transactionId}/cancel
```

### Mes transactions
```http
GET /payments/transactions
```

**Headers :**
```
Authorization: Bearer {token}
```

### Statistiques de paiement (Admin)
```http
GET /payments/statistics
```

**Headers :**
```
Authorization: Bearer {admin_token}
```

---

## 🛒 Achats et Inscriptions

### Mes achats
```http
GET /purchases
```

**Headers :**
```
Authorization: Bearer {token}
```

**Réponse (200) :**
```json
[
  {
    "id": 1,
    "user_id": 9,
    "formation_id": 1,
    "montant_total": 25000,
    "statut": "completed",
    "methode_paiement": "orange_money",
    "transaction_id": "TXN_123456789",
    "created_at": "2025-08-24T14:57:23.000000Z",
    "formation": {
      "id": 1,
      "titre": "Laravel Avancé - De Zéro à Expert",
      "formateur": {
        "name": "Amadou Diallo"
      }
    }
  }
]
```

### Créer un achat
```http
POST /purchases
```

**Body :**
```json
{
  "formation_id": 1,
  "payment_method_id": 1
}
```

### Mes inscriptions
```http
GET /inscriptions
```

**Headers :**
```
Authorization: Bearer {token}
```

**Réponse (200) :**
```json
[
  {
    "id": 1,
    "user_id": 9,
    "formation_id": 1,
    "purchase_id": 1,
    "statut": "active",
    "date_inscription": "2025-08-24T14:57:23.000000Z",
    "progres": 88,
    "formation": {
      "id": 1,
      "titre": "Laravel Avancé - De Zéro à Expert",
      "formateur": {
        "name": "Amadou Diallo"
      }
    }
  }
]
```

---

## 👥 Social et Suivi

### Mes followers
```http
GET /my-followers
```

**Headers :**
```
Authorization: Bearer {token}
```

**Réponse (200) :**
```json
[
  {
    "id": 1,
    "follower": {
      "id": 5,
      "name": "Marie Diop",
      "avatar_url": "/images/avatars/marie.jpg"
    },
    "created_at": "2025-08-24T14:57:23.000000Z"
  }
]
```

### Mes abonnements
```http
GET /my-followings
```

### Suivre un utilisateur
```http
POST /users/{userId}/follow
```

**Headers :**
```
Authorization: Bearer {token}
```

### Ne plus suivre un utilisateur
```http
DELETE /users/{userId}/unfollow
```

### Vérifier si je suis un utilisateur
```http
GET /users/{userId}/is-following
```

---

## ⭐ Favoris

### Mes vidéos favorites
```http
GET /favoris
```

**Headers :**
```
Authorization: Bearer {token}
```

### Ajouter aux favoris
```http
POST /favoris
```

**Body :**
```json
{
  "lesson_video_id": 1
}
```

### Basculer favori
```http
POST /favoris/toggle
```

**Body :**
```json
{
  "lesson_video_id": 1
}
```

---

## 💬 Messages

### Mes messages
```http
GET /messages
```

**Headers :**
```
Authorization: Bearer {token}
```

### Envoyer un message
```http
POST /messages
```

**Body :**
```json
{
  "destinataire_id": 2,
  "contenu": "Bonjour, j'ai une question sur votre formation"
}
```

### Marquer comme lu
```http
POST /messages/{id}/read
```

### Messages non lus (count)
```http
GET /messages/unread/count
```

---

## 👤 Profil Utilisateur

### Mon profil
```http
GET /profile
```

**Headers :**
```
Authorization: Bearer {token}
```

### Modifier mon profil
```http
PUT /profile
```

**Body :**
```json
{
  "name": "Nouveau Nom",
  "bio": "Nouvelle bio",
  "avatar_url": "/images/avatars/new-avatar.jpg"
}
```

### Profil d'un utilisateur
```http
GET /users/{userId}/profile
```

### Mes cours inscrits
```http
GET /profile/enrolled-courses
```

### Mes vidéos favorites
```http
GET /profile/favorite-videos
```

### Mes cours récents
```http
GET /profile/recent-courses
```

### Données complètes du profil
```http
GET /profile/page-data
```

---

## 🎥 Vidéos de Cours

### Vidéos d'une formation
```http
GET /formations/{formationId}/videos
```

### Détail d'une vidéo
```http
GET /lesson-videos/{id}
```

### Ajouter une vidéo (Formateur)
```http
POST /formations/{formationId}/videos
```

**Body :**
```json
{
  "titre": "Nouvelle leçon",
  "description": "Description de la leçon",
  "url_video": "/videos/lesson.mp4",
  "duree": 1200,
  "section_id": 1,
  "ordre": 1,
  "est_gratuit": false
}
```

---

## 📊 Progression

### Ma progression
```http
GET /progressions
```

### Créer/Mettre à jour progression
```http
POST /progressions
```

**Body :**
```json
{
  "lesson_video_id": 1,
  "temps_visionne": 600,
  "termine": false
}
```

---

## 🔧 Webhooks

### Webhook TouchPoint
```http
POST /webhooks/touchpoint
```

**Headers :**
```
Authorization: Bearer {webhook_secret}
Content-Type: application/json
```

**Body :**
```json
{
  "ref_command": "TXN_123456789",
  "status": "SUCCESS",
  "transaction_id": "TP_987654321",
  "amount": 25000,
  "currency": "XOF"
}
```

---

## 📋 Codes d'Erreur

| Code | Description |
|------|-------------|
| 200  | Succès |
| 201  | Créé avec succès |
| 400  | Requête invalide |
| 401  | Non authentifié |
| 403  | Accès interdit |
| 404  | Ressource non trouvée |
| 422  | Erreur de validation |
| 500  | Erreur serveur |

---

## 🔑 Authentification

Toutes les routes protégées nécessitent un token Bearer dans l'en-tête :

```
Authorization: Bearer {your_token_here}
```

Le token est obtenu lors de la connexion ou de l'inscription et doit être inclus dans toutes les requêtes authentifiées.

---

## 🌍 Environnements

### Développement
- **Base URL :** `http://localhost:8001/api`
- **TouchPoint :** Mode sandbox

### Production
- **Base URL :** `https://votre-domaine.com/api`
- **TouchPoint :** Mode production

---

## 📞 Support

Pour toute question sur l'API, contactez l'équipe de développement.

**Version :** 1.0.0  
**Dernière mise à jour :** 24 août 2025
