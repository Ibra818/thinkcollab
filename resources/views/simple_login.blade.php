<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bint School - Connexion</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('js/bintschool-api.js') }}"></script>
</head>
<body>
    <div class="login-container">
        <div class="login-form">
            <h1>Bint School</h1>
            <h2>Connexion</h2>
            
            <form id="loginForm">
                <div class="form-group">
                    <input type="email" id="email" placeholder="Email" required>
                </div>
                <div class="form-group">
                    <input type="password" id="password" placeholder="Mot de passe" required>
                </div>
                <button type="submit" id="loginBtn">Se connecter</button>
            </form>
            
            <div id="message" style="display: none; margin-top: 15px; padding: 10px; border-radius: 5px;"></div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#loginForm').on('submit', function(e) {
                e.preventDefault();
                
                const email = $('#email').val();
                const password = $('#password').val();
                const $btn = $('#loginBtn');
                const $message = $('#message');
                
                $btn.text('Connexion...').prop('disabled', true);
                
                BintSchoolAPI.auth.login({
                    email: email,
                    password: password
                })
                .done(function(response) {
                    if (response.success && response.token) {
                        BintSchoolAPI.setToken(response.token);
                        BintSchoolAPI.setUser(response.user);
                        
                        $message.removeClass('error').addClass('success')
                               .text('Connexion réussie ! Redirection...')
                               .show();
                        
                        setTimeout(() => {
                            window.location.href = '/home';
                        }, 1000);
                    } else {
                        throw new Error(response.message || 'Erreur de connexion');
                    }
                })
                .fail(function(xhr) {
                    let errorMessage = 'Erreur de connexion';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }
                    
                    $message.removeClass('success').addClass('error')
                           .text(errorMessage)
                           .show();
                })
                .always(function() {
                    $btn.text('Se connecter').prop('disabled', false);
                });
            });
        });
    </script>

    <style>
        .login-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            font-family: 'Arial', sans-serif;
        }
        
        .login-form {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }
        
        .login-form h1 {
            text-align: center;
            color: #333;
            margin-bottom: 10px;
        }
        
        .login-form h2 {
            text-align: center;
            color: #666;
            margin-bottom: 30px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            box-sizing: border-box;
        }
        
        .form-group input:focus {
            outline: none;
            border-color: #667eea;
        }
        
        button {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: opacity 0.3s;
        }
        
        button:hover {
            opacity: 0.9;
        }
        
        button:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }
        
        .success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</body>
</html>

