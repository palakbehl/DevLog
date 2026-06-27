@extends('layouts.app')

@section('content')

@php
    // Fetch recent posts and projects respecting the user's role scope
    if (auth()->user()->isAdmin()) {
        $recentPosts = \App\Models\Post::latest()->take(5)->get();
        $recentProjects = \App\Models\Project::latest()->take(5)->get();
    } else {
        $recentPosts = \App\Models\Post::where('user_id', auth()->id())->latest()->take(5)->get();
        $recentProjects = \App\Models\Project::where('user_id', auth()->id())->latest()->take(5)->get();
    }
@endphp

<div class="space-y-8">
    <!-- Welcome Header / Dashboard Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900 dark:text-zinc-50 tracking-tight">Dashboard</h1>
            <p class="text-sm text-gray-500 mt-1 dark:text-zinc-400">Welcome back, {{ auth()->user()->name }}! Here's an overview of your CMS content.</p>
        </div>
        
        <!-- Quick Action Buttons -->
        <div class="flex items-center gap-3">
            <x-button variant="secondary" :href="url('/projects/create')" class="px-4 py-2.5 shadow-xs cursor-pointer">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Create Project
            </x-button>
            <x-button variant="primary" :href="url('/posts/create')" class="px-4 py-2.5 shadow-xs cursor-pointer">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Create Post
            </x-button>
        </div>
    </div>

    <!-- Statistics Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
        <x-stat-card 
            title="Total Posts" 
            :value="$totalPosts" 
            icon='<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 4a2 2 0 00-2 2v3m2-3a2 2 0 012 2v3m0 0a2 2 0 01-2 2h-2m-4-7a1 1 0 11-2 0 1 1 0 012 0zM9 9h1m-1 4h1m-4-4h.01M5 13h.01"/></svg>'
        />
        <x-stat-card 
            title="Total Projects" 
            :value="$totalProjects" 
            icon='<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>'
        />
    </div>

    <!-- Recent Content Grids -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Recent Posts Card Container -->
        <x-card class="flex flex-col h-full">
            <div class="flex items-center justify-between border-b border-gray-200 dark:border-zinc-800 pb-4 mb-4">
                <h2 class="text-lg font-bold text-gray-900 dark:text-zinc-50">Recent Posts</h2>
                <a href="{{ url('/posts') }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-700 dark:text-indigo-400">View All</a>
            </div>
            
            <div class="flex-1 divide-y divide-gray-100 dark:divide-zinc-800">
                @forelse($recentPosts as $post)
                    <div class="py-3.5 flex items-center justify-between gap-4">
                        <div class="flex items-center gap-3 overflow-hidden">
                            <div class="shrink-0 w-10 h-10 rounded-lg bg-gray-100 dark:bg-zinc-800 overflow-hidden border border-gray-200 dark:border-zinc-700">
                                @if($post->featured_image)
                                    <img src="{{ asset('storage/' . $post->featured_image) }}" alt="Thumbnail" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-xs font-bold text-gray-400">P</div>
                                @endif
                            </div>
                            <div class="truncate">
                                <h3 class="text-sm font-semibold text-gray-950 dark:text-zinc-100 truncate">{{ $post->title }}</h3>
                                <p class="text-xs text-gray-500 dark:text-zinc-400 mt-0.5">{{ $post->created_at->format('M d, Y') }}</p>
                            </div>
                        </div>
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold {{ $post->is_published ? 'bg-emerald-50 text-emerald-700 border border-emerald-100 dark:bg-emerald-950/20 dark:text-emerald-400 dark:border-emerald-900/30' : 'bg-amber-50 text-amber-700 border border-amber-100 dark:bg-amber-950/20 dark:text-amber-400 dark:border-amber-900/30' }}">
                            {{ $post->is_published ? 'Published' : 'Draft' }}
                        </span>
                    </div>
                @empty
                    <div class="py-12 text-center">
                        <svg class="w-10 h-10 mx-auto text-gray-300 dark:text-zinc-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 4a2 2 0 00-2 2v3m2-3a2 2 0 012 2v3m0 0a2 2 0 01-2 2h-2m-4-7a1 1 0 11-2 0 1 1 0 012 0z"/>
                        </svg>
                        <p class="text-sm text-gray-500 dark:text-zinc-400 mt-2">No posts available yet.</p>
                    </div>
                @endforelse
            </div>
        </x-card>

        <!-- Recent Projects Card Container -->
        <x-card class="flex flex-col h-full">
            <div class="flex items-center justify-between border-b border-gray-200 dark:border-zinc-800 pb-4 mb-4">
                <h2 class="text-lg font-bold text-gray-900 dark:text-zinc-50">Recent Projects</h2>
                <a href="{{ url('/projects') }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-700 dark:text-indigo-400">View All</a>
            </div>

            <div class="flex-1 divide-y divide-gray-100 dark:divide-zinc-800">
                @forelse($recentProjects as $project)
                    <div class="py-3.5 flex items-center justify-between gap-4">
                        <div class="flex items-center gap-3 overflow-hidden">
                            <div class="shrink-0 w-10 h-10 rounded-lg bg-gray-100 dark:bg-zinc-800 overflow-hidden border border-gray-200 dark:border-zinc-700">
                                @if($project->thumbnail)
                                    <img src="{{ asset('storage/' . $project->thumbnail) }}" alt="Thumbnail" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-xs font-bold text-gray-400">PR</div>
                                @endif
                            </div>
                            <div class="truncate">
                                <h3 class="text-sm font-semibold text-gray-950 dark:text-zinc-100 truncate">{{ $project->title }}</h3>
                                <p class="text-xs text-gray-500 dark:text-zinc-400 mt-0.5 truncate">{{ $project->technologies }}</p>
                            </div>
                        </div>
                        <div class="flex gap-2">
                            @if($project->github_url)
                                <a href="{{ $project->github_url }}" target="_blank" class="text-gray-400 hover:text-gray-600 dark:hover:text-zinc-200">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd"/></svg>
                                </a>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="py-12 text-center">
                        <svg class="w-10 h-10 mx-auto text-gray-300 dark:text-zinc-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01"/>
                        </svg>
                        <p class="text-sm text-gray-500 dark:text-zinc-400 mt-2">No projects available yet.</p>
                    </div>
                @endforelse
            </div>
        </x-card>
    </div>
</div>

@endsection