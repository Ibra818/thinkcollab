# 🔧 Guide de Dépannage - Bint School

## 🚨 Problème: "View [pages.login] not found"

### **Diagnostic**

Ce problème peut avoir plusieurs causes :

1. **Fichier de vue manquant**
2. **Permissions de fichiers**
3. **Cache des vues**
4. **Problème de configuration Laravel**

### **Solutions par ordre de priorité**

#### **1. Vérification des fichiers**
```bash
# Vérifier que les fichiers existent
ls -la resources/views/pages/login.blade.php
ls -la resources/views/index.blade.php
```

#### **2. Nettoyer les caches Laravel**
```bash
php artisan view:clear
php artisan config:clear
php artisan route:clear
php artisan cache:clear
```

#### **3. Vérifier les permissions**
```bash
# Sur Linux/Mac
chmod -R 755 resources/
chmod -R 644 resources/views/*.php

# Sur Windows
# Vérifier les droits dans les propriétés des dossiers
```

#### **4. Test avec route de debug**
Accédez à `/debug` pour obtenir des informations détaillées :
```
GET /debug
```

#### **5. Utiliser la vue de fallback**
La route `/` utilise automatiquement `simple_login.blade.php` en cas d'erreur.

### **Routes de test disponibles**

- `/` - Page principale (avec fallbacks)
- `/login` - Page de login directe
- `/test` - Test simple de routes
- `/debug` - Informations de diagnostic

### **Fallbacks automatiques**

La route principale (`/`) utilise cette logique :

1. **Essai 1** : `pages.login` (vue complète)
2. **Essai 2** : `simple_login` (vue simplifiée)
3. **Fallback** : Message d'erreur JSON avec diagnostic

### **Si le problème persiste**

#### **Vérification manuelle**
```php
// Dans une route de test
Route::get('/check', function() {
    return [
        'view_paths' => config('view.paths'),
        'pages_login_exists' => view()->exists('pages.login'),
        'file_exists' => file_exists(resource_path('views/pages/login.blade.php')),
        'is_readable' => is_readable(resource_path('views/pages/login.blade.php')),
    ];
});
```

#### **Recréer la vue**
Si nécessaire, vous pouvez utiliser `simple_login.blade.php` comme base :

```bash
cp resources/views/simple_login.blade.php resources/views/pages/login.blade.php
```

### **Configuration recommandée**

#### **Structure des vues**
```
resources/views/
├── index.blade.php          # Layout principal
├── simple_login.blade.php   # Vue de fallback
├── layouts/
│   └── app.blade.php       # Layout moderne (optionnel)
└── pages/
    ├── login.blade.php     # Page de connexion complète
    ├── home.blade.php      # Dashboard
    ├── formation.blade.php # Page formation
    └── admin-home.blade.php # Dashboard admin
```

#### **Headers recommandés dans les vues**
```php
@extends('index')

@section('content')
<link rel="stylesheet" href="{{ asset('css/your-styles.css') }}">
<script src="{{ asset('js/bintschool-api.js') }}"></script>

<!-- Votre contenu ici -->

@endsection
```

### **Commandes utiles**

```bash
# Vérifier la configuration Laravel
php artisan config:show view

# Lister toutes les vues disponibles
php artisan view:list

# Vérifier les routes
php artisan route:list

# Mode debug Laravel
php artisan serve --env=local
```

### **En cas d'urgence**

Si rien ne fonctionne, utilisez directement la vue simplifiée :

```php
// Dans routes/web.php
Route::get('/', function () {
    return view('simple_login');
})->name('login');
```

Cette vue est autonome et ne dépend d'aucun layout externe.

---

## 📞 Support

Si le problème persiste après avoir suivi ces étapes :

1. Vérifiez les logs Laravel : `storage/logs/laravel.log`
2. Activez le debug : `APP_DEBUG=true` dans `.env`
3. Consultez la documentation Laravel sur les vues

**Note** : Les modifications apportées ont créé un système de fallback robuste qui devrait fonctionner même en cas de problème avec la vue principale.

