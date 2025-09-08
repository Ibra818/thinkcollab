/**
 * Bint School API Configuration
 * Configuration JavaScript pour les requêtes API REST
 */

window.BintSchoolAPI = {
    baseURL: '/api',
    token: localStorage.getItem('auth_token'),
    user: JSON.parse(localStorage.getItem('user') || 'null'),

    /**
     * Définir le token d'authentification
     */
    setToken(token) {
        this.token = token;
        localStorage.setItem('auth_token', token);
    },

    /**
     * Définir les données utilisateur
     */
    setUser(user) {
        this.user = user;
        localStorage.setItem('user', JSON.stringify(user));
    },

    /**
     * Nettoyer les données d'authentification
     */
    clearAuth() {
        this.token = null;
        this.user = null;
        localStorage.removeItem('auth_token');
        localStorage.removeItem('user');
    },

    /**
     * Vérifier si l'utilisateur est connecté
     */
    isAuthenticated() {
        return !!this.token;
    },

    /**
     * Obtenir les headers pour les requêtes
     */
    getHeaders(includeAuth = true) {
        const headers = {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        };
        
        if (includeAuth && this.token) {
            headers['Authorization'] = `Bearer ${this.token}`;
        }
        
        return headers;
    },

    /**
     * Effectuer une requête API
     */
    request(method, endpoint, data = null, options = {}) {
        const config = {
            url: `${this.baseURL}${endpoint}`,
            method: method,
            headers: this.getHeaders(options.auth !== false),
            timeout: options.timeout || 10000,
            ...options
        };

        // Gérer les données selon le type
        if (data) {
            if (data instanceof FormData) {
                // Pour les uploads de fichiers
                config.data = data;
                config.processData = false;
                config.contentType = false;
                delete config.headers['Content-Type'];
            } else {
                // Pour les données JSON
                config.data = JSON.stringify(data);
            }
        }

        return $.ajax(config);
    },

    /**
     * Gérer les erreurs d'authentification
     */
    handleAuthError(xhr) {
        if (xhr.status === 401) {
            this.clearAuth();
            window.location.href = '/';
        }
    },

    /**
     * Méthodes raccourcies pour les verbes HTTP
     */
    get(endpoint, options = {}) {
        return this.request('GET', endpoint, null, options);
    },

    post(endpoint, data = null, options = {}) {
        return this.request('POST', endpoint, data, options);
    },

    put(endpoint, data = null, options = {}) {
        return this.request('PUT', endpoint, data, options);
    },

    delete(endpoint, options = {}) {
        return this.request('DELETE', endpoint, null, options);
    },

    // === MÉTHODES SPÉCIALISÉES ===

    /**
     * Authentification
     */
    auth: {
        register(userData) {
            return window.BintSchoolAPI.post('/register', {
                name: userData.username,
                email: userData.email,
                password: userData.password,
                password_confirmation: userData.confirm_password,
                role: 'apprenant'
            }, { auth: false });
        },

        login(credentials) {
            return window.BintSchoolAPI.post('/login', {
                email: credentials.email,
                password: credentials.password
            }, { auth: false });
        },

        logout() {
            return window.BintSchoolAPI.post('/logout');
        },

        changeToFormateur(data) {
            return window.BintSchoolAPI.post('/user/change-to-formateur', {
                bio: data.bio || '',
                motivation: data.motivation || ''
            });
        },

        deleteAccount(data) {
            return window.BintSchoolAPI.delete('/user/delete-account', {
                data: JSON.stringify({
                    password: data.password,
                    deletion_reason: data.deletion_reason,
                    confirmation: data.confirmation
                })
            });
        }
    },

    /**
     * Profil utilisateur
     */
    profile: {
        get() {
            return window.BintSchoolAPI.get('/profile');
        },

        update(userData) {
            return window.BintSchoolAPI.put('/profile', {
                name: userData.username,
                email: userData.email,
                bio: userData.bio
            });
        }
    },

    /**
     * Formations
     */
    formations: {
        getAll() {
            return window.BintSchoolAPI.get('/formations');
        },

        get(id) {
            return window.BintSchoolAPI.get(`/formations/${id}`);
        },

        create(formationData) {
            return window.BintSchoolAPI.post('/formations', formationData);
        },

        addVideo(formationId, videoData) {
            return window.BintSchoolAPI.post(`/formations/${formationId}/videos`, videoData);
        },

        getMyFormations() {
            return window.BintSchoolAPI.get('/my-formations');
        }
    },

    /**
     * Paiements
     */
    payments: {
        getMethods() {
            return window.BintSchoolAPI.get('/payment-methods', { auth: false });
        },

        initialize(paymentData) {
            return window.BintSchoolAPI.post('/payments/initialize', {
                purchase_id: paymentData.purchase_id,
                payment_method_id: paymentData.payment_method_id,
                customer_name: paymentData.customer_name,
                customer_email: paymentData.customer_email,
                phone_number: paymentData.phone_number
            });
        },

        checkStatus(transactionId) {
            return window.BintSchoolAPI.get(`/payments/${transactionId}/status`);
        }
    },

    /**
     * Achats
     */
    purchases: {
        create(formationId, paymentMethodId) {
            return window.BintSchoolAPI.post('/purchases', {
                formation_id: formationId,
                payment_method_id: paymentMethodId
            });
        },

        getAll() {
            return window.BintSchoolAPI.get('/purchases');
        }
    },

    /**
     * Feed vidéos
     */
    feedVideos: {
        getAll(params = {}) {
            let url = '/feed-videos';
            if (Object.keys(params).length > 0) {
                url += '?' + new URLSearchParams(params).toString();
            }
            return window.BintSchoolAPI.get(url);
        },

        create(videoData) {
            return window.BintSchoolAPI.post('/feed-videos', videoData);
        },

        like(videoId) {
            return window.BintSchoolAPI.post(`/feed-videos/${videoId}/like`);
        }
    }
};

/**
 * Intercepteur global pour gérer les erreurs d'authentification
 */
$(document).ajaxError(function(event, xhr, settings) {
    if (xhr.status === 401) {
        window.BintSchoolAPI.handleAuthError(xhr);
    }
});

/**
 * Initialisation automatique si un token existe
 */
$(document).ready(function() {
    if (window.BintSchoolAPI.isAuthenticated()) {
        console.log('🔐 Utilisateur connecté:', window.BintSchoolAPI.user?.name);
    }
});

