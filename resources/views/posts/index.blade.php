@extends('layouts.app')

@section('content')

@if(request()->routeIs('posts.edit'))
    <!-- ================= EDIT POST WORKAROUND ================= -->
    @php
        $routePost = request()->route('post');
        $editingPost = $routePost instanceof \App\Models\Post ? $routePost : \App\Models\Post::find($routePost);
    @endphp

    @if($editingPost)
        <div class="space-y-6">
            <!-- Header -->
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-extrabold text-gray-900 dark:text-zinc-50 tracking-tight">Edit Post</h1>
                    <p class="text-sm text-gray-500 dark:text-zinc-400 mt-1">Modify your post details below.</p>
                </div>
                <x-button variant="secondary" :href="url('/posts')" class="cursor-pointer">
                    Cancel
                </x-button>
            </div>

            <!-- Form Card -->
            <x-card>
                <form action="{{ url('/posts/' . $editingPost->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Title -->
                    <x-form-input 
                        type="text" 
                        name="title" 
                        label="Post Title" 
                        :value="$editingPost->title" 
                        placeholder="Enter post title" 
                        required 
                    />

                    <!-- Content -->
                    <x-textarea 
                        name="content" 
                        label="Post Content" 
                        :value="$editingPost->content" 
                        placeholder="Write your article content here..." 
                        rows="8"
                        required 
                    />

                    <!-- Image Preview (If available, controller does not support image updates but we can display the existing one) -->
                    @if($editingPost->featured_image)
                        <div class="space-y-1.5">
                            <label class="block text-sm font-semibold text-gray-700 dark:text-zinc-300">Featured Image Preview</label>
                            <div class="w-48 h-32 rounded-lg overflow-hidden border border-gray-200 dark:border-zinc-700">
                                <img src="{{ asset('storage/' . $editingPost->featured_image) }}" alt="Featured Image" class="w-full h-full object-cover">
                            </div>
                        </div>
                    @endif

                    <!-- Published Checkbox -->
                    <div class="flex items-center">
                        <input 
                            id="is_published" 
                            type="checkbox" 
                            name="is_published" 
                            value="1" 
                            {{ $editingPost->is_published ? 'checked' : '' }}
                            class="w-4.5 h-4.5 text-indigo-600 border-gray-300 dark:border-zinc-700 dark:bg-zinc-900 rounded-sm focus:ring-indigo-500 focus:ring-2 cursor-pointer"
                        >
                        <label for="is_published" class="ml-2.5 text-sm font-semibold text-gray-600 dark:text-zinc-400 cursor-pointer">
                            Publish Post (Visible on homepage)
                        </label>
                    </div>

                    <!-- Actions -->
                    <div class="flex justify-end gap-3 border-t border-gray-200 dark:border-zinc-800 pt-6">
                        <x-button type="button" variant="secondary" :href="url('/posts')" class="cursor-pointer">
                            Cancel
                        </x-button>
                        <x-button variant="success" class="cursor-pointer">
                            Update Post
                        </x-button>
                    </div>
                </form>
            </x-card>
        </div>
    @else
        <x-alert type="error" message="Post not found." />
    @endif

@else
    <!-- ================= POSTS LISTING TABLE ================= -->
    <div x-data="{ showDeleteModal: false, deleteActionUrl: '' }" class="space-y-6">
        
        <!-- Header & Action -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-3xl font-extrabold text-gray-900 dark:text-zinc-50 tracking-tight">Posts</h1>
                <p class="text-sm text-gray-500 mt-1 dark:text-zinc-400">Manage, edit, or delete articles and publications.</p>
            </div>
            <x-button variant="primary" :href="url('/posts/create')" class="shadow-xs cursor-pointer">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Create Post
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
                    placeholder="Search posts..." 
                    class="block w-full pl-10 pr-4 py-2 bg-gray-50 dark:bg-zinc-950 border border-gray-200 dark:border-zinc-800 rounded-lg text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200"
                >
            </div>
            
            <div class="text-xs font-semibold text-gray-400 dark:text-zinc-400">
                Showing {{ $posts->count() }} posts
            </div>
        </div>

        <!-- Table Card -->
        @if($posts->isNotEmpty())
            <x-card class="p-0 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 dark:bg-zinc-800/50 border-b border-gray-200 dark:border-zinc-800">
                                <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-zinc-400 uppercase tracking-wider">Image</th>
                                <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-zinc-400 uppercase tracking-wider">Title</th>
                                <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-zinc-400 uppercase tracking-wider">Author</th>
                                <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-zinc-400 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-zinc-400 uppercase tracking-wider">Created At</th>
                                <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-zinc-400 uppercase tracking-wider text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-zinc-800">
                            @foreach($posts as $post)
                                <tr class="hover:bg-gray-50/50 dark:hover:bg-zinc-800/20 transition-colors duration-150">
                                    <!-- Image -->
                                    <td class="px-6 py-4">
                                        <div class="w-12 h-12 rounded-lg bg-gray-100 dark:bg-zinc-800 overflow-hidden border border-gray-200 dark:border-zinc-700">
                                            @if($post->featured_image)
                                                <img src="{{ asset('storage/' . $post->featured_image) }}" alt="Featured Image" class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center text-xs font-bold text-gray-400 uppercase">No</div>
                                            @endif
                                        </div>
                                    </td>
                                    <!-- Title -->
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-gray-900 dark:text-zinc-100 max-w-xs truncate">{{ $post->title }}</div>
                                        <div class="text-xs text-gray-400 mt-0.5 max-w-xs truncate">/posts/{{ $post->slug }}</div>
                                    </td>
                                    <!-- Author -->
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2">
                                            <div class="w-6 h-6 rounded-full bg-indigo-50 dark:bg-indigo-950/40 text-indigo-600 dark:text-indigo-400 flex items-center justify-center text-xs font-bold">{{ substr($post->user->name ?? 'U', 0, 1) }}</div>
                                            <span class="text-sm text-gray-600 dark:text-zinc-300 font-medium">{{ $post->user->name ?? 'Unknown' }}</span>
                                        </div>
                                    </td>
                                    <!-- Status -->
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $post->is_published ? 'bg-emerald-50 text-emerald-700 border border-emerald-100 dark:bg-emerald-950/20 dark:text-emerald-400 dark:border-emerald-900/30' : 'bg-amber-50 text-amber-700 border border-amber-100 dark:bg-amber-955/20 dark:text-amber-400 dark:border-amber-900/30' }}">
                                            {{ $post->is_published ? 'Published' : 'Draft' }}
                                        </span>
                                    </td>
                                    <!-- Created At -->
                                    <td class="px-6 py-4 text-sm text-gray-500 dark:text-zinc-400 font-medium">
                                        {{ $post->created_at->format('M d, Y') }}
                                    </td>
                                    <!-- Actions -->
                                    <td class="px-6 py-4 text-right">
                                        @if(auth()->user()->isAdmin() || auth()->id() == $post->user_id)
                                            <div class="inline-flex items-center gap-2.5">
                                                <a href="{{ url('/posts/' . $post->id . '/edit') }}" class="text-sm font-bold text-indigo-600 hover:text-indigo-700 dark:text-indigo-400 dark:hover:text-indigo-300 transition-colors">
                                                    Edit
                                                </a>
                                                <span class="text-gray-300 dark:text-zinc-700">|</span>
                                                <a href="#" 
                                                   @click.prevent="deleteActionUrl = '{{ url('/posts/' . $post->id) }}'; showDeleteModal = true"
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
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 4a2 2 0 00-2 2v3m2-3a2 2 0 012 2v3m0 0a2 2 0 01-2 2h-2m-4-7a1 1 0 11-2 0 1 1 0 012 0zM9 9h1m-1 4h1m-4-4h.01M5 13h.01"/></svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 dark:text-zinc-50">No posts found</h3>
                <p class="text-sm text-gray-500 dark:text-zinc-400 mt-1 max-w-sm mx-auto">Get started by creating your very first blog post to share it with the world.</p>
                <x-button variant="primary" :href="url('/posts/create')" class="mt-6 cursor-pointer">
                    Create Post
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

                    <p class="text-sm text-gray-500 dark:text-zinc-400 mt-3">Are you sure you want to delete this post? This action is permanent and cannot be undone.</p>
                    
                    <div class="flex justify-end gap-3 mt-6 border-t border-gray-100 dark:border-zinc-800/80 pt-4">
                        <x-button type="button" variant="secondary" @click="showDeleteModal = false" class="cursor-pointer">
                            Cancel
                        </x-button>
                        <form :action="deleteActionUrl" method="POST">
                            @csrf
                            @method('DELETE')
                            <x-button variant="danger" class="cursor-pointer">
                                Delete Post
                            </x-button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endif

@endsection