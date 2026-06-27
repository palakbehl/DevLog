<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth bg-gray-50 dark:bg-zinc-950">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'DevLog') }} - Developer Portfolio & Blog</title>

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="text-gray-900 dark:text-zinc-100 antialiased min-h-screen flex flex-col">

    <!-- Sticky Glassmorphic Navbar -->
    <header class="sticky top-0 z-45 w-full bg-white/80 dark:bg-zinc-900/80 backdrop-blur-md border-b border-gray-200 dark:border-zinc-800">
        <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">
            <a href="/" class="flex items-center gap-2.5">
                <span class="w-8 h-8 rounded-lg bg-indigo-650 flex items-center justify-center text-white font-extrabold text-lg shadow-sm">D</span>
                <span class="font-extrabold text-xl text-gray-900 dark:text-zinc-50 tracking-tight">DevLog</span>
            </a>
            
            <nav class="flex items-center gap-6">
                <a href="/" class="text-sm font-semibold text-gray-600 dark:text-zinc-350 hover:text-indigo-600 dark:hover:text-indigo-400">Home</a>
                <a href="?view=portfolio" class="text-sm font-semibold text-gray-600 dark:text-zinc-350 hover:text-indigo-600 dark:hover:text-indigo-400">Portfolio</a>
                
                @if (Route::has('login'))
                    <span class="text-gray-200 dark:text-zinc-800">|</span>
                    @auth
                        <a href="{{ url('/dashboard') }}" class="inline-flex items-center justify-center px-4 py-1.5 text-xs font-bold text-white bg-indigo-600 hover:bg-indigo-755 rounded-lg shadow-xs transition-all duration-200">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-semibold text-gray-600 dark:text-zinc-350 hover:text-indigo-600 dark:hover:text-indigo-400">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-4 py-1.5 text-xs font-bold text-white bg-indigo-600 hover:bg-indigo-755 rounded-lg shadow-xs transition-all duration-200">
                                Register
                            </a>
                        @endif
                    @endauth
                @endif
            </nav>
        </div>
    </header>

    <!-- Main Content Container -->
    <main class="flex-grow">

        @if(request()->has('post'))
            <!-- ============================================== -->
            <!--            BLOG DETAILS PAGE                   -->
            <!-- ============================================== -->
            @php
                $postSlug = request('post');
                $post = \App\Models\Post::where('slug', $postSlug)->orWhere('id', $postSlug)->first();
            @endphp

            @if($post)
                <article class="max-w-3xl mx-auto px-6 py-12 space-y-8">
                    <!-- Breadcrumbs & Back -->
                    <div class="flex items-center justify-between border-b border-gray-100 dark:border-zinc-900 pb-4">
                        <a href="/" class="inline-flex items-center text-xs font-bold text-indigo-650 hover:text-indigo-750 dark:text-indigo-400">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                            Back to Home
                        </a>
                        <span class="text-xs text-gray-400 dark:text-zinc-500 font-medium">Published in Blog</span>
                    </div>

                    <!-- Title & Header -->
                    <div class="space-y-4">
                        <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-900 dark:text-zinc-50 tracking-tight leading-tight">
                            {{ $post->title }}
                        </h1>
                        
                        <!-- Metadata -->
                        <div class="flex items-center gap-3 text-sm">
                            <div class="w-8 h-8 rounded-full bg-indigo-50 dark:bg-indigo-950/40 text-indigo-600 dark:text-indigo-400 flex items-center justify-center font-bold">
                                {{ substr($post->user->name ?? 'U', 0, 1) }}
                            </div>
                            <div>
                                <p class="font-semibold text-gray-800 dark:text-zinc-300">{{ $post->user->name ?? 'Unknown' }}</p>
                                <p class="text-xs text-gray-400 mt-0.5 dark:text-zinc-500">{{ $post->created_at->format('F d, Y') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Featured Image -->
                    @if($post->featured_image)
                        <div class="w-full aspect-video rounded-2xl overflow-hidden border border-gray-200 dark:border-zinc-800 shadow-xs">
                            <img src="{{ asset('storage/' . $post->featured_image) }}" alt="Featured Image" class="w-full h-full object-cover">
                        </div>
                    @endif

                    <!-- Blog Body -->
                    <div class="text-gray-700 dark:text-zinc-300 leading-relaxed text-base space-y-6 whitespace-pre-line font-medium border-t border-gray-200 dark:border-zinc-800/80 pt-6">
                        {{ $post->content }}
                    </div>
                </article>
            @else
                <div class="max-w-md mx-auto py-24 px-6 text-center">
                    <h2 class="text-2xl font-bold text-gray-900">Post Not Found</h2>
                    <p class="text-sm text-gray-500 mt-2">The article you are looking for does not exist or has been removed.</p>
                    <a href="/" class="inline-block mt-6 text-sm font-bold text-indigo-600 hover:text-indigo-700">Go Home</a>
                </div>
            @endif

        @elseif(request('view') === 'portfolio')
            <!-- ============================================== -->
            <!--             PORTFOLIO VIEW                     -->
            <!-- ============================================== -->
            @php
                $projects = \App\Models\Project::latest()->get();
            @endphp

            <div class="max-w-6xl mx-auto px-6 py-12 space-y-8">
                <!-- Header -->
                <div class="border-b border-gray-200 dark:border-zinc-800 pb-6">
                    <h1 class="text-3xl font-extrabold text-gray-950 dark:text-zinc-50 tracking-tight">Software Portfolio</h1>
                    <p class="text-sm text-gray-500 mt-1.5 dark:text-zinc-400">An archive of projects, libraries, and applications I've designed and engineered.</p>
                </div>

                @if($projects->isNotEmpty())
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($projects as $project)
                            <div class="bg-white dark:bg-zinc-900 border border-gray-200 dark:border-zinc-800 rounded-2xl overflow-hidden shadow-xs hover:shadow-md transition-all duration-300 hover:-translate-y-1 flex flex-col h-full">
                                <div class="w-full aspect-video bg-gray-100 dark:bg-zinc-800 border-b border-gray-100 dark:border-zinc-800 shrink-0 relative">
                                    @if($project->thumbnail)
                                        <img src="{{ asset('storage/' . $project->thumbnail) }}" alt="Thumbnail" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-gray-400 font-bold text-lg uppercase">Codebase</div>
                                    @endif
                                </div>
                                <div class="p-5 flex-grow flex flex-col justify-between space-y-4">
                                    <div class="space-y-2">
                                        <h3 class="text-base font-bold text-gray-950 dark:text-zinc-50 tracking-tight line-clamp-1">{{ $project->title }}</h3>
                                        <p class="text-xs text-gray-500 dark:text-zinc-400 line-clamp-3 leading-relaxed">{{ $project->description }}</p>
                                    </div>
                                    <div class="space-y-4">
                                        <div class="flex flex-wrap gap-1.5">
                                            @foreach(explode(',', $project->technologies) as $tech)
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-bold bg-gray-100 dark:bg-zinc-800 text-gray-700 dark:text-zinc-300 border border-gray-200 dark:border-zinc-700/50">
                                                    {{ trim($tech) }}
                                                </span>
                                            @endforeach
                                        </div>
                                        <div class="flex items-center gap-3 border-t border-gray-100 dark:border-zinc-800 pt-3">
                                            @if($project->github_url)
                                                <a href="{{ $project->github_url }}" target="_blank" class="text-xs font-bold text-gray-700 hover:text-gray-900 dark:text-zinc-400 dark:hover:text-zinc-200 flex items-center gap-1.5">
                                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd"/></svg>
                                                    GitHub
                                                </a>
                                            @endif
                                            @if($project->live_url)
                                                @if($project->github_url)
                                                    <span class="text-gray-300 dark:text-zinc-800">/</span>
                                                @endif
                                                <a href="{{ $project->live_url }}" target="_blank" class="text-xs font-bold text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300 flex items-center gap-1.5">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                                    Live Demo
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-20 bg-white border border-gray-200 dark:border-zinc-800 dark:bg-zinc-900 rounded-2xl">
                        <p class="text-sm text-gray-500 dark:text-zinc-400">No projects added to the portfolio yet.</p>
                    </div>
                @endif
            </div>

        @else
            <!-- ============================================== -->
            <!--             PUBLIC LANDING HOMEPAGE            -->
            <!-- ============================================== -->
            @php
                $posts = \App\Models\Post::where('is_published', true)->latest()->take(3)->get();
                $projects = \App\Models\Project::latest()->take(3)->get();
            @endphp

            <!-- Hero Section -->
            <section class="max-w-6xl mx-auto px-6 pt-16 pb-20 text-center space-y-6">
                <span class="inline-flex items-center px-3.5 py-1 rounded-full text-xs font-bold bg-indigo-50 dark:bg-indigo-950/40 text-indigo-600 dark:text-indigo-400 border border-indigo-100 dark:border-indigo-900/30">
                    Laravel 12 + Tailwind CSS v4 CMS
                </span>
                <h1 class="text-4xl sm:text-6xl font-black text-gray-900 dark:text-zinc-50 tracking-tight leading-tight max-w-4xl mx-auto">
                    A beautiful portal for your <span class="text-indigo-600 dark:text-indigo-400">code & chronicles</span>.
                </h1>
                <p class="text-lg text-gray-500 dark:text-zinc-400 max-w-2xl mx-auto font-medium">
                    DocLog is a minimalist developer cms workstation designed to write code updates, blog, and showcase project portfolios.
                </p>
                <div class="flex items-center justify-center gap-4 pt-4">
                    <x-button variant="primary" href="?view=portfolio" class="px-6 py-3 shadow-md cursor-pointer">
                        Explore Projects
                    </x-button>
                    <a href="#blog" class="text-sm font-bold text-gray-600 hover:text-gray-900 dark:text-zinc-400 dark:hover:text-zinc-200">
                        Read Blog →
                    </a>
                </div>
            </section>

            <!-- Latest Blog Posts -->
            <section id="blog" class="bg-white dark:bg-zinc-900 border-y border-gray-200 dark:border-zinc-800/80 py-20">
                <div class="max-w-6xl mx-auto px-6 space-y-12">
                    <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4">
                        <div>
                            <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-950 dark:text-zinc-50 tracking-tight">Latest Blog Posts</h2>
                            <p class="text-sm text-gray-500 dark:text-zinc-400 mt-1">Updates, technical guides, and thoughts on software building.</p>
                        </div>
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">DocLog CMS Diary</span>
                    </div>

                    @if($posts->isNotEmpty())
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                            @foreach($posts as $post)
                                <a href="?post={{ $post->slug }}" class="group block space-y-4">
                                    <div class="w-full aspect-video rounded-2xl bg-gray-200 dark:bg-zinc-800 overflow-hidden border border-gray-200 dark:border-zinc-800/80 relative">
                                        @if($post->featured_image)
                                            <img src="{{ asset('storage/' . $post->featured_image) }}" alt="Featured Image" class="w-full h-full object-cover group-hover:scale-103 transition-transform duration-300">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-xs font-bold text-gray-400 uppercase">Featured Image</div>
                                        @endif
                                    </div>
                                    <div class="space-y-2.5">
                                        <div class="flex items-center gap-3 text-xs font-semibold text-gray-500 dark:text-zinc-400">
                                            <span>{{ $post->created_at->format('M d, Y') }}</span>
                                            <span>•</span>
                                            <span>By {{ $post->user->name ?? 'Unknown' }}</span>
                                        </div>
                                        <h3 class="text-lg font-bold text-gray-900 dark:text-zinc-50 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors leading-snug">
                                            {{ $post->title }}
                                        </h3>
                                        <p class="text-xs text-gray-500 dark:text-zinc-400 leading-relaxed line-clamp-2">
                                            {{ Str::limit($post->content, 120) }}
                                        </p>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12 text-gray-500 dark:text-zinc-400">
                            No blog posts published yet.
                        </div>
                    @endif
                </div>
            </section>

            <!-- Featured Projects -->
            <section class="max-w-6xl mx-auto px-6 py-20 space-y-12">
                <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4">
                    <div>
                        <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-950 dark:text-zinc-50 tracking-tight">Featured Projects</h2>
                        <p class="text-sm text-gray-500 dark:text-zinc-400 mt-1">Selected highlights of code builds and open source repositories.</p>
                    </div>
                    <a href="?view=portfolio" class="text-sm font-bold text-indigo-600 hover:text-indigo-700 dark:text-indigo-400 flex items-center">
                        All Projects
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>

                @if($projects->isNotEmpty())
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($projects as $project)
                            <div class="bg-white dark:bg-zinc-900 border border-gray-200 dark:border-zinc-800 rounded-2xl overflow-hidden shadow-xs hover:shadow-md transition-all duration-300 hover:-translate-y-1 flex flex-col h-full">
                                <div class="w-full aspect-video bg-gray-100 dark:bg-zinc-800 border-b border-gray-200 dark:border-zinc-800 shrink-0 relative">
                                    @if($project->thumbnail)
                                        <img src="{{ asset('storage/' . $project->thumbnail) }}" alt="Thumbnail" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-gray-400 font-bold text-sm uppercase">Codebase</div>
                                    @endif
                                </div>
                                <div class="p-5 flex-grow flex flex-col justify-between space-y-4">
                                    <div class="space-y-2">
                                        <h3 class="text-base font-bold text-gray-950 dark:text-zinc-50 tracking-tight line-clamp-1">{{ $project->title }}</h3>
                                        <p class="text-xs text-gray-500 dark:text-zinc-400 line-clamp-2 leading-relaxed">{{ $project->description }}</p>
                                    </div>
                                    <div class="space-y-3.5">
                                        <div class="flex flex-wrap gap-1.5">
                                            @foreach(explode(',', $project->technologies) as $tech)
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[9px] font-bold bg-gray-50 dark:bg-zinc-800 text-gray-600 dark:text-zinc-300 border border-gray-200 dark:border-zinc-700/50">
                                                    {{ trim($tech) }}
                                                </span>
                                            @endforeach
                                        </div>
                                        <div class="flex items-center gap-3 border-t border-gray-100 dark:border-zinc-800 pt-3">
                                            @if($project->github_url)
                                                <a href="{{ $project->github_url }}" target="_blank" class="text-xs font-bold text-gray-700 hover:text-gray-900 dark:text-zinc-400 dark:hover:text-zinc-200 flex items-center gap-1.5">
                                                    GitHub
                                                </a>
                                            @endif
                                            @if($project->live_url)
                                                @if($project->github_url)
                                                    <span class="text-gray-300 dark:text-zinc-800">/</span>
                                                @endif
                                                <a href="{{ $project->live_url }}" target="_blank" class="text-xs font-bold text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300 flex items-center gap-1.5">
                                                    Live Demo
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12 text-gray-505 dark:text-zinc-400">
                        No projects showcased yet.
                    </div>
                @endif
            </section>

            <!-- About DevLog -->
            <section class="bg-gray-100/50 dark:bg-zinc-900/50 border-t border-gray-200 dark:border-zinc-800/80 py-20">
                <div class="max-w-3xl mx-auto px-6 text-center space-y-6">
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-950 dark:text-zinc-50 tracking-tight">About DevLog CMS</h2>
                    <p class="text-base text-gray-600 dark:text-zinc-300 leading-relaxed font-medium">
                        DevLog is a minimalist Scribe and Showcase platform. It enables authors to jot down diaries, write developer documentation, and index live web software prototypes, all from a unified, elegant admin workspace panel.
                    </p>
                </div>
            </section>
        @endif

    </main>

    <!-- Footer Section -->
    <footer class="bg-white dark:bg-zinc-900 border-t border-gray-200 dark:border-zinc-800">
        <div class="max-w-6xl mx-auto px-6 py-10 flex flex-col sm:flex-row items-center justify-between gap-6">
            <div class="flex items-center gap-2.5">
                <span class="w-7 h-7 rounded-md bg-indigo-600 flex items-center justify-center text-white font-extrabold text-base shadow-xs">D</span>
                <span class="font-extrabold text-lg text-gray-900 dark:text-zinc-100 tracking-tight">DevLog CMS</span>
            </div>
            
            <p class="text-xs text-gray-400 dark:text-zinc-500 font-semibold order-last sm:order-none">
                &copy; {{ date('Y') }} DevLog CMS. All rights reserved.
            </p>

            <div class="flex items-center gap-4">
                <a href="https://github.com" target="_blank" class="text-xs font-bold text-gray-500 hover:text-gray-700 dark:text-zinc-400 dark:hover:text-zinc-200 flex items-center gap-1">
                    GitHub
                </a>
                <span class="text-gray-200 dark:text-zinc-800">|</span>
                <a href="https://linkedin.com" target="_blank" class="text-xs font-bold text-gray-500 hover:text-gray-700 dark:text-zinc-400 dark:hover:text-zinc-200 flex items-center gap-1">
                    LinkedIn
                </a>
            </div>
        </div>
    </footer>

</body>
</html>
