<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Post;
use App\Models\Project;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Truncate tables to allow fresh repeatable seeds
        Schema::disableForeignKeyConstraints();
        Post::truncate();
        Project::truncate();
        User::truncate();
        Schema::enableForeignKeyConstraints();

        // 1. Seed Admin User
        $admin = new User();
        $admin->name = 'Palak Behl (Admin)';
        $admin->email = 'admin@example.com';
        $admin->password = Hash::make('password');
        $admin->role = 'admin';
        $admin->save();

        // 2. Seed Author User
        $author = new User();
        $author->name = 'Palak Behl (Author)';
        $author->email = 'author@example.com';
        $author->password = Hash::make('password');
        $author->role = 'author';
        $author->save();

        // 3. Seed Posts for Admin
        Post::create([
            'user_id' => $admin->id,
            'title' => 'Welcome to DevLog CMS Workspace',
            'slug' => 'welcome-to-devlog-cms-workspace',
            'content' => "Welcome to the DevLog CMS. This workstation enables you to organize technical documentations, diary entries, and project showcases.\n\nEnjoy the dark mode, responsive layouts, and modern typography optimized for readability.",
            'is_published' => true,
        ]);

        Post::create([
            'user_id' => $admin->id,
            'title' => 'Building Scalable APIs with Laravel 12',
            'slug' => 'building-scalable-apis-with-laravel-12',
            'content' => "Laravel 12 brings robust type safety and performant Eloquent execution. Here's a brief guide on structuring your controllers, services, and API resources to maximize throughput and developer clarity.",
            'is_published' => false,
        ]);

        // 4. Seed Posts for Author
        Post::create([
            'user_id' => $author->id,
            'title' => 'My First Post as Author',
            'slug' => 'my-first-post-as-author',
            'content' => "This is my initial post as a content author. I'll be using this workspace to log daily developer achievements and code snippets.",
            'is_published' => true,
        ]);

        Post::create([
            'user_id' => $author->id,
            'title' => 'Mastering Blade and Tailwind CSS v4',
            'slug' => 'mastering-blade-and-tailwind-css-v4',
            'content' => "Tailwind CSS v4 introduces compilation inside Vite without the need for additional configuration files. It is faster, more cohesive, and provides high-quality utility tokens out of the box.",
            'is_published' => false,
        ]);

        // 5. Seed Projects for Admin
        Project::create([
            'user_id' => $admin->id,
            'title' => 'DevLog CMS Workstation',
            'description' => 'A beautiful, minimalist administrative CMS layout designed using Laravel, Blade, and Tailwind CSS v4.',
            'technologies' => 'Laravel 12, Tailwind CSS v4, Alpine.js, PHP, MySQL',
            'github_url' => 'https://github.com',
            'live_url' => 'http://127.0.0.1:8000',
        ]);

        Project::create([
            'user_id' => $admin->id,
            'title' => 'Vite CSS Optimization Utility',
            'description' => 'A plugin to systematically detect and remove unused Tailwind CSS components and classes during the production build.',
            'technologies' => 'JavaScript, Node.js, Vite, Rollup',
            'github_url' => 'https://github.com',
        ]);

        // 6. Seed Projects for Author
        Project::create([
            'user_id' => $author->id,
            'title' => 'Personal Developer Portfolio',
            'description' => 'A fully responsive front-end website showcasing past open-source contributions, technical articles, and active repositories.',
            'technologies' => 'HTML5, CSS3, JavaScript, Alpine.js',
            'github_url' => 'https://github.com',
            'live_url' => 'http://127.0.0.1:8000',
        ]);

        Project::create([
            'user_id' => $author->id,
            'title' => 'Go Task Scheduler Daemon',
            'description' => 'A high-performance lightweight Go daemon utility to manage cron schedules and queue triggers synchronously.',
            'technologies' => 'Go, Gin Framework, Redis',
            'github_url' => 'https://github.com',
        ]);
    }
}
