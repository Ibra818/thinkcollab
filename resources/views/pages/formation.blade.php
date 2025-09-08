@extends('index')
<link rel="stylesheet" href="{{ asset('css/formation.css') }}">

<script>
    document.addEventListener('DOMContentLoaded', ()=>{

        const content= document.querySelector('.formation .content');
        const playingVideo = document.querySelector('.formation .content .video video');
        const token = localStorage.getItem('token');
        const apiUrl= 'http://localhost:8000/';
        const apiStorage= 'http://localhost:8000/storage';

        const segments= window.location.pathname.split('/');
        const id = segments.pop();

        const dureeText = document.querySelector('.progression .duree');
        const progressBar = document.querySelector('.progression .progress-bar');
        const playPauseBtn = document.querySelector('.progression button');

        // Ajout d’une propriété utilitaire "playing" pour les vidéos
        Object.defineProperty(HTMLMediaElement.prototype, 'playing', {
            get: function(){
                return !!(this.currentTime > 0 && !this.paused && !this.ended && this.readyState > 2);
            }
        });

        // Fonction utilitaire pour formater en mm:ss
        function formatTime(seconds) {
            const minutes = Math.floor(seconds / 60);
            const secs = Math.floor(seconds % 60);
            return `${minutes}:${secs.toString().padStart(2, '0')}`;
        }

        // Quand les métadonnées de la vidéo sont chargées
        playingVideo.addEventListener('loadedmetadata', () => {
            const total = formatTime(playingVideo.duration);
            dureeText.textContent = `0:00 / ${total}`;
        });

        // Pendant la lecture -> mettre à jour la durée et la barre
        playingVideo.addEventListener('timeupdate', () => {
            const current = formatTime(playingVideo.currentTime);
            const total = formatTime(playingVideo.duration);

            dureeText.textContent = `${current} / ${total}`;

            const percent = (playingVideo.currentTime / playingVideo.duration) * 100;
            progressBar.style.background = `linear-gradient(to right, white ${percent}%, gray ${100 - percent}%)`;
        });

        // Barre cliquable pour naviguer
        progressBar.addEventListener('click', (e) => {
            const rect = progressBar.getBoundingClientRect();
            const percent = (e.clientX - rect.left) / rect.width;
            playingVideo.currentTime = percent * playingVideo.duration;
        });

        // Bouton play/pause
        playPauseBtn.addEventListener('click', () => {
            if (playingVideo.paused) {
                playingVideo.play();
            } else {
                playingVideo.pause();
            }
        });

        // Variables globales pour la gestion des vidéos
        let stopAllPreviewVideos;
        let currentSyncHandler = null;
        let currentActiveModule = null;

        // Récupérer les infos de la formation
        $.ajax({
            url: apiUrl+ `formations/${id}`,
            type: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'Authorization': `Bearer ${token}`,
            },
            success: function(response){
                content.querySelector('.video video').poster= apiStorage + response.formation.image_couverture;
                content.querySelector('.categorie').innerText= response.formation.categorie.nom;
                content.querySelector('.name-forma').innerText= response.formation.titre;
                content.querySelector('.formateur h4').innerText= response.formation.formateur.name;
                content.querySelector('.formateur .specialite').innerText= response.formation.formateur.bio;
                content.querySelector('.formateur img').src= response.formation.formateur.avatar_url ? apiStorage + response.formation.formateur.avatar_url : " data:image/jpeg;base64,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";
            },
            error: function(erreurs){
                console.log('formation-errors: ', erreurs);
            },
        });

        // Récupérer les vidéos de la formation
        $.ajax({
            url: apiUrl+ `formations/${id}/videos`,
            type: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'Authorization': `Bearer ${token}`,
            },
            success: function(response){

                const coursContainer = content.querySelector('.cours');
                const template = document.querySelector('#cour-template');

                response.forEach((element, index) =>{
                    const courItem = template.content.cloneNode(true);
                    courItem.querySelector('.video video').preload = 'metadata';
                    courItem.querySelector('.video video').onloadedmetadata = () => {
                        const total = formatTime(courItem.querySelector('.video video').duration);
                        total= Math.floor(total)/60;
                        courItem.querySelector('.module-last').innerText = `${total} min`;
                    };

                    courItem.querySelector('.video video source').src= apiStorage+element.url_video;
                    courItem.querySelector('.module').innerText= element.titre;

                    // const minutes = Math.floor(element.duree / 60);
                    // const secondes = element.duree % 60;
                    // courItem.querySelector('.module-last').innerText = `${minutes} min ${secondes}s`;

                    coursContainer.appendChild(courItem);

                    // Charger automatiquement la 1ère vidéo
                    if(index === 0){
                        playingVideo.querySelector('source').src = apiStorage+ element.url_video;
                        playingVideo.load();
                    }
                });

                // Fonction pour arrêter toutes les vidéos miniatures
                stopAllPreviewVideos = function() {
                    coursContainer.querySelectorAll('.cour .video video').forEach(video => {
                        if (!video.paused) {
                            video.pause();
                            video.currentTime = 0;
                        }
                    });
                };

                // Fonction pour arrêter la vidéo principale si elle joue
                function stopMainVideo() {
                    if (!playingVideo.paused) {
                        playingVideo.pause();
                    }
                }

                // Ajouter les événements après injection
                coursContainer.querySelectorAll('.cour').forEach(courItem => {
                    courItem.addEventListener('click', (e)=>{
                        // Arrêter toutes les vidéos miniatures
                        stopAllPreviewVideos();
                        
                        // Retirer la classe active de tous les modules
                        document.querySelectorAll('.formation .content .cours .cour.active')
                            .forEach(active => active.classList.remove('active'));
                        
                        // Ajouter la classe active au module cliqué (animation bordure orange)
                        e.currentTarget.classList.add('active');
                        
                        // Récupérer la source vidéo du module cliqué
                        const videoSrc = courItem.querySelector('.video video source').src;
                        const moduleVideo = courItem.querySelector('.video video');
                        
                        // Jouer sur la vidéo principale
                        playingVideo.querySelector('source').src = videoSrc;
                        playingVideo.load();
                        playingVideo.play();
                        playingVideo.muted = false;
                        
                        // Nettoyer les anciens event listeners si ils existent
                        if (currentSyncHandler) {
                            playingVideo.removeEventListener('timeupdate', currentSyncHandler);
                        }
                        
                        // Stocker la référence du module actuel
                        currentActiveModule = moduleVideo;
                        
                        // Jouer aussi sur la miniature mais en muet
                        moduleVideo.currentTime = 0;
                        moduleVideo.muted = true;
                        moduleVideo.play();
                        
                        // Créer la fonction de synchronisation pour ce module
                        currentSyncHandler = () => {
                            if (currentActiveModule === moduleVideo && !moduleVideo.paused && !playingVideo.paused) {
                                if (Math.abs(playingVideo.currentTime - moduleVideo.currentTime) > 0.5) {
                                    moduleVideo.currentTime = playingVideo.currentTime;
                                }
                            }
                        };
                        
                        // Ajouter la synchronisation
                        playingVideo.addEventListener('timeupdate', currentSyncHandler);
                        
                        // Synchroniser pause/play uniquement pour le module actif
                        const pauseHandler = () => {
                            if (currentActiveModule === moduleVideo && !moduleVideo.paused) {
                                moduleVideo.pause();
                            }
                        };
                        
                        const playHandler = () => {
                            if (currentActiveModule === moduleVideo && moduleVideo.paused) {
                                moduleVideo.currentTime = playingVideo.currentTime;
                                moduleVideo.play();
                            }
                        };
                        
                        // Nettoyer les anciens handlers et ajouter les nouveaux
                        playingVideo.removeEventListener('pause', pauseHandler);
                        playingVideo.removeEventListener('play', playHandler);
                        playingVideo.addEventListener('pause', pauseHandler);
                        playingVideo.addEventListener('play', playHandler);
                    });

                    const previewVideo = courItem.querySelector('.video video');
                    // Rendre les miniatures muettes par défaut
                    previewVideo.muted = true;
                    
                    previewVideo.addEventListener('click', (e)=>{
                        e.stopPropagation(); // Empêcher le clic de déclencher l'événement du parent
                        
                        if(e.currentTarget.playing){
                            e.currentTarget.pause();
                        } else {
                            // Arrêter toutes les autres vidéos miniatures avant de jouer
                            stopAllPreviewVideos();
                            
                            e.currentTarget.play();
                            // Garder les miniatures muettes
                            e.currentTarget.muted = true;
                        }
                    });

                    // Ajouter un événement pour arrêter automatiquement les autres vidéos miniatures
                    previewVideo.addEventListener('play', (e) => {
                        // Arrêter toutes les autres vidéos miniatures
                        coursContainer.querySelectorAll('.cour .video video').forEach(video => {
                            if (video !== e.currentTarget && !video.paused) {
                                video.pause();
                                video.currentTime = 0;
                            }
                        });
                    });

                    // Optionnel : Arrêter la vidéo quand elle se termine
                    previewVideo.addEventListener('ended', (e) => {
                        e.currentTarget.currentTime = 0;
                    });
                });

            },
            error: function(erreurs){
                console.log('formation-detail-errors: ', erreurs);
            },
        });

    });
</script>

@section('content')
<section class="formation">

    <div class="content">
        <div class="video">
            <video poster="#">
                <source src="#" type="video/mp4">
            </video>
            <div class="progression">
                <button>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pause-fill" viewBox="0 0 16 16">
                        <path d="M5.5 3.5A1.5 1.5 0 0 1 7 5v6a1.5 1.5 0 0 1-3 0V5a1.5 1.5 0 0 1 1.5-1.5m5 0A1.5 1.5 0 0 1 12 5v6a1.5 1.5 0 0 1-3 0V5a1.5 1.5 0 0 1 1.5-1.5"/>
                    </svg>
                </button>
                <div class="progress-bar"></div>
                <div class="duree">0:00</div>
            </div>
        </div>

        <div class="categorie"></div>
        <h3 class="name-forma"></h3>
        <div class="formateur">
            <div class="info">
                <img src="#" alt="">
                <div class="profil">
                    <h4 class="username"></h4>
                    <div class="specialite"> </div>
                </div>
            </div>
            <button class="visite">
                <svg xmlns="http://www.w3.org/2000/svg"class="bi bi-eye-fill" viewBox="0 0 16 16">
                    <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0"/>
                    <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8m8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7"/>
                </svg>
                Visiter
            </button>
        </div>

        <div class="cours"></div>
    </div>

</section>

{{-- Template pour les cours --}}
<template id="cour-template">
    <div class="cour">
        <div class="video">
            <video poster="#">
                <source src="#" type="video/mp4">
            </video>

            <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-play-fill" viewBox="0 0 16 16">
                <path d="m11.596 8.697-6.363 3.692c-.54.313-1.233-.066-1.233-.697V4.308c0-.63.692-1.01 1.233-.696l6.363 3.692a.802.802 0 0 1 0 1.393"/>
            </svg>

            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pause-fill" viewBox="0 0 16 16">
                <path d="M5.5 3.5A1.5 1.5 0 0 1 7 5v6a1.5 1.5 0 0 1-3 0V5a1.5 1.5 0 0 1 1.5-1.5m5 0A1.5 1.5 0 0 1 12 5v6a1.5 1.5 0 0 1-3 0V5a1.5 1.5 0 0 1 1.5-1.5"/>
            </svg>
        </div>

        <div class="module">
            Module
            <div class="modul-progress">0%</div>
        </div>

        <div class="module-last">0:00</div>
    </div>
</template>
@endsection
