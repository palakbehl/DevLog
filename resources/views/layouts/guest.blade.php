<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-gray-50 dark:bg-zinc-950">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'DevLog') }}</title>

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="h-full text-gray-900 dark:text-zinc-100 antialiased flex flex-col items-center justify-center p-6">
    <div class="w-full max-w-md">
        <!-- Logo / Brand Header -->
        <div class="flex flex-col items-center mb-8">
            <a href="/" class="flex items-center gap-2.5">
                <span class="w-10 h-10 rounded-xl bg-indigo-600 flex items-center justify-center text-white font-extrabold text-xl shadow-md">D</span>
                <span class="font-extrabold text-2xl text-gray-900 dark:text-zinc-50 tracking-tight">DevLog</span>
            </a>
            <p class="text-sm text-gray-500 mt-2 dark:text-zinc-400">Minimalist Developer CMS</p>
        </div>

        <!-- Auth Card Container -->
        <x-card class="shadow-md">
            {{ $slot }}
        </x-card>
    </div>
</body>
</html>
