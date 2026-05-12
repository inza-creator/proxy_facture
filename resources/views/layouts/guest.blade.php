<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        @include('partials.favicon')

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            .auth-page-bg {
                background: linear-gradient(160deg, #e0f2fe 0%, #f0f9ff 35%, #e0e7ff 100%);
                min-height: 100vh;
            }
            .auth-form-card {
                background: rgba(240, 249, 255, 0.95);
                border: 1px solid rgba(147, 197, 253, 0.5);
                box-shadow: 0 25px 50px -12px rgba(59, 130, 246, 0.15);
            }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="auth-page-bg min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
            <div class="auth-form-card w-full sm:max-w-md px-6 py-5 overflow-hidden sm:rounded-2xl backdrop-blur-sm">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
