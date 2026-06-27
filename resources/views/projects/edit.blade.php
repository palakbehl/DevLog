@extends('layouts.app')

@section('content')

<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900 dark:text-zinc-50 tracking-tight">Edit Project</h1>
            <p class="text-sm text-gray-500 mt-1 dark:text-zinc-400">Modify your project parameters below.</p>
        </div>
        <x-button variant="secondary" :href="url('/projects')" class="cursor-pointer">
            Cancel
        </x-button>
    </div>

    <!-- Form Card -->
    <x-card>
        <form action="{{ url('/projects/' . $project->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Title -->
                <div class="md:col-span-2">
                    <x-form-input 
                        type="text" 
                        name="title" 
                        label="Project Title" 
                        :value="$project->title" 
                        placeholder="e.g. Developer Blogging CMS" 
                        required 
                    />
                </div>

                <!-- Description -->
                <div class="md:col-span-2">
                    <x-textarea 
                        name="description" 
                        label="Project Description" 
                        :value="$project->description"
                        placeholder="Provide details about what you built, key features, and your learnings..." 
                        rows="5"
                        required 
                    />
                </div>

                <!-- Technologies -->
                <div class="md:col-span-2">
                    <x-form-input 
                        type="text" 
                        name="technologies" 
                        label="Technologies Used" 
                        :value="$project->technologies" 
                        placeholder="e.g. Laravel, Tailwind CSS, MySQL, Alpine.js" 
                        required 
                    />
                    <p class="text-[10px] text-gray-400 dark:text-zinc-500 mt-1">Separate technologies with a comma.</p>
                </div>

                <!-- GitHub URL -->
                <x-form-input 
                    type="url" 
                    name="github_url" 
                    label="GitHub Repository URL" 
                    :value="$project->github_url" 
                    placeholder="https://github.com/username/repo" 
                />

                <!-- Live URL -->
                <x-form-input 
                    type="url" 
                    name="live_url" 
                    label="Live Demo URL" 
                    :value="$project->live_url" 
                    placeholder="https://yourproject.com" 
                />

                <!-- Thumbnail Upload & Preview -->
                <div class="md:col-span-2 space-y-3">
                    <div class="space-y-1.5 w-full">
                        <label for="thumbnail" class="block text-sm font-semibold text-gray-700 dark:text-zinc-300">
                            Project Thumbnail
                        </label>
                        <div class="flex items-center justify-center w-full">
                            <label for="thumbnail" class="flex flex-col items-center justify-center w-full h-36 border-2 border-gray-300 dark:border-zinc-800 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:bg-zinc-950 hover:bg-gray-100 dark:hover:bg-zinc-900 transition-all duration-200">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <svg class="w-8 h-8 mb-2.5 text-gray-400 dark:text-zinc-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                                    <p class="text-xs text-gray-500 dark:text-zinc-400"><span class="font-bold">Click to upload new thumbnail</span> or drag and drop</p>
                                    <p class="text-[10px] text-gray-400 dark:text-zinc-500 mt-1">PNG, JPG or JPEG (Max 2MB)</p>
                                </div>
                                <input id="thumbnail" name="thumbnail" type="file" class="hidden" accept="image/*" />
                            </label>
                        </div>
                        @error('thumbnail')
                            <p class="text-xs font-medium text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    @if($project->thumbnail)
                        <div class="space-y-1.5">
                            <label class="block text-sm font-semibold text-gray-700 dark:text-zinc-300">Current Thumbnail</label>
                            <div class="w-48 h-32 rounded-lg overflow-hidden border border-gray-200 dark:border-zinc-700">
                                <img src="{{ asset('storage/' . $project->thumbnail) }}" alt="Project Thumbnail" class="w-full h-full object-cover">
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Actions -->
            <div class="flex justify-end gap-3 border-t border-gray-200 dark:border-zinc-800 pt-6">
                <x-button type="button" variant="secondary" :href="url('/projects')" class="cursor-pointer">
                    Cancel
                </x-button>
                <x-button variant="success" class="cursor-pointer">
                    Update Project
                </x-button>
            </div>
        </form>
    </x-card>
</div>

@endsection