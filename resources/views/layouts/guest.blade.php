<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Connexion CRM</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            .bg-crm {
                background-image: url("{{ asset('images/zoo.jpg') }}");
                background-size: cover;
                background-position: center;
                background-repeat: no-repeat;
                background-attachment: fixed;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 20px; /* Espace pour mobile */
            }

            /* Couleur et style du fond du formulaire */
            .form-card {
                /* Changez ici la couleur : rgba(R, G, B, Opacité) */
                background-color: rgba(255, 255, 255, 0.9) !important; 
                backdrop-filter: blur(10px); /* Effet de flou derrière le formulaire */
                border: 1px solid rgba(255, 255, 255, 0.2);
            }

            /* Adaptation pour le mode sombre si nécessaire */
            @media (prefers-color-scheme: dark) {
                .form-card {
                    background-color: rgba(31, 41, 55, 0.9) !important;
                }
            }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased">
        
        <div class="min-h-screen bg-crm">
            
            <!-- Conteneur responsive -->
            <div class="w-full max-w-md mx-auto">
                
                <!-- Logo -->
                <div class="flex justify-center mb-6">
                    <a href="/">
                        <h1 class="text-white text-4xl font-extrabold tracking-tight drop-shadow-lg">
                            MON CRM
                        </h1>
                    </a>
                </div>

                <!-- Carte de connexion responsive -->
                <div class="form-card w-full px-8 py-10 shadow-2xl rounded-2xl overflow-hidden">
                    {{ $slot }}
                </div>

                <!-- Footer optionnel -->
                <p class="text-center text-white text-sm mt-6 drop-shadow-md">
                    &copy; {{ date('Y') }} - Tous droits réservés
                </p>
            </div>
        </div>

    </body>
</html>