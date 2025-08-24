# 🎓 Bint School - Plateforme de Formation

Une application web moderne de formation construite avec Laravel, offrant une expérience utilisateur élégante avec un design minimaliste en jaune-orange et un mode sombre.

## ✨ Fonctionnalités

### 🔐 Authentification
- Page de connexion élégante avec design glassmorphism
- Gestion des sessions utilisateur
- Basculement automatique entre mode clair et sombre

### 👥 Sélection de Profil
- Choix entre profil **Apprenant** et **Formateur**
- Interface intuitive avec cartes interactives
- Animations fluides et transitions

### 📚 Dashboard Apprenant
- Vue d'ensemble des cours actifs
- Barres de progression animées
- Statistiques de performance
- Activité récente
- Design responsive et moderne

## 🎨 Design & UX

- **Couleurs** : Palette jaune-orange avec dégradés
- **Style** : Minimaliste avec effets glassmorphism
- **Animations** : Transitions fluides et micro-interactions
- **Mode sombre** : Basculement automatique selon les préférences
- **Responsive** : Adaptation mobile/tablette/desktop

## 🚀 Installation

1. **Cloner le projet** (déjà fait)
```bash
cd bint_school
```

2. **Installer les dépendances**
```bash
composer install
npm install
```

3. **Configuration de l'environnement**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Base de données**
```bash
php artisan migrate:fresh --seed
```

5. **Compilation des assets**
```bash
npm run dev
# ou pour la production
npm run build
```

6. **Démarrer le serveur**
```bash
php artisan serve
```

## 🧪 Comptes de Test

L'application est fournie avec des comptes de démonstration :

| Email | Mot de passe | Type |
|-------|-------------|------|
| `test@example.com` | `password` | Utilisateur test |
| `marie@example.com` | `password` | Étudiant |
| `jean@example.com` | `password` | Formateur |

## 📱 Utilisation

1. **Connexion** : Accédez à `/login` et utilisez un des comptes de test
2. **Sélection** : Choisissez votre profil (Apprenant ou Formateur)
3. **Dashboard** : Explorez les fonctionnalités selon votre profil

## 🛠 Technologies Utilisées

- **Backend** : Laravel 11
- **Frontend** : Blade Templates + Tailwind CSS
- **Base de données** : MySQL
- **Animations** : CSS Animations + Transitions
- **Icons** : Heroicons

## 📁 Structure des Vues

```
resources/views/
├── layouts/
│   └── app.blade.php          # Layout principal
├── auth/
│   └── login.blade.php        # Page de connexion
├── profile/
│   └── selection.blade.php    # Sélection de profil
└── student/
    └── dashboard.blade.php    # Dashboard apprenant
```

## 🎯 Fonctionnalités Avancées

### Thème Adaptatif
- Détection automatique du mode sombre/clair
- Sauvegarde des préférences utilisateur
- Bouton de basculement dans toutes les vues

### Glassmorphism
- Effets de transparence et de flou
- Adaptation selon le thème actuel
- Optimisé pour les performances

### Animations
- Transitions CSS fluides
- Animations de chargement
- Effets hover interactifs
- Respect des préférences de mouvement réduit

## 🔧 Personnalisation

### Couleurs
Les couleurs principales peuvent être modifiées dans `resources/css/app.css` :
```css
.bg-orange-gradient {
    background: linear-gradient(135deg, #f97316 0%, #eab308 100%);
}
```

### Animations
Les animations personnalisées sont définies dans les utilities CSS :
```css
@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-20px); }
}
```

## 📈 Prochaines Étapes

- [ ] Dashboard Formateur
- [ ] Gestion des cours
- [ ] Système de messagerie
- [ ] Évaluations et quiz
- [ ] Notifications en temps réel
- [ ] API REST
- [ ] Application mobile

## 🤝 Contribution

1. Fork le projet
2. Créer une branche feature (`git checkout -b feature/nouvelle-fonctionnalite`)
3. Commit les changements (`git commit -am 'Ajouter nouvelle fonctionnalité'`)
4. Push vers la branche (`git push origin feature/nouvelle-fonctionnalite`)
5. Créer une Pull Request

## 📄 License

Ce projet est sous licence MIT. Voir le fichier `LICENSE` pour plus de détails.

---

**Développé avec ❤️ pour l'éducation moderne**
