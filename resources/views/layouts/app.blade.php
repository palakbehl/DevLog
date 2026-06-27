<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-gray-50 dark:bg-zinc-950">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'DevLog') }} - Dashboard</title>

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
<body class="h-full text-gray-900 dark:text-zinc-100 antialiased flex flex-col md:flex-row" x-data="{ sidebarOpen: false }">

    <!-- Mobile Top Header / Navigation -->
    <header class="flex items-center justify-between px-6 py-4 bg-white dark:bg-zinc-900 border-b border-gray-200 dark:border-zinc-800 md:hidden w-full shrink-0">
        <div class="flex items-center gap-3">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                <span class="w-8 h-8 rounded-lg bg-indigo-600 flex items-center justify-center text-white font-bold text-lg shadow-sm">D</span>
                <span class="font-bold text-lg text-gray-900 dark:text-zinc-50 tracking-tight">DevLog</span>
            </a>
            <span class="text-[9px] font-bold text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-950/40 border border-indigo-100 dark:border-indigo-900/30 px-1.5 py-0.5 rounded-md uppercase tracking-wider">
                {{ auth()->user()->role === 'admin' ? 'Admin' : 'Author' }}
            </span>
        </div>
        <button @click="sidebarOpen = true" class="text-gray-500 hover:text-gray-700 dark:text-zinc-400 dark:hover:text-zinc-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 rounded-lg p-1.5 cursor-pointer">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>
    </header>

    <!-- Sidebar Drawer (Mobile Overlay) -->
    <div x-show="sidebarOpen" class="relative z-50 md:hidden" role="dialog" aria-modal="true" style="display: none;">
        <!-- Backdrop -->
        <div x-show="sidebarOpen" 
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="sidebarOpen = false" 
             class="fixed inset-0 bg-gray-900/80 backdrop-blur-xs"></div>

        <div class="fixed inset-0 flex">
            <!-- Sidebar Panel -->
            <div x-show="sidebarOpen"
                 x-transition:enter="transition ease-in-out duration-300 transform"
                 x-transition:enter-start="-translate-x-full"
                 x-transition:enter-end="translate-y-0"
                 x-transition:leave="transition ease-in-out duration-300 transform"
                 x-transition:leave-start="translate-y-0"
                 x-transition:leave-end="-translate-x-full"
                 class="relative mr-16 flex w-full max-w-xs flex-1 flex-col bg-white dark:bg-zinc-900 pt-5 pb-4 border-r border-gray-200 dark:border-zinc-800">
                
                <div class="absolute top-0 right-0 -mr-12 pt-2">
                    <button @click="sidebarOpen = false" class="ml-1 flex h-10 w-10 items-center justify-center rounded-full focus:outline-none focus:ring-2 focus:ring-white cursor-pointer">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="flex flex-col px-6 shrink-0">
                    <div class="flex items-center">
                        <span class="w-8 h-8 rounded-lg bg-indigo-600 flex items-center justify-center text-white font-bold text-lg shadow-sm">D</span>
                        <span class="ml-3 font-bold text-lg text-gray-900 dark:text-zinc-50 tracking-tight">DevLog CMS</span>
                    </div>
                    <span class="mt-2 text-[10px] font-bold text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-950/40 border border-indigo-100 dark:border-indigo-900/30 px-2 py-0.5 rounded-md self-start uppercase tracking-wider">
                        {{ auth()->user()->role === 'admin' ? 'Administrator' : 'Author' }}
                    </span>
                </div>

                <div class="mt-6 flex-1 overflow-y-auto px-4">
                    <nav class="space-y-1">
                        @include('layouts.partials.sidebar-links')
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <!-- Desktop Sidebar -->
    <aside class="hidden md:flex md:w-64 md:flex-col md:fixed md:inset-y-0 bg-white dark:bg-zinc-900 border-r border-gray-200 dark:border-zinc-800 h-full">
        <div class="flex flex-col flex-grow pt-6 pb-4 overflow-y-auto">
            <div class="flex flex-col px-6 shrink-0">
                <div class="flex items-center">
                    <span class="w-8 h-8 rounded-lg bg-indigo-600 flex items-center justify-center text-white font-bold text-lg shadow-sm">D</span>
                    <span class="ml-3 font-bold text-lg text-gray-900 dark:text-zinc-50 tracking-tight">DevLog CMS</span>
                </div>
                <span class="mt-2 text-[10px] font-bold text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-950/40 border border-indigo-100 dark:border-indigo-900/30 px-2 py-0.5 rounded-md self-start uppercase tracking-wider">
                    {{ auth()->user()->role === 'admin' ? 'Administrator' : 'Author' }}
                </span>
            </div>
            <div class="mt-8 flex-grow flex flex-col px-4">
                <nav class="flex-1 space-y-1">
                    @include('layouts.partials.sidebar-links')
                </nav>
            </div>
        </div>
    </aside>

    <!-- Main Content Container -->
    <div class="flex-1 flex flex-col md:pl-64 min-h-screen">
        <main class="flex-grow py-8 px-4 sm:px-6 lg:px-8 max-w-6xl w-full mx-auto">
            @if(isset($slot))
                {{ $slot }}
            @else
                @yield('content')
            @endif
        </main>
    </div>

</body>
</html>