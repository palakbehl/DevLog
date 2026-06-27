@extends('layouts.app')

@section('content')

<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900 dark:text-zinc-50 tracking-tight">Edit Post</h1>
            <p class="text-sm text-gray-500 mt-1 dark:text-zinc-400">Modify your post details below.</p>
        </div>
        <x-button variant="secondary" :href="url('/posts')" class="cursor-pointer">
            Cancel
        </x-button>
    </div>

    <!-- Form Card -->
    <x-card>
        <form action="{{ url('/posts/' . $post->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Title -->
            <x-form-input 
                type="text" 
                name="title" 
                label="Post Title" 
                :value="$post->title" 
                placeholder="Enter post title" 
                required 
            />

            <!-- Content -->
            <x-textarea 
                name="content" 
                label="Post Content" 
                :value="$post->content" 
                placeholder="Write your article content here..." 
                rows="8"
                required 
            />

            <!-- Image Preview (If available, controller does not support image updates but we display the existing one) -->
            @if($post->featured_image)
                <div class="space-y-1.5">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-zinc-300">Featured Image Preview</label>
                    <div class="w-48 h-32 rounded-lg overflow-hidden border border-gray-200 dark:border-zinc-700">
                        <img src="{{ asset('storage/' . $post->featured_image) }}" alt="Featured Image" class="w-full h-full object-cover">
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
                    {{ $post->is_published ? 'checked' : '' }}
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

@endsection