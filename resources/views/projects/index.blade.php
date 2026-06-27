@extends('layouts.app')

@section('content')

<div x-data="{ showDeleteModal: false, deleteActionUrl: '' }" class="space-y-6">
    
    <!-- Header & Action -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900 dark:text-zinc-50 tracking-tight">Projects</h1>
            <p class="text-sm text-gray-500 mt-1 dark:text-zinc-400">Manage, showcase, and edit your software portfolio.</p>
        </div>
        <x-button variant="primary" :href="url('/projects/create')" class="shadow-xs cursor-pointer">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Create Project
        </x-button>
    </div>

    <!-- Success/Error Alert -->
    @if(session('success'))
        <x-alert type="success" :message="session('success')" />
    @endif

    <!-- Search & Info Bar -->
    <div class="flex items-center justify-between gap-4 bg-white dark:bg-zinc-900 p-4 border border-gray-200 dark:border-zinc-800 rounded-xl shadow-xs">
        <!-- Search Bar UI-only -->
        <div class="relative w-full max-w-xs">
            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </span>
            <input 
                type="text" 
                placeholder="Search projects..." 
                class="block w-full pl-10 pr-4 py-2 bg-gray-50 dark:bg-zinc-950 border border-gray-200 dark:border-zinc-800 rounded-lg text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200"
            >
        </div>
        
        <div class="text-xs font-semibold text-gray-400 dark:text-zinc-400">
            Showing {{ $projects->count() }} projects
        </div>
    </div>

    <!-- Table Card -->
    @if($projects->isNotEmpty())
        <x-card class="p-0 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 dark:bg-zinc-800/50 border-b border-gray-200 dark:border-zinc-800">
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-zinc-400 uppercase tracking-wider">Thumbnail</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-zinc-400 uppercase tracking-wider">Title</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-zinc-400 uppercase tracking-wider">Technologies</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-zinc-400 uppercase tracking-wider">Links</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-zinc-400 uppercase tracking-wider text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-zinc-800">
                        @foreach($projects as $project)
                            <tr class="hover:bg-gray-50/50 dark:hover:bg-zinc-800/20 transition-colors duration-150">
                                <!-- Thumbnail -->
                                <td class="px-6 py-4">
                                    <div class="w-16 h-12 rounded-lg bg-gray-100 dark:bg-zinc-800 overflow-hidden border border-gray-200 dark:border-zinc-700">
                                        @if($project->thumbnail)
                                            <img src="{{ asset('storage/' . $project->thumbnail) }}" alt="Thumbnail" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-xs font-bold text-gray-400 uppercase">Code</div>
                                        @endif
                                    </div>
                                </td>
                                <!-- Title -->
                                <td class="px-6 py-4">
                                    <div class="font-bold text-gray-900 dark:text-zinc-100 max-w-xs truncate">{{ $project->title }}</div>
                                    <div class="text-xs text-gray-400 mt-0.5 max-w-xs truncate">{{ Str::limit($project->description, 50) }}</div>
                                </td>
                                <!-- Technologies -->
                                <td class="px-6 py-4">
                                    <div class="flex flex-wrap gap-1.5 max-w-xs">
                                        @foreach(explode(',', $project->technologies) as $tech)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-bold bg-indigo-50 dark:bg-indigo-950/30 text-indigo-700 dark:text-indigo-400 border border-indigo-100 dark:border-indigo-900/30">
                                                {{ trim($tech) }}
                                            </span>
                                        @endforeach
                                    </div>
                                </td>
                                <!-- Links -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        @if($project->github_url)
                                            <a href="{{ $project->github_url }}" target="_blank" class="text-xs font-bold text-gray-600 hover:text-gray-900 dark:text-zinc-400 dark:hover:text-zinc-200 flex items-center gap-1">
                                                GitHub
                                            </a>
                                        @else
                                            <span class="text-xs text-gray-300 dark:text-zinc-750">-</span>
                                        @endif
                                        
                                        @if($project->live_url)
                                            <span class="text-gray-300 dark:text-zinc-700">/</span>
                                            <a href="{{ $project->live_url }}" target="_blank" class="text-xs font-bold text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300 flex items-center gap-1">
                                                Live Demo
                                            </a>
                                        @endif
                                    </div>
                                </td>
                                <!-- Actions -->
                                <td class="px-6 py-4 text-right">
                                    @if(auth()->user()->isAdmin() || auth()->id() == $project->user_id)
                                        <div class="inline-flex items-center gap-2.5">
                                            <a href="{{ url('/projects/' . $project->id . '/edit') }}" class="text-sm font-bold text-indigo-600 hover:text-indigo-700 dark:text-indigo-400 dark:hover:text-indigo-300 transition-colors">
                                                Edit
                                            </a>
                                            <span class="text-gray-300 dark:text-zinc-700">|</span>
                                            <a href="#" 
                                               @click.prevent="deleteActionUrl = '{{ url('/projects/' . $project->id) }}'; showDeleteModal = true"
                                               class="text-sm font-bold text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 transition-colors cursor-pointer">
                                                Delete
                                            </a>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </x-card>
    @else
        <!-- Empty State -->
        <x-card class="py-16 text-center">
            <div class="w-14 h-14 bg-indigo-50 dark:bg-indigo-950/40 rounded-2xl flex items-center justify-center text-indigo-600 dark:text-indigo-400 mx-auto mb-4">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01"/></svg>
            </div>
            <h3 class="text-lg font-bold text-gray-900 dark:text-zinc-50">No projects found</h3>
            <p class="text-sm text-gray-500 dark:text-zinc-400 mt-1 max-w-sm mx-auto">Get started by adding a software project, showcase, or live application to your portfolio.</p>
            <x-button variant="primary" :href="url('/projects/create')" class="mt-6 cursor-pointer">
                Create Project
            </x-button>
        </x-card>
    @endif

    <!-- ================= MODERN DELETE MODAL ================= -->
    <div x-show="showDeleteModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <!-- Overlay -->
        <div x-show="showDeleteModal" 
             x-transition:enter="transition-opacity ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-gray-950/60 backdrop-blur-xs"></div>

        <!-- Panel -->
        <div class="flex items-center justify-center min-h-screen p-4">
            <div x-show="showDeleteModal"
                 x-transition:enter="transition ease-out duration-300 transform"
                 x-transition:enter-start="opacity-0 scale-95 translate-y-4 sm:translate-y-0"
                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-200 transform"
                 x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                 x-transition:leave-end="opacity-0 scale-95 translate-y-4 sm:translate-y-0"
                 @click.away="showDeleteModal = false"
                 class="relative w-full max-w-md bg-white dark:bg-zinc-900 border border-gray-200 dark:border-zinc-800 rounded-xl shadow-lg p-6">
                
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-red-50 dark:bg-red-950/30 text-red-600 dark:text-red-400 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-950 dark:text-zinc-50">Confirm Deletion</h3>
                </div>

                <p class="text-sm text-gray-500 dark:text-zinc-400 mt-3">Are you sure you want to delete this project? This action is permanent and cannot be undone.</p>
                
                <div class="flex justify-end gap-3 mt-6 border-t border-gray-100 dark:border-zinc-800/80 pt-4">
                    <x-button type="button" variant="secondary" @click="showDeleteModal = false" class="cursor-pointer">
                        Cancel
                    </x-button>
                    <form :action="deleteActionUrl" method="POST">
                        @csrf
                        @method('DELETE')
                        <x-button variant="danger" class="cursor-pointer">
                            Delete Project
                        </x-button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection