@extends('layouts.app')

@section('content')
<div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
    <!-- Theme Toggle Button -->
    <div class="absolute top-6 right-6">
        <button onclick="toggleTheme()" class="p-2 rounded-full bg-white/80 dark:bg-gray-800/80 shadow-lg hover:shadow-xl transition-all duration-300 backdrop-blur-sm">
            <svg class="w-5 h-5 text-orange-600 dark:text-yellow-400 hidden dark:block" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 2.25a.75.75 0 01.75.75v2.25a.75.75 0 01-1.5 0V3a.75.75 0 01.75-.75zM7.5 12a4.5 4.5 0 119 0 4.5 4.5 0 01-9 0zM18.894 6.166a.75.75 0 00-1.06-1.06l-1.591 1.59a.75.75 0 101.06 1.061l1.591-1.59zM21.75 12a.75.75 0 01-.75.75h-2.25a.75.75 0 010-1.5H21a.75.75 0 01.75.75zM17.834 18.894a.75.75 0 001.06-1.06l-1.59-1.591a.75.75 0 10-1.061 1.06l1.59 1.591zM12 18a.75.75 0 01.75.75V21a.75.75 0 01-1.5 0v-2.25A.75.75 0 0112 18zM7.758 17.303a.75.75 0 00-1.061-1.06l-1.591 1.59a.75.75 0 001.06 1.061l1.591-1.59zM6 12a.75.75 0 01-.75.75H3a.75.75 0 010-1.5h2.25A.75.75 0 016 12zM6.697 7.757a.75.75 0 001.06-1.06l-1.59-1.591a.75.75 0 00-1.061 1.06l1.59 1.591z" />
            </svg>
            <svg class="w-5 h-5 text-orange-600 dark:text-yellow-400 block dark:hidden" fill="currentColor" viewBox="0 0 24 24">
                <path fill-rule="evenodd" d="M9.528 1.718a.75.75 0 01.162.819A8.97 8.97 0 009 6a9 9 0 009 9 8.97 8.97 0 003.463-.69.75.75 0 01.981.98 10.503 10.503 0 01-9.694 6.46c-5.799 0-10.5-4.701-10.5-10.5 0-4.368 2.667-8.112 6.46-9.694a.75.75 0 01.818.162z" clip-rule="evenodd" />
            </svg>
        </button>
    </div>

    <div class="sm:mx-auto sm:w-full sm:max-w-sm">
        <!-- Logo/Icon -->
        <div class="mx-auto h-16 w-16 bg-gradient-to-br from-orange-400 to-yellow-500 rounded-2xl shadow-lg flex items-center justify-center mb-8">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
            </svg>
        </div>
        
        <h2 class="text-center text-3xl font-bold leading-9 tracking-tight text-gray-900 dark:text-white">
            Connexion
        </h2>
        <p class="mt-2 text-center text-sm text-gray-600 dark:text-gray-400">
            Accédez à votre espace de formation
        </p>
    </div>

    <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
        <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-3xl shadow-xl p-8 border border-orange-100 dark:border-gray-700">
            <form class="space-y-6" action="{{ route('login') }}" method="POST">
                @csrf
                
                <!-- Email Field -->
                <div>
                    <label for="email" class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">
                        Email
                    </label>
                    <div class="mt-2">
                        <input id="email" name="email" type="email" autocomplete="email" required 
                            value="{{ old('email') }}"
                            class="block w-full rounded-2xl border-0 py-3 px-4 text-gray-900 shadow-md ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-orange-500 dark:bg-gray-700 dark:text-white dark:ring-gray-600 dark:focus:ring-yellow-400 sm:text-sm sm:leading-6 transition-all duration-300" 
                            placeholder="votre@email.com">
                    </div>
                    @error('email')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Field -->
                <div>
                    <label for="password" class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">
                        Mot de passe
                    </label>
                    <div class="mt-2">
                        <input id="password" name="password" type="password" autocomplete="current-password" required 
                            class="block w-full rounded-2xl border-0 py-3 px-4 text-gray-900 shadow-md ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-orange-500 dark:bg-gray-700 dark:text-white dark:ring-gray-600 dark:focus:ring-yellow-400 sm:text-sm sm:leading-6 transition-all duration-300" 
                            placeholder="••••••••">
                    </div>
                    @error('password')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember" name="remember" type="checkbox" 
                            class="h-4 w-4 rounded border-gray-300 text-orange-600 focus:ring-orange-500 dark:border-gray-600 dark:bg-gray-700 dark:focus:ring-yellow-400">
                        <label for="remember" class="ml-2 block text-sm text-gray-900 dark:text-gray-300">
                            Se souvenir de moi
                        </label>
                    </div>
                    <div class="text-sm">
                        <a href="#" class="font-medium text-orange-600 hover:text-orange-500 dark:text-yellow-400 dark:hover:text-yellow-300 transition-colors">
                            Mot de passe oublié ?
                        </a>
                    </div>
                </div>

                <!-- Submit Button -->
                <div>
                    <button type="submit" 
                        class="flex w-full justify-center rounded-2xl bg-gradient-to-r from-orange-500 to-yellow-500 px-4 py-3 text-sm font-semibold leading-6 text-white shadow-lg hover:shadow-xl hover:from-orange-600 hover:to-yellow-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-orange-600 transition-all duration-300 transform hover:scale-[1.02]">
                        Se connecter
                    </button>
                </div>
            </form>

            <!-- Demo Credentials -->
            <div class="mt-6 p-4 bg-orange-50 dark:bg-gray-700/50 rounded-2xl">
                <p class="text-xs text-gray-600 dark:text-gray-400 text-center">
                    <span class="font-medium">Démo:</span> email: test@example.com / mot de passe: password
                </p>
            </div>
        </div>
    </div>
</div>
@endsection 