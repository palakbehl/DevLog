<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Project;

class DashboardController extends Controller
{
    public function index()
    {
        if (auth()->user()->isAdmin()) {

            $totalPosts = Post::count();

            $totalProjects = Project::count();

        } else {

            $totalPosts = Post::where('user_id', auth()->id())->count();

            $totalProjects = Project::where('user_id', auth()->id())->count();

        }

        return view('dashboard', compact(
            'totalPosts',
            'totalProjects'
        ));
    }
}