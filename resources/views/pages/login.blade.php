@extends('index')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">

<!-- Police Inter pour toute l'application -->
<style>
    * {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif !important;
    }
    
    html, body {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif !important;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        localStorage.clear();

        const main = document.querySelector('main');
        const registerForm = document.querySelector('.register');
        const loginForm = document.querySelector('.login');
        const btnRegister = document.querySelector('.register .btns .btn-register');
        const btnLogin = document.querySelector('.register .btns .btn-login');
        const btnLogin2 = document.querySelector('.login .btns .btn-login');
        const btnRegister2 = document.querySelector('.login .btns .btn-register');
        const message = document.querySelector('#message');
        const success = document.querySelector('.success');
        const error = document.querySelector('.error');
        const successMsg = document.querySelector('.success-msg');
        const errorMsg = document.querySelector('.error-msg');
        const btnCloseMsg = document.querySelectorAll('.close-msg');
        const loaderOverlay = document.querySelector('#loader-overlay');
        const loader = document.querySelector('#loader-overlay .loader');
        const restorePass = document.querySelector('.restore-pass');
        const forgottenPass = document.querySelector('#forgotten-pass');
        const forgottenBtnConfirm = document.querySelector('#forgotten-pass .forgotten.btn-confirm');
        const forgottenBtnRegister = document.querySelector('.forgotten.btn-register');
        const emailForgot = document.querySelector('#email-forgotten');
        const profile = document.querySelector('#profile');
        const teacher = document.querySelector('#profile .profiles .profile-teacher');
        const learner = document.querySelector('#profile .profiles .profile-learner');
        const proContOverlayBtn = document.querySelector('#profile .overlay-btn');
        const proBtnContinue = document.querySelector('#profile .btn-continue');
        const restorePassword = document.querySelector('#restore-pass');
        const goBackBtn = document.querySelector('#restore-pass .goBack-btn');
        const spanRestorePass = document.querySelector('#restore-pass p .useremail');
        const restoreText = document.querySelector('#restore-pass p');
        const apiUrl = 'https://phplaravel-1249520-5839753.cloudwaysapps.com/';
        const apiStorage= 'https://phplaravel-1249520-5839753.cloudwaysapps.com//storage';
        // const apiUrl= 'http://localhost:8000/'
        // const apiStorage= 'http://localhost:8000/storage';
        // const apiUrl= 'localhost:8000/'
        // const apiStorage= 'localhost:8000/storage'

        goBackBtn.addEventListener('click', (e)=>{
            e.preventDefault();
            
            loaderOverlay.classList.remove('active');
            restorePassword.classList.remove('active');
            forgottenPass.classList.remove('active');
        });

        forgottenBtnConfirm.addEventListener('click', (e)=>{
            e.preventDefault();
            const token = "{{ csrf_token() }}";
            const email = emailForgot?.value;
            // loaderOverlay.classList.add('active');
            // loader.classList.add('active');
            $.ajax({
                url: apiUrl + 'resetPassword',
                headers: {
                    'X-CSRF-TOKEN' : token,
                    'Content-Type' : 'application/json',
                },
                data: JSON.stringify({
                    'email' : email,
                }),
                type: 'POST',
                success: function(response){
                    email.value=null;
                    console.log('restore-pass classlist:',restorePassword.classList);
                    // console.log('loader-classlist: ', loader.classList);
                    
                    if(response.status==200){
                        // loader.classList.remove('active');
                        restorePassword.classList.add('active');
                        spanRestorePass.innerText = email;
                        restoreText.innerText = restoreText.innerText;
                        
                    }else if(response.status==400){
                        // loader.classList.remove('active');
                        restoreText.innerText = response.message;
                        // loaderOverlay.classList.add('active');
                        restorePassword.classList.add('active');
                    }
                },

                error: function(error){

                }
            });
        });

        proBtnContinue.addEventListener('click', (e)=>{
            // loaderOverlay.classList.add('active');
            // loader.classList.add('active');
            const email = document.querySelector('#email')?.value;
            const password = document.querySelector('#password')?.value;
            const confirm_password = document.querySelector('#confirm_password')?.value;
            const name = document.querySelector('#username')?.value;
            // const token = "{{ csrf_token() }}";
            // console.log(token);

            $.ajax({
                url: apiUrl +'register',
                data: JSON.stringify({
                    'profile': teacher.classList.contains('active')? 'formateur' : 'apprenant',
                    'name': name,
                    'email': email,
                    'password': password,
                    'password_confirmation': confirm_password,
                }),
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}",
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
                success: function(response){
                    console.log(response);
                    if(response.success){
                        // Nettoyer les états précédents
                        // loaderOverlay.classList.remove('active');
                        // loader.classList.remove('active');
                        // error.classList.remove('active');
                        registerForm.classList.remove('active');
                        profile.classList= [];
                        
                        // Afficher le succès
                        // successMsg.innerText = response.message;
                        // message.classList.add('success');
                        // success.classList.add('active');
                        registerForm.classList.add('active');
                        loginForm.classList.add('active');
                        
                        localStorage.setItem('user', response.user);
                        localStorage.setItem('token', response.token);
                        
                        loginForm.classList.add('active');
                        // window.location.href = " {{ route('home') }}";
                    }
                },
                error: function(erreurs){
                    console.log(erreurs);
                    // Nettoyer les états précédents
                    // loaderOverlay.classList.remove('active');
                    // loader.classList.remove('active');
                    // success.classList.remove('active');
                    // message.classList.remove('success');
                    let errorMessage = 'Erreur d\'inscription';
                    
                    // errorMessage = erreurs.responseJSON.errors;
                    errorMessage = 'Erreur d\'inscription';
                    console.log(errorMessage);
                    // Afficher l'erreur
                    // errorMsg.innerText = errorMessage;
                    // message.classList.add('error');
                    // error.classList.add('active');
                },
            })
        });
        teacher.addEventListener('click', (e)=>{
            e.preventDefault();
            console.log(teacher.classList)
            if(teacher.classList.contains('active')){
                teacher.classList.remove('active');
                if(proContOverlayBtn.classList.contains('unactive'))proContOverlayBtn.classList.remove('unactive');
                proContOverlayBtn.classList.add('active');
                return;
            }else{
                teacher.classList.add('active');
                if(learner.classList.contains('active')) learner.classList.remove('active');
                if(proContOverlayBtn.classList.contains('active')) proContOverlayBtn.classList.remove('active');
                proContOverlayBtn.classList.add('unactive');
            }
            
        });

        learner.addEventListener('click', (e)=>{
            e.preventDefault();
            console.log(learner.classList)
            if(learner.classList.contains('active')){
                learner.classList.remove('active');
                if(proContOverlayBtn.classList.contains('unactive'))proContOverlayBtn.classList.remove('unactive');
                proContOverlayBtn.classList.add('active');
                return;
            }else{
                learner.classList.add('active');
                proContOverlayBtn.classList.add('active');
                if(teacher.classList.contains('active')) teacher.classList.remove('active');
                if(proContOverlayBtn.classList.contains('active')) proContOverlayBtn.classList.remove('active');
                proContOverlayBtn.classList.add('unactive');
            }
        });

      

        forgottenBtnRegister.addEventListener('click', (e)=>{
            e.preventDefault();
            forgottenPass.classList.remove('active');
            registerForm.classList.remove('active');
        });

        restorePass.addEventListener('click', (e)=>{
            e.preventDefault();   
            console.log('clické!');  
            forgottenPass.classList.remove('active');   
            forgottenPass.classList.add('active');
        });     

        btnCloseMsg.forEach(btn =>{
            btn.addEventListener('click', (e)=>{
                e.preventDefault();
                e.currentTarget.parentNode.classList.remove('active');
                e.currentTarget.parentNode.parentNode.classList.remove('active');
            })
        })
        btnRegister2.addEventListener('click', (e)=> {
            e.preventDefault();
            if(registerForm.classList.contains('active')) registerForm.classList.remove('active');
        });

        // Soumission du formulaire de login
        btnLogin2.addEventListener('click', (e)=> {
            e.preventDefault();
            const logEmail = document.querySelector('#log-email')?.value;
            const logPassword = document.querySelector('#log-password')?.value;
            const token = "{{ csrf_token() }}";
            // loaderOverlay.classList.add('active');
            // loader.classList.add('active');
            $.ajax({
                type : 'POST',
                url:  apiUrl + "login",
                headers: {
                    'X-CSRF-TOKEN' : token,
                    'Content-Type' : 'application/json',
                    'Accept' : 'application/json'
                },
                data : JSON.stringify({
                    'email': logEmail,
                    'password': logPassword,
                }),

                success: function(response){
                    console.log('user: ',response);
                    if(response.success){
                        // loader.classList.remove('active');
                        // loaderOverlay.classList.remove('active');
                        localStorage.setItem('user', response.user);
                        localStorage.setItem('token', response.token);
                         if(response.user.role== 'admin' || response.user.role== 'superadmin'){
                            window.location.href = "{{ route('admin-home') }}";
                         }else{
                            window.location.href = "{{ route('home') }}";
                         }
                        

                        // Nettoyer les états précédents
                        // if(loaderOverlay.classList.contains('active')) loaderOverlay.classList.remove('active');
                        // if(loader.classList.contains('active')) loader.classList.remove('active');
                        // if(error.classList.contains('active')) error.classList.remove('active');
                        // if(message.classList.contains('error')) message.classList.remove('error');
                        
                        // Afficher le succès
                        // successMsg.innerText = response.message;
                        // message.classList.add('success');
                        // success.classList.add('active');
                    }else{
                        // loaderOverlay.classList.remove('active');
                        // loader.classList.remove('active');
                        // success.classList.remove('active');
                        // message.classList.remove('success');
                        
                        // let errorMessage = response.message;
                        console.log(errorMessage);
                        // Afficher l'erreur
                        // errorMsg.innerText = errorMessage;
                        // error.classList.add('active');
                        // message.classList.add('error');
                    }
                },
                error: function(erreur){
                    
                    // Nettoyer les états précédents
                    // loaderOverlay.classList.remove('active');
                    // loader.classList.remove('active');
                    // success.classList.remove('active');
                    // message.classList.remove('success');
                    
                    // let errorMessage = erreur.responseJSON.message;
                    // console.log(errorMessage);
                    // // Afficher l'erreur
                    // errorMsg.innerText = errorMessage;
                    // error.classList.add('active');
                    // message.classList.add('error');
                }
            })

            


        });
        // Activateur de la page de choix de type de profile
        
        btnRegister.addEventListener('click', (e)=> {
            e.preventDefault();
            // const registerForm= document.querySelector('.register');
            if(registerForm.querySelector('#email').value && registerForm.querySelector('#password').value, registerForm.querySelector('#username').value && registerForm.querySelector('#confirm_password').value){
                profile.classList.add('active');
            }
            
        });

        btnLogin.addEventListener('click', (e)=> {
            e.preventDefault();
            registerForm.classList.add('active');
        });
    });
</script>
@section('content')
    <section id="blockpage">
        <div class="container-left">
                <div class="block"><img src="{{ asset('images/image4.png')}}" alt=""></div>
                <div class="block"></div>
                <div class="block"></div>
                <div class="block"></div>
            </div>
            <div class="overlay" >
                <img src="https://www.bintschool.com/wp-content/uploads/2023/04/BintSchooloff.png" alt="" class="logo">
                <div class="register">
                    <div class="register-head">
                        <h2>Créer un nouveau compte</h2>
                        <p>Renseignez ces champs pour acceder immédiatement aux cours</p>
                    </div>
                    <form action="">
                        <h3>Créer un compte</h3>
                        @csrf
                        <div class="input-container">
                            <label for="name">Nom Complet</label>
                            <input type="text" id="username" name="name" required>
                        </div>
                        <div class="input-container">
                            <label for="email">Adresse mail</label>
                            <input type="text" id="email" name="email" required>
                        </div>
                        <div class="input-container">
                            <label for="password">Mot de passe</label>
                            <input type="password" id="password" name="password" required>
                        </div>
                        <div class="input-container">
                            <label for="password_confirmation">Mot de passe de confirmation</label>
                            <input type="password" id="confirm_password" name="password_confirmation" required>
                        </div>
                        <div class="btns">
                            <button class="btn-register">Creer un compte</button>
                            <div>ou</div>
                            <button class="btn-login">Se connecter</button>
                        </div> 
                    </form>
                </div>
                <div class="login">
                    <div class="login-head">
                        <h2>Connectez-vous !</h2>
                        <p>Accédez à votre compte rapidement et simplement</p>
                    </div>
                    <form action="">
                        @csrf
                        <div class="input-container">
                            <label for="email">Adresse mail</label>
                            <input type="text" id="log-email" name="email" required>
                            <span></span>
                        </div>
                        <div class="input-container">
                            <label for="password">Mot de passe</label>
                            <input type="password" id="log-password" name="password" required>
                            <span></span>
                        </div>
                        <a class="restore-pass"href="">Mot de passe oublié ?</a>
                        <div class="btns">
                            <button class="btn-login">Se connecter</button>
                            <div>ou</div>
                            <button class="btn-register">Créer un nouveau compte</button>
                        </div>
                        
                    </form>
                </div>
                <div id="forgotten-pass">
                    <div class="text">
                        <h3>Réinitialiser votre mot de passe</h3>
                        <p>Renseignez votre email afin de réinitialiser votre mot de passe</p>
                    </div>
                    <form action="">
                        <div class="input-container">
                            <label for="email-forgotten">Adresse email</label>
                            <input type="text" id="email-forgotten" name="email-forgotten" required>
                            <span></span>
                        </div>
                        
                        <div class="btns">
                            <button class="forgotten btn-confirm">continuer</button>
                            <div>ou</div>
                            <button class="forgotten btn-register">créer un nouveau compte</button>
                        </div>
                    </form>
                </div>

                <div id="profile">
                    <div class="profile-head">
                        <div class="text">
                            <h3>Définir votre profil</h3>
                            <p>Renseignez ces champs pour acceder immediatement aux cours</p>
                        </div>
                    </div>
                    <div class="profiles">
                        <div class="teacher">
                            <div class="profile-teacher">
                                <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-shop" viewBox="0 0 16 16">
                                    <path d="M2.97 1.35A1 1 0 0 1 3.73 1h8.54a1 1 0 0 1 .76.35l2.609 3.044A1.5 1.5 0 0 1 16 5.37v.255a2.375 2.375 0 0 1-4.25 1.458A2.37 2.37 0 0 1 9.875 8 2.37 2.37 0 0 1 8 7.083 2.37 2.37 0 0 1 6.125 8a2.37 2.37 0 0 1-1.875-.917A2.375 2.375 0 0 1 0 5.625V5.37a1.5 1.5 0 0 1 .361-.976zm1.78 4.275a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 1 0 2.75 0V5.37a.5.5 0 0 0-.12-.325L12.27 2H3.73L1.12 5.045A.5.5 0 0 0 1 5.37v.255a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0M1.5 8.5A.5.5 0 0 1 2 9v6h1v-5a1 1 0 0 1 1-1h3a1 1 0 0 1 1 1v5h6V9a.5.5 0 0 1 1 0v6h.5a.5.5 0 0 1 0 1H.5a.5.5 0 0 1 0-1H1V9a.5.5 0 0 1 .5-.5M4 15h3v-5H4zm5-5a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1zm3 0h-2v3h2z"/>
                                </svg>

                                <div class="text">
                                    <h4>Formateur</h4>
                                    <p>Présentez et vendez des cours aux apprenants</p>
                                </div>
                                <img src=" {{asset('images/image2.png') }} " alt="">
                            </div>
                        </div>
                            
                        <div class="learner">
                            <div class="profile-learner">
                                <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-mortarboard" viewBox="0 0 16 16"><path d="M8.211 2.047a.5.5 0 0 0-.422 0l-7.5 3.5a.5.5 0 0 0 .025.917l7.5 3a.5.5 0 0 0 .372 0L14 7.14V13a1 1 0 0 0-1 1v2h3v-2a1 1 0 0 0-1-1V6.739l.686-.275a.5.5 0 0 0 .025-.917zM8 8.46 1.758 5.965 8 3.052l6.242 2.913z"/><path d="M4.176 9.032a.5.5 0 0 0-.656.327l-.5 1.7a.5.5 0 0 0 .294.605l4.5 1.8a.5.5 0 0 0 .372 0l4.5-1.8a.5.5 0 0 0 .294-.605l-.5-1.7a.5.5 0 0 0-.656-.327L8 10.466zm-.068 1.873.22-.748 3.496 1.311a.5.5 0 0 0 .352 0l3.496-1.311.22.748L8 12.46z"/></svg>
                                <div class="text">
                                    <h4>Apprenant</h4>
                                    <p>Découvrez et apprenez des cours</p>
                                        
                                </div>
                                <img src=" {{ asset('images/image3.png') }} " alt="">
                            </div>
                        </div>
                            
                    </div>

                        <div class="overlay-btn"></div>
                        <div class="btn-continue">continuer</div>
                    </div>

            </div>
            <div class="container-right">
                <div class="block"></div>
                <div class="block"><img src="{{ asset('images/image3.png')}}" alt=""></div>
                <div class="block"></div>
                <div class="block"></div>
            </div>
            
            
        </div>


        
</section>
<section id="message">
    <div class="success">
        <h4>
            <div class="ctn-svg">
            <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-check-circle" viewBox="0 0 16 16">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                <path d="m10.97 4.97-.02.022-3.473 4.425-2.093-2.094a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05"/>
            </svg>
            Réussi
            </div>
        </h4>
        <div class="success-msg"></div>
        <button class="close-msg">fermer</button>
    </div>

    <div class="error">
        <h4>
            <div class="ctn-svg">
                <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-exclamation-triangle" viewBox="0 0 16 16">
                    <path d="M7.938 2.016A.13.13 0 0 1 8.002 2a.13.13 0 0 1 .063.016.15.15 0 0 1 .054.057l6.857 11.667c.036.06.035.124.002.183a.2.2 0 0 1-.054.06.1.1 0 0 1-.066.017H1.146a.1.1 0 0 1-.066-.017.2.2 0 0 1-.054-.06.18.18 0 0 1 .002-.183L7.884 2.073a.15.15 0 0 1 .054-.057m1.044-.45a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767z"/>
                    <path d="M7.002 12a1 1 0 1 1 2 0 1 1 0 0 1-2 0M7.1 5.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0z"/>
                </svg>
            </div>
            
            Erreur
        </h4>
        <div class="error-msg"></div>
        <button class="close-msg">fermer</button>
    </div>
</section>
<section id="loader-overlay">
    <div class="loader">
        Veuillez patienter...
        <div class="spinner">
            <div class="vertical">
                <div class="top"></div>
                <div class="bottom"></div>
            </div>

            <div class="horizontal">
                <div class="left"></div>
                <div class="right"></div>
            </div>
            
        </div>
    </div>

    <div id="restore-pass">
        <h2>Message</h2>
        <p>Le mail de réinitialisation a été envoyé sur votre adresse <span class="useremail"></span>.Consulter le dès maintenant afin d'acceder a votre compte</p>
        <button class="goBack-btn">Revenir à la page de connexion</button>
    </div>
</section>
    
@endsection