<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased relative bg-slate-900 overflow-hidden">
        <!-- Dynamic Gradient Background -->
        <div class="absolute inset-0 z-0">
            <div class="absolute top-0 -left-4 w-72 h-72 bg-purple-500 rounded-full mix-blend-multiply filter blur-2xl opacity-50 animate-blob"></div>
            <div class="absolute top-0 -right-4 w-72 h-72 bg-blue-500 rounded-full mix-blend-multiply filter blur-2xl opacity-50 animate-blob animation-delay-2000"></div>
            <div class="absolute -bottom-8 left-20 w-72 h-72 bg-indigo-500 rounded-full mix-blend-multiply filter blur-2xl opacity-50 animate-blob animation-delay-4000"></div>
        </div>

        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 relative z-10">
            <div>
                <a href="/">
                    <x-application-logo class="w-24 h-24 fill-current text-white drop-shadow-lg" />
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-8 px-8 py-8 bg-white/10 backdrop-blur-xl border border-white/20 shadow-[0_8px_32px_0_rgba(31,38,135,0.37)] sm:rounded-2xl text-white">
                {{ $slot }}
            </div>
        </div>
        
        <style>
            @keyframes blob {
                0% { transform: translate(0px, 0px) scale(1); }
                33% { transform: translate(30px, -50px) scale(1.1); }
                66% { transform: translate(-20px, 20px) scale(0.9); }
                100% { transform: translate(0px, 0px) scale(1); }
            }
            .animate-blob { animation: blob 7s infinite; }
            .animation-delay-2000 { animation-delay: 2s; }
            .animation-delay-4000 { animation-delay: 4s; }
            
            /* Overriding some default Breeze input text colors to fit the dark theme */
            input, select, textarea {
                background-color: rgba(255, 255, 255, 0.05) !important;
                border-color: rgba(255, 255, 255, 0.1) !important;
                color: white !important;
            }
            input:focus, select:focus, textarea:focus {
                border-color: #a855f7 !important;
                box-shadow: 0 0 0 1px #a855f7 !important;
            }
            label {
                color: rgba(255, 255, 255, 0.8) !important;
            }
            .text-gray-600, .text-gray-500 {
                color: rgba(255, 255, 255, 0.6) !important;
            }
            .text-gray-900 {
                color: white !important;
            }
        </style>
    </body>
</html>
