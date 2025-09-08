<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Bint School - Plateforme de Formation')</title>
    
    <!-- Meta Tags -->
    <meta name="description" content="Bint School - Plateforme de formation en ligne moderne avec des cours de qualité">
    <meta name="author" content="Bint School">
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @stack('styles')
    
    <!-- jQuery (requis pour les scripts AJAX existants) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- API Configuration -->
    <script src="{{ asset('js/bintschool-api.js') }}"></script>
    
    <!-- ApexCharts (pour les graphiques) -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
</head>
<body class="@yield('body-class', '')">
    <!-- Loader global -->
    <div id="global-loader" class="loader-overlay" style="display: none;">
        <div class="loader">
            <div class="spinner"></div>
            <p>Chargement...</p>
        </div>
    </div>
    
    <!-- Messages globaux -->
    <div id="global-messages">
        <div class="alert alert-success" id="success-alert" style="display: none;">
            <span class="message"></span>
            <button type="button" class="close" aria-label="Fermer">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        
        <div class="alert alert-error" id="error-alert" style="display: none;">
            <span class="message"></span>
            <button type="button" class="close" aria-label="Fermer">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>
    
    <!-- Contenu principal -->
    <main id="app">
        @yield('content')
    </main>
    
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    
    <!-- Scripts globaux pour l'API -->
    <script>
        // Configuration globale de l'API
        $(document).ready(function() {
            // Initialiser l'API avec les données utilisateur si disponibles
            @auth
                BintSchoolAPI.setUser(@json(auth()->user()));
                // Récupérer le token depuis la session ou localStorage
                const token = localStorage.getItem('auth_token');
                if (token) {
                    BintSchoolAPI.setToken(token);
                }
            @endauth
            
            // Gestionnaire global pour les erreurs AJAX
            $(document).ajaxError(function(event, xhr, settings) {
                console.error('Erreur AJAX:', xhr.responseJSON);
                
                if (xhr.status === 401) {
                    showGlobalMessage('Session expirée. Veuillez vous reconnecter.', 'error');
                    setTimeout(() => {
                        window.location.href = '/';
                    }, 2000);
                } else if (xhr.status >= 500) {
                    showGlobalMessage('Erreur serveur. Veuillez réessayer plus tard.', 'error');
                }
            });
            
            // Gestionnaire pour les fermetures d'alertes
            $(document).on('click', '.alert .close', function() {
                $(this).parent().fadeOut();
            });
        });
        
        /**
         * Afficher un message global
         */
        function showGlobalMessage(message, type = 'success') {
            const alertId = type === 'success' ? '#success-alert' : '#error-alert';
            const $alert = $(alertId);
            
            $alert.find('.message').text(message);
            $alert.fadeIn();
            
            // Auto-hide après 5 secondes
            setTimeout(() => {
                $alert.fadeOut();
            }, 5000);
        }
        
        /**
         * Afficher/Cacher le loader global
         */
        function toggleGlobalLoader(show = true) {
            if (show) {
                $('#global-loader').fadeIn();
            } else {
                $('#global-loader').fadeOut();
            }
        }
        
        // Exporter les fonctions utilitaires globalement
        window.showGlobalMessage = showGlobalMessage;
        window.toggleGlobalLoader = toggleGlobalLoader;
    </script>
    
    @stack('scripts')
</body>
</html>