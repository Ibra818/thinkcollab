@extends('layouts.app')

@section('content')
<div class="flex h-screen bg-gray-900 overflow-hidden">
    <!-- Left Sidebar - Navigation -->
    <div class="w-80 bg-gray-900 flex flex-col">
        <!-- Logo -->
        <div class="p-6 border-b border-gray-800">
            <div class="flex items-center">
                <div class="h-10 w-10 bg-gradient-to-br from-orange-400 to-yellow-500 rounded-xl shadow-lg flex items-center justify-center">
                    <span class="text-white font-bold text-lg">B</span>
                </div>
                <div class="ml-3">
                    <h1 class="text-white font-bold text-xl">Bint</h1>
                    <p class="text-gray-400 text-sm">School</p>
                </div>
            </div>
        </div>

        <!-- Menu Section -->
        <div class="p-6">
            <div class="mb-6">
                <h3 class="text-orange-400 text-xs font-semibold uppercase tracking-wide mb-4">MENU</h3>
                <nav class="space-y-2">
                    <a href="#" class="flex items-center px-4 py-3 text-white bg-orange-600 rounded-lg">
                        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-9 9a1 1 0 001.414 1.414L2 12.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-4.586l.293.293a1 1 0 001.414-1.414l-9-9z"/>
                        </svg>
                        Pour toi
                    </a>
                    <a href="#" class="flex items-center px-4 py-3 text-gray-400 hover:text-white hover:bg-gray-800 rounded-lg transition-colors">
                        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                        </svg>
                        Mon profil
                    </a>
                    <a href="#" class="flex items-center px-4 py-3 text-gray-400 hover:text-white hover:bg-gray-800 rounded-lg transition-colors">
                        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                        </svg>
                        Messagerie
                    </a>
                    <a href="#" class="flex items-center px-4 py-3 text-gray-400 hover:text-white hover:bg-gray-800 rounded-lg transition-colors">
                        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"/>
                        </svg>
                        Formations suivies
                    </a>
                </nav>
            </div>
        </div>

        <!-- Categories Section -->
        <div class="flex-1 px-6 pb-6 overflow-y-auto custom-scrollbar">
            <h3 class="text-orange-400 text-xs font-semibold uppercase tracking-wide mb-4">CATÉGORIES</h3>
            <nav class="space-y-1">
                <a href="#" class="block py-2 px-4 text-orange-400 bg-gray-800 rounded-lg text-sm">
                    📚 Toutes les catégories
                </a>
                <a href="#" class="block py-2 px-4 text-gray-400 hover:text-white hover:bg-gray-800 rounded-lg text-sm transition-colors">
                    🏗️ Construction
                </a>
                <a href="#" class="block py-2 px-4 text-gray-400 hover:text-white hover:bg-gray-800 rounded-lg text-sm transition-colors">
                    🎨 Digital Artwork
                </a>
                <a href="#" class="block py-2 px-4 text-gray-400 hover:text-white hover:bg-gray-800 rounded-lg text-sm transition-colors">
                    💼 Personal branding
                </a>
                <a href="#" class="block py-2 px-4 text-gray-400 hover:text-white hover:bg-gray-800 rounded-lg text-sm transition-colors">
                    🎯 User Experience
                </a>
                <a href="#" class="block py-2 px-4 text-gray-400 hover:text-white hover:bg-gray-800 rounded-lg text-sm transition-colors">
                    📊 Market Research
                </a>
                <a href="#" class="block py-2 px-4 text-gray-400 hover:text-white hover:bg-gray-800 rounded-lg text-sm transition-colors">
                    📈 Content Strategy
                </a>
                <a href="#" class="block py-2 px-4 text-gray-400 hover:text-white hover:bg-gray-800 rounded-lg text-sm transition-colors">
                    📱 Digital Marketing
                </a>
                <a href="#" class="block py-2 px-4 text-gray-400 hover:text-white hover:bg-gray-800 rounded-lg text-sm transition-colors">
                    🔍 SEO Optimization
                </a>
                <a href="#" class="block py-2 px-4 text-gray-400 hover:text-white hover:bg-gray-800 rounded-lg text-sm transition-colors">
                    📲 Social Media Management
                </a>
                <a href="#" class="block py-2 px-4 text-gray-400 hover:text-white hover:bg-gray-800 rounded-lg text-sm transition-colors">
                    🎪 Brand Strategy
                </a>
                <a href="#" class="block py-2 px-4 text-gray-400 hover:text-white hover:bg-gray-800 rounded-lg text-sm transition-colors">
                    💻 Web Development
                </a>
                <a href="#" class="block py-2 px-4 text-gray-400 hover:text-white hover:bg-gray-800 rounded-lg text-sm transition-colors">
                    🎨 Graphic Design
                </a>
                <a href="#" class="block py-2 px-4 text-gray-400 hover:text-white hover:bg-gray-800 rounded-lg text-sm transition-colors">
                    ✉️ Email Marketing
                </a>
                <a href="#" class="block py-2 px-4 text-gray-400 hover:text-white hover:bg-gray-800 rounded-lg text-sm transition-colors">
                    📊 Data Analysis
                </a>
                <a href="#" class="block py-2 px-4 text-gray-400 hover:text-white hover:bg-gray-800 rounded-lg text-sm transition-colors">
                    🛒 E-commerce Solutions
                </a>
                <a href="#" class="block py-2 px-4 text-gray-400 hover:text-white hover:bg-gray-800 rounded-lg text-sm transition-colors">
                    🎉 Event Planning
                </a>
                <a href="#" class="block py-2 px-4 text-gray-400 hover:text-white hover:bg-gray-800 rounded-lg text-sm transition-colors">
                    👥 Influencer Marketing
                </a>
                <a href="#" class="block py-2 px-4 text-gray-400 hover:text-white hover:bg-gray-800 rounded-lg text-sm transition-colors">
                    🗺️ Customer Journey Mapping
                </a>
                <a href="#" class="block py-2 px-4 text-gray-400 hover:text-white hover:bg-gray-800 rounded-lg text-sm transition-colors">
                    🧪 A/B Testing
                </a>
            </nav>
        </div>

        <!-- Logout -->
        <div class="p-6 border-t border-gray-800">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="flex items-center px-4 py-3 text-gray-400 hover:text-white hover:bg-gray-800 rounded-lg transition-colors w-full">
                    <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z" clip-rule="evenodd"/>
                    </svg>
                    Déconnexion
                </button>
            </form>
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="flex-1 flex">
        <!-- Central Feed -->
        <div class="flex-1 bg-gray-800 overflow-y-auto custom-scrollbar">
            <!-- Main Featured Post -->
            <div class="relative">
                <!-- Hero Image/Video -->
                <div class="relative h-96 bg-gradient-to-r from-orange-600 to-yellow-500 overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80" 
                         alt="Formation" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-black bg-opacity-20"></div>
                </div>

                <!-- Post Content Overlay -->
                <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black to-transparent p-6">
                    <div class="bg-gray-900 bg-opacity-90 backdrop-blur-sm rounded-2xl p-6 border border-purple-500">
                        <!-- User Info -->
                        <div class="flex items-center mb-4">
                            <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=100&q=80" 
                                 alt="Jean Marc Krebe" class="w-12 h-12 rounded-full">
                            <div class="ml-3">
                                <div class="flex items-center">
                                    <h4 class="text-white font-semibold">Jean Marc Krebe</h4>
                                    <button class="ml-3 px-3 py-1 bg-gray-600 text-white text-sm rounded-full hover:bg-gray-500 transition-colors">
                                        + Suivre
                                    </button>
                                </div>
                                <p class="text-gray-400 text-sm">26 Jan • 18H00</p>
                            </div>
                        </div>

                        <!-- Post Text -->
                        <p class="text-gray-300 mb-4">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                        </p>

                        <!-- Post Actions -->
                        <div class="flex items-center space-x-6">
                            <button class="flex items-center text-gray-400 hover:text-red-500 transition-colors">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                                </svg>
                                <span>1</span>
                            </button>
                            <button class="flex items-center text-gray-400 hover:text-blue-500 transition-colors">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd"/>
                                </svg>
                                <span>1</span>
                            </button>
                            <button class="flex items-center text-gray-400 hover:text-green-500 transition-colors">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M15 8a3 3 0 10-2.977-2.63l-4.94 2.47a3 3 0 100 4.319l4.94 2.47a3 3 0 10.895-1.789l-4.94-2.47a3.027 3.027 0 000-.74l4.94-2.47C13.456 7.68 14.19 8 15 8z"/>
                                </svg>
                                <span>1</span>
                            </button>
                        </div>
                    </div>

                    <!-- Comment Input -->
                    <div class="mt-4 bg-gray-900 bg-opacity-90 backdrop-blur-sm rounded-2xl p-4">
                        <div class="flex space-x-3">
                            <img src="https://images.unsplash.com/photo-1633332755192-727a05c4013d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=100&q=80" 
                                 alt="You" class="w-8 h-8 rounded-full">
                            <div class="flex-1 flex">
                                <input type="text" placeholder="Lorem ipsum dolor sit amet, consectetur ..." 
                                       class="flex-1 bg-transparent text-gray-300 placeholder-gray-500 border-none outline-none">
                                <button class="ml-3 px-4 py-2 bg-orange-500 text-white text-sm rounded-full hover:bg-orange-600 transition-colors">
                                    En savoir +
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Additional Posts -->
            <div class="p-6 space-y-6">
                @for($i = 0; $i < 3; $i++)
                <div class="bg-gray-900 rounded-2xl p-6 border border-gray-700">
                    <div class="flex items-center mb-4">
                        <img src="https://images.unsplash.com/photo-1{{ 500 + $i }}99645785-5658abf4ff4e?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80" 
                             alt="User" class="w-10 h-10 rounded-full">
                        <div class="ml-3">
                            <h4 class="text-white font-semibold">Formateur {{ ['Marie', 'Paul', 'Sophie'][$i] }}</h4>
                            <p class="text-gray-400 text-sm">Il y a {{ [2, 5, 8][$i] }} heures</p>
                        </div>
                    </div>
                    <p class="text-gray-300 mb-4">
                        Découvrez les dernières techniques en {{ ['développement web', 'design UI/UX', 'marketing digital'][$i] }}. 
                        Un cours complet pour maîtriser tous les aspects...
                    </p>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <button class="text-gray-400 hover:text-red-500 transition-colors">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                                </svg>
                            </button>
                            <button class="text-gray-400 hover:text-blue-500 transition-colors">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7z" clip-rule="evenodd"/>
                                </svg>
                            </button>
                        </div>
                        <button class="px-4 py-2 bg-orange-500 text-white text-sm rounded-full hover:bg-orange-600 transition-colors">
                            Voir le cours
                        </button>
                    </div>
                </div>
                @endfor
            </div>
        </div>

        <!-- Right Sidebar - Videos -->
        <div class="w-80 bg-gray-900 border-l border-gray-800 overflow-y-auto custom-scrollbar">
            <!-- Search Bar -->
            <div class="p-4 border-b border-gray-800">
                <div class="relative">
                    <input type="text" placeholder="Rechercher" 
                           class="w-full bg-gray-700 text-white placeholder-gray-400 rounded-full py-2 px-4 pr-10 focus:outline-none focus:ring-2 focus:ring-orange-500">
                    <button class="absolute right-2 top-1/2 transform -translate-y-1/2 px-3 py-1 bg-orange-500 text-white text-xs rounded-full hover:bg-orange-600 transition-colors">
                        Rechercher
                    </button>
                </div>
            </div>

            <!-- Video Grid -->
            <div class="p-4">
                <div class="grid grid-cols-2 gap-3">
                    @for($i = 0; $i < 8; $i++)
                    <div class="relative group cursor-pointer">
                        <div class="aspect-video bg-gray-700 rounded-lg overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1{{ 1520 + $i }}99645785-5658abf4ff4e?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&q=80" 
                                 alt="Video" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 transition-all duration-300 flex items-center justify-center">
                                <button class="w-12 h-12 bg-white bg-opacity-90 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transform scale-75 group-hover:scale-100 transition-all duration-300">
                                    <svg class="w-6 h-6 text-gray-900 ml-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M6.3 2.841A1.5 1.5 0 004 4.11v11.78a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <h4 class="text-white text-sm mt-2 line-clamp-2">{{ ['Formation Laravel', 'Design Systems', 'Marketing Digital', 'UI/UX Avancé', 'React Native', 'Python Data', 'Vue.js Pro', 'Node.js Master'][$i] }}</h4>
                        <p class="text-gray-400 text-xs">{{ [45, 32, 28, 67, 23, 89, 12, 56][$i] }} min</p>
                    </div>
                    @endfor
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 