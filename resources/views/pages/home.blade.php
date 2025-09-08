@extends('index')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    
    <!-- Responsive CSS pour mobile -->
    <style>
        /* ========================================
           RESPONSIVE MOBILE STYLES
           ========================================*/
        
        /* Masquer les éléments mobiles sur desktop */
        @media screen and (min-width: 769px) {
            .mobile-nav-toggle,
            .nav-overlay {
                display: none !important;
            }
        }
        
        @media screen and (max-width: 768px) {
            /* Navigation mobile */
            nav {
                position: fixed;
                top: 0;
                left: -100%;
                width: 280px;
                height: 100vh;
                background: var(--bg-primary, #fff);
                z-index: 1000;
                transition: left 0.3s ease;
                box-shadow: 2px 0 10px rgba(0,0,0,0.1);
                overflow-y: auto;
            }
            
            nav.mobile-open {
                left: 0;
            }
            
            nav ul {
                flex-direction: column;
                padding: 20px 0;
                gap: 10px;
            }
            
            nav ul li {
                width: 100%;
                padding: 15px 20px;
                border-bottom: 1px solid var(--border-color, #eee);
            }
            
            /* Overlay pour fermer le menu */
            .nav-overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100vh;
                background: rgba(0,0,0,0.5);
                z-index: 999;
                opacity: 0;
                visibility: hidden;
                transition: all 0.3s ease;
            }
            
            .nav-overlay.active {
                opacity: 1;
                visibility: visible;
            }
            
            /* Bouton hamburger */
            .mobile-nav-toggle {
                position: fixed;
                top: 20px;
                left: 20px;
                width: 40px;
                height: 40px;
                background: var(--primary-color, #007bff);
                border: none;
                border-radius: 8px;
                z-index: 1001;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                gap: 4px;
                cursor: pointer;
            }
            
            .mobile-nav-toggle span {
                width: 20px;
                height: 2px;
                background: white;
                transition: all 0.3s ease;
            }
            
            .mobile-nav-toggle.active span:nth-child(1) {
                transform: rotate(45deg) translate(5px, 5px);
            }
            
            .mobile-nav-toggle.active span:nth-child(2) {
                opacity: 0;
            }
            
            .mobile-nav-toggle.active span:nth-child(3) {
                transform: rotate(-45deg) translate(7px, -6px);
            }
            
            /* Contenu principal */
            main {
                padding-left: 0;
                padding-top: 80px;
            }
            
            /* Sections principales */
            #content, #profile, #messagerie, #formation-suivie, 
            #cours-en-vente, #retrait, #ajout-formation {
                padding: 20px 15px;
                margin: 0;
            }
            
            /* Grilles responsive */
            .grid, .grid-2, .grid-3, .grid-4 {
                grid-template-columns: 1fr;
                gap: 15px;
            }
            
            /* Cards et items */
            .card, .item, .cour-item {
                margin-bottom: 15px;
            }
            
            /* Formulaires */
            form {
                padding: 20px 15px;
            }
            
            .input-container, .input-ctn {
                margin-bottom: 20px;
            }
            
            input, textarea, select {
                font-size: 16px; /* Évite le zoom sur iOS */
                padding: 12px;
            }
            
            /* Boutons */
            button, .btn {
                padding: 12px 20px;
                font-size: 16px;
                min-height: 44px; /* Taille minimale pour le touch */
            }
            
            /* Modals responsive */
            #overlay {
                padding: 20px 15px;
                overflow-y: auto;
            }
            
            #overlay > div {
                max-width: 100%;
                margin: 0;
                border-radius: 12px 12px 0 0;
            }
            
            /* Modal create-formation */
            #create-formation {
                position: fixed;
                bottom: 0;
                left: 0;
                right: 0;
                top: auto;
                max-height: 90vh;
                overflow-y: auto;
                border-radius: 20px 20px 0 0;
            }
            
            #create-formation .create-formation-head {
                position: sticky;
                top: 0;
                background: var(--bg-primary, #fff);
                z-index: 10;
                padding: 20px;
                border-bottom: 1px solid var(--border-color, #eee);
            }
            
            #create-formation .create-formation-body {
                padding: 20px;
            }
            
            #create-formation .create-formation-footer {
                position: sticky;
                bottom: 0;
                background: var(--bg-primary, #fff);
                padding: 20px;
                border-top: 1px solid var(--border-color, #eee);
                display: flex;
                gap: 15px;
            }
            
            #create-formation .create-formation-footer button {
                flex: 1;
            }
            
            /* File upload area */
            .file-ctn {
                min-height: 150px;
                padding: 20px;
                text-align: center;
            }
            
            /* Formation parts */
            .formation-parts {
                padding: 20px;
            }
            
            .part-temp {
                margin-bottom: 20px;
                border: 1px solid var(--border-color, #eee);
                border-radius: 8px;
                overflow: hidden;
            }
            
            .part-head {
                padding: 15px;
                background: var(--bg-secondary, #f8f9fa);
                border-bottom: 1px solid var(--border-color, #eee);
            }
            
            .part-body {
                padding: 15px;
            }
            
            /* Profile page */
            #profile .user {
                flex-direction: column;
                text-align: center;
            }
            
            #profile .user-profile {
                margin-bottom: 20px;
            }
            
            #profile .btns {
                flex-direction: column;
                gap: 10px;
            }
            
            /* Messages et notifications */
            #message {
                position: fixed;
                bottom: 20px;
                left: 20px;
                right: 20px;
                z-index: 1002;
            }
            
            #message .success,
            #message .error {
                border-radius: 8px;
                padding: 15px;
            }
            
            /* Loader */
            #loader-overlay {
                padding: 20px;
            }
            
            .loader {
                max-width: 90%;
            }
            
            /* Tables responsive */
            table {
                font-size: 14px;
            }
            
            table th,
            table td {
                padding: 8px 4px;
                font-size: 12px;
            }
            
            /* Video players */
            video, .video-container {
                width: 100%;
                height: auto;
            }
            
            /* Cours details */
            #cour-details {
                padding: 20px 15px;
            }
            
            #cour-details .container-left,
            #cour-details .container-right {
                width: 100%;
                margin-bottom: 20px;
            }
            
            /* Categories */
            #categories ul {
                flex-wrap: wrap;
                gap: 10px;
            }
            
            #categories ul li {
                flex: 1;
                min-width: calc(50% - 5px);
                text-align: center;
                padding: 10px 5px;
                font-size: 14px;
            }
            
            /* Search and filters */
            .search-container {
                margin-bottom: 20px;
            }
            
            .search-container input {
                width: 100%;
            }
            
            /* Responsive utilities */
            .hide-mobile {
                display: none !important;
            }
            
            .show-mobile {
                display: block !important;
            }
            
            /* Touch improvements */
            * {
                -webkit-tap-highlight-color: transparent;
            }
            
            button, .btn, a {
                -webkit-touch-callout: none;
                -webkit-user-select: none;
                user-select: none;
            }
            
            /* Scroll improvements */
            .scrollable {
                -webkit-overflow-scrolling: touch;
            }
            
            /* Specific components mobile adjustments */
            
            /* User profile section */
            #profile .complete-profil {
                margin-bottom: 20px;
            }
            
            #profile .complete-profil .percentage {
                font-size: 14px;
            }
            
            /* Formation suivie section */
            #formation-suivie .forma-cour-list table {
                display: block;
                overflow-x: auto;
                white-space: nowrap;
            }
            
            #formation-suivie .forma-cour-grid {
                display: grid;
                grid-template-columns: 1fr;
                gap: 15px;
            }
            
            #formation-suivie .btns {
                margin-bottom: 20px;
                display: flex;
                gap: 10px;
            }
            
            #formation-suivie .btns button {
                flex: 1;
            }
            
            /* Cours en vente section */
            #cours-en-vente .btn-creer-formation {
                width: 100%;
                margin-bottom: 20px;
                padding: 15px;
                font-size: 16px;
            }
            
            /* Messagerie section */
            #messagerie {
                padding: 15px;
            }
            
            #messagerie .message-item {
                padding: 15px;
                margin-bottom: 10px;
                border-radius: 8px;
            }
            
            /* Retrait section */
            #retrait form {
                padding: 20px 15px;
            }
            
            #retrait .input-container {
                margin-bottom: 20px;
            }
            
            /* Content feed */
            #content .content-item {
                margin-bottom: 20px;
                border-radius: 12px;
                overflow: hidden;
            }
            
            #content .content-item img,
            #content .content-item video {
                width: 100%;
                height: auto;
            }
            
            /* Categories responsive */
            #categories {
                margin-bottom: 20px;
            }
            
            #categories ul {
                display: flex;
                flex-wrap: wrap;
                gap: 8px;
                padding: 10px 0;
            }
            
            /* Cour details responsive */
            #cour-details .cour-body {
                padding: 20px 15px;
            }
            
            #cour-details .content-items {
                display: flex;
                flex-direction: column;
                gap: 15px;
            }
            
            #cour-details .btn-buy-cour {
                position: fixed;
                bottom: 20px;
                left: 20px;
                right: 20px;
                z-index: 100;
                padding: 15px;
                font-size: 16px;
                border-radius: 8px;
            }
            
            /* Sell cour overlay mobile */
            #sell-cour-detail-overlay {
                position: fixed;
                bottom: 0;
                left: 0;
                right: 0;
                top: 20%;
                border-radius: 20px 20px 0 0;
                overflow-y: auto;
            }
            
            #sell-cour-detail-overlay .sell-cour-steps {
                padding: 20px;
            }
            
            #sell-cour-detail-overlay .payment-methods {
                margin: 20px 0;
            }
            
            #sell-cour-detail-overlay .payment-methods .btns {
                display: flex;
                flex-direction: column;
                gap: 15px;
            }
            
            #sell-cour-detail-overlay .payment-methods .btns button {
                padding: 15px;
                border-radius: 8px;
            }
            
            /* Settings and params mobile */
            #params {
                position: fixed;
                bottom: 0;
                left: 0;
                right: 0;
                top: 10%;
                border-radius: 20px 20px 0 0;
                overflow-y: auto;
            }
            
            #params .param-head {
                position: sticky;
                top: 0;
                background: var(--bg-primary, #fff);
                z-index: 10;
                padding: 20px;
                border-bottom: 1px solid var(--border-color, #eee);
            }
            
            #params .btns {
                padding: 20px;
                display: flex;
                flex-direction: column;
                gap: 15px;
            }
            
            #params .btns button {
                width: 100%;
                padding: 15px;
                text-align: left;
                border-radius: 8px;
            }
            
            /* Switch account modal */
            #switch-acc,
            #conf-acc-switch,
            #del-acc-msg,
            #change-user-info {
                position: fixed;
                bottom: 0;
                left: 0;
                right: 0;
                top: 20%;
                border-radius: 20px 20px 0 0;
                padding: 20px;
                overflow-y: auto;
            }
            
            /* File input improvements */
            input[type="file"] {
                padding: 10px;
                border: 2px dashed var(--border-color, #ddd);
                border-radius: 8px;
                background: var(--bg-secondary, #f8f9fa);
            }
            
            /* Drag and drop area */
            .file-ctn {
                border: 2px dashed var(--border-color, #ddd);
                border-radius: 12px;
                background: var(--bg-secondary, #f8f9fa);
                transition: all 0.3s ease;
            }
            
            .file-ctn:hover {
                border-color: var(--primary-color, #007bff);
                background: rgba(0, 123, 255, 0.05);
            }
            
            /* Loading states */
            .loading {
                opacity: 0.6;
                pointer-events: none;
            }
            
            .loading::after {
                content: '';
                position: absolute;
                top: 50%;
                left: 50%;
                width: 20px;
                height: 20px;
                margin: -10px 0 0 -10px;
                border: 2px solid var(--primary-color, #007bff);
                border-top-color: transparent;
                border-radius: 50%;
                animation: spin 1s linear infinite;
            }
            
            @keyframes spin {
                to {
                    transform: rotate(360deg);
                }
            }
        }
        
        /* Tablet adjustments */
        @media screen and (min-width: 769px) and (max-width: 1024px) {
            nav ul li {
                padding: 10px 15px;
                font-size: 14px;
            }
            
            main {
                padding-left: 200px;
            }
            
            .grid-3 {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .grid-4 {
                grid-template-columns: repeat(3, 1fr);
            }
        }
        
        /* Large mobile screens */
        @media screen and (min-width: 481px) and (max-width: 768px) {
            .grid-2 {
                grid-template-columns: repeat(2, 1fr);
            }
            
            #categories ul li {
                min-width: calc(33.333% - 10px);
            }
            
            #create-formation {
                max-height: 85vh;
            }
        }
        
        /* Small mobile screens */
        @media screen and (max-width: 480px) {
            .mobile-nav-toggle {
                width: 35px;
                height: 35px;
                top: 15px;
                left: 15px;
            }
            
            main {
                padding-top: 70px;
            }
            
            #overlay {
                padding: 10px;
            }
            
            button, .btn {
                padding: 10px 15px;
                font-size: 14px;
            }
            
            input, textarea, select {
                padding: 10px;
                font-size: 16px;
            }
            
            #create-formation .create-formation-head h3 {
                font-size: 18px;
            }
            
            #message {
                bottom: 10px;
                left: 10px;
                right: 10px;
            }
        }
        
        /* Landscape orientation adjustments */
        @media screen and (max-height: 500px) and (orientation: landscape) {
            #create-formation {
                max-height: 95vh;
            }
            
            .mobile-nav-toggle {
                top: 10px;
                left: 10px;
            }
            
            main {
                padding-top: 60px;
            }
        }
    </style>

    <script>

        document.addEventListener('DOMContentLoaded', () =>{
            
            let user = localStorage.getItem('user');
            let profileUser= null;
            const pauses = document.querySelectorAll('.pause-play .bi-play-fill');
            const categories = document.querySelector('#categories');
            const listes = document.querySelector('#categories ul li');
            const main = document.querySelector('main');
            const navList = document.querySelectorAll('nav ul li');
            const profilePage = document.querySelector('#profile');
            const profileLink = document.querySelector('nav ul li.profile-link');
            const pourToi = document.querySelector('nav ul li.pour-toi');
            const messagerieLink = document.querySelector('nav ul li.messagerie-link');
            const messagerie = document.querySelector('#messagerie');
            const formaSuivieLink = document.querySelector('nav ul li.forma-suivie');
            // const addFormLink = document.querySelector('nav ul li.ajout-forma');
            const coursEnVenteLink = document.querySelector('nav ul li.cours-en-vente');
            const formaSuivie = document.querySelector('#formation-suivie');
            const coursEnVente = document.querySelector('#cours-en-vente');
            const retraitLink = document.querySelector('nav ul li.retrait-link');
            const retrait = document.querySelector('#retrait');
            const btnParam = document.querySelector('#profile .user .user-profile .btns .param');
            const btnShare = document.querySelector('#profile .user .user-profile .btns .profile-share');
            const btnChangeCover = document.querySelector('#profile .user .user-profile .btns .change-cover');
            const coverPic = document.querySelector('#cover-pic');
            const profilePic = document.querySelector('#profile-pic');
            const overlay = document.querySelector('#overlay');
            const params = document.querySelector('#params');
            const paramHead = document.querySelector('#params .param-head');
            const closeParam = document.querySelector('#params .param-head .par-head-block1 .btn-close-param');
            const infoPerso = document.querySelector('#params .btns .info-perso');
            const courDetailsPage = document.querySelector('#cour-details');
            const courDetailBtnBack = document.querySelector('#cour-details .container-left button');
            const allCours = document.querySelectorAll('#cours .items .cour');
            const coursLi = document.querySelectorAll('#cours ul li');
            const btnDelAcc = document.querySelector('#params .btns .btn-del-acc');
            const btnDevForma = document.querySelector('#params .btns .btn-dev-forma');
            const btnInfoPerso = document.querySelector('#params .btns .btn-info-perso');
            const switchAcc = document.querySelector('#switch-acc');
            const btnCtnSwitchAcc = document.querySelector('#switch-acc .switch-acc-btn-ctn');
            const delAccMsg = document.querySelector('#del-acc-msg');
            const btnConfirmDelAcc = document.querySelector('#del-acc-msg form .btn-del-acc-msg');
            const delReasons = document.querySelector('#params .body .del-reasons');
            const btnDelAccReturn = document.querySelector('.btn-del-acc-return');
            const btnCancelDel = document.querySelector('#params .del-reasons .foot .btn-del-cancel');
            const btnContinuDelAcc = document.querySelector('#params .del-reasons .foot .btn-continue-del-acc');
            const sellCourOverlay = document.querySelector('#cour-details #sell-cour-detail-overlay');
            const btnBuyCour = document.querySelector('#cour-details .cour-detail-body .btn-buy-cour');
            const btnCardPay = document.querySelector('#cour-details #sell-cour-detail-overlay .sell-cour-steps .step1 .payment-methods .btns .btn-card-payement');
            const btnMobilePay = document.querySelector('#cour-details #sell-cour-detail-overlay .sell-cour-steps .step1 .payment-methods .btns .btn-mobile-money');
            const pay = document.querySelector('#sell-cour-detail-overlay .sell-cour-steps .step1 .btn-pay');
            const btnRetourSellCour = document.querySelector('#sell-cour-detail-overlay .sell-cour-steps .btn-retour');
            const sellCourStep1 = document.querySelector('#sell-cour-detail-overlay .sell-cour-steps .step1');
            const sellCourStep2 = document.querySelector('#sell-cour-detail-overlay .sell-cour-steps .step2');
            const BtnSellStartCour = document.querySelector('#sell-cour-detail-overlay .sell-cour-steps .step2 .btn-start-cour');
            const courList = document.querySelector('#formation-suivie .forma-cour-list');
            const courGrid = document.querySelector('#formation-suivie .forma-cour-grid');
            const courListItem = document.querySelector('#formation-suivie .forma-cour-list .list-item');
            const btnFormaList = document.querySelector('#formation-suivie .btns .btn-table-view');
            const btnFormaGrid = document.querySelector('#formation-suivie .btns .btn-grid-view');
            const cardPay = document.querySelector('#card-payment');
            const mobPay = document.querySelector('#mobile-payment');
            const paymentMethods = document.querySelector('#cour-details #sell-cour-detail-overlay .sell-cour-steps .step1 .payment-methods');
            const btnOverlayRetour = document.querySelector('#overlay .btn-overlay-retour');
            const userEmail = document.querySelector('#email');
            const userPassword = document.querySelector('#password');
            const userName = document.querySelector('#username');
            const changePersInfoForm = document.querySelector('#params .btns .info-perso form');
            const changeUserInfo = document.querySelector('#change-user-info');
            const btnChangeUserInfo = document.querySelector('#change-user-info form .btn-change-info');
            const formInfoPerso = document.querySelector('#form-info-perso');
            const loader = document.querySelector('.loader');
            const courListItems = document.querySelectorAll('#formation-suivie .forma-cour-list table tbody tr');
            const courGridItems = document.querySelectorAll('#formation-suivie .forma-cour-grid .list-item');
            // const addFormPage = document.querySelector('#ajout-formation');
            const videoIntro = document.querySelector('#video_intro');
            // let addModuleForm = document.querySelector('#ajout-formation form#add-modules');
            const addVideoIntro = document.querySelector('#add-forma .add-intro-video');
            // const btnAddModule = document.querySelector('#ajout-formation form#add-modules .add-module');
            const addForma = document.querySelector('#overlay #add-forma');
            const btnAddForma = document.querySelector('#ajout-formation .btn-add-forma');
            const message = document.querySelector('#message');
            const error = document.querySelector('#message .error');
            const errorMsg = document.querySelector('#message .error .error-msg');
            const success = document.querySelector('#message .success');
            const successMsg = document.querySelector('#message .success .success-msg');
            const btnCloseMsg = document.querySelectorAll('#message .close-msg');
            const confSwitchAcc = document.querySelector('#conf-acc-switch');
            const btnSwitchAcc = document.querySelector('#conf-acc-switch .conf-switch-foot button:nth-child(2)');
            const btnCancelSwitchAcc = document.querySelector('#conf-acc-switch .conf-switch-foot button:nth-child(1)');
            const username = document.querySelector('#profile .user .user-profile .user-info h2');
            const homeContent = document.querySelector('#content');
            const contentItem = document.querySelector('#content .content-item');
            const comProfile = document.querySelector('#profile .complete-profil .percentage');
            const percentage = document.querySelector('#profile .complete-profil .percentage');
            const btnAddImgCouv= document.querySelector('.btn-img-couv');
            const createFormation= document.querySelector('#create-formation');
            const formationFile = document.querySelector('#create-formation .file-ctn');
            const gratuit= document.querySelector('#create-formation .create-formation-body form .btns button:nth-child(1)');
            const payant= document.querySelector('#create-formation .create-formation-body form .btns button:nth-child(2)');
            let formationID= null;
            let part= 1;
            let lesson= 1;
            const apiUrl = 'http://localhost:8000/';
            const apiStorage= 'http://localhost:8000/storage';
            const token = localStorage.getItem('token');
            
            // Mobile Navigation Elements
            const mobileNavToggle = document.querySelector('.mobile-nav-toggle');
            const navOverlay = document.querySelector('.nav-overlay');
            const nav = document.querySelector('nav');

            
            $.ajax({
                url: apiUrl+'user',
                type: 'GET',
                processData: true,
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'Authorization': `Bearer ${token}`,
                },
                success: function(response){
                    // console.log('user:', response);
                    user= response;
                    username.innerText= response.name;
                    email.value = response.email;
                    userName.value = response.name;
                    // console.log('description', document.querySelector('#profile .user-info p'));
                    document.querySelector('#profile .user-info p').innerText= response.bio;
                    // if(response.role == 'apprenant') addFormLink.style.display = 'none';
                    if(response.role == 'formateur') btnDevForma.style.display= 'none';
                    if(response.role == 'formateur') formaSuivieLink.innerHTML= 
                    `<svg viewBox="0 0 32 32" fill="white" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns" >
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier"> 
                            <title>book-album</title> 
                            <desc>Created with Sketch Beta.</desc> 
                            <defs> </defs> 
                            <g id="Page-1" stroke="none" stroke-width="1" fill-rule="evenodd" sketch:type="MSPage"> 
                                <g id="Icon-Set-Filled" sketch:type="MSLayerGroup" transform="translate(-414.000000, -101.000000)" fill="#000000"> 
                                    <path d="M418,101 C415.791,101 414,102.791 414,105 L414,126 C414,128.209 415.885,129.313 418,130 L429,133 L429,104 C423.988,102.656 418,101 418,101 L418,101 Z M442,101 C442,101 436.212,102.594 430.951,104 L431,104 L431,133 C436.617,131.501 442,130 442,130 C444.053,129.469 446,128.209 446,126 L446,105 C446,102.791 444.209,101 442,101 L442,101 Z" id="book-album" sketch:type="MSShapeGroup"> </path> 
                                </g> 
                            </g> 
                        </g>
                    </svg>   My formations `;
                    formaSuivieLink.querySelector('svg').style.cssText+= 'fill: white; stroke: white;';

                },
                error: function(erreurs){
                    console.log(erreurs);
                }
            });


            /*==================== Categories ===================*/

            // Get the categories

            $.ajax({
                url: apiUrl +'categories',
                type: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                
                success: function(response){
                    // console.log('Categories: ',response);
                    selectCategories= document.querySelector('#forma-cate');
                    response.forEach(categorie=> {
                        const element = document.createElement('li').cloneNode(true);
                        const option = document.createElement('option');

                        option.innerText= categorie.nom;
                        option.value= categorie.id;
                        element.innerText= categorie.nom;

                        categories.querySelector('ul').appendChild(element);
                        document.querySelector('#create-formation .create-formation-body form select').appendChild(option);

                        element.addEventListener('click', (e)=>{
                            e.preventDefault();
                            const liActive= categories.querySelectorAll('li.active');
                            liActive.forEach(li =>{
                                li.classList.remove('active');
                            });
                            e.currentTarget.classList.add('active');
                        });
                    });
                    document.querySelector('#categories ul').firstElementChild.classList.add('active');
                },

                error: function(erreurs){
                    console.log(erreurs);
                }
            });

            //  Create the categories

            // $.ajax({
            //     type: 'POST',
            //     url: apiUrl+ 'categories',
            //     headers: {
            //         'Content-Type': 'application/json',
            //         // 'Authorization': `Bearer ${token}`,
            //     },
            //     data: JSON.stringify({}),
            //     success: function(response){
            //         console.log('categorie-categorie:',response);
            //     },
            //     error: function(erreurs){
            //         console.log(erreurs);
            //     }
            // });

            //  Modifier a categorie

            // $.ajax({
            //     type: 'PUT',
            //     url: apiUrl+ `categories/${id}`,
            //     headers: {
            //         'Content-Type': 'application/json',
            //         'Authorization': `Bearer ${token}`,
            //     },
            //     data: JSON.stringify({}),
            //     success: function(response){
            //         console.log(response);
            //     },
            //     error: function(erreurs){
            //         console.log(erreurs);
            //     }
            // });

            /* ==================Formations================= */

            // btnAddImgCouv.addEventListener('click', (e)=>{
            //     e.preventDefault();
            //     document.querySelector('input[name="forma-couverture"]').click();
            // });

            // Creer une formation
            // addForma.addEventListener('submit', (e)=>{
            //     e.preventDefault();

            //     const data= new FormData();
            //     let vidDuration= null;
            //     overlay.classList=[];
            //     overlay.classList.add('load');
            //     loader.classList.add('active')
                
            //     const titre= document.querySelector('input[name="formation-name"]').value;
            //     const price= document.querySelector('input[name="formation-price"]').value;
            //     const categorie= document.querySelector('#forma-cate').value;
            //     const description= document.querySelector('#description').value;
            //     const file= document.querySelector('#video_intro').files[0];
            //     const video= document.createElement('video');
            //     video.preload= 'metadata';
            //     video.src= URL.createObjectURL(file);

            //     video.onloadedmetadata= () =>{
            //         URL.revokeObjectURL(video.src);
            //         vidDuration= video.duration.toFixed(2);

            //         const img_couv= document.querySelector('input[name="forma-couverture"]').files[0];
            //         data.append('titre', titre);
            //         data.append('categorie_id', categorie);
            //         data.append('prix', price);
            //         data.append('description', description);
            //         data.append('video_intro', file)
            //         data.append('img_couv', img_couv);
            //         data.append('statut', 'publie');
            //         data.append('duree', vidDuration);
                    
            //         $.ajax({
            //             url: apiUrl+ 'formations',
            //             type: 'POST',
            //             contentType: false,
            //             processData: false,
            //             headers: {
            //                 'Accept': 'application/json',
            //                 'Authorization': `Bearer ${token}`,
            //             },
            //             data: data,
            //             success: function(response){
            //                 // console.log(response);
            //                 overlay.classList= [];
            //                 loader.classList= [];
            //                 message.classList= [];
            //                 message.classList.add('success');
            //                 success.classList.add('active');
            //                 successMsg.innerText= 'Formation ajouté avec success!';
            //             },
            //             error: function(erreurs){
            //                 // console.log(erreurs);
            //                 overlay.classList= [];
            //                 loader.classList= [];
            //                 message.classList= [];
            //                 message.classList.add('error');
            //                 error.classList.add('active');
            //                 errorMsg.innerText= erreurs.responseJSON.message;
            //             },
            //         });
            //     }
                
            // });


            // Detail d'une formation

            // $.ajax({
            //     url: apiUrl + `formations/${id}`,
            //     type: 'GET',
            //     headers: {
            //         'Content-Type': 'application/json',
            //         'Accept': 'application/json',
            //         'Authorization': `Bearer ${token}`,
            //     },
            //     success: function(response){
            //         console.log(response);
            //     },
            //     error: function(erreurs){
            //         console.log(erreurs);
            //     }
            // });

            // Mes formations (Formateur)

            // $.ajax({
            //     url: apiUrl+'my-formations',
            //     type: 'GET',
            //     headers: {
            //         'Content-Type': 'application/json',
            //         'Accept': 'application/json',
            //         'Authorization': `Bearer ${token}`,
            //     },
            //     success: function(response){
            //         // console.log('myformations: ', response);
            //         const userFormations = document.querySelector('#user-formations');
                    

            //         response.forEach(element =>{
            //             const option= document.createElement('option');
            //             option.innerText= element.titre;
            //             option.value= element.id
            //             userFormations.appendChild(option);
            //         });
                    
            //     },
            //     error: function(erreurs){
            //         console.log('my-formations-errors: ',erreurs);
            //     }
            // });


           

            // Publier une formation

            // $.ajax({
            //     url: apiUrl+ `formations/${id}/publish`,
            //     type: 'POST',
            //     headers: {
            //         'Content-Type': 'application/json',
            //         'Accept': 'application/json',
            //         'Authorization': `Bearer ${token}`,
            //     },
            //     success: function(response){
            //         console.log(resposne);
            //     },
            //     error: function(erreurs){
            //         console.log(erreurs);
            //     },

            // });

            // Dépublier une formation

            // $.ajax({
            //     url: apiUrl+ `formations/${id}/unpublish`,
            //     type: 'POST',
            //     headers: {
            //         'Content-Type': 'application/json',
            //         'Accept': 'application/json',
            //         'Authorization': `Bearer ${token}`,
            //     },
            //     success: function(response){
            //         console.log(resposne);
            //     },
            //     error: function(erreurs){
            //         console.log(erreurs);
            //     },

            // });

            /* =============== Feed videos ============== */

            $.ajax({
                url: apiUrl + 'feed-videos',
                type: 'GET',
                headers:{
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'Authorization': `Bearer ${token}`,
                },
                success: function(response){
                    
                    response.data.forEach(feed=>{
                        console.log('Feed:', feed);
                        // console.log('url', apiStorage+ feed.miniature);
                        const content = contentItem.cloneNode(true);
                        content.querySelector('video').poster= feed.miniature ? apiStorage+ feed.miniature : "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSjKpLDQpOaFi-qf8UyakjjLvBbUlKm4fvw4g&s";
                        content.querySelector('video source').src= apiStorage+ feed.url_video;
                        content.querySelector('.text .legend').innerText= feed.description;
                        const contentUser = content.querySelector('.text .user');
                        const btnFollow = content.querySelector('.btn-follow');
                        const btnLike = content.querySelector('.btns button:nth-child(1)');
                        const btnSavoirPlus = content.querySelector('.more button');
                        contentUser.querySelector('img').src= feed.user.avatar_url ? apiStorage+ feed.user.avatar_url : " data:image/jpeg;base64,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 ";
                        contentUser.querySelector('h6').innerText= feed.user.name;
                        homeContent.appendChild(content);

                        contentUser.onclick= ()=>{
                            document.querySelector('#formateur-profile').classList.add('active');
                        }

                        content.querySelector('video').addEventListener('click', (e)=>{
                            // e.preventDefault(); // Supprimé pour permettre la lecture
                            // console.log('style:' ,);
                            // e.currentTarget.style.cssText= 'border:1px solid white;';
                            // console.log(e.currentTarget.querySelector('source').src);
                            
                            // Ajouter la logique de lecture ici
                            if(e.currentTarget.paused){
                                e.currentTarget.play();
                                // console.log('video-clické');
                                if(e.currentTarget.nextElementSibling) {
                                    e.currentTarget.nextElementSibling.classList.add('active');
                                }
                                e.currentTarget.muted = false;
                            } else {
                                if(e.currentTarget.nextElementSibling) {
                                    e.currentTarget.nextElementSibling.classList.remove('active');
                                }
                                e.currentTarget.pause();
                                // console.log('video-pause');
                            }
                        });


                        // Follow the user from the feed-video
                        btnFollow.addEventListener('click', (e)=> {
                            $.ajax({
                                url: apiUrl+ `users/${feed.user.id}/follow`,
                                type: 'POST',
                                headers:{
                                    'Content-Type': 'application/json',
                                    'Accept': 'application/json',
                                    'Authorization': `Bearer ${token}`,
                                },
                                success: function(response){
                                    message.classList= [];
                                    message.classList.add('success');
                                    success.classList.add('active');
                                    successMsg.innerText= response.message;
                                },
                                error: function(erreurs){
                                    message.classList= [];
                                    message.classList.add('error');
                                    error.classList.add('active');
                                    errorMsg.innerText= erreurs.message;
                                }
                            });
                        });

                        btnLike.onclick= ()=>{

                            $.ajax({
                                url: apiUrl+ `feed-videos/${feed.id}/like`,
                                type: 'POST',
                                headers:{
                                    'Content-Type': 'application/json',
                                    'Accept': 'application/json',
                                    'Authorization': `Bearer ${token}`,
                                },
                                success: function(response){
                                    message.classList= [];
                                    message.classList.add('success');
                                    success.classList.add('active');
                                    successMsg.innerText= response.message;
                                },
                                error: function(erreurs){
                                    message.classList= [];
                                    message.classList.add('error');
                                    error.classList.add('active');
                                    errorMsg.innerText= erreurs.message;
                                }
                            });
                        }
                        
                        // Show the relative formation from the feeds 
                        btnSavoirPlus.addEventListener('click', (e)=>{
                            e.preventDefault();
                            // console.log(feed.id);
                            $.ajax({
                                url: apiUrl +'formations/'+ feed.id,
                                type: 'GET',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'Accept': 'application/json',
                                    'Authorization': `Bearer ${token}`,
                                },
                                success: function(response){

                                    $.ajax({
                                        url: apiUrl + `formations/${response.formation.id}/videos`,
                                        type: 'GET',
                                        headers:{
                                            'Content-Type': 'application/json',
                                            'Accept': 'application/json',
                                            'Authorization': `Bearer ${token}`,
                                        },
                                        success: function(lessons){
                                            console.log('formation-lessons', lessons);
                                            const contentItem= document.querySelector('#cour-details .cour-body .content-items');
                                            lessons.forEach(lesson => {
                                                const module = document.querySelector('#cour-details .cour-body .content-items .item').cloneNode(true);
                                                module.querySelector('.module-name').innerText= lesson.titre;
                                                contentItem.appendChild(module);
                                            });

                                        },
                                        error: function(erreurs){
                                            console.log('formation-lessons-erreurs', erreurs);
                                        }

                                    });
                                    // console.log('formation-detail:', response.formation);
                                    courDetailsPage.classList.add('active');
                                    // console.log('courDetailPage:', courDetailsPage.querySelector('.cour-detail-body'));
                                    const block1 = courDetailsPage.querySelector('.cour-detail-body .container-right .cdtls-block1');
                                    const block2 = courDetailsPage.querySelector('.cour-detail-body .container-right .cdtls-block2');
                                    // console.log('block2:',block2);
                                    // Image de couverture
                                        block1.querySelector('img').src = apiStorage + response.formation.image_couverture;

                                        // Catégorie + titre
                                        block2.querySelector('.cour-intro .cour-cat').innerText = 'Catégorie: ' + response.formation.categorie.nom;
                                        block2.querySelector('.cour-intro h3').innerText = response.formation.titre;

                                        // Infos formateur
                                        block2.querySelector('.cour-intro .cour-formateur .formateur-info img')
                                            .src = response.formation.formateur.avatar_url ? apiStorage + response.formation.formateur.avatar_url : "data:image/jpeg;base64,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";
                                        block2.querySelector('.cour-intro .cour-formateur .formateur-info h4')
                                            .innerText = response.formation.formateur.name;
                                        block2.querySelector('.cour-intro .cour-formateur .formateur-info span')
                                            .innerText = response.formation.formateur.role;

                                        // A propos
                                        courDetailsPage.querySelector('.a-propos p').innerText = response.formation.description;

                                        // Stats
                                        const btns = courDetailsPage.querySelector('.btns');
                                        btns.querySelector('.btn-nbre-inscript .nbre-inscript').innerText = response.formation.duree_estimee;
                                        btns.querySelector('.btn-duree .duree').innerText = response.formation.inscriptions.length;
                                },
                                error: function(erreurs){
                                    console.log('formations-details-err:', erreurs);
                                },
                            });
                        });
                    });
                },
                error: function(erreurs){
                    console.log('Feed-videos-errors:', erreurs);
                },
            });

            

            /* =============== Load Feed Videos for Suggestions ============== */

            function loadSuggestionsVideos() {
                $.ajax({
                    url: apiUrl + 'feed-videos',
                    type: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'Authorization': `Bearer ${token}`,
                    },
                    success: function(response) {
                        console.log('Suggestions Feed-videos:', response);
                        const suggestionsContainer = document.querySelector('#suggestions');
                        
                        // Clear existing videos
                        suggestionsContainer.innerHTML = '';
                        
                        // Take first 6 videos for suggestions to fit your 40% width style
                        const suggestedVideos = response.data.slice(0, 6);
                        
                        suggestedVideos.forEach(feed => {
                            const videoElement = document.createElement('div');
                            videoElement.className = 'video';
                            videoElement.innerHTML = `
                                <video poster="${feed.miniature ? apiStorage + feed.miniature : 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSjKpLDQpOaFi-qf8UyakjjLvBbUlKm4fvw4g&s'}" preload="auto" muted>
                                    <source src="${apiStorage + feed.url_video}" type="video/mp4">
                                </video>
                                <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-play-fill" viewBox="0 0 16 16">
                                    <path d="m11.596 8.697-6.363 3.692c-.54.313-1.233-.066-1.233-.697V4.308c0-.63.692-1.01 1.233-.696l6.363 3.692a.802.802 0 0 1 0 1.393"/>
                                </svg>
                            `;
                            
                            const video = videoElement.querySelector('video');
                            const playIcon = videoElement.querySelector('svg');
                            
                            // Add click event to play/pause video with animation
                            video.addEventListener('click', (e) => {
                                e.stopPropagation(); // Empêcher le clic de déclencher l'ajout au contenu principal
                                
                                if (video.paused) {
                                    // Arrêter toutes les autres vidéos suggestions
                                    stopAllSuggestionVideos();
                                    
                                    video.play();
                                    videoElement.classList.add('playing');
                                } else {
                                    video.pause();
                                    videoElement.classList.remove('playing');
                                }
                            });

                            // Add click event on SVG to play video
                            playIcon.addEventListener('click', (e) => {
                                e.stopPropagation();
                                
                                // Arrêter toutes les autres vidéos suggestions
                                stopAllSuggestionVideos();
                                
                                video.play();
                                videoElement.classList.add('playing');
                            });

                            // Event listener pour la fin de vidéo
                            video.addEventListener('ended', () => {
                                videoElement.classList.remove('playing');
                                video.currentTime = 0;
                            });

                            // Double-click pour ajouter au contenu principal
                            videoElement.addEventListener('dblclick', () => {
                                addVideoToMainContent(feed);
                            });
                            
                            suggestionsContainer.appendChild(videoElement);
                        });

                        // Fonction pour arrêter toutes les vidéos suggestions
                        function stopAllSuggestionVideos() {
                            suggestionsContainer.querySelectorAll('.video').forEach(videoItem => {
                                const video = videoItem.querySelector('video');
                                if (!video.paused) {
                                    video.pause();
                                    video.currentTime = 0;
                                    videoItem.classList.remove('playing');
                                }
                            });
                        }
                    },
                    error: function(erreurs) {
                        console.log('Suggestions Feed-videos-errors:', erreurs);
                    },
                });
            }

            function addVideoToMainContent(feed) {
                const mainContent = document.querySelector('#content');
                const contentItem = document.querySelector('#content .content-item');
                
                // Create new content item based on the template
                const newContent = contentItem.cloneNode(true);
                
                // Set video source and poster
                const video = newContent.querySelector('video');
                const videoSource = newContent.querySelector('video source');
                video.poster = feed.miniature ? apiStorage + feed.miniature : "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSjKpLDQpOaFi-qf8UyakjjLvBbUlKm4fvw4g&s";
                videoSource.src = apiStorage + feed.url_video;
                
                // Set description
                newContent.querySelector('.text .legend').innerText = feed.description || 'Vidéo suggestion';
                
                // Set user info
                const contentUser = newContent.querySelector('.text .user');
                const userImg = contentUser.querySelector('img');
                const userName = contentUser.querySelector('.info h3');
                
                userImg.src = feed.user && feed.user.avatar_url ? 
                    apiStorage + feed.user.avatar_url : 
                    "data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wCEAAkGBw0NDQ4NDQ0NDQ4NDQ0NEA0ODQ8ODhANFxEWFhURFRUYHSoiGholGxUTITUhJSkuLi46Fx8zODMsNzQvOi0BCgoKDQ0NDw8PECsZHxkrKysrKysrKysrKysrKysrKysrKysrKysrKysrKysrKysrKysrKysrKysrKysrKysrK//AABEIAOEA4QMBIgACEQEDEQH/xAAcAAEAAwADAQEAAAAAAAAAAAAAAQIDEAEFBgcICRD/2wCEAAkGBw0NDQ4NDQ0NDQ4NDQ0NEA0ODQ8ODhANFxEWFhURFRUYHSoiGholGxUTITUhJSkuLi46Fx8zODMsNzQvOi0BCgoKDQ0NDw8PECsZHxkrKysrKysrKysrKysrKysrKysrKysrKysrKysrKysrKysrKysrKysrKysrKysrKysrK//AABEIAOEA4QMBIgACEQEDEQH/";
                
                userName.innerText = feed.user && feed.user.name ? feed.user.name : 'Utilisateur';
                
                // Reset video to start from beginning
                video.currentTime = 0;
                video.load();
                
                // Insert at the beginning of main content (after the first template item)
                const firstRealContent = mainContent.children[1] || mainContent.firstChild;
                mainContent.insertBefore(newContent, firstRealContent);
                
                // Scroll to the new video
                newContent.scrollIntoView({ behavior: 'smooth', block: 'center' });
                
                // Auto play the video after a short delay
                setTimeout(() => {
                    video.play().catch(e => console.log('Auto-play prevented:', e));
                }, 500);
            }

            // Load suggestions videos on page load
            loadSuggestionsVideos();

            // Button to close the messages

            btnCloseMsg.forEach(btn =>{
                btn.addEventListener('click', (e)=>{
                    e.preventDefault();
                    e.currentTarget.parentNode.classList.remove('active');
                    e.currentTarget.parentNode.parentNode.classList= [];
                });
            });

            document.querySelectorAll('#content .content-item video').forEach(video=>{
                video.addEventListener('click', (e)=>{
                    e.preventDefault();
                    if(e.currentTarget.paused){
                        e.currentTarget.play();
                        // console.log('video-clické');
                        e.currentTarget.nextElementSibling.classList.add('active');
                        e.currentTarget.muted = false;
                    }else{
                        console.log(e.currentTarget.nextElementSibling)
                        e.currentTarget.nextElementSibling.classList.remove('active');
                        e.currentTarget.pause();
                        // console.log('video-pause');
                    }
                    
                });

            });
            
            // Ajouter un module a une formation

            // addModuleForm.addEventListener('submit', (e) => {
            //     e.preventDefault();
            //     const donnee = new FormData(e.target);
            //     overlay.classList = [];
            //     overlay.classList.add('load');
            //     loader.classList.add('active');
            //     const id= document.querySelector('#user-formations').value;
            //     donnee.append('id', id);

            //     $.ajax({
            //         url: apiUrl+ `formations/${id}/videos`,
            //         type: 'POST',
            //         data: donnee,
            //         contentType: false,
            //         processData: false,
            //         headers: {
            //             'Accept': 'application/json',
            //             'Authorization': `Bearer ${token}`,
            //          },
            //         success: function(response) {
            //             // console.log(response);
            //             overlay.classList = [];
            //             loader.classList = [];     
            //             message.classList.add('success');
            //             successMsg.innerText= `${response.success}`;
            //             success.classList.add('active');
                        
            //         },
            //         error: function(erreurs) {
            //             // console.log(erreurs);
            //             loader.classList = [];
            //             overlay.classList = [];
            //             message.classList= [];
            //             message.classList.add('error');
            //             errorMsg.innerText= `${erreurs.responseJSON.message}`;
            //             error.classList.add('active');
            //         },
            //     });
            // });


            // btnAddForma.addEventListener('click', (e)=>{
            //     e.preventDefault();
            //     overlay.classList= [];
            //     // console.log(overlay.classList)
            //     overlay.classList.add('add-forma');
            //     addForma.classList.add('active');
            //     // console.log(addForma)
            // });

            // btnAddModule.addEventListener('click', (e) => {
            //     e.preventDefault();

            //     let length = document.querySelectorAll('#ajout-formation form .ctn-input-video').length + 1;

            //     let div = document.createElement('div');
            //     div.classList.add('ctn-input-video');

            //     let textInput = document.createElement('input');
            //     textInput.type = 'text';
            //     textInput.required = true;
            //     textInput.placeholder = `Nom du module`;
            //     textInput.name = `module-name-${length}`;
            //     textInput.classList.add(`module-name-${length}`);

            //     let input = document.createElement('input');
            //     input.type = 'file';
            //     input.name = `module-file-${length}`;

            //     let button = document.createElement('button');
            //     button.classList.add('btn-add-module-vid');
            //     button.innerHTML = `
            //         <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960">
            //                 <path d="M360-320h80v-120h120v-80H440v-120h-80v120H240v80h120v120ZM160-160q-33 0-56.5-23.5T80-240v-480q0-33 23.5-56.5T160-800h480q33 0 56.5 23.5T720-720v180l160-160v440L720-420v180q0 33-23.5 56.5T640-160H160Zm0-80h480v-480H160v480Zm0 0v-480 480Z"/>
            //         </svg>
            //     `;
                
            //     button.addEventListener('click', (e) => {
            //         e.preventDefault();
            //         input.click();
            //     });

            //     div.appendChild(textInput);
            //     div.appendChild(input);
            //     div.appendChild(button);

            //     addModuleForm.insertBefore(div, document.querySelector('#add-modules button[type="submit"]'));
            // });




            // Add introduction video to the formation

            // addVideoIntro.addEventListener('click', (e)=> {
            //     e.preventDefault();
            //     videoIntro.click();
            // });


            

            // Redirection when a list-element's clicked

            courListItems.forEach(item =>{
                item.addEventListener('click', (e)=>{
                    e.preventDefault();
                    const row = e.currentTarget.querySelectorAll('td');
                    
                    $.ajax({
                        url: "{{ url('sendSingleFormation') }}/" + row[0].innerText,
                        type: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': " {{ csrf_token() }} "
                        },
                        
                        success: function(response){
                            // console.log(response);
                            window.location.href = "{{ url('sendSingleFormation') }}/" + row[0].innerText;
                        },
                        
                        error: function(erreurs){
                            console.log(erreurs);
                        }
                    });


                });
            });

            // Swith from de apprenant account to a formateur one

            btnCtnSwitchAcc.addEventListener('click', (e)=>{
                e.preventDefault();
                switchAcc.classList= [];
                confSwitchAcc.classList.add('active');
            });


            // Change user informations

            formInfoPerso.addEventListener('submit', (e)=>{
                e.preventDefault();
                overlay.classList.add('change-info');
                params.classList.remove('active');
                changeUserInfo.classList.add('active');

            });
            

            btnChangeUserInfo.addEventListener('click', (e)=>{
                e.preventDefault();
                const email = document.querySelector('#email').value;
                const password = document.querySelector('#password').value;
                const username = document.querySelector('#username').value;
                const passwordActuel = document.querySelector('#actual-password').value;
                if(overlay.classList.contains('active')) overlay.classList.remove('active');
                if(overlay.classList.contains('change-info')) overlay.classList.remove('change-info');
                if(overlay.classList.contains('del-acc')) overlay.classList.remove('del-acc');
                overlay.classList.add('load');
                loader.classList.add('active')
                // console.log(email.length);

                $.ajax({
                    url: 'change-user-info',
                    type: 'PUT',
                    headers: {
                        'Content-Type' : 'application/json',
                        'X-CSRF-TOKEN' : " {{ csrf_token() }} "
                    },
                    processData: false,
                    data: JSON.stringify({
                        email: email.length > 8 ? email : '',
                        name : username.length > 2 ? username : '',
                        newPassword: password.length > 8 ? password : '',
                        oldPass : passwordActuel ? passwordActuel : '', 
                    }),

                    success: function (response){
                        if(overlay.classList.contains('load')) overlay.classList.remove('load');
                        // console.log(response)
                    },
                    error: function(erreurs){
                        if(overlay.classList.contains('load')) overlay.classList.remove('load');
                        // console.log(erreurs)
                    }

                });
            });


            userPassword.addEventListener('input', (e)=>{
                e.preventDefault();
                const labelPassword = document.querySelector('#params .btns .info-perso form .label-password');
                // console.log(labelPassword.innerText);

                if(e.currentTarget.value.length < 8){
                    e.currentTarget.parentNode.style.cssText += `border: 2px solid red; transition: border .5s ease-in;`;
                    labelPassword.innerText = '8 caractères minimum pour le mot de passe';
                    labelPassword.style.cssText = `color: red; transition: color .5s ease;`;
                }else{
                    e.currentTarget.parentNode.style.cssText += ` border: 2px solid green; transition: border .5s ease-in; `;
                    labelPassword.innerText = 'Mot de passe correct';
                    labelPassword.style.cssText= `color: green; transition: transform .5s ease;`;
                }
            });

            userEmail.addEventListener('input', (e)=>{
                e.preventDefault();
                const labelEmail = document.querySelector('#params .btns .info-perso form .label-email');
                // console.log(labelEmail.innerText);
                if(e.currentTarget.value.length < 8){
                    e.currentTarget.parentNode.style.cssText += `border: 2px solid red; transition: border .5s ease-in;`;
                    labelEmail.innerText = '8 caractères minimum pour le mail';
                    labelEmail.style.cssText = `color: red; transition: color .5s ease;`;
                }else{
                    e.currentTarget.parentNode.style.cssText += `border: 2px solid green; transition: border .5s ease-in;`;
                    labelEmail.innerText = 'Email';
                    labelEmail.style.cssText= `color: green; transition: transform .5s ease;`;
                }
            });

            userName.addEventListener('input', (e)=>{
                e.preventDefault();
                const labelUsername = document.querySelector('#params .btns .info-perso form .label-username');
                // console.log(labelUsername.innerText);
                if(e.currentTarget.value.length < 2){
                    e.currentTarget.parentNode.style.cssText += `border: 2px solid red; transition: border .5s ease-in;`;
                    labelUsername.innerText = '2 caractères minimum pour le Nom d\'utilisateur';
                    labelUsername.style.cssText = `color: red; transition: color .5s ease;`;
                }else{
                    e.currentTarget.parentNode.style.cssText += `border: 2px solid green; transition: border .5s ease-in;`;
                    labelUsername.innerText = 'Nom et Prénom';
                    labelUsername.style.cssText= `color: green; transition: transform .5s ease;`;
                }
            });
            

            btnOverlayRetour.addEventListener('click', (e) =>{
                overlay.classList = [];

                if(changeUserInfo.classList.contains('active')) changeUserInfo.classList.remove('active');
                if(addForma.classList.contains('active')) addForma.classList.remove('active');
                if(confSwitchAcc.classList.contains('active')){
                    confSwitchAcc.classList= [];
                    switchAcc.classList.add('active');
                    return;
                }
            });

            // ================= Profile ===============

            document.querySelector('#profile-pic').addEventListener('change', (e)=>{
                    // e.preventDefault();
                    // console.log(e.currentTarget.files[0]);
                    const profileData= new FormData();
                    profileData.append('avatar', e.currentTarget.files[0]);
                    console.log()

                    $.ajax({
                        url: apiUrl + `profile`,
                        type: 'POST',
                        processData: false,
                        contentType: false,
                        headers: {
                            // 'Content-Type': 'application/json',
                            // 'Accept': 'application/json',
                            'Authorization': `Bearer ${token}`,
                        },
                        data: profileData,
                        success: function(response){
                            console.log('change-profile-response:', response);
                            // message.classList= [];
                            // success.classList= [];
                            message.classList.add('success');
                            successMsg.innerText= response.message;
                            success.classList.add('active');
                            // window.location.reload();
                        },
                        error: function(erreurs){
                            console.log('change-profile-errors:', erreurs);
                        }
                    });
                });

                document.querySelector('#profile .user .user-info img').addEventListener('click', (e)=>{
                    e.preventDefault()
                    document.querySelector('#profile-pic').click();
                    // console.log('profile-pic:', document.querySelector('#profile-pic'));
                });

                document.querySelector('.change-profile').addEventListener('click', (e)=>{
                    e.preventDefault();
                    document.querySelector('#profile-pic').click();
                });

                document.querySelector('#cover-pic').onchange= (e)=> {

                    const coverData= new FormData();
                    coverData.append('cover', e.currentTarget.files[0]);
                    $.ajax({
                        url: apiUrl + `profile`,
                        type: 'POST',
                        processData: false,
                        contentType: false,
                        headers: {
                            // 'Content-Type': 'application/json',
                            // 'Accept': 'application/json',
                            'Authorization': `Bearer ${token}`,
                        },
                        data: coverData,
                        success: function(response){
                            console.log('change-profile-response:', response);
                            // message.classList= [];
                            // success.classList= [];
                            message.classList.add('success');
                            successMsg.innerText= response.message;
                            success.classList.add('active');
                            // window.location.reload();
                        },
                        error: function(erreurs){
                            console.log('change-profile-errors:', erreurs);
                        }
                    });

                }

            
            /*=================== Éléments de la messagerie ================*/

            let messagerieInitialized = false;
            let contactItems;
            let messageInput;
            let sendButton;

            btnFormaGrid.addEventListener('click', (e)=>{
                e.preventDefault();
                btnFormaGrid.classList.add('active');
                btnFormaList.classList.remove('active');
                if(courGrid.classList.contains('active')) return;
                if(courList.classList.contains('active')) courList.classList.remove('active');
                courGrid.classList.add('active');
            });


            btnFormaList.addEventListener('click', (e)=>{
                e.preventDefault();
                btnFormaList.classList.add('active');
                btnFormaGrid.classList.remove('active');
                // console.log(courGrid.classList.contains('active'));
                if(courList.classList.contains('active')) return;
                if(courGrid.classList.contains('active')) courGrid.classList.remove('active');
                courList.classList.add('active');
            });

            btnRetourSellCour.addEventListener('click', (e)=> {
                e.preventDefault();
                if(sellCourStep2.classList.contains('active')){
                    sellCourStep2.classList.remove('active');
                    sellCourStep1.classList.add('active');
                }else{
                    e.currentTarget.parentNode.parentNode.classList.remove('active');
                }
                
            });


            /*============================ Pay a cour ====================*/

            pay.addEventListener('click', (e) => {
                e.preventDefault();

                const token = " {{ csrf_token() }} ";
                const data = new FormData(mobPay);
                const number = data.get('indicatif') + data.get('mobile-num');
                const code = data.get('code0') + data.get('code1') + data.get('code2') + data.get('code3');

                $.ajax({
                    type: 'POST',
                    url: '/pay-cour',
                    headers: {
                        'X-CSRF-TOKEN': token,
                        'Content-Type': 'application/json',
                    },
                    data: JSON.stringify({
                        number: number,
                        code: code,
                    }),

                    success: function(response){
                        sellCourStep1.classList.remove('active')
                        sellCourStep2.classList.add('active');
                        // console.log(response);
                    },

                    error: function(error){
                        console.log('error');
                    }
                });
            });

            
            //Buttons to swith between mobile payment or card payment

            btnCardPay.addEventListener('click', (e) =>{
                e.preventDefault();
                e.currentTarget.style.cssText += 'color: orange; border:2px solid orange; transition: color .5s ease;';
                btnMobilePay.style.cssText += 'color: white; border:none; transition: all .5s ease-out;';
                if(mobPay.classList.contains('active')) mobPay.classList.remove('active');
                if(paymentMethods.classList.contains('mobile')) paymentMethods.classList.remove('mobile');
                if(cardPay.classList.contains('active')){
                    cardPay.classList.remove('active');
                    if(mobPay.classList.contains('active')) mobPay.classList.remove('active');
                    paymentMethods.classList.add('card');

                }else{
                    paymentMethods.classList.remove('card');
                    cardPay.classList.add('active');
                };

            });

            btnMobilePay.addEventListener('click', (e) => {
                e.preventDefault();
                e.currentTarget.style.cssText += 'color: orange; border:2px solid orange; transition: color .5s ease;';
                btnCardPay.style.cssText += 'color: white; border:none; transition: all .5s ease-out;';
                if(!cardPay.classList.contains('active')) cardPay.classList.add('active');
                if(paymentMethods.classList.contains('card')) paymentMethods.classList.remove('card');
                if(mobPay.classList.contains('active')){
                    paymentMethods.classList.remove('mobile');
                    mobPay.classList.remove('active');
                }else{
                    paymentMethods.classList.add('mobile');
                    if(!cardPay.classList.contains('active')) cardPay.classList.add('active');
                    mobPay.classList.add('active');
                }
            });

            // Buying a cour process

            btnBuyCour.addEventListener('click', (e)=>{
                sellCourOverlay.classList.add('active');
            });

            // Cour detail backward
            courDetailBtnBack.addEventListener('click', (e)=>{
                e.preventDefault();
                courDetailsPage.classList.remove('active');
            });
            // Appear the cour details

            allCours.forEach((cour) => {
                cour.addEventListener('click', (e)=>{
                    e.preventDefault();
                    // console.log(e.currentTarget.querySelector('h4'));
                    // courDetailsPage.classList.add('active');
                });
            });
               
            // Request to delete an account

            btnContinuDelAcc.addEventListener('click', (e)=>{
                // console.log(delAccMsg);
                params.classList.remove('active');
                delReasons.classList.remove('active');
                overlay.classList.remove('active');
                overlay.classList.add('del-acc');
                delAccMsg.classList.add('active');
                
            });

            
            // Back on the parameters from delete account interface

            btnCancelDel.addEventListener('click', (e)=>{
                e.preventDefault();
                delReasons.classList.remove('active');
                paramHead.classList.remove('active');
            });
             
            btnDelAccReturn.addEventListener('click', (e)=>{
                e.preventDefault();
                delReasons.classList.remove('active');
                paramHead.classList.remove('active');

            });

            // Confirmation of the deletion of the account

                btnConfirmDelAcc.addEventListener('click', (e)=>{

                    e.preventDefault();
                    overlay.classList.add('load');
                    loader.classList.add('active');
                    const reasons= document.querySelector('#reasons')?.value;
                    const pwd = document.querySelector('#del-password')?.value;
                    message.classList= [];
                    
                    $.ajax({
                        type: 'DELETE',
                        url: apiUrl+'user/delete-account',
                        timeout: 10000,
                        headers:{
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'Authorization': `Bearer ${token}`,
                        },
                        data: JSON.stringify({
                            deletion_reason: reasons ? reasons : 'Je n\'utilise plus le compte',
                            confirmation: true,
                            password: pwd,
                        }),
                        success: function(response){
                            // console.log(response);
                            loader.classList= [];
                            overlay.classList= [];
                            message.classList.add('success');
                            success.classList.add('active');
                            successMsg.innerText = '';
                            window.location.href= "http://localhost:8000/login";

                        },
                        error: function(erreurs){
                            // console.log(erreurs);
                            loader.classList= [];
                            overlay.classList= [];
                            message.classList.add('error');
                            error.classList.add('active');
                            errorMsg.innerText= `${erreurs.responseJSON.message}`;
                        },
                    });
                });
                      
            // Initiate the account deletion process 
                btnDelAcc.addEventListener('click', (e)=>{
                    e.preventDefault();
                    if(!delReasons.classList.contains('active')){
                        
                        delReasons.classList.add('active');
                        paramHead.classList.add('active');

                    }else{
                        return
                    }

                });
                

            // Action executed when the user want to swicth the type of account

            btnDevForma.addEventListener('click', (e)=>{
                e.preventDefault();
                params.classList.remove('active');
                overlay.classList.remove('active');
                overlay.classList.add('del-acc');
                switchAcc.classList.add('active');
            });

            btnSwitchAcc.addEventListener('click', (e)=>{
                e.preventDefault();
                $.ajax({
                    type: 'GET',
                    url: apiUrl+ 'user/change-to-formateur',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'Authorization': `Bearer ${token}`,
                    },
                    success: function(response){
                        console.log(response)
                    },
                    error: function(erreurs){
                        // console.log(erreurs);
                        // console.log('erreurs', erreurs.responseJSON.message);
                        erreurs = erreurs.responseJSON.message
                        message.classList.add('error');
                        error.classList.add('active');
                        errorMsg.innerText= `${erreurs}`;
                        switchAcc.classList= [];
                        overlay.classList= [];
                        confSwitchAcc.classList= [];
                    },
                });
            });

            btnCancelSwitchAcc.addEventListener('click', (e)=>{
                e.preventDefault();
                switchAcc.classList= [];
                overlay.classList= [];
                confSwitchAcc.classList= [];
            });
            
            // Show the personnaly information in the parameters

            btnInfoPerso.addEventListener('click', (e)=>{
                e.preventDefault();
                if(infoPerso.classList.contains('active')){
                    infoPerso.classList.remove('active');
                }else{
                    infoPerso.classList.add('active');
                }
            })

            // Animation on les active cour element

            coursLi.forEach((courLi) =>{
                courLi.addEventListener('click', (e)=>{
                    e.preventDefault();
                    const active = document.querySelector('#cours ul li.active');
                    if(active) active.classList.remove('active');
                    if(e.currentTarget.classList.contains('active')) return;
                    e.currentTarget.classList.add('active');
                });
            });

            main.style.cssText += 'display:flex; width:100%; height:100%;';

            // Appear the params & close params

            btnParam.addEventListener('click', (e)=>{
                e.preventDefault();
                delAccMsg.classList= [];
                loader.classList= [];
                if(switchAcc.classList.contains('active')) switchAcc.classList.remove('active');
                if(! overlay.classList.contains('active')) overlay.classList.add('active');
                if(! params.classList.contains('active')) params.classList.add('active');
            });

            closeParam.addEventListener('click', (e)=>{
                params.classList.remove('active');
                overlay.classList.remove('active');
            });

            // Change the profile and cover picture

            btnChangeCover.addEventListener('click', (e)=> {
                e.preventDefault();
                coverPic.click();
            });

            // btnChangeCover.addEventListener('click', (e)=> {
            //     e.preventDefault();
            //     coverPic.click();
            // });

            // Appear the Ajout formation page

            // addFormLink.addEventListener('click', (e)=>{
            //     e.preventDefault();
                
            //     if(addFormPage.classList.contains('active')) return;
            //     if(pourToi.classList.contains('active')) pourToi.classList.remove('active');
            //     if(profileLink.classList.contains('active')) profileLink.classList.remove('active');
            //     if(profilePage.classList.contains('active')) profilePage.classList.remove('active');
            //     if(messagerieLink.classList.contains('active')) messagerieLink.classList.remove('active');
            //     if(messagerie.classList.contains('active')) messagerie.classList.remove('active');
            //     if(formaSuivieLink.classList.contains('active')) formaSuivieLink.classList.remove('active');
            //     if(formaSuivie.classList.contains('active')) formaSuivie.classList.remove('active');
            //     if(coursEnVenteLink.classList.contains('active')) coursEnVenteLink.classList.remove('active');
            //     if(coursEnVente.classList.contains('active')) coursEnVente.classList.remove('active');
            //     if(retraitLink.classList.contains('active')) retraitLink.classList.remove('active');
            //     if(retrait.classList.contains('active')) retrait.classList.remove('active');
            //     if(document.querySelector('#formateur-profile').classList.contains('active')) document.querySelector('#formateur-profile').classList.remove('active');
            //     addFormPage.classList.add('active');
            // });

            // Appear the home page

            pourToi.addEventListener('click', (e)=>{
                e.preventDefault();
                if(document.querySelector('#formateur-profile').classList.contains('active')) document.querySelector('#formateur-profile').classList.remove('active');
                if(pourToi.classList.contains('active')) return;
                // if(addFormPage.classList.contains('active')) addFormPage.classList.remove('active');
                // if(addFormLink.classList.contains('active')) addFormLink.classList.remove('active');
                if(profileLink.classList.contains('active')) profileLink.classList.remove('active');
                if(profilePage.classList.contains('active')) profilePage.classList.remove('active');
                if(messagerieLink.classList.contains('active')) messagerieLink.classList.remove('active');
                if(messagerie.classList.contains('active')) messagerie.classList.remove('active');
                if(formaSuivieLink.classList.contains('active')) formaSuivieLink.classList.remove('active');
                if(formaSuivie.classList.contains('active')) formaSuivie.classList.remove('active');
                if(coursEnVenteLink.classList.contains('active')) coursEnVenteLink.classList.remove('active');
                if(coursEnVente.classList.contains('active')) coursEnVente.classList.remove('active');
                if(retraitLink.classList.contains('active')) retraitLink.classList.remove('active');
                if(retrait.classList.contains('active')) retrait.classList.remove('active');
                
                pourToi.classList.add('active');
            });

            // Make the profile page appear

            profileLink.addEventListener('click', (e)=>{
                e.preventDefault();
                $.ajax({
                    url: apiUrl+'profile',
                    type: 'GET',
                    headers: {
                        'Content-Type': 'accept/json',
                        'Accept': 'accept/json',
                        'Authorization': `Bearer ${token}`,
                    },
                    success: function(response){
                        console.log('profile', response);
                        // user = response.user
                        console.log('user', user);
                        // console.log('image:' , document.querySelector('#profile .user-info img').src= );

                        document.querySelector('#profile .user .cover img').src= user.cover ? apiStorage + user.cover_url : "https://images.pexels.com/photos/956999/milky-way-starry-sky-night-sky-star-956999.jpeg";
                        document.querySelector('#profile .user-info img').src= user.avatar_url ? apiStorage + user.avatar_url : "data:image/jpeg;base64,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";
                        document.querySelector('#profile .user .user-profile .user-info .followers').innerText= response.stats.followers_count;
                        document.querySelector('#profile .user .user-profile .user-info .following').innerText= response.stats.followings_count;
                        document.querySelector('#profile .user .user-profile .user-info .profession').innerText= '  Développeur';
                        const max = response.profile_completion;
                        let point = 0;
                        // before.content= max;
                        percentage.querySelector('.percent-jauge').style.transition = "background .5s ease";
                        const animInt = setInterval(() => {
                            if (point <= max) {
                                percentage.querySelector('.percent-jauge').style.background = `
                                    conic-gradient(#5ede50ff ${point}%, gray ${point}%)
                                `;
                                percentage.querySelector('.over-jauge').innerText = `${point}%`;
                                point++;
                            } else {
                                clearInterval(animInt);
                            }
                        }, 20);

                    },
                    error: function(erreurs){
                        console.log('profile-erreurs:', erreurs)
                    }

                });

                // if(addFormPage.classList.contains('active')) addFormPage.classList.remove('active');
                if(profilePage.classList.contains('active')) return;
                if(formaSuivieLink.classList.contains('active')) formaSuivieLink.classList.remove('active');
                if(formaSuivie.classList.contains('active')) formaSuivie.classList.remove('active');
                if(messagerieLink.classList.contains('active')) messagerieLink.classList.remove('active');
                if(retrait.classList.contains('actuve')) retrait.classList.remove('active');
                if(retraitLink.classList.contains('active')) retraitLink.classList.remove('active');
                if(messagerie.classList.contains('active')) messagerie.classList.remove('active');
                if(document.querySelector('#formateur-profile').classList.contains('active')) document.querySelector('#formateur-profile').classList.remove('active');
                profilePage.classList.add('active');
                
            });

            // Show the cours en vente page
            coursEnVenteLink.addEventListener('click', (e)=>{
                e.preventDefault();
                console.log('Cours en vente clicked!');
                
                if(coursEnVente.classList.contains('active')) return;
                
                // Hide all other sections and navigation links
                // if(addFormPage.classList.contains('active')) addFormPage.classList.remove('active');
                // if(addFormLink.classList.contains('active')) addFormLink.classList.remove('active');
                if(pourToi.classList.contains('active')) pourToi.classList.remove('active');
                if(profilePage.classList.contains('active')) profilePage.classList.remove('active');
                if(profileLink.classList.contains('active')) profileLink.classList.remove('active');
                if(messagerieLink.classList.contains('active')) messagerieLink.classList.remove('active');
                if(messagerie.classList.contains('active')) messagerie.classList.remove('active');
                if(retraitLink.classList.contains('active')) retraitLink.classList.remove('active');
                if(formaSuivieLink.classList.contains('active')) formaSuivieLink.classList.remove('active');
                if(formaSuivie.classList.contains('active')) formaSuivie.classList.remove('active');
                if(retrait.classList.contains('active')) retrait.classList.remove('active');
                if(document.querySelector('#formateur-profile').classList.contains('active')) document.querySelector('#formateur-profile').classList.remove('active');
                
                // Show cours en vente section
                console.log('Adding active class to coursEnVente');
                coursEnVente.classList.add('active');
                console.log('coursEnVente classes:', coursEnVente.className);
                
                // Load formations data
                loadCoursEnVenteData();
            });

            // Function to load cours en vente data
            function loadCoursEnVenteData() {
                $.ajax({
                    url: apiUrl + 'my-formations',
                    type: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer ${token}`,
                    },
                    success: function(response) {
                        console.log('My formations:', response);
                        
                        // Update statistics
                        const formationsPubliees = response.filter(f => f.statut === 'publie').length;
                        const formationsBrouillons = response.filter(f => f.statut === 'brouillon').length;
                        const categories = [...new Set(response.map(f => f.categorie.nom))].length;
                        
                        document.getElementById('formations-publiees').textContent = formationsPubliees;
                        document.getElementById('formations-brouillons').textContent = formationsBrouillons;
                        document.getElementById('types-categories').textContent = categories;
                        document.getElementById('nombre-apprenants').textContent = '100'; // Placeholder
                        
                        // Render formations grid
                        renderFormationsGrid(response);
                    },
                    error: function(erreurs) {
                        console.log('Cours en vente error:', erreurs);
                    }
                });
            }

            // Function to render formations grid
            function renderFormationsGrid(formations) {
                const grid = document.getElementById('formations-grid');
                grid.innerHTML = '';
                
                formations.forEach(formation => {
                    const formationCard = document.createElement('div');
                    formationCard.className = 'formation-card';
                    formationCard.innerHTML = `
                        <div class="formation-thumbnail">
                            <video poster="${formation.image_couverture ? apiStorage + formation.image_couverture : 'https://via.placeholder.com/300x200'}" preload="none">
                                <source src="${formation.video_preview ? apiStorage + formation.video_preview : '#'}" type="video/mp4">
                            </video>
                            <div class="play-overlay">
                                <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-play-fill" viewBox="0 0 16 16">
                                    <path d="m11.596 8.697-6.363 3.692c-.54.313-1.233-.066-1.233-.697V4.308c0-.63.692-1.01 1.233-.696l6.363 3.692a.802.802 0 0 1 0 1.393"/>
                                </svg>
                            </div>
                        </div>
                        <div class="formation-info">
                            <div class="categorie-price">
                                <div class="formation-category"> <div class="categorie">CATEGORIE: </div> ${formation.categorie.nom}</div>
                                <div class="price ${ formation.prix== 0 ? 'gratuit' : 'payant'} "> ${ formation.prix== 0 ? 'GRATUIT' : formation.prix + ' cfa'} </div>
                            </div>
                            <h3 class="formation-title">${formation.titre}</h3>
                            <p class="formation-description">${formation.description || 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut et massa mi. Aliquam in hendrerit urna. Pellentesque sit amet sapien fringilla, mattis ligula consectetur, ultrices mauris.'}</p>
                            
                            <div class="formation-meta">

                                <div class="parties">
                                    <div class="title">Parties</div>
                                    <div class="number">${formation.parties?.length || 12}</div>
                                </div>

                                <div class="achats">
                                    <div class="title">Achats</div>
                                    <div class="number">${formation.achats?.length || 12}</div>
                                </div>

                                <div class="modules">
                                    <div class="title">Modules</div>
                                    <div class="number">${formation.modules?.length || 12}</div>
                                </div>

                                <div class="statut">
                                    <div class="title">Statut</div>
                                    <div class="number">${formation.statut}</div>
                                </div>

                            </div>  
                            <div class="formation-actions">
                                <button class="btn-consulter" onclick="window.location.href='/formation/${formation.id}'">Consulter</button>
                                <button class="btn-modifier" onclick="editFormation(${formation.id})">Modifier</button>
                            </div>
                        </div>
                    `;
                    
                    // Add video play functionality
                    const video = formationCard.querySelector('video');
                    const playOverlay = formationCard.querySelector('.play-overlay');
                    
                    playOverlay.addEventListener('click', () => {
                        if (video.paused) {
                            video.play();
                            playOverlay.style.opacity = '0';
                        } else {
                            video.pause();
                            playOverlay.style.opacity = '1';
                        }
                    });
                    
                    video.addEventListener('ended', () => {
                        playOverlay.style.opacity = '1';
                    });
                    
                    grid.appendChild(formationCard);
                });
            }

            // Function to edit formation
            function editFormation(formationId) {
                console.log('Edit formation:', formationId);
                // Redirect to edit formation page or open edit modal
                // Add edit functionality here
            }

            // Add event listeners for cours-en-vente buttons
            // $(document).on('click', '.btn-voir-brouillons', function() {
            //     // Filter and show only draft formations
            //     $.ajax({
            //         url: apiUrl + 'my-formations',
            //         type: 'GET',
            //         headers: {
            //             'Content-Type': 'application/json',
            //             'Authorization': `Bearer ${token}`,
            //         },
            //         success: function(response) {
            //             const brouillons = response.filter(f => f.statut === 'brouillon');
            //             renderFormationsGrid(brouillons);
                        
            //             // Update button text
            //             $('.btn-voir-brouillons').text('Voir toutes');
            //             $('.btn-voir-brouillons').removeClass('btn-voir-brouillons').addClass('btn-voir-toutes');
            //         }
            //     });
            // });

            $(document).on('click', '.btn-voir-toutes', function() {
                // Show all formations
                loadCoursEnVenteData();
                
                // Update button text
                $('.btn-voir-toutes').text('Voir brouillons');
                $('.btn-voir-toutes').removeClass('btn-voir-toutes').addClass('btn-voir-brouillons');
            });

            $(document).on('click', '.btn-creer-formation', function() {
                // // Trigger the add formation modal
                // if(addFormLink) {
                //     addFormLink.click();
                // }
                // console.log('Clické!')

                overlay.classList= [];
                overlay.classList.add('create-formation');
                console.log(document.querySelector('#create-formation').classList.add('active'));
                // $('#overlay').classList.add('create-formation');
                // $('#create-formation').classList.add('active');
            });

            // Show the retrait page
            retraitLink.addEventListener('click', (e)=>{
                e.preventDefault();
                console.log('Retrait clicked!');
                
                if(retrait.classList.contains('active')) return;
                
                // Hide all other sections and navigation links
                // if(addFormPage.classList.contains('active')) addFormPage.classList.remove('active');
                // if(addFormLink.classList.contains('active')) addFormLink.classList.remove('active');
                if(pourToi.classList.contains('active')) pourToi.classList.remove('active');
                if(profilePage.classList.contains('active')) profilePage.classList.remove('active');
                if(profileLink.classList.contains('active')) profileLink.classList.remove('active');
                if(messagerieLink.classList.contains('active')) messagerieLink.classList.remove('active');
                if(messagerie.classList.contains('active')) messagerie.classList.remove('active');
                if(formaSuivieLink.classList.contains('active')) formaSuivieLink.classList.remove('active');
                if(formaSuivie.classList.contains('active')) formaSuivie.classList.remove('active');
                if(coursEnVenteLink.classList.contains('active')) coursEnVenteLink.classList.remove('active');
                if(coursEnVente.classList.contains('active')) coursEnVente.classList.remove('active');
                if(document.querySelector('#formateur-profile').classList.contains('active')) document.querySelector('#formateur-profile').classList.remove('active');
                
                // Show retrait section
                console.log('Adding active class to retrait');
                retrait.classList.add('active');
                console.log('retrait classes:', retrait.className);
                
                // Load retrait data
                loadRetraitData();
            });

            // Function to load retrait data
            function loadRetraitData() {
                // Load balance
                $.ajax({
                    url: apiUrl + 'user/balance',
                    type: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer ${token}`,
                    },
                    success: function(response) {
                        console.log('Balance:', response);
                        document.getElementById('balance-amount').textContent = response.balance || '400 000';
                    },
                    error: function(erreurs) {
                        console.log('Balance error:', erreurs);
                        // Keep default value
                    }
                });

                // Load recent transactions
                $.ajax({
                    url: apiUrl + 'user/transactions',
                    type: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer ${token}`,
                    },
                    success: function(response) {
                        console.log('Transactions:', response);
                        renderTransactions(response);
                    },
                    error: function(erreurs) {
                        console.log('Transactions error:', erreurs);
                        renderMockTransactions();
                    }
                });
            }

            // Function to render transactions
            function renderTransactions(transactions) {
                const transactionsList = document.getElementById('transactions-list');
                transactionsList.innerHTML = '';
                
                transactions.forEach(transaction => {
                    const transactionItem = document.createElement('div');
                    transactionItem.className = 'transaction-item';
                    transactionItem.innerHTML = `
                        <div class="transaction-info">
                            <div class="transaction-name">${transaction.user_name || 'Mathieu Kouassi'}</div>
                            <div class="transaction-description">${transaction.description}</div>
                        </div>
                        <div class="transaction-amount">
                            <span class="amount-value">+ ${transaction.amount} cfa</span>
                            <div class="transaction-actions">
                                <button class="btn-transaction ${transaction.status === 'available' ? 'btn-available' : 'btn-pending'}">
                                    ${transaction.status === 'available' ? 'Disponible pour retrait' : 'En cours'}
                                </button>
                            </div>
                        </div>
                    `;
                    
                    transactionsList.appendChild(transactionItem);
                });
            }

            // Function to render mock transactions (fallback)
            function renderMockTransactions() {
                const mockTransactions = [
                    {
                        user_name: 'Mathieu Kouassi',
                        description: 'Comprendre la détermination des cryptos',
                        amount: '10 999',
                        status: 'available'
                    },
                    {
                        user_name: 'Mathieu Kouassi',
                        description: 'Création créative et innovante',
                        amount: '1 999',
                        status: 'pending'
                    },
                    {
                        user_name: 'Mathieu Kouassi',
                        description: 'Stratégie marketing',
                        amount: '9 999',
                        status: 'pending'
                    },
                    {
                        user_name: 'Mathieu Kouassi',
                        description: 'Comprendre la détermination des cryptos',
                        amount: '10 999',
                        status: 'available'
                    },
                    {
                        user_name: 'Mathieu Kouassi',
                        description: 'Comprendre la détermination des cryptos',
                        amount: '10 999',
                        status: 'available'
                    },
                    {
                        user_name: 'Mathieu Kouassi',
                        description: 'Comprendre la détermination des cryptos',
                        amount: '10 999',
                        status: 'available'
                    },
                    {
                        user_name: 'Mathieu Kouassi',
                        description: 'Comprendre la détermination des cryptos',
                        amount: '10 999',
                        status: 'available'
                    }
                ];
                
                renderTransactions(mockTransactions);
            }

            // Add event listeners for retrait buttons
            $(document).on('click', '.btn-withdraw', function() {
                alert('Fonctionnalité de retrait en cours de développement');
            });

            $(document).on('click', '.btn-history', function() {
                alert('Historique de retrait en cours de développement');
            });

            // Fonction pour initialiser la messagerie
            function initMessagerieIfNeeded() {
                if (messagerieInitialized) return;
                
                // Récupérer les éléments de la messagerie
                contactItems = document.querySelectorAll('.contact-item');
                messageInput = document.getElementById('message-input');
                sendButton = document.getElementById('send-message');
                
                // Ajouter les écouteurs d'événements
                contactItems.forEach(contact => {
                    contact.addEventListener('click', handleContactClick);
                });
                
                messageInput.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        sendMessage();
                    }
                });
                
                sendButton.addEventListener('click', sendMessage);
                
                // Marquer comme initialisé
                messagerieInitialized = true;
            }
            
            // Gérer le clic sur un contact
            function handleContactClick(e) {
                // Retirer la classe active de tous les contacts
                contactItems.forEach(c => c.classList.remove('active'));
                
                // Ajouter la classe active au contact cliqué
                this.classList.add('active');
                
                // Mettre à jour les informations du contact dans l'en-tête du chat
                const contactName = this.querySelector('.contact-name').textContent;
                const contactStatus = this.querySelector('.contact-status').textContent;
                const contactImage = this.querySelector('img').src;
                const hasStatusOnline = this.querySelector('.status-online') !== null;
                
                document.getElementById('current-chat-name').textContent = contactName;
                document.getElementById('current-chat-status').textContent = contactStatus;
                document.getElementById('current-chat-avatar').src = contactImage;
                
                const statusOnlineInHeader = document.querySelector('.chat-avatar .status-online');
                if (hasStatusOnline) {
                    if (!statusOnlineInHeader) {
                        const statusSpan = document.createElement('span');
                        statusSpan.className = 'status-online';
                        document.querySelector('.chat-avatar').appendChild(statusSpan);
                    }
                } else {
                    if (statusOnlineInHeader) {
                        statusOnlineInHeader.remove();
                    }
                }
                
                // Simuler le chargement des messages pour ce contact
                loadMessages(this.dataset.contact);
            }
            
            // Fonction pour charger les messages d'un contact
            function loadMessages(contactId) {
                // Dans une application réelle, vous chargeriez les messages depuis une API
                // Pour cette démo, on va juste afficher des messages différents selon le contact
                
                const messagesContainer = document.getElementById('chat-messages');
                
                // Vider les messages existants sauf le premier (qui est l'en-tête "Aujourd'hui")
                const dayHeader = messagesContainer.querySelector('.message-day');
                messagesContainer.innerHTML = '';
                messagesContainer.appendChild(dayHeader);
                
                // Ajouter quelques messages selon le contact
                if (contactId === 'ralph-edwards') {
                    addMessage('received', 'Bonjour, comment ça va aujourd\'hui ?', '10:30');
                    addMessage('sent', 'Bonjour Ralph ! Ça va bien, merci. Et toi ?', '10:31 ✓✓');
                    addMessage('received', 'Très bien ! Je voulais te parler du nouveau projet.', '10:32');
                    addMessage('sent', 'Bien sûr, je suis tout ouïe.', '10:33 ✓✓');
                } else if (contactId === 'courtney-henry') {
                    addMessage('received', 'Salut, as-tu terminé le rapport ?', '09:15');
                    addMessage('sent', 'Pas encore, je le finis aujourd\'hui.', '09:20 ✓✓');
                    addMessage('received', 'Super, merci !', '09:21');
                } else {
                    addMessage('received', 'Bonjour Cedric', '11:00');
                    addMessage('sent', 'Bonjour ! Comment puis-je vous aider ?', '11:01 ✓✓');
                }
                
                // Faire défiler jusqu'au dernier message
                messagesContainer.scrollTop = messagesContainer.scrollHeight;
            }
            
            // Fonction pour ajouter un message à la conversation
            function addMessage(type, content, time) {
                const messagesContainer = document.getElementById('chat-messages');
                
                const messageDiv = document.createElement('div');
                messageDiv.className = `message ${type}`;
                
                const contentDiv = document.createElement('div');
                contentDiv.className = 'message-content';
                contentDiv.textContent = content;
                
                const timeDiv = document.createElement('div');
                timeDiv.className = 'message-time';
                timeDiv.textContent = time;
                
                messageDiv.appendChild(contentDiv);
                messageDiv.appendChild(timeDiv);
                
                messagesContainer.appendChild(messageDiv);
            }
            
            // Fonction pour envoyer un message
            function sendMessage() {
                const content = messageInput.value.trim();
                if (content === '') return;
                
                // Ajouter le message à la conversation
                const now = new Date();
                const time = `${now.getHours()}:${String(now.getMinutes()).padStart(2, '0')} ✓✓`;
                addMessage('sent', content, time);
                
                // Vider le champ de saisie
                messageInput.value = '';
                
                // Faire défiler jusqu'au dernier message
                const messagesContainer = document.getElementById('chat-messages');
                messagesContainer.scrollTop = messagesContainer.scrollHeight;
                
                // Simuler une réponse après un court délai
                setTimeout(() => {
                    const responses = [
                        'D\'accord, je comprends.',
                        'Merci pour l\'information.',
                        'Je vais voir ce que je peux faire.',
                        'Parfait, je reviens vers toi rapidement.',
                        'C\'est noté !'
                    ];
                    const randomResponse = responses[Math.floor(Math.random() * responses.length)];
                    const responseTime = `${now.getHours()}:${String(now.getMinutes() + 1).padStart(2, '0')}`;
                    
                    addMessage('received', randomResponse, responseTime);
                    messagesContainer.scrollTop = messagesContainer.scrollHeight;
                }, 1500);
            }

            // Show the messagerie page
            messagerieLink.addEventListener('click', (e)=>{
                e.preventDefault();

                if(messagerie.classList.contains('active')) return;
                // if(addFormPage.classList.contains('active')) addFormPage.classList.remove('active');
                if(profile.classList.contains('active')) profile.classList.remove('active');
                if(pourToi.classList.contains('active')) pourToi.classList.remove('active');
                if(profilePage.classList.contains('active')) profilePage.classList.remove('active');
                if(formaSuivieLink.classList.contains('active')) formaSuivieLink.classList.remove('active');
                if(formaSuivie.classList.contains('active')) formaSuivie.classList.remove('active');
                if(coursEnVenteLink.classList.contains('active')) coursEnVenteLink.classList.remove('active');
                if(coursEnVente.classList.contains('active')) coursEnVente.classList.remove('active');
                if(retraitLink.classList.contains('active')) retraitLink.classList.remove('active');
                if(retrait.classList.contains('active')) retrait.classList.remove('active');
                messagerie.classList.add('active');
                if(document.querySelector('#formateur-profile').classList.contains('active')) document.querySelector('#formateur-profile').classList.remove('active');
                messagerieLink.classList.add('active');
                
                
                // Initialiser la messagerie si ce n'est pas déjà fait
                initMessagerieIfNeeded();
            });

            // Show the formation suivie page

            // Variable pour tracker si les formations ont déjà été chargées
            let formationsLoaded = false;

            formaSuivieLink.addEventListener('click', (e)=>{
                if(formaSuivie.classList.contains('active')) return;
                // if(addFormPage.classList.contains('active')) addFormPage.classList.remove('active');
                if(profile.classList.contains('active')) profile.classList.remove('active');
                if(pourToi.classList.contains('active')) pourToi.classList.remove('active');
                if(profilePage.classList.contains('active')) profilePage.classList.remove('active');
                if(messagerieLink.classList.contains('active')) messagerieLink.classList.remove('active');
                if(messagerie.classList.contains('active')) messagerie.classList.remove('active');
                if(coursEnVenteLink.classList.contains('active')) coursEnVenteLink.classList.remove('active');
                if(coursEnVente.classList.contains('active')) coursEnVente.classList.remove('active');
                if(retraitLink.classList.contains('active')) retraitLink.classList.remove('active');
                if(retrait.classList.contains('active')) retrait.classList.remove('active');
                if(document.querySelector('#formateur-profile').classList.contains('active')) document.querySelector('#formateur-profile').classList.remove('active');
                formaSuivie.classList.add('active');

                 // Lister les formations seulement si pas encore chargées
                if(user.role == 'apprenant' && !formationsLoaded){
                    $.ajax({
                        url: apiUrl+ 'formations',
                        type: 'GET',
                        headers: {
                            'Content-Type': 'application/json',
                            'Authorization': `Bearer ${token}`,
                        },

                        success: function(response){
                            // console.log('formations:',response);
                            const tableBody = formaSuivie.querySelector('table tbody');
                            const gridContainer = courGrid;
                            
                            // Vider les conteneurs avant d'ajouter les nouveaux éléments
                            tableBody.innerHTML = '';
                            gridContainer.innerHTML = '';
                            
                            // Créer un template pour les éléments
                            const templateRow = document.createElement('tr');
                            templateRow.innerHTML = `
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            `;
                            
                            const templateGridItem = document.createElement('div');
                            templateGridItem.className = 'list-item';
                            templateGridItem.innerHTML = `
                                <div class="list-item-head">
                                    <img src="" alt="">
                                </div>
                                <div class="text">
                                    <p class="type"></p>
                                    <h4 class="name"></h4>
                                </div>
                            `;
                            
                            response.forEach(element =>{
                                
                                const tableRow = templateRow.cloneNode(true);
                                const gridItem = templateGridItem.cloneNode(true);

                                // const items= document.querySelectorAll('.list-item');
                                // console.log(items);
                                // if(items){
                                //     items.forEach(item =>{
                                //         item.remove();
                                //     });
                                // }

                                // console.log( 'tableRow: ', tableRow);
                                // console.log('gridItem: ', gridItem);
                                
                                tableRow.querySelector('td:nth-child(1)').innerText= element.titre;
                                tableRow.querySelector('td:nth-child(2)').innerText= element.duree_estimee;
                                tableRow.querySelector('td:nth-child(3)').innerText= element.created_at;
                                tableRow.querySelector('td:nth-child(4)').innerText= element.categorie.nom;
                                tableRow.querySelector('td:nth-child(5)').innerText= element.formateur.name;
                                tableBody.appendChild(tableRow);

                                gridItem.querySelector('.list-item-head img').src= apiStorage + element.image_couverture;
                                gridItem.querySelector('.text .type').innerText=  element.categorie.nom;
                                gridItem.querySelector(' .text .name').innerText=  element.titre;
                                gridItem.querySelector(' .text .duree-user .duree').innerText=  element.duree_estimee +' min';
                                gridItem.querySelector(' .text .duree-user .user img').src=  element.formateur.avatar_url;

                                courGrid.appendChild(gridItem);

                                // Show the content of the row of formation's table clicked

                                tableRow.addEventListener('click', (e)=>{
                                    e.preventDefault();

                                    window.location.href= `http://localhost:8000/sendSingleFormation/${element.id}`;
                                });

                                // Show the content of the grid element of formation's grid clicked
                                gridItem.addEventListener('click', (e)=>{
                                    e.preventDefault();

                                    window.location.href= `http://localhost:8000/sendSingleFormation/${element.id}`;
                                    
                                });

                            });
                            
                            // Marquer les formations comme chargées pour éviter les rechargements
                            formationsLoaded = true;
                            
                            // const items= courGrid.querySelectorAll('.list-item');
                            // items.forEach(item=> {
                            //     item.addEventListener('click', (e)=>{
                            //         e.preventDefault();
                            //         courDetailsPage.classList.add('active');
                            //     });
                            // });
                            
                        },
                        error: function(erreurs){
                            console.log('formation-erreur:',erreurs);
                        },

                    });
                }else if(user.role == 'formateur' && !formationsLoaded){
                    $.ajax({
                        url: apiUrl+ 'my-formations',
                        type: 'GET',
                        headers: {
                            'Content-Type': 'application/json',
                            'Authorization': `Bearer ${token}`,
                        },

                        success: function(response){
                            // console.log('formations:',response);
                            const tableBody = formaSuivie.querySelector('table tbody');
                            const gridContainer = courGrid;
                            
                            // Vider les conteneurs avant d'ajouter les nouveaux éléments
                            tableBody.innerHTML = '';
                            gridContainer.innerHTML = '';
                            
                            // Créer un template pour les éléments
                            const templateRow = document.createElement('tr');
                            templateRow.innerHTML = `
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            `;
                            
                            const templateGridItem = document.createElement('div');
                            templateGridItem.className = 'list-item';
                            templateGridItem.innerHTML = `
                                <div class="list-item-head">
                                    <img src="" alt="">
                                </div>
                                <div class="text">
                                    <p class="type"></p>
                                    <h4 class="name"></h4>
                                    <div class="duree-user">
                                        <span class="duree"></span>
                                        <div class="user">
                                            <img src="" alt="">
                                        </div>
                                    </div>
                                </div>
                            `;
                            
                            response.forEach(element =>{
                                
                                const tableRow = templateRow.cloneNode(true);
                                const gridItem = templateGridItem.cloneNode(true);

                                // const items= document.querySelectorAll('.list-item');
                                // console.log(items);
                                // if(items){
                                //     items.forEach(item =>{
                                //         item.remove();
                                //     });
                                // }

                                // console.log( 'tableRow: ', tableRow);
                                // console.log('gridItem: ', gridItem);
                                
                                tableRow.querySelector('td:nth-child(1)').innerText= element.titre;
                                tableRow.querySelector('td:nth-child(2)').innerText= element.duree_estimee;
                                tableRow.querySelector('td:nth-child(3)').innerText= element.created_at;
                                tableRow.querySelector('td:nth-child(4)').innerText= element.categorie.nom;
                                // tableRow.querySelector('td:nth-child(5)').innerText= element.formateur.name;
                                tableBody.appendChild(tableRow);

                                gridItem.querySelector('.list-item-head img').src= apiStorage + element.image_couverture;
                                gridItem.querySelector('.text .type').innerText=  element.categorie.nom;
                                gridItem.querySelector(' .text .name').innerText=  element.titre;
                                gridItem.querySelector(' .text .duree-user .duree').innerText=  element.duree_estimee +' min';
                                // gridItem.querySelector(' .text .duree-user .user img').src=  element.formateur.avatar_url;

                                courGrid.appendChild(gridItem);

                                // Show the content of the row of formation's table clicked

                                tableRow.addEventListener('click', (e)=>{
                                    e.preventDefault();

                                    window.location.href= `http://localhost:8000/sendSingleFormation/${element.id}`;
                                });

                                // Show the content of the grid element of formation's grid clicked
                                gridItem.addEventListener('click', (e)=>{
                                    e.preventDefault();

                                    window.location.href= `http://localhost:8000/sendSingleFormation/${element.id}`;
                                    
                                });

                            });
                            
                            // Marquer les formations comme chargées pour éviter les rechargements
                            formationsLoaded = true;
                            
                            // const items= courGrid.querySelectorAll('.list-item');
                            // items.forEach(item=> {
                            //     item.addEventListener('click', (e)=>{
                            //         e.preventDefault();
                            //         courDetailsPage.classList.add('active');
                            //     });
                            // });
                            
                        },
                        error: function(erreurs){
                            console.log('formation-erreur:',erreurs);
                        },

                    });
                }

            });

            // Init create formation

            // $('#cours-en-vente .btn-creer-formation').onclick= () => {
            //     $('#create-formation').classList.add('active');
            // }


            gratuit.onclick= (e) =>{
                e.preventDefault();

                if(gratuit.classList.contains('active')) return;
                if(payant.classList.contains('active')) payant.classList.remove('active');
                e.currentTarget.classList.add('active');
                // console.log(document.querySelector('#overlay #create-formation .create-formation-body form .ctn-price .ctn-input.price'));
                if(document.querySelector('#overlay #create-formation .create-formation-body form .ctn-price .ctn-input.price')) document.querySelector('#overlay #create-formation .create-formation-body form .ctn-price .ctn-input.price').remove();
            }

            payant.onclick= (e) =>{
                e.preventDefault();

                if(payant.classList.contains('active')) return;
                if(gratuit.classList.contains('active')) gratuit.classList.remove('active');
                e.currentTarget.classList.add('active');
                const div= document.createElement('div');
                div.classList= [];
                div.classList.add('ctn-input', 'price');
                div.innerHTML= `
                    <input type="number">
                    <div>CFA</div>
                `;
                div.querySelector('input').style.cssText+= `width: 90%; boder: 1px solid white; margin: 10px 0 15px 0;`;
                div.style.cssText+= 'display: flex; flex-direction: row; justify-content: space-evenly; align-items: center; width: 100%;';
                e.currentTarget.parentNode.parentNode.appendChild(div);
            }

            // Drag & drop files
            
            formationFile.ondragover= (e)=>{
                e.preventDefault();

            };

            formationFile.ondrop= (e)=>{

                e.preventDefault();
                const file= e.dataTransfer.files[0];
                if(file.type.includes('image')){
                    const image= document.createElement('img');
                    image.src= URL.createObjectURL(file);
                    formationFile.innerHTML= '';
                    formationFile.innerHTML= `
                    <div class="block">
                        <div class="image-ctn">
                            <img src="${URL.createObjectURL(file)}" alt="Image">
                        </div>
                        <div>
                            <div class="duree">
                                Nom: <span></span>
                            </div>
                            <div class="taille">
                                Taille: <span></span>
                            </div>
                        </div>
                    </div>
                        <div class="btns">

                            <button class="btn-edit">
                                <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                </svg>
                            </button>

                            <button class="btn-delete">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                    <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                                </svg>
                            </button>

                        </div>

                    `;
                    formationFile.querySelector('.block').style.cssText= 'display: flex; flex-direction: row; justify-content: space-between; align-items: flex-start; background-color: var(--graylite); color white; padding-top: 10px;';
                    formationFile.style.cssText= 'display: flex; flex-direction: row; justify-content: space-around; align-items: flex-start; background-color: var(--graylite); color white; padding-top: 10px;';
                    formationFile.querySelector('.btns').style.cssText= 'display: flex; justify-content: space-between; align-items: center; background-color: var(--graylite); color white; width: 100px; height: 75px;';
                    formationFile.querySelectorAll('button').forEach(button=>{
                        button.style.cssText= 'background-color: var(--graylite); color white; border: none; border-radius: 15px; padding: 10px; cursor: pointer; width: calc(90% / 2); height: 50%; overflow: hidden; display: flex; justify-content: center; align-items: center;';
                    });
                    formationFile.querySelector('.duree').style.cssText= 'display: flex; justify-content: space-between; align-items: baseline; overflow: hidden; text-align: left; font-size: .8em; background-color: var(--graylite); color: gray; width: 100px;';
                    formationFile.querySelector('.taille').style.cssText= 'display: flex; justify-content: space-between; align-items: baseline; overflow: hidden; text-align: left; font-size: .8em; background-color: var(--graylite); color: gray; width: 100px;';
                    formationFile.querySelector('.duree span').innerText= file.name;
                    formationFile.querySelector('.taille span').innerText= `${Math.floor(file.size / (1024))} KB`;
                    formationFile.querySelectorAll('.block span').forEach(span=>{
                        span.style.cssText= 'color: white;';
                    });
                    formationFile.querySelectorAll('svg').forEach(svg=>{
                        svg.style.cssText= 'fill: white; height: 100%; width:90%;';
                    });
                    formationFile.querySelector('.image-ctn').style.cssText= 'display: flex; justify-content: space-between; align-items: center; background-color: var(--graylite); color white; width: 120px; height: 85%; overflow: hidden;';
                    formationFile.querySelector('.image-ctn img').style.cssText= 'width: 85%; height: 100%; object-fit: cover; border-radius: 10px;';
                    // console.log('btn-delete:', formationFile);
                    formationFile.querySelector('.btn-edit').style.cssText+= 'background-color: var(--secondary); border-radius: 10px;';
                    formationFile.querySelector('.btns .btn-delete').onclick= (e)=>{
                        e.preventDefault();
                        console.log('btn-delete-clicked');
                        formationFile.innerHTML= `
                            <div class="ctn-svg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-file-earmark-plus" viewBox="0 0 16 16">
                                    <path d="M8 6.5a.5.5 0 0 1 .5.5v1.5H10a.5.5 0 0 1 0 1H8.5V11a.5.5 0 0 1-1 0V9.5H6a.5.5 0 0 1 0-1h1.5V7a.5.5 0 0 1 .5-.5"/>
                                    <path d="M14 4.5V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h5.5zm-3 0A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5z"/>
                                </svg>
                                Glisser et déposer ici
                            </div>
                            <button class="btn-file">
                                Choisir un fichier
                            </button>
                        `;
                        formationFile.style.cssText= 'display: flex; flex-direction: column; justify-content: space-around; align-items: center; background-color: var(--graylite); color white;';
                    };

                    formationFile.querySelector('.btns .btn-edit').onclick= (e)=>{
                        e.preventDefault();
                        formationFile.querySelector('input[name="formation-file"]').click();
                    };
                    
                }else if(file.type.includes('video')){
                    const video= document.createElement('video');
                    video.preload= 'metadata';
                    video.src= URL.createObjectURL(file);
                    formationFile.innerHTML= '';
                    formationFile.innerHTML= `
                    <div class="block">
                        <div class="video-ctn">
                            <video src="${URL.createObjectURL(file)}" alt="Video"></video>
                            <svg class="bi bi-play-fill" viewBox="0 0 16 16">
                                <path d="M11.596 8.697l-6.363 3.692c-.54.313-1.233-.066-1.233-.697V4.308c0-.63.692-1.01 1.233-.696l6.363 3.692a.802.802 0 0 1 0 1.393z"/>
                            </svg>
                        </div>
                        <div>
                            <div class="duree">
                                Duree: <span></span>
                            </div>
                            <div class="taille">
                                Taille: <span></span>
                            </div>
                        </div>
                    </div>
                        <div class="btns">  
                            <button class="btn-edit">
                                <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                </svg>
                            </button>

                            <button class="btn-delete">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                    <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                                </svg>
                            </button>
                        </div>
                    `;
                    formationFile.querySelector('.block').style.cssText= 'display: flex; flex-direction: row; justify-content: space-between; align-items: flex-start; background-color: var(--graylite); color: white; padding-top: 10px;'; 
                    video.onloadedmetadata= ()=>{
                        formationFile.querySelector('.duree span').innerText= `${Math.floor(video.duration / 60)} min ${Math.floor(video.duration % 60)}s`;
                        formationFile.querySelector('.taille span').innerText= `${Math.floor(file.size / (1024 * 1024))} MB`;
                    };
                    formationFile.querySelector('.duree').style.cssText= 'display: flex; justify-content: space-between; align-items: baseline; overflow: hidden; text-align: left; font-size: .8em; background-color: var(--graylite); color: gray; width: 100px;';
                    formationFile.querySelector('.taille').style.cssText= 'display: flex; justify-content: space-between; align-items: baseline; overflow: hidden; text-align: left; font-size: .8em; background-color: var(--graylite); color: gray; width: 100px;';
                    formationFile.querySelectorAll('.block span').forEach(span=>{
                        span.style.cssText= 'color: white;';
                    });
                    formationFile.style.cssText= 'display: flex; flex-direction: row; justify-content: space-between; align-items: center; background-color: var(--graylite); color white;';
                    formationFile.querySelector('.btns').style.cssText= 'display: flex; justify-content: space-between; align-items: center; background-color: var(--graylite); color white; width: 100px; height: 75px;';
                    formationFile.querySelectorAll('button').forEach(button=>{
                        button.style.cssText= 'background-color: var(--graylite); color white; border: none; border-radius: 15px; padding: 10px; cursor: pointer; width: calc(90% / 2); height: 50%; overflow: hidden; display: flex; justify-content: center; align-items: center;';
                    });
                    formationFile.querySelectorAll('svg').forEach(svg=>{
                        svg.style.cssText= 'fill: white; height: 100%; width:90%;';
                    });
                        formationFile.querySelector('.video-ctn').style.cssText= 'display: flex; justify-content: center; align-items: center; background-color: var(--graylite); color white; width: 120px; height: 120px; overflow: hidden; position: relative;';
                        formationFile.querySelector('.video-ctn .bi-play-fill').style.cssText= 'z-index: 10; position: absolute; height: 30px; whidth: 30px; fill: white;';
                        formationFile.querySelector('.video-ctn video').style.cssText= 'width: 85%; height: 100%; object-fit: cover; border-radius: 10px;';
                    formationFile.querySelector('.btn-edit').style.cssText+= 'background-color: var(--secondary); border-radius: 10px;';

                    formationFile.querySelector('.btns .btn-delete').onclick= (e)=>{
                        e.preventDefault();
                        console.log('btn-delete-clicked');
                        formationFile.innerHTML= `
                            <div class="ctn-svg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-file-earmark-plus" viewBox="0 0 16 16">
                                    <path d="M8 6.5a.5.5 0 0 1 .5.5v1.5H10a.5.5 0 0 1 0 1H8.5V11a.5.5 0 0 1-1 0V9.5H6a.5.5 0 0 1 0-1h1.5V7a.5.5 0 0 1 .5-.5"/>
                                    <path d="M14 4.5V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h5.5zm-3 0A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5z"/>
                                </svg>
                                Glisser et déposer ici
                            </div>
                            <button class="btn-file">
                                Choisir un fichier
                            </button>
                        `;
                        formationFile.style.cssText= 'display: flex; flex-direction: column; justify-content: space-around; align-items: center; background-color: var(--graylite); color white;';
                    };

                    formationFile.querySelector('.btns .btn-edit').onclick= (e)=>{
                        e.preventDefault();
                        document.querySelector('input[name="formation-file"]').click();
                    };
                }
                if(createFormation.classList.contains('active')){
                    // Gestionnaire pour le bouton "Continuer" (soumission du formulaire)
                    document.querySelector('#create-formation .btn-submit-create-formation').onclick= (e)=>{

                        e.preventDefault();
                        const data= new FormData();
                        console.log('file-ctn-file: ', file);
                        const titre= document.querySelector('#create-formation .create-formation-body input[name="titre"]').value;
                        const legende= document.querySelector('#create-formation .create-formation-body input[name="legende"]').value;
                        const categorie= document.querySelector('#create-formation .create-formation-body select').value;
                        const description= document.querySelector('#create-formation .create-formation-body textarea').value;
                        if(payant.classList.contains('active')){
                        const prix= document.querySelector('#create-formation .create-formation-body .ctn-price input[type="number"]').value
                            data.append('prix', prix);
                        }else{
                            data.append('prix', 0);
                        }
                        
                        data.append('file', file);
                        data.append('titre', titre);
                        data.append('legende', legende);
                        data.append('categorie', categorie);
                        data.append('description', description);

                        $.ajax({
                            url: apiUrl +'formations',
                            type: 'POST',
                            processData: false,
                            contentType: false,
                            headers: {
                                'Authorization': `Bearer ${token}`,
                                // 'Content-Type': 'application/json',
                            },
                            data: data,
                            success: function(response){
                                message.classList.add('success');
                                success.classList.add('active');
                                successMsg.innerText= response.message;
                                
                                // Réinitialiser seulement les champs de la première étape
                                document.querySelector('#create-formation form').reset();
                                const fileCtn = document.querySelector('#create-formation .file-ctn');
                                if (fileCtn) {
                                    fileCtn.innerHTML = `
                                        <div class="ctn-svg">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-file-earmark-plus" viewBox="0 0 16 16">
                                                <path d="M8 6.5a.5.5 0 0 1 .5.5v1.5H10a.5.5 0 0 1 0 1H8.5V11a.5.5 0 0 1-1 0V9.5H6a.5.5 0 0 1 0-1h1.5V7a.5.5 0 0 1 .5-.5"/>
                                                <path d="M14 4.5V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h5.5zm-3 0A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5z"/>
                                            </svg>
                                            Glisser et déposer ici
                                        </div>
                                        <button class="btn-file">
                                            Choisir un fichier
                                        </button>
                                    `;
                                }
                                
                                createFormation.classList= [];
                                createFormation.classList.add('parts');
                                formationID= response.formation_id;
                                
                                // Ajouter le gestionnaire pour le bouton "Continuer" en mode parts
                                setTimeout(() => {
                                    const submitBtn = document.querySelector('#create-formation .btn-submit-create-formation');
                                    if (submitBtn) {
                                        submitBtn.onclick = (e) => {
                                            e.preventDefault();
                                            submitFormationVideos();
                                        };
                                    }
                                }, 100);
                            },
                            error: function(erreurs){
                                message.classList.add('error');
                                error.classList.add('active');
                                erroMsg.innerText= 'Erreur lors de la création de la formation';
                            }
                        });
                        
                    }
                }

                // Gestionnaire pour le bouton "Annuler" 
                document.querySelector('#create-formation .btn-cancel-create-formation').onclick = (e) => {
                    e.preventDefault();
                    // Utiliser la fonction de réinitialisation complète
                    resetCreateFormationModal();
                    // Fermer le modal
                    overlay.classList.remove('create-formation');
                };

                // Gestionnaire pour le bouton de fermeture (X)
                document.querySelector('#create-formation .btn-close-create-formation').onclick = (e) => {
                    e.preventDefault();
                    // Même action que le bouton Annuler
                    document.querySelector('#create-formation .btn-cancel-create-formation').click();
                };

            };

            document.querySelector('#create-formation .formation-parts .btn-add-part').onclick = (e) => {
                const createFormationHead = document.querySelector('#create-formation .create-formation-head');
                const formationParts = document.querySelector('#create-formation .formation-parts');

                const partTemplate = document.createElement('div');
                partTemplate.classList = "part-temp";

                partTemplate.innerHTML = `
                    <div class="part-head">
                        <div class="partname">Part ${part + 1}
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                            </svg>
                        </div>
                        <div class="block">
                            <div class="ctn-input">
                                <input type="text" name="titre-partie" placeholder="Titre de la partie">
                                <span>40 caractères max</span>
                            </div>
                        </div>
                    </div>

                    <div class="part-body">
                        <div class="module">
                            <div class="video-edit">
                                <video poster="">
                                    <source src="">
                                </video>
                                <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                </svg>
                                <input type="file" name="module-video-${lesson}" hidden>
                            </div>
                            <div class="ctn-input">
                                <input type="text" name="module-name-${lesson}" placeholder="Titre du module">
                            </div>
                            <button class="btn-close">
                                <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-x" viewBox="0 0 16 16">
                                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <button class="btn-add-module"> Ajouter un module </button>
                `;

                // Upload vidéo module
                const svgBtn = partTemplate.querySelector('.video-edit svg');
                const fileInput = partTemplate.querySelector('input[type="file"]');
                const video = partTemplate.querySelector('video');
                svgBtn.onclick = () => fileInput.click();
                fileInput.onchange = (ev) => {
                    video.preload = 'metadata';
                    video.src = URL.createObjectURL(ev.target.files[0]);
                };

                // Supprimer partie
                partTemplate.querySelector('.part-head .partname svg').onclick = () => partTemplate.remove();

                // Ajouter module
                partTemplate.querySelector('.btn-add-module').onclick = () => {
                    lesson++;
                    const moduleTemp = partTemplate.querySelector('.part-body .module').cloneNode(true);
                    moduleTemp.querySelector('input[type="file"]').name = `module-video-${lesson}`;
                    moduleTemp.querySelector('input[type="text"]').name = `module-name-${lesson}`;
                    moduleTemp.querySelector('input[type="file"]').value = "";
                    moduleTemp.querySelector('input[type="text"]').value = "";
                    moduleTemp.querySelector('video').src = "";

                    moduleTemp.querySelector('.btn-close').onclick = () => moduleTemp.remove();

                    const svgModuleBtn = moduleTemp.querySelector('.video-edit svg');
                    const fileInputModule = moduleTemp.querySelector('input[type="file"]');
                    const videoModule = moduleTemp.querySelector('video');
                    svgModuleBtn.onclick = () => fileInputModule.click();
                    fileInputModule.onchange = (ev) => {
                        videoModule.preload = 'metadata';
                        videoModule.src = URL.createObjectURL(ev.target.files[0]);
                    };

                    partTemplate.querySelector('.part-body').appendChild(moduleTemp);
                };

                formationParts.insertBefore(partTemplate, formationParts.querySelector('.btn-add-part'));
                part++;
            };

            // Fonction pour réinitialiser complètement le modal de création de formation
            function resetCreateFormationModal() {
                console.log('Réinitialisation complète du modal create-formation');
                
                // Réinitialiser le formulaire principal
                const mainForm = document.querySelector('#create-formation form');
                if (mainForm) {
                    mainForm.reset();
                }
                
                // Réinitialiser tous les inputs text, textarea, select
                document.querySelectorAll('#create-formation input[type="text"], #create-formation textarea, #create-formation select').forEach(input => {
                    input.value = '';
                });
                
                // Réinitialiser tous les inputs file
                document.querySelectorAll('#create-formation input[type="file"]').forEach(input => {
                    input.value = '';
                });
                
                // Réinitialiser les boutons radio (gratuit/payant)
                document.querySelectorAll('#create-formation input[type="radio"]').forEach(radio => {
                    radio.checked = false;
                });
                
                // Réinitialiser les classes des boutons gratuit/payant
                if (gratuit) gratuit.classList.remove('active');
                if (payant) payant.classList.remove('active');
                
                // Supprimer le champ prix dynamique s'il existe
                const priceInput = document.querySelector('#create-formation .ctn-price .ctn-input.price');
                if (priceInput) {
                    priceInput.remove();
                }
                
                // Réinitialiser l'affichage du fichier
                const fileCtn = document.querySelector('#create-formation .file-ctn');
                if (fileCtn) {
                    fileCtn.innerHTML = `
                        <div class="ctn-svg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-file-earmark-plus" viewBox="0 0 16 16">
                                <path d="M8 6.5a.5.5 0 0 1 .5.5v1.5H10a.5.5 0 0 1 0 1H8.5V11a.5.5 0 0 1-1 0V9.5H6a.5.5 0 0 1 0-1h1.5V7a.5.5 0 0 1 .5-.5"/>
                                <path d="M14 4.5V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h5.5zm-3 0A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5z"/>
                            </svg>
                            Glisser et déposer ici
                        </div>
                        <button class="btn-file">
                            Choisir un fichier
                        </button>
                    `;
                }
                
                // Supprimer toutes les parties ajoutées dynamiquement
                const partTemps = document.querySelectorAll('#create-formation .part-temp');
                partTemps.forEach(partTemp => {
                    partTemp.remove();
                });
                
                // Réinitialiser les compteurs
                part = 1;
                lesson = 1;
                formationID = null;
                
                // Réinitialiser les classes du modal
                createFormation.classList.remove('active', 'parts');
                
                console.log('Modal réinitialisé complètement');
            }

            // Soumission finale de tous les modules et parties
            // Cette fonction sera appelée après la création de la formation, quand on passe en mode "parts"
            function submitFormationVideos() {
                const partTemps = document.querySelectorAll('#create-formation .part-temp');
                if (partTemps.length === 0) {
                    console.log('Aucune partie à soumettre');
                    return;
                }
                
                const data = new FormData();
                data.append('id', formationID);

                partTemps.forEach(partTemp => {
                    partTemp.querySelectorAll('input[type="file"]').forEach(inputFile => {
                        if (inputFile.files.length > 0) data.append(inputFile.name, inputFile.files[0]);
                    });
                    partTemp.querySelectorAll('input[type="text"]').forEach(inputText => {
                        data.append(inputText.name, inputText.value);
                    });
                });

                console.log('Soumission des vidéos pour formation ID:', formationID);
                
                $.ajax({
                    url: apiUrl + `formations/${formationID}/videos`,
                    type: 'POST',
                    processData: false,
                    contentType: false,
                    headers: { 'Authorization': `Bearer ${token}` },
                    data: data,
                    success: function(response) {
                        console.log('Vidéos ajoutées avec succès:', response);
                        
                        // Réinitialiser tous les inputs du modal
                        resetCreateFormationModal();
                        
                        // Fermer le modal et afficher un message de succès
                        createFormation.classList.remove('active', 'parts');
                        overlay.classList.remove('create-formation');
                        
                        // Afficher message de succès
                        message.classList.add('success');
                        success.classList.add('active');
                        successMsg.innerText = 'Formation créée avec succès !';
                    },
                    error: function(err) { 
                        console.error('Erreur lors de l\'ajout des vidéos:', err);
                        // Afficher message d'erreur
                        message.classList.add('error');
                        error.classList.add('active');
                        errorMsg.innerText = 'Erreur lors de l\'ajout des vidéos';
                    }
                });
            }


            document.querySelector('#create-formation .create-formation-head button').onclick= (e)=>{
                e.preventDefault();
                document.querySelector('#create-formation').classList= [];
                overlay.classList= [];
            };

            // ========================================
            // MOBILE NAVIGATION HANDLERS
            // ========================================
            
            // Mobile Navigation Functions
            function toggleBodyScroll(disable) {
                if (disable) {
                    document.body.style.overflow = 'hidden';
                } else {
                    document.body.style.overflow = '';
                }
            }
            
            function toggleMobileNav() {
                const isOpen = nav.classList.contains('mobile-open');
                
                if (isOpen) {
                    closeMobileNav();
                } else {
                    openMobileNav();
                }
            }
            
            function openMobileNav() {
                nav.classList.add('mobile-open');
                if (navOverlay) navOverlay.classList.add('active');
                if (mobileNavToggle) mobileNavToggle.classList.add('active');
                toggleBodyScroll(true);
            }
            
            function closeMobileNav() {
                nav.classList.remove('mobile-open');
                if (navOverlay) navOverlay.classList.remove('active');
                if (mobileNavToggle) mobileNavToggle.classList.remove('active');
                toggleBodyScroll(false);
            }
            
            // Toggle mobile navigation
            if (mobileNavToggle) {
                mobileNavToggle.addEventListener('click', (e) => {
                    e.preventDefault();
                    toggleMobileNav();
                });
            }
            
            // Close nav when overlay is clicked
            if (navOverlay) {
                navOverlay.addEventListener('click', (e) => {
                    e.preventDefault();
                    closeMobileNav();
                });
            }
            
            // Close nav when nav item is clicked (mobile)
            document.querySelectorAll('nav ul li').forEach(navItem => {
                navItem.addEventListener('click', () => {
                    if (window.innerWidth <= 768) {
                        closeMobileNav();
                    }
                });
            });
            
            // Handle window resize
            window.addEventListener('resize', () => {
                if (window.innerWidth > 768) {
                    closeMobileNav();
                }
            });
            
            // Touch gestures for mobile nav
            let startX = 0;
            let currentX = 0;
            let isSwipe = false;
            
            document.addEventListener('touchstart', (e) => {
                startX = e.touches[0].clientX;
                isSwipe = true;
            });
            
            document.addEventListener('touchmove', (e) => {
                if (!isSwipe) return;
                currentX = e.touches[0].clientX;
            });
            
            document.addEventListener('touchend', (e) => {
                if (!isSwipe) return;
                isSwipe = false;
                
                const diffX = startX - currentX;
                const threshold = 50;
                
                // Swipe left to close nav (when nav is open)
                if (nav.classList.contains('mobile-open') && diffX > threshold) {
                    closeMobileNav();
                }
                
                // Swipe right to open nav (when nav is closed and starting from left edge)
                if (!nav.classList.contains('mobile-open') && startX < 50 && diffX < -threshold) {
                    openMobileNav();
                }
            });

            // Logout

            document.querySelector('#logout').onclick= ()=> {
                $.ajax({
                    url: apiUrl + `logout`,
                    type: 'GET',
                    headers: {
                        'Authorization': `Bearer ${token}`,
                    },
                    success: function(response){
                        console.log(response);
                        window.location.href= 'http://localhost:8000/login';
                    },
                    error: function(erreurs){
                        console.log(erreurs);
                    }

                });
            }

            // Animate the nav element

            navList.forEach(li =>{
                li.addEventListener('click', (e)=>{
                    e.preventDefault();
                    const pageListActive = document.querySelector('nav ul li.active');
                    if(pageListActive?.classList.contains('active')) pageListActive?.classList.remove('active');
                    if(e.currentTarget.classList.contains('active')) return;
                    e.currentTarget.classList.add('active');
                                  
                });
            });

            // document.querySelectorAll('#categories ul li').forEach(liste =>{
            //     liste.addEventListener('click', (e)=>{
            //         e.preventDefault();
            //         const liActive = document.querySelector('#categories ul li.active');
            //         if(liActive?.classList.contains('active')) liActive?.classList.remove('active');
            //         if(e.currentTarget.classList.contains('active')){
            //             e.currentTarget.classList.remove('active');
            //             return;
            //         }
                    
            //         e.currentTarget.classList.add('active');
            //     });
            // });

            // Play the video on the pause button's click 
            // pauses.forEach(pause =>{
            //     pause.addEventListener('click', (e)=>{
            //         e.preventDefault();
            //         // console.log('pause!')
            //         e.currentTarget.parentNode.previousElementSibling.click();
            //     });

            // });

        });

    </script>

    <!-- Mobile Navigation Toggle Button -->
    <button class="mobile-nav-toggle" aria-label="Toggle navigation">
        <span></span>
        <span></span>
        <span></span>
    </button>

    <!-- Navigation Overlay for Mobile -->
    <div class="nav-overlay"></div>

    <nav>
        <div class="nav-head">
            <img src="https://www.bintschool.com/wp-content/uploads/2023/04/BintSchooloff.png" alt="" class="logo">
        </div>
        <div class="pages">
            <ul>
                MENU
                <li class="pour-toi active">
                    <svg xmlns="http://www.w3.org/2000/svg"  class="bi bi-house" viewBox="0 0 16 16">
                        <path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L2 8.207V13.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V8.207l.646.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293zM13 7.207V13.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V7.207l5-5z"/>
                    </svg>
                    Pour toi
                </li>

                <li class="profile-link">
                    <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-person-fill" viewBox="0 0 16 16">
                        <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/>
                    </svg>
                    Profil
                </li>

                <li class="retrait-link">
                    <svg xmlns="http://www.w3.org/2000/svg"class="bi bi-gift-fill" viewBox="0 0 16 16">
                        <path d="M3 2.5a2.5 2.5 0 0 1 5 0 2.5 2.5 0 0 1 5 0v.006c0 .07 0 .27-.038.494H15a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h2.038A3 3 0 0 1 3 2.506zm1.068.5H7v-.5a1.5 1.5 0 1 0-3 0c0 .085.002.274.045.43zM9 3h2.932l.023-.07c.043-.156.045-.345.045-.43a1.5 1.5 0 0 0-3 0zm6 4v7.5a1.5 1.5 0 0 1-1.5 1.5H9V7zM2.5 16A1.5 1.5 0 0 1 1 14.5V7h6v9z"/>
                    </svg>
                    Retrait
                </li>

                <li class="cours-en-vente">
                    <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-journal-text" viewBox="0 0 16 16">
                        <path d="M5 10.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5m0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5m0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5m0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5"/>
                        <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2"/>
                        <path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1z"/>
                    </svg>
                    Cours en vente
                </li>

                <li class="messagerie-link">
                    <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-chat-left-dots" viewBox="0 0 16 16">
                        <path d="M14 1a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H4.414A2 2 0 0 0 3 11.586l-2 2V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12.793a.5.5 0 0 0 .854.353l2.853-2.853A1 1 0 0 1 4.414 12H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z"/>
                        <path d="M5 6a1 1 0 1 1-2 0 1 1 0 0 1 2 0m4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0m4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
                    </svg>
                    Messagerie</li>
                <li class="forma-suivie">
                    <svg viewBox="0 0 32 32" fill="white" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns" >
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier"> 
                            <title>book-album</title> 
                            <desc>Created with Sketch Beta.</desc> 
                            <defs> </defs> 
                            <g id="Page-1" stroke="none" stroke-width="1" fill-rule="evenodd" sketch:type="MSPage"> 
                                <g id="Icon-Set-Filled" sketch:type="MSLayerGroup" transform="translate(-414.000000, -101.000000)" fill="#000000"> 
                                    <path d="M418,101 C415.791,101 414,102.791 414,105 L414,126 C414,128.209 415.885,129.313 418,130 L429,133 L429,104 C423.988,102.656 418,101 418,101 L418,101 Z M442,101 C442,101 436.212,102.594 430.951,104 L431,104 L431,133 C436.617,131.501 442,130 442,130 C444.053,129.469 446,128.209 446,126 L446,105 C446,102.791 444.209,101 442,101 L442,101 Z" id="book-album" sketch:type="MSShapeGroup"> </path> 
                                </g> 
                            </g> 
                        </g>
                    </svg>  
                    Formation suivies
                </li>
               
            </ul> 
        </div>
        

        <button id="logout">
            <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-box-arrow-in-right" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M6 3.5a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 0-1 0v2A1.5 1.5 0 0 0 6.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-8A1.5 1.5 0 0 0 5 3.5v2a.5.5 0 0 0 1 0z"/>
                <path fill-rule="evenodd" d="M11.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H1.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z"/>
            </svg>    
        Déconnexion</button>
    </nav>

    <div id="blockpage">
            <section id="home">
                <div id="categories">
                    <ul>CATEGORIES
                        
                    </ul>
                </div>

                <div id="content">


                    <div class="content-item">
                        <video poster="" preload="auto">
                            <source src="#" type="video/mp4">
                        </video>
                        <div class="pause-play">

                            <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-play-fill" viewBox="0 0 16 16">
                                <path d="m11.596 8.697-6.363 3.692c-.54.313-1.233-.066-1.233-.697V4.308c0-.63.692-1.01 1.233-.696l6.363 3.692a.802.802 0 0 1 0 1.393"/>
                            </svg>

                        </div>
                        <div class="text">

                            <div class="user">
                                <img src=" {{ asset('images/image4.png') }}" alt="">
                                <div class="info">
                                    <h6>Username</h6>
                                    <div class="date">Date</div>
                                </div>
                                
                                <button class="btn-follow">+ Suivre</button>
                            </div>
                            <p class="legend">Lorem ipsum dolor sit amet consectetur adipisicing elit. Sapiente nobis, dolore distinctio quisquam aspernatur perspiciatis ducimus repellat aliquam numquam vero ut atque nisi eum, laborum libero reiciendis nam quas nulla!</p>
                            <div class="btns">
                                <button>
                                    1
                                    <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-heart" viewBox="0 0 16 16">
                                        <path d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143q.09.083.176.171a3 3 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15"/>
                                    </svg>
                                </button>

                                <button>
                                    1
                                    <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-chat" viewBox="0 0 16 16">
                                        <path d="M2.678 11.894a1 1 0 0 1 .287.801 11 11 0 0 1-.398 2c1.395-.323 2.247-.697 2.634-.893a1 1 0 0 1 .71-.074A8 8 0 0 0 8 14c3.996 0 7-2.807 7-6s-3.004-6-7-6-7 2.808-7 6c0 1.468.617 2.83 1.678 3.894m-.493 3.905a22 22 0 0 1-.713.129c-.2.032-.352-.176-.273-.362a10 10 0 0 0 .244-.637l.003-.01c.248-.72.45-1.548.524-2.319C.743 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7-3.582 7-8 7a9 9 0 0 1-2.347-.306c-.52.263-1.639.742-3.468 1.105"/>
                                    </svg>
                                </button>
                                <button>
                                    1
                                    <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-send" viewBox="0 0 16 16">
                                        <path d="M15.854.146a.5.5 0 0 1 .11.54l-5.819 14.547a.75.75 0 0 1-1.329.124l-3.178-4.995L.643 7.184a.75.75 0 0 1 .124-1.33L15.314.037a.5.5 0 0 1 .54.11ZM6.636 10.07l2.761 4.338L14.13 2.576zm6.787-8.201L1.591 6.602l4.339 2.76z"/>
                                    </svg>
                                </button>
                            </div>
                            <div class="more">
                                <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Fuga iste eum, similique impedit doloremque repudiandae sequi quisquam quidem voluptates placeat sunt adipisci commodi iure magni eligendi omnis. Neque, sequi vel.</p>
                                <button>En savoir +</button>
                            </div>
                        </div>
                    </div>


                </div>

                <aside>
                    <div class="search">
                        <div class="input-container">
                            <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-search" viewBox="0 0 16 16">
                                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                            </svg>
                            <input type="text" placeholder="Rechercher">
                        </div>
                        <button class="btn-search">Rechercher</button>
                    </div>

                    <div id="suggestions">
                        <div class="video">
                            <video poster="" preload="auto">
                                <source src="#" type="video/mp4">
                            </video>
                            <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-play-fill" viewBox="0 0 16 16">
                                <path d="m11.596 8.697-6.363 3.692c-.54.313-1.233-.066-1.233-.697V4.308c0-.63.692-1.01 1.233-.696l6.363 3.692a.802.802 0 0 1 0 1.393"/>
                            </svg>
                        </div>

                        <div class="video">
                            <video poster="" preload="auto">
                                <source src="#" type="video/mp4">
                            </video>
                            <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-play-fill" viewBox="0 0 16 16">
                                <path d="m11.596 8.697-6.363 3.692c-.54.313-1.233-.066-1.233-.697V4.308c0-.63.692-1.01 1.233-.696l6.363 3.692a.802.802 0 0 1 0 1.393"/>
                            </svg>
                        </div>

                        <div class="video">
                            <video poster="" preload="auto">
                                <source src="#" type="video/mp4">
                            </video>
                            <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-play-fill" viewBox="0 0 16 16">
                                <path d="m11.596 8.697-6.363 3.692c-.54.313-1.233-.066-1.233-.697V4.308c0-.63.692-1.01 1.233-.696l6.363 3.692a.802.802 0 0 1 0 1.393"/>
                            </svg>
                        </div>

                        <div class="video">
                            <video poster="" preload="auto">
                                <source src="#" type="video/mp4">
                            </video>
                            <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-play-fill" viewBox="0 0 16 16">
                                <path d="m11.596 8.697-6.363 3.692c-.54.313-1.233-.066-1.233-.697V4.308c0-.63.692-1.01 1.233-.696l6.363 3.692a.802.802 0 0 1 0 1.393"/>
                            </svg>
                        </div>

                        <div class="video">
                            <video poster="" preload="auto">
                                <source src="#" type="video/mp4">
                            </video>
                            <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-play-fill" viewBox="0 0 16 16">
                                <path d="m11.596 8.697-6.363 3.692c-.54.313-1.233-.066-1.233-.697V4.308c0-.63.692-1.01 1.233-.696l6.363 3.692a.802.802 0 0 1 0 1.393"/>
                            </svg>
                        </div>

                        <div class="video">
                            <video poster="" preload="auto">
                                <source src="#" type="video/mp4">
                            </video>
                            <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-play-fill" viewBox="0 0 16 16">
                                <path d="m11.596 8.697-6.363 3.692c-.54.313-1.233-.066-1.233-.697V4.308c0-.63.692-1.01 1.233-.696l6.363 3.692a.802.802 0 0 1 0 1.393"/>
                            </svg>
                        </div>

                        <div class="video">
                            <video poster="" preload="auto">
                                <source src="#" type="video/mp4">
                            </video>
                            <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-play-fill" viewBox="0 0 16 16">
                                <path d="m11.596 8.697-6.363 3.692c-.54.313-1.233-.066-1.233-.697V4.308c0-.63.692-1.01 1.233-.696l6.363 3.692a.802.802 0 0 1 0 1.393"/>
                            </svg>
                        </div>

                        <div class="video">
                            <video poster="" preload="auto">
                                <source src="#" type="video/mp4">
                            </video>
                            <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-play-fill" viewBox="0 0 16 16">
                                <path d="m11.596 8.697-6.363 3.692c-.54.313-1.233-.066-1.233-.697V4.308c0-.63.692-1.01 1.233-.696l6.363 3.692a.802.802 0 0 1 0 1.393"/>
                            </svg>
                        </div>
                        
                        <!-- <video src="#" muted poster="" preload="auto"></video>
                        <video src="#" muted poster="" preload="auto"></video>
                        <video src="#" muted poster="" preload="auto"></video>
                        <video src="#" muted poster="" preload="auto"></video>
                        <video src="#" muted poster="" preload="auto"></video> -->
                    </div>

                </aside>

            </section>


            
            <!-- Represent the profil page -->


            <section id="profile">

                <!-- Contain user information -->
                <div class="user">
                    <div class="cover">
                        <img src="https://images.pexels.com/photos/956999/milky-way-starry-sky-night-sky-star-956999.jpeg" alt="">
                    </div>

                    <div class="user-profile">
                        <div class="user-info">
                            <img src="#" alt="">
                            <h2></h2>
                            <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Exercitationem, officia earum nihil, modi beatae consequuntur ea voluptatibus asperiores, enim magnam harum dolorum nobis doloremque deserunt sunt aliquid quisquam nulla. Nisi!</p>
                            <div class="follows">
                                <div>Followers:  <span class="followers"></span> | </div> 
                                <div>Following:  <span class="following"></span> | </div>
                                <div> <span class="profession"> </span></div>
                            </div>
                        </div>

                            <!-- Contain the buttons in the profil -->
                        <div class="btns">
                            <button class="change-profile">changer profile</button>
                            <button class="change-cover">changer cover</button>
                            <button class="profile-share">Partage profil</button>
                            <button class="param">Paramètres</button>
                        </div>
                    </div>

                </div>

                <!-- This part represent the profil completion elements -->

                <div class="complete-profil">

                    <div class="block1">
                        <div class="percentage"> <!-- contain percentage --> 
                            <div class="percent-jauge"></div>
                            <div class="over-jauge"></div>
                        </div>

                        <div class="checkboxs">
                            <h2>Complèter votre profil</h2>
                            <div class="checks">
                                <div class="check-item"> <div class="check">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-check-circle" viewBox="0 0 16 16">
                                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                                        <path d="m10.97 4.97-.02.022-3.473 4.425-2.093-2.094a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05"/>
                                    </svg>
                                </div> Ajouter une photo de profil </div>
                                <div class="check-item"> <div class="check">
                                    <svg xmlns="http://www.w3.org/2000/svg"  class="bi bi-check-circle" viewBox="0 0 16 16">
                                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                                        <path d="m10.97 4.97-.02.022-3.473 4.425-2.093-2.094a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05"/>
                                    </svg>
                                </div> Confirmer l'adresse mail</div>
                                <div class="check-item"> <div class="check">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-check-circle" viewBox="0 0 16 16">
                                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                                        <path d="m10.97 4.97-.02.022-3.473 4.425-2.093-2.094a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05"/>
                                    </svg>
                                </div> Acheter un cour </div>
                            </div>
                        </div>

                        <div class="congratulations"> 
                            <h4>
                                <div class="ctn-svg">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960">
                                        <path d="m80-80 200-560 360 360L80-80Zm132-132 282-100-182-182-100 282Zm370-246-42-42 224-224q32-32 77-32t77 32l24 24-42 42-24-24q-14-14-35-14t-35 14L582-458ZM422-618l-42-42 24-24q14-14 14-34t-14-34l-26-26 42-42 26 26q32 32 32 76t-32 76l-24 24Zm80 80-42-42 144-144q14-14 14-35t-14-35l-64-64 42-42 64 64q32 32 32 77t-32 77L502-538Zm160 160-42-42 64-64q32-32 77-32t77 32l64 64-42 42-64-64q-14-14-35-14t-35 14l-64 64ZM212-212Z"/>
                                    </svg>
                                </div>
                                Bravo, vous y êtes presque.
                            </h4>
                            <p>Continuer de compléter les étapes pour avoir un profil parfait</p>
                        </div>
                    </div>

                    <!-- This contain the second block of the complete profil block (Mail confirmation link) -->

                    <div class="block2">
                        <div class="block2-item">
                            <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-mailbox2" viewBox="0 0 16 16">
                                <path d="M9 8.5h2.793l.853.854A.5.5 0 0 0 13 9.5h1a.5.5 0 0 0 .5-.5V8a.5.5 0 0 0-.5-.5H9z"/>
                                <path d="M12 3H4a4 4 0 0 0-4 4v6a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1V7a4 4 0 0 0-4-4M8 7a4 4 0 0 0-1.354-3H12a3 3 0 0 1 3 3v6H8zm-3.415.157C4.42 7.087 4.218 7 4 7s-.42.086-.585.157C3.164 7.264 3 7.334 3 7a1 1 0 0 1 2 0c0 .334-.164.264-.415.157"/>
                            </svg>

                            <div class="send-link">
                                <h4>Un lien de confirmation a été envoyé</h4>
                                <div class="link-mail"><p>Votre addresse mail: iba@gmail.com</p> <a href="">Modifier</a></div>
                            </div>
                        </div>

                        <button>Renvoyez le lien</button>
                    </div>

                </div>
                <!-- Cours template -->
                <div id="cours">
                    <ul>
                        <li class="active">Favoris</li>
                        <li>Cours suivis</li>
                        <li>Derniers cours suivis</li>
                    </ul>

                    <!-- template of a single cour -->

                    <div class="items">

                        <div class="cour">
                            <img src="{{ asset('images/image2.png') }}" alt="img-cour">
                            <div class="text">
                                <h4>nom cour</h4>
                                <div class="meta-info">
                                    <div class="hour">hour</div>
                                    <div class="cour-cate">cour-cate</div>
                                    <div class="publisher"> <img src="" alt=""> publisher</div>
                                </div>
                            </div>
                        </div>

                        <div class="cour">
                            <img src="{{ asset('images/image2.png') }}" alt="img-cour">
                            <div class="text">
                                <h4>nom cour</h4>
                                <div class="meta-info">
                                    <div class="hour">hour</div>
                                    <div class="cour-cate">cour-cate</div>
                                    <div class="publisher"> <img src="" alt=""> publisher</div>
                                </div>
                            </div>
                        </div>

                        <div class="cour">
                            <img src="{{ asset('images/image2.png') }}" alt="img-cour">
                            <div class="text">
                                <h4>nom cour</h4>
                                <div class="meta-info">
                                    <div class="hour">hour</div>
                                    <div class="cour-cate">cour-cate</div>
                                    <div class="publisher"> <img src="" alt=""> publisher</div>
                                </div>
                            </div>
                        </div>

                        <div class="cour">
                            <img src="{{ asset('images/image2.png') }}" alt="img-cour">
                            <div class="text">
                                <h4>nom cour</h4>
                                <div class="meta-info">
                                    <div class="hour">hour</div>
                                    <div class="cour-cate">cour-cate</div>
                                    <div class="publisher"> <img src="" alt=""> publisher</div>
                                </div>
                            </div>
                        </div>

                    </div>

                    
                </div>

                <div id="inputs">
                    <input type="file" id="profile-pic" name="profile-pic">
                    <input type="file" id="cover-pic" name="cover-pic">
                </div>

            </section>

            <section id="formateur-profile">

                <!-- Contain user information -->
                <div class="user">
                    <div class="cover">
                        <img src="https://images.pexels.com/photos/956999/milky-way-starry-sky-night-sky-star-956999.jpeg" alt="">
                    </div>

                    <div class="user-profile">

                        <div class="user-info">
                            <img src="#" alt="">
                            <h2></h2>
                            <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Exercitationem.</p>
                            <div class="follows">
                                <div>Followers:  <span class="followers"></span> | </div> 
                                <div>Following:  <span class="following"></span> | </div>
                                <div> <span class="profession"> </span></div>
                            </div>
                        </div>

                            <!-- Contain the buttons in the profil -->
                        <div class="btns">
                            <button class="suivre-profil">Suivre</button>
                            <button class="profile-share">Partage profil</button>
                        </div>

                    </div>

                    <div class="cours-container">
                            <div class="cour-suivie"></div>

                            <div class="dernier-cour-suivie"></div>
                    </div>

                </div>
                
                <!-- Cours template -->
                

            </section>

            <!-- The cour-detail page -->

            <section id="cour-details">
                <div class="cour-detail-body">
                    <div class="container-left">
                        <button>
                            <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-chevron-left" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0"/>
                            </svg>
                            Retour
                        </button>
                    </div>

                    <div class="container-right">
                        <div class="cdtls-block1">
                            <img src=" {{ asset('images/image2.png') }} " alt="">
                        </div>

                        <div class="cdtls-block2">
                            <!-- The cour introduction (Head) -->
                            <div class="cour-intro">
                                <div class="cour-cat"> Categorie : Business</div>
                                <h3>Créer un compte paypal professionnel depuis l'Afrique(Pays non éligibles) </h3>
                                <div class="stars">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-star-fill" viewBox="0 0 16 16">
                                        <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                        <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-star-fill" viewBox="0 0 16 16">
                                        <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                        <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-star-fill" viewBox="0 0 16 16">
                                        <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                    </svg>
                                
                                </div>
                                <div class="cour-reactions">

                                    <button>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-heart" viewBox="0 0 16 16">
                                            <path d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143q.09.083.176.171a3 3 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15"/>
                                        </svg>
                                    </button>

                                    <button>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-chat" viewBox="0 0 16 16">
                                            <path d="M2.678 11.894a1 1 0 0 1 .287.801 11 11 0 0 1-.398 2c1.395-.323 2.247-.697 2.634-.893a1 1 0 0 1 .71-.074A8 8 0 0 0 8 14c3.996 0 7-2.807 7-6s-3.004-6-7-6-7 2.808-7 6c0 1.468.617 2.83 1.678 3.894m-.493 3.905a22 22 0 0 1-.713.129c-.2.032-.352-.176-.273-.362a10 10 0 0 0 .244-.637l.003-.01c.248-.72.45-1.548.524-2.319C.743 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7-3.582 7-8 7a9 9 0 0 1-2.347-.306c-.52.263-1.639.742-3.468 1.105"/>
                                        </svg>
                                    </button>

                                    <button>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-send" viewBox="0 0 16 16">
                                            <path d="M15.854.146a.5.5 0 0 1 .11.54l-5.819 14.547a.75.75 0 0 1-1.329.124l-3.178-4.995L.643 7.184a.75.75 0 0 1 .124-1.33L15.314.037a.5.5 0 0 1 .54.11ZM6.636 10.07l2.761 4.338L14.13 2.576zm6.787-8.201L1.591 6.602l4.339 2.76z"/>
                                        </svg>
                                    </button>
                                </div>

                                <div class="cour-formateur">
                                    <div class="formateur-info">
                                        <img src="{{ asset('images/image4.png') }} " alt="">
                                        <div class="formateur">
                                            <h4>Jean Marc Krebe</h4>
                                            <span>Spécialist Marketing Digital</span>
                                        </div>
                                        <button class="visiter">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-eye-fill" viewBox="0 0 16 16">
                                                <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0"/>
                                                <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8m8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7"/>
                                            </svg>
                                            Visiter
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <!-- The cour body -->
                            <div class="cour-body">

                                <div class="a-propos">
                                    <h3>A propos de ce cour</h3>
                                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolores tempora animi sit illo! Repellat id, quaerat inventore totam fuga doloremque sed veniam explicabo accusamus mollitia sit rerum dolore ex fugit.</p>
                                    <button class="acces">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-heart-fill" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314"/>
                                        </svg>
                                        Acces gratuit
                                    </button>

                                    <div class="btns">
                                        <button>
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960">
                                                <path d="m826-585-56-56 30-31-128-128-31 30-57-57 30-31q23-23 57-22.5t57 23.5l129 129q23 23 23 56.5T857-615l-31 30ZM346-104q-23 23-56.5 23T233-104L104-233q-23-23-23-56.5t23-56.5l30-30 57 57-31 30 129 129 30-31 57 57-30 30Zm397-336 57-57-303-303-57 57 303 303ZM463-160l57-58-302-302-58 57 303 303Zm-6-234 110-109-64-64-109 110 63 63Zm63 290q-23 23-57 23t-57-23L104-406q-23-23-23-57t23-57l57-57q23-23 56.5-23t56.5 23l63 63 110-110-63-62q-23-23-23-57t23-57l57-57q23-23 56.5-23t56.5 23l303 303q23 23 23 56.5T857-441l-57 57q-23 23-57 23t-57-23l-62-63-110 110 63 63q23 23 23 56.5T577-161l-57 57Z"/>
                                            </svg>
                                            Tous les niveaux
                                        </button>
                                        <button class="btn-nbre-inscript">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-people" viewBox="0 0 16 16">
                                                <path d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1zm-7.978-1L7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002-.014.002zM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4m3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0M6.936 9.28a6 6 0 0 0-1.23-.247A7 7 0 0 0 5 9c-4 0-5 3-5 4q0 1 1 1h4.216A2.24 2.24 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816M4.92 10A5.5 5.5 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275ZM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0m3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4"/>
                                            </svg>
                                            <div class="nbre-inscript">420 Incrits</div>
                                        </button>
                                        <button class="btn-duree">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-clock" viewBox="0 0 16 16">
                                                <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71z"/>
                                                <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16m7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0"/>
                                            </svg>
                                            <div class="duree">4H</div>
                                        </button>
                                    </div>
                                </div>
                                <!-- Chapitre du cour -->
                                <div class="cour-chapters">
                                    <h3>Qu'Allez-vous apprendre</h3>
                                    <div class="chapters-items">
                                        <div class="item">
                                            <button>
                                                <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-1-square" viewBox="0 0 16 16">
                                                    <path d="M9.283 4.002V12H7.971V5.338h-.065L6.072 6.656V5.385l1.899-1.383z"/>
                                                    <path d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm15 0a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1z"/>
                                                </svg>
                                            </button>
                                            Contourner les restrictions paypal
                                        </div>
                                        <div class="item">
                                            <button>
                                                <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-2-square" viewBox="0 0 16 16">
                                                    <path d="M6.646 6.24v.07H5.375v-.064c0-1.213.879-2.402 2.637-2.402 1.582 0 2.613.949 2.613 2.215 0 1.002-.6 1.667-1.287 2.43l-.096.107-1.974 2.22v.077h3.498V12H5.422v-.832l2.97-3.293c.434-.475.903-1.008.903-1.705 0-.744-.557-1.236-1.313-1.236-.843 0-1.336.615-1.336 1.306"/>
                                                    <path d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm15 0a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1z"/>
                                                </svg>
                                            </button>
                                            Contourner les restrictions paypal
                                        </div>
                                        <div class="item">
                                            <button>
                                                <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-3-square" viewBox="0 0 16 16">
                                                    <path d="M7.918 8.414h-.879V7.342h.838c.78 0 1.348-.522 1.342-1.237 0-.709-.563-1.195-1.348-1.195-.79 0-1.312.498-1.348 1.055H5.275c.036-1.137.95-2.115 2.625-2.121 1.594-.012 2.608.885 2.637 2.062.023 1.137-.885 1.776-1.482 1.875v.07c.703.07 1.71.64 1.734 1.917.024 1.459-1.277 2.396-2.93 2.396-1.705 0-2.707-.967-2.754-2.144H6.33c.059.597.68 1.06 1.541 1.066.973.006 1.6-.563 1.588-1.354-.006-.779-.621-1.318-1.541-1.318"/>
                                                    <path d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm15 0a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1z"/>
                                                </svg>
                                            </button>
                                            Contourner les restrictions paypal
                                        </div>
                                    </div>
                                </div>
                                <!-- Modules du cours -->
                                <div class="cour-content">
                                    <h3>Contenu du cour</h3>
                                    <!-- <div class="part">Partie 1</div> -->

                                    <div class="content-items">

                                        <div class="item">
                                            <div>
                                                <button>
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-play-fill" viewBox="0 0 16 16">
                                                        <path d="m11.596 8.697-6.363 3.692c-.54.313-1.233-.066-1.233-.697V4.308c0-.63.692-1.01 1.233-.696l6.363 3.692a.802.802 0 0 1 0 1.393"/>
                                                    </svg>
                                                </button> 
                                                <div class="module-name">Titre du module</div>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-lock" viewBox="0 0 16 16">
                                                    <path fill-rule="evenodd" d="M8 0a4 4 0 0 1 4 4v2.05a2.5 2.5 0 0 1 2 2.45v5a2.5 2.5 0 0 1-2.5 2.5h-7A2.5 2.5 0 0 1 2 13.5v-5a2.5 2.5 0 0 1 2-2.45V4a4 4 0 0 1 4-4M4.5 7A1.5 1.5 0 0 0 3 8.5v5A1.5 1.5 0 0 0 4.5 15h7a1.5 1.5 0 0 0 1.5-1.5v-5A1.5 1.5 0 0 0 11.5 7zM8 1a3 3 0 0 0-3 3v2h6V4a3 3 0 0 0-3-3"/>
                                                </svg>
                                            </div>
                                            
                                    </div>
                                </div>
                                <!-- Public cible -->
                                <div class="public-cible">
                                    <h3>Public cible</h3>
                                    <ul>
                                        <li>Freelanceur et entrepreneurs</li>
                                        <li>Paiement internations</li>
                                    </ul>
                                </div>
                                <!-- Pre requis -->
                                <div class="pre-requis">
                                    <h3>Prérequis</h3>
                                    <ul>
                                        <li>Téléphone et oridination connecté à internet</li>
                                    </ul>
                                </div>
                                <button class="btn-buy-cour">Obtenir ce cours</button>
                            </div>

                        </div>
                    </div>
                </div>

                <div id="sell-cour-detail-overlay">

                    <div class="sell-cour-steps">
                        <button class="btn-retour">Retour</button>
                        <div class="step1 active">
                            <div class="head">
                                <div class="block1">
                                    <img src=" {{ asset('images/image2.png') }}" alt="">
                                </div>
                                
                                <div class="block2">
                                    <h3 class="cour-name">Nom du cour</h3>
                                    <div class="cour-price">
                                        Montant à payer: <div class="price"> 400 000 cfa</div>
                                    </div>
                                    <div class="validite">
                                        <div>Validité : </div>
                                        <button>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-heart-fill" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314"/>
                                            </svg>
                                            Accès à vie
                                        </button>
                                    </div>
                                </div>

                            </div>

                            <div class="payment-methods">
                                <h4>Choisir votre moyen de paiement: </h4>

                                <div class="btns">
                                    <button class="btn-card-payement">Carte 
                                        <div class="imgs">
                                            <img src="https://static.vecteezy.com/system/resources/previews/019/167/108/original/mastercard-free-download-free-png.png" alt="">
                                            <img src="https://cdn.imgbin.com/23/20/16/imgbin-mastercard-visa-payment-american-express-debit-card-italy-visa-u0xvJCG7cPDWPk4UWVHFAwWC1.jpg" alt="">
                                        </div>
                                    </button>
                                    <button class="btn-mobile-money"> Mobile money
                                        <div class="imgs">
                                            <img src="data:image/png;base64,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" alt="">
                                            <img src="data:image/png;base64,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" alt="">
                                        </div>
                                    </button>
                                </div>

                                <div class="forms">

                                    <form action="" id="card-payment" class="active">

                                        <div class="ctn-card-name">
                                            <label for="">Nom de titulaire</label>
                                            <input type="text" id="card-name" name="card-name">
                                        </div>
                                        <div class="ctn-card-number">
                                            <label for="card-number">Numero de la carte</label>
                                            <input type="text" id="card-number" name="card-number">
                                        </div>

                                        <div class="card-payment-foot">

                                            <div class="expiration">
                                                Expiration
                                                <div class="card-year-month">
                                                    <input type="number" min="0" max="1" step="1" name="month0" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 1)">
                                                    <input type="number" min="0" max="1" step="1" name="month1" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 1)">
                                                    /
                                                    <input type="number" min="0" max="1" step="1" name="year0" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 1)">
                                                    <input type="number" min="0" max="1" step="1" name="year1" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 1)">
                                                </div>
                                            </div>

                                            <div class="cvc">
                                                CVC
                                                <div class="inputs">
                                                    <input type="number" min="0" max="1" step="1" name="cvc0" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 1)">
                                                    <input type="number" min="0" max="1" step="1" name="cvc1" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 1)">
                                                    <input type="number" min="0" max="1" step="1" name="cvc2" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 1)">
                                                </div>
                                            </div>

                                        </div>

                                        

                                    </form>

                                    <form action="" id="mobile-payment">

                                        <div class="number">

                                            <select id="indicatif" name="indicatif">
                                                <option value="">Votre pays</option>
                                                <option value="+223">Mali</option>
                                                <option value="Burkina Faso">Burkina Faso</option>
                                                <option value="Niger">Niger</option>
                                            </select>

                                            <div class="ctn-mobile-num">
                                                <input type="text" id="mobile-num" name="mobile-num">
                                            </div>
                                        </div>

                                        <div class="code-confirmation">
                                            <h4>Code de confirmation</h4>
                                            <p>Compose le code **** pour générer un code de validation</p>

                                            <div class="inputs">
                                                <input type="number" max="9" min="0" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 1)" name="code0">
                                                <input type="number" max="9" min="0" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 1)" name="code1">
                                                <input type="number" max="9" min="0" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 1)" name="code2">
                                                <input type="number" max="9" min="0" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 1)" name="code3">
                                            </div>
                                        </div>
                                    </form>

                                </div>

                                
                            </div>

                            <button class="btn-pay">Payer</button>
                        </div>

                        <div class="step2">
                            <div class="head">
                                <img src="{{ asset('images/image2.png') }}" alt="">
                                <div class="step2-head-ctn">
                                    Comprendre les bitcoins et les criptos
                                    <div class="cour-info">
                                        <div class="block1">
                                            <div class="hour">4h</div> 
                                            <div class="cour-cat">Design</div>
                                        </div>
                                        <div class="user"> <img src="{{ asset('images/image4.png')}}" alt="">Isaac Mars</div>
                                    </div>
                                    <div class="acces">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-heart-fill" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314"/>
                                        </svg>
                                        Acces à vie gratuitement</div>
                                </div>   
                            </div>
                            <button class="btn-start-cour">Commencer</button>
                        </div>

                    </div>
               
                </div>

            </section>

            <!-- Messagerie Page -->

            <section id="messagerie">

                <!-- Panneau gauche - Liste des contacts -->

                <div class="messagerie-sidebar">
                    
                    <div class="messagerie-header">
                        <h2>Messagerie</h2>
                        <div class="search-container">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                            </svg>
                            <input type="text" placeholder="Rechercher" id="search-contacts">
                        </div>
                    </div>

                    <div class="contacts-section">
                        <h3>Contacts</h3>
                        <div class="online-contacts">
                            <div class="contact-item active" data-contact="ralph-edwards">
                                <div class="contact-avatar">
                                    <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=50&h=50&fit=crop&crop=face" alt="Ralph Edwards">
                                    <span class="status-online"></span>
                                </div>
                                <div class="contact-info">
                                    <div class="contact-name">Ralph Edwards</div>
                                    <div class="contact-status">En ligne depuis 3h</div>
                                </div>
                            </div>

                            <div class="contact-item" data-contact="courtney-henry">
                                <div class="contact-avatar">
                                    <img src="https://images.unsplash.com/photo-1494790108755-2616b668e7b0?w=50&h=50&fit=crop&crop=face" alt="Courtney Henry">
                                    <span class="status-online"></span>
                                </div>
                                <div class="contact-info">
                                    <div class="contact-name">Courtney Henry</div>
                                    <div class="contact-status">Activité</div>
                                </div>
                            </div>

                            <div class="contact-item" data-contact="ronald-richards">
                                <div class="contact-avatar">
                                    <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=50&h=50&fit=crop&crop=face" alt="Ronald Richards">
                                </div>
                                <div class="contact-info">
                                    <div class="contact-name">Ronald Richards</div>
                                    <div class="contact-status">Bonjour Cedric</div>
                                </div>
                            </div>

                            <div class="contact-item" data-contact="devon-lane">
                                <div class="contact-avatar">
                                    <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=50&h=50&fit=crop&crop=face" alt="Devon Lane">
                                </div>
                                <div class="contact-info">
                                    <div class="contact-name">Devon Lane</div>
                                    <div class="contact-status">Bonjour Cedric</div>
                                </div>
                            </div>

                            <div class="contact-item" data-contact="darlene-robertson">
                                <div class="contact-avatar">
                                    <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=50&h=50&fit=crop&crop=face" alt="Darlene Robertson">
                                </div>
                                <div class="contact-info">
                                    <div class="contact-name">Darlene Robertson</div>
                                    <div class="contact-status">Bonjour Cedric</div>
                                </div>
                            </div>

                            <div class="contact-item" data-contact="cody-fisher">
                                <div class="contact-avatar">
                                    <img src="https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?w=50&h=50&fit=crop&crop=face" alt="Cody Fisher">
                                </div>
                                <div class="contact-info">
                                    <div class="contact-name">Cody Fisher</div>
                                    <div class="contact-status">Bonjour Cedric</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="conversations-section">
                        <h3>Conversations</h3>
                        <div class="conversation-list">
                            <div class="contact-item" data-contact="courtney-henry">
                                <div class="contact-avatar">
                                    <img src="https://images.unsplash.com/photo-1494790108755-2616b668e7b0?w=50&h=50&fit=crop&crop=face" alt="Courtney Henry">
                                </div>
                                <div class="contact-info">
                                    <div class="contact-name">Courtney Henry</div>
                                    <div class="contact-status">4:52</div>
                                </div>
                            </div>

                            <div class="contact-item" data-contact="ronald-richards">
                                <div class="contact-avatar">
                                    <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=50&h=50&fit=crop&crop=face" alt="Ronald Richards">
                                </div>
                                <div class="contact-info">
                                    <div class="contact-name">Ronald Richards</div>
                                    <div class="contact-status">9:12</div>
                                </div>
                            </div>

                            <div class="contact-item" data-contact="ralph-edwards">
                                <div class="contact-avatar">
                                    <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=50&h=50&fit=crop&crop=face" alt="Ralph Edwards">
                                </div>
                                <div class="contact-info">
                                    <div class="contact-name">Ralph Edwards</div>
                                    <div class="contact-status">7:30</div>
                                </div>
                            </div>

                            <div class="contact-item" data-contact="devon-lane">
                                <div class="contact-avatar">
                                    <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=50&h=50&fit=crop&crop=face" alt="Devon Lane">
                                </div>
                                <div class="contact-info">
                                    <div class="contact-name">Devon Lane</div>
                                    <div class="contact-status">2:06</div>
                                </div>
                            </div>

                            <div class="contact-item" data-contact="darlene-robertson">
                                <div class="contact-avatar">
                                    <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=50&h=50&fit=crop&crop=face" alt="Darlene Robertson">
                                </div>
                                <div class="contact-info">
                                    <div class="contact-name">Darlene Robertson</div>
                                    <div class="contact-status">2:06</div>
                                </div>
                            </div>

                            <div class="contact-item" data-contact="cody-fisher">
                                <div class="contact-avatar">
                                    <img src="https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?w=50&h=50&fit=crop&crop=face" alt="Cody Fisher">
                                </div>
                                <div class="contact-info">
                                    <div class="contact-name">Cody Fisher</div>
                                    <div class="contact-status">2:06</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Panneau droit - Zone de conversation -->
                <div class="messagerie-chat">
                    <div class="chat-header">
                        <div class="chat-contact-info">
                            <div class="chat-avatar">
                                <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=40&h=40&fit=crop&crop=face" alt="Ralph Edwards" id="current-chat-avatar">
                                <span class="status-online"></span>
                            </div>
                            <div class="chat-contact-details">
                                <div class="chat-contact-name" id="current-chat-name">Ralph Edwards</div>
                                <div class="chat-contact-status" id="current-chat-status">En ligne depuis 3h</div>
                            </div>
                        </div>
                        <div class="chat-actions">
                            <button class="chat-action-btn">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M8 3a5 5 0 1 0 4.546 2.914.5.5 0 0 1 .908-.417A6 6 0 1 1 8 2z"/>
                                    <path d="M8 4.466V.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384L8.41 4.658A.25.25 0 0 1 8 4.466"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="chat-messages" id="chat-messages">
                        <div class="message-day">Aujourd'hui</div>
                        
                        <div class="message received">
                            <div class="message-content">Bonjour, ça va et toi ?</div>
                            <div class="message-time">11:00</div>
                        </div>

                        <div class="message sent">
                            <div class="message-content">Bonjour Henry, comment vas-tu ?</div>
                            <div class="message-time">11:00 ✓✓</div>
                        </div>

                        <div class="message received">
                            <div class="message-content">Bonjour, ça va et toi ?</div>
                            <div class="message-time">11:00</div>
                        </div>

                        <div class="message sent">
                            <div class="message-content">Bonjour Henry, comment vas-tu ?</div>
                            <div class="message-time">11:00 ✓✓</div>
                        </div>
                    </div>

                    <div class="chat-input-container">
                        <div class="input-wrapper">
                            <input type="text" placeholder="Tapez votre message..." id="message-input">
                            <button class="send-btn" id="send-message">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M15.854.146a.5.5 0 0 1 .11.54l-5.819 14.547a.75.75 0 0 1-1.329.124l-3.178-4.995L.643 7.184a.75.75 0 0 1 .124-1.33L15.314.037a.5.5 0 0 1 .54.11ZM6.636 10.07l2.761 4.338L14.13 2.576 6.636 10.07Zm6.787-8.201L1.591 6.602l4.339 2.76 7.494-7.493Z"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </section>

            <section id="formation-suivie">

                <div class="forma-head">
                    <h4>Vos formations</h4>

                    <div class="ctn-right">
                        <form action="">
                            <div class="ctn-forma-search">
                                <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-search" viewBox="0 0 16 16">
                                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                                </svg>
                                <input type="text" name="forma-search" placeholder="Rechercher">
                            </div>
                            <button class="btn-forma-search">Rechercher</button>
                        </form>

                    </div>

                </div>

                <div class="btns">
                    Les cours que vous suivez sont ici

                    <div class="btns-btns">
                        <button class="btn-table-view">
                            <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-list-ul" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M5 11.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5m-3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2m0 4a1 1 0 1 0 0-2 1 1 0 0 0 0 2m0 4a1 1 0 1 0 0-2 1 1 0 0 0 0 2"/>
                            </svg>
                        </button>

                        <button class="btn-grid-view active">
                            <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-grid" viewBox="0 0 16 16">
                                <path d="M1 2.5A1.5 1.5 0 0 1 2.5 1h3A1.5 1.5 0 0 1 7 2.5v3A1.5 1.5 0 0 1 5.5 7h-3A1.5 1.5 0 0 1 1 5.5zM2.5 2a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5zm6.5.5A1.5 1.5 0 0 1 10.5 1h3A1.5 1.5 0 0 1 15 2.5v3A1.5 1.5 0 0 1 13.5 7h-3A1.5 1.5 0 0 1 9 5.5zm1.5-.5a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5zM1 10.5A1.5 1.5 0 0 1 2.5 9h3A1.5 1.5 0 0 1 7 10.5v3A1.5 1.5 0 0 1 5.5 15h-3A1.5 1.5 0 0 1 1 13.5zm1.5-.5a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5zm6.5.5A1.5 1.5 0 0 1 10.5 9h3a1.5 1.5 0 0 1 1.5 1.5v3a1.5 1.5 0 0 1-1.5 1.5h-3A1.5 1.5 0 0 1 9 13.5zm1.5-.5a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5z"/>
                            </svg>
                        </button>
                    </div>
                            
                </div>

                <!-- Table display -->

                <div class="forma-cour-list">
                    <table>
                        <thead>
                            <tr>
                                <th>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-sort-alpha-up" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M10.082 5.629 9.664 7H8.598l1.789-5.332h1.234L13.402 7h-1.12l-.419-1.371zm1.57-.785L11 2.687h-.047l-.652 2.157z"/>
                                        <path d="M12.96 14H9.028v-.691l2.579-3.72v-.054H9.098v-.867h3.785v.691l-2.567 3.72v.054h2.645zm-8.46-.5a.5.5 0 0 1-1 0V3.707L2.354 4.854a.5.5 0 1 1-.708-.708l2-1.999.007-.007a.5.5 0 0 1 .7.006l2 2a.5.5 0 1 1-.707.708L4.5 3.707z"/>
                                    </svg>
                                    Titre
                                </th>
                                <th>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-hourglass-top" viewBox="0 0 16 16">
                                        <path d="M2 14.5a.5.5 0 0 0 .5.5h11a.5.5 0 1 0 0-1h-1v-1a4.5 4.5 0 0 0-2.557-4.06c-.29-.139-.443-.377-.443-.59v-.7c0-.213.154-.451.443-.59A4.5 4.5 0 0 0 12.5 3V2h1a.5.5 0 0 0 0-1h-11a.5.5 0 0 0 0 1h1v1a4.5 4.5 0 0 0 2.557 4.06c.29.139.443.377.443.59v.7c0 .213-.154.451-.443.59A4.5 4.5 0 0 0 3.5 13v1h-1a.5.5 0 0 0-.5.5m2.5-.5v-1a3.5 3.5 0 0 1 1.989-3.158c.533-.256 1.011-.79 1.011-1.491v-.702s.18.101.5.101.5-.1.5-.1v.7c0 .701.478 1.236 1.011 1.492A3.5 3.5 0 0 1 11.5 13v1z"/>
                                    </svg>
                                    Durée
                                </th>
                                <th>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-calendar-week" viewBox="0 0 16 16">
                                        <path d="M11 6.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm-3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm-5 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5z"/>
                                        <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4z"/>
                                    </svg>
                                    Date début
                                </th>
                                <th>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-ui-radios-grid" viewBox="0 0 16 16">
                                        <path d="M3.5 15a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5m9-9a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5m0 9a2.5 2.5 0 1 1 0-5 2.5 2.5 0 0 1 0 5M16 3.5a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0m-9 9a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0m5.5 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7m-9-11a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3m0 2a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7"/>
                                    </svg>
                                    Categorie
                                </th>
                                <th>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-person" viewBox="0 0 16 16">
                                        <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/>
                                    </svg>
                                    Nom formateur
                                </th>
                            </tr>

                        </thead>

                        <tbody>

                            <tr> 
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>

                        </tbody>

                        <tfoot></tfoot>
                    </table>
                </div>

                <!-- Grid display -->

                <div class="forma-cour-grid active">


                    <div class="list-item">
                        <div class="list-item-head">
                            <img src="" alt="">
                        </div>
                        <div class="text">
                            <div class="id"></div>
                            <div class="type"></div>
                            <div class="name"></div>
                            <div class="jauge"> 
                                <div class="jauge-jauge"></div> 
                                10% <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-trophy" viewBox="0 0 16 16">
                                <path d="M2.5.5A.5.5 0 0 1 3 0h10a.5.5 0 0 1 .5.5q0 .807-.034 1.536a3 3 0 1 1-1.133 5.89c-.79 1.865-1.878 2.777-2.833 3.011v2.173l1.425.356c.194.048.377.135.537.255L13.3 15.1a.5.5 0 0 1-.3.9H3a.5.5 0 0 1-.3-.9l1.838-1.379c.16-.12.343-.207.537-.255L6.5 13.11v-2.173c-.955-.234-2.043-1.146-2.833-3.012a3 3 0 1 1-1.132-5.89A33 33 0 0 1 2.5.5m.099 2.54a2 2 0 0 0 .72 3.935c-.333-1.05-.588-2.346-.72-3.935m10.083 3.935a2 2 0 0 0 .72-3.935c-.133 1.59-.388 2.885-.72 3.935M3.504 1q.01.775.056 1.469c.13 2.028.457 3.546.87 4.667C5.294 9.48 6.484 10 7 10a.5.5 0 0 1 .5.5v2.61a1 1 0 0 1-.757.97l-1.426.356a.5.5 0 0 0-.179.085L4.5 15h7l-.638-.479a.5.5 0 0 0-.18-.085l-1.425-.356a1 1 0 0 1-.757-.97V10.5A.5.5 0 0 1 9 10c.516 0 1.706-.52 2.57-2.864.413-1.12.74-2.64.87-4.667q.045-.694.056-1.469z"/>
                                </svg>
                            </div>
                            <div class="duree-user">
                                <div class="duree"></div>
                                <div class="user"><img src="" alt=""></div>
                            </div>
                        </div>
                    </div>


                </div>

            </section>

            <!-- Ajouter formation -->

            <!-- <section id="ajout-formation">
                <div class="ajout-forma-head">
                    <h3>Ajouter une formation: </h3>

                    <button class="btn-add-forma">Ajouter une formation</button>
                </div>
                
                <form action="" id="add-modules">
                    <div class="form-ctn">
                        <select name="user-formations" id="user-formations" class="form-control" required>
                            
                        </select>

                    <button class="add-module">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960">
                                <path d="M452-160q6 20 16.5 41.5T490-80H200q-33 0-56.5-23.5T120-160v-640q0-33 23.5-56.5T200-880h480q33 0 56.5 23.5T760-800v284q-18-2-40-2t-40 2v-284H480v280l-100-60-100 60v-280h-80v640h252ZM720-40q-83 0-141.5-58.5T520-240q0-83 58.5-141.5T720-440q83 0 141.5 58.5T920-240q0 83-58.5 141.5T720-40Zm-50-100 160-100-160-100v200ZM280-800h200-200Zm172 0H200h480-240 12Z"/>
                            </svg>
                    </button>
                    
                   </div>
                   <button type="submit">Envoyer</button>
                </form>
            </section> -->

            <!-- Cours en vente -->
            <section id="cours-en-vente">
                <div class="cours-vente-header">
                    <div class="block1">
                        <h2>Vos formations en vente</h2>
                        <div class="action-buttons">
                            <button class="btn-voir-brouillons">Voir brouillons</button>
                            <button class="btn-creer-formation">Créer une nouvelle formation</button>
                        </div>
                    </div>
                    <div class="stats-cards">
                        <div class="stat-card">
                            <h3>Formations publiées</h3>
                            <span class="stat-number" id="formations-publiees">0</span>
                        </div>
                        <div class="stat-card">
                            <h3>Types de catégories</h3>
                            <span class="stat-number" id="types-categories">0</span>
                        </div>
                        <div class="stat-card">
                            <h3>Nombre d'apprenants</h3>
                            <span class="stat-number" id="nombre-apprenants">0</span>
                        </div>
                        <div class="stat-card">
                            <h3>Formations en brouillons</h3>
                            <span class="stat-number" id="formations-brouillons">0</span>
                        </div>
                    </div>                    
                    
                </div>

                <div class="formations-grid" id="formations-grid">
                    <!-- Les formations seront injectées ici via JavaScript -->
                </div>
            </section>

            <!-- Section Retrait/Portefeuille -->
            <section id="retrait">
                <div class="retrait-header">
                    <div class="balance-card">
                        <div class="balance-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-wallet2" viewBox="0 0 16 16">
                                <path d="M12.136.326A1.5 1.5 0 0 1 14 1.78V3h.5A1.5 1.5 0 0 1 16 4.5v9a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 13.5v-9a1.5 1.5 0 0 1 1.5-1.5H2V1.78a1.5 1.5 0 0 1 1.864-1.454l8.272 1.454zm-3.032 1.18a.5.5 0 0 1-.398-.17L8 .5l-.706.836a.5.5 0 0 1-.398.17L3 2.78V3h10V2.78l-3.896-.274zM1.5 4a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5h13a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-13z"/>
                            </svg>
                            <span>Solde actuel</span>
                        </div>
                        <div class="balance-amount">
                            <span class="amount" id="balance-amount">400 000</span>
                            <span class="currency">cfa</span>
                            <div class="balance-change">
                                <span class="change-text">Hausse de 20%</span>
                            </div>
                        </div>
                        <div class="balance-actions">
                            <button class="btn-withdraw">Lancer un retrait</button>
                            <button class="btn-history">Voir historique de retrait</button>
                        </div>
                    </div>
                </div>

                <div class="transactions-section">
                    <h3>ACHAT RÉCENTS</h3>
                    <div class="transactions-list" id="transactions-list">
                        <!-- Les transactions seront injectées ici via JavaScript -->
                    </div>
                </div>
            </section>

            <!-- container the settings element -->

            <section id="overlay">
                <button class="btn-overlay-retour">Retour</button>

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

                <!-- <form action="" id="add-forma">
                    <h2>Ajouter une nouvelle formation</h2>
                    <select name="forma-cate" id="forma-cate">
                        <option value="">Catégorie</option>
                    </select>
                    <button class="add-intro-video">
                            <div>Video Intro</div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-person-video3" viewBox="0 0 16 16">
                                <path d="M14 9.5a2 2 0 1 1-4 0 2 2 0 0 1 4 0m-6 5.7c0 .8.8.8.8.8h6.4s.8 0 .8-.8-.8-3.2-4-3.2-4 2.4-4 3.2"/>
                                <path d="M2 2a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h5.243c.122-.326.295-.668.526-1H2a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v7.81c.353.23.656.496.91.783Q16 12.312 16 12V4a2 2 0 0 0-2-2z"/>
                            </svg>

                    </button>
                    <button class="btn-img-couv">Image couverture</button>
                    <input type="file" name="forma-couverture">
                    <input type="file" id="video_intro" name="video_intro">
                    <input type="text" name="formation-name" placeholder="Nom de la formation">
                    <input type="number" name="formation-price" placeholder="Prix de la formation">
                    <label for="description">Description</label>
                    <textarea name="description" id="description"></textarea>
                    <button type="submit">Envoyer</button>
                </form> -->

                <div id="params">

                    <div class="param-head">
                        <div class="par-head-block1">
                            <h3>Paramètres</h3> 
                                <button class="btn-close-param">
                                <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-x" viewBox="0 0 16 16">
                                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
                                </svg>
                            </button>
                        </div>

                        <div class="par-head-block2">
                            <button class="btn-del-acc-return">
                                <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-chevron-left" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0"/>
                                </svg>
                                <h2>Supprimer le compte</h2>
                            </button>
                        </div>
                        
                    </div>

                    <div class="body">
                        <div class="btns">

                            <div class="info-perso">
                                <button class="btn-info-perso">Informations personnelles 
                                    <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-chevron-right" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708"/>
                                    </svg>
                                </button>

                                <form action="" method="POST" id="form-info-perso">
                                    <h4>Changez les champs que vous souhaitez modifer </h4>
                                    <div class="ctn-input">
                                        <label for="username" class="label-username">Modifier Nom et Prenom</label>
                                        <div class="ctn-username">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-person-fill" viewBox="0 0 16 16">
                                                <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/>
                                            </svg>
                                            <input type="text" id="username" name="username" value="">
                                        </div>
                                    </div>

                                    <div class="ctn-input" >
                                        <label for="email" class="label-email">Modifier adresse mail</label>
                                        <div class="ctn-email">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-envelope" viewBox="0 0 16 16">
                                                <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1zm13 2.383-4.708 2.825L15 11.105zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741M1 11.105l4.708-2.897L1 5.383z"/>
                                            </svg>
                                            <input type="email" id="email" name="email" value="">
                                        </div>
                                    </div>

                                    <div class="ctn-input">
                                        <label for="password" class="label-password">Nouveau mot de passe</label>
                                        <div class="ctn-password">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-lock" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M8 0a4 4 0 0 1 4 4v2.05a2.5 2.5 0 0 1 2 2.45v5a2.5 2.5 0 0 1-2.5 2.5h-7A2.5 2.5 0 0 1 2 13.5v-5a2.5 2.5 0 0 1 2-2.45V4a4 4 0 0 1 4-4M4.5 7A1.5 1.5 0 0 0 3 8.5v5A1.5 1.5 0 0 0 4.5 15h7a1.5 1.5 0 0 0 1.5-1.5v-5A1.5 1.5 0 0 0 11.5 7zM8 1a3 3 0 0 0-3 3v2h6V4a3 3 0 0 0-3-3"/>
                                            </svg>
                                            <input type="password" id="password" name="password" placeholder="Mot de passe">
                                        </div>
                                    </div>

                                    <button type="submit">Envoyer</button>
                                        
                                </form>

                            </div>
                                
                            <div class="ctn-dev-forma">
                                <button class="btn-dev-forma">Devenir formateur
                                    <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-chevron-right" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708"/>
                                    </svg>
                                </button>
                            </div>

                            <div class="ctn-del-acc">
                                <button class="btn-del-acc">Supprimer le compte
                                    <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-chevron-right" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708"/>
                                    </svg>
                                </button>
                            </div>

                        </div>

                        <div class="del-reasons">
                            <div class="del-reasons-content">
                                <div class="del-reasons-head">
                                    <h3>Oh! Pourquoi partir maintenant?</h3>
                                    <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Dolorem deleniti tempore dolores reiciendis repellendus odio dolor vel ab reprehenderit doloremque incidunt quaerat pariatur magni eaque esse illo, impedit provident! Error.</p>
                                </div>
                                
                                <form action="">
                                    <label for="reasons">Les raisons de votre départ</label>
                                    <textarea name="reasons" id="reasons"></textarea>
                                </form>
                            </div>
                            <div class="foot">
                                <button class="btn-del-cancel">Annuler</button>
                                <button class="btn-continue-del-acc">Continuer</button>
                            </div>
                        </div>

                    </div>


                </div>

                <!-- Create a formation -->
                 <div id="create-formation">

                    <div class="create-formation-head">
                        <h3>Créer une formation</h3>
                        <button class="btn-close-create-formation">
                            <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-x" viewBox="0 0 16 16">
                                <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
                            </svg>
                        </button>
                    </div>

                    <div class="create-formation-body">
                        <form action="">
                            <input type="file" name="formation-file" >
                            <div class="file-ctn">
                                <div class="ctn-svg">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-file-earmark-plus" viewBox="0 0 16 16">
                                        <path d="M8 6.5a.5.5 0 0 1 .5.5v1.5H10a.5.5 0 0 1 0 1H8.5V11a.5.5 0 0 1-1 0V9.5H6a.5.5 0 0 1 0-1h1.5V7a.5.5 0 0 1 .5-.5"/>
                                        <path d="M14 4.5V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h5.5zm-3 0A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5z"/>
                                    </svg>
                                    Glisser et déposer ici
                                </div>
                                <button class="btn-file">
                                    Choisir un fichier
                                </button>
                            </div>
                            <div class="input-ctn">
                                <label for="formation-name">Titre</label>
                                <input type="text" id="titre" name="titre" required>
                            </div>

                            <div class="input-ctn">
                                <select name="" id="">
                                </select>
                            </div>

                            <div class="input-ctn">
                                <label for="formation-name">Legende</label>
                                <input type="text" id="legende" name="legende" required>
                            </div>

                            <div class="input-ctn">
                                <label for="formation-name">Description</label>
                                <textarea name="description" id="description" required></textarea>
                            </div>

                            <div class="ctn-price">
                                Prix
                                <div class="btns">
                                    <button class="btn-pay">
                                    <input type="radio" id="gratuit" name="gratuit" value="gratuit">
                                        Gratuit
                                    </button>
                                    <button class="btn-pay"> 
                                        <input type="radio" id="payant" name="payant" value="payant">
                                        Payant
                                    </button>
                                </div>
                            </div>

                        </form>
                    </div>

                    <div class="formation-parts">
                        <button class="btn-add-part">Ajouter une partie</button>
                    </div>

                    <div class="create-formation-footer">
                        <button class="btn-cancel-create-formation">Annuler</button>
                        <button class="btn-submit-create-formation">Continuer</button>
                    </div>

                 </div>

                <!-- To delete the account  -->

                <div id="del-acc-msg">

                    <div class="del-acc-head">
                        <div class="ctn-svg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-exclamation-triangle" viewBox="0 0 16 16">
                                <path d="M7.938 2.016A.13.13 0 0 1 8.002 2a.13.13 0 0 1 .063.016.15.15 0 0 1 .054.057l6.857 11.667c.036.06.035.124.002.183a.2.2 0 0 1-.054.06.1.1 0 0 1-.066.017H1.146a.1.1 0 0 1-.066-.017.2.2 0 0 1-.054-.06.18.18 0 0 1 .002-.183L7.884 2.073a.15.15 0 0 1 .054-.057m1.044-.45a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767z"/>
                                <path d="M7.002 12a1 1 0 1 1 2 0 1 1 0 0 1-2 0M7.1 5.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0z"/>
                            </svg>
                        </div>
                        
                        <h3>Cette action est irréverssible. </h3>
                        <p>Cette action va supprimer votre compte, Confirmer avec votre mot de passe </p>
                    </div>
                    <form>
                        <label for="del-password">Mot de passe</label>
                        <input type="password" id="del-password" name="del-password" required>
                        <button type="submit" class="btn-del-acc-msg">Supprimer le compte</button>
                    </form>

                </div>

                <!-- To switch account  -->

                <div id="switch-acc">
                    <div class="switch-acc-head">
                        <h3>Vous rêvez de partager votre savoir</h3>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Maxime libero harum tenetur asperiores!</p>
                    </div>
                    <div class="switch-acc-advantages">
                        <h4>Avantages</h4>
                        <div class="advantage-item">
                            <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-check-circle" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                                <path d="m10.97 4.97-.02.022-3.473 4.425-2.093-2.094a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05"/>
                            </svg>
                            Publiez des cours
                        </div>
                        <div class="advantage-item">
                            <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-check-circle" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                                <path d="m10.97 4.97-.02.022-3.473 4.425-2.093-2.094a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05"/>
                            </svg>
                            Vendre des cours
                        </div>
                        <div class="advantage-item">
                            <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-check-circle" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                                <path d="m10.97 4.97-.02.022-3.473 4.425-2.093-2.094a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05"/>
                            </svg> 
                            Effectuez des retrais d'argent
                        </div>
                        <div class="advantage-item">
                            <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-check-circle" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                                <path d="m10.97 4.97-.02.022-3.473 4.425-2.093-2.094a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05"/>
                            </svg>
                            Être connu comme expert du domaine
                        </div>
                    </div>
                    <button class="switch-acc-btn-ctn">Continuer</button>
                </div>

                <!-- Confirmation of the account switching -->

                <div id="conf-acc-switch">
                    <div class="conf-switch-head">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle" viewBox="0 0 16 16">
                            <path d="M7.938 2.016A.13.13 0 0 1 8.002 2a.13.13 0 0 1 .063.016.15.15 0 0 1 .054.057l6.857 11.667c.036.06.035.124.002.183a.2.2 0 0 1-.054.06.1.1 0 0 1-.066.017H1.146a.1.1 0 0 1-.066-.017.2.2 0 0 1-.054-.06.18.18 0 0 1 .002-.183L7.884 2.073a.15.15 0 0 1 .054-.057m1.044-.45a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767z"/>
                            <path d="M7.002 12a1 1 0 1 1 2 0 1 1 0 0 1-2 0M7.1 5.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0z"/>
                        </svg>
                    </div>
                    <div class="conf-switch-body">
                        <h4>Cette action est irréversible</h4>
                        <p>Devenir formateur est une action irréversible. Vous découvrirez une nouvelle interface et de nouvelles fonctionnalitées</p>
                    </div>

                    <div class="conf-switch-foot">
                        <button class="btn-cancel-switch">Annuler</button>
                        <button class="btn-conf-switch">Continuer</button>
                    </div>
                </div>

                <div id="change-user-info">
                    <div class="change-info-head">
                        <h4>Cette action va changer vos inforamtion personnelles. Voulez-vous continuer?</h4>
                    </div>

                    <form action="">
                        <div class="ctn-old-pass">
                            <label for="actual-password">Mot de passe</label>
                            <div class="ctn-password">
                                <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-lock" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M8 0a4 4 0 0 1 4 4v2.05a2.5 2.5 0 0 1 2 2.45v5a2.5 2.5 0 0 1-2.5 2.5h-7A2.5 2.5 0 0 1 2 13.5v-5a2.5 2.5 0 0 1 2-2.45V4a4 4 0 0 1 4-4M4.5 7A1.5 1.5 0 0 0 3 8.5v5A1.5 1.5 0 0 0 4.5 15h7a1.5 1.5 0 0 0 1.5-1.5v-5A1.5 1.5 0 0 0 11.5 7zM8 1a3 3 0 0 0-3 3v2h6V4a3 3 0 0 0-3-3"/>
                                </svg>
                                <input type="password" id="actual-password" name="actual-password" placeholder="Mot de passe" required>
                            </div>
                        </div>
                        <button class="btn-change-info">Continuer</button>
                    </form>
                    
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

            <section id="retrait">

            </section>

            <section id="cour-en-vente">
                
            </section>
    </div>


@endsection