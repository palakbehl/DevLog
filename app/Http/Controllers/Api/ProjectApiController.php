<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProjectApiController extends Controller
{
    public function index()
    {
        return Project::latest()->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
    'title' => 'required|max:255',
    'description' => 'required',
    'technologies' => 'required',
    'github_url' => 'nullable|url',
    'live_url' => 'nullable|url',
]);

        $validated['user_id'] = 1; // Temporary
        $validated['slug'] = Str::slug($validated['title']);

        return Project::create($validated); // This line creates a new Project record in the database using the validated data. The 'create' method is a mass assignment method that takes an array of attributes and saves them to the database. The newly created Project instance is then returned as a response.
    }

    public function show(Project $project)
    {
        return $project;
    }

    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
        ]);

        $validated['slug'] = Str::slug($validated['title']); 

        $project->update($validated);

        return $project;
    }

    public function destroy(Project $project)
    {
        $project->delete();

        return response()->json([
            'message' => 'Project Deleted Successfully'
        ]);
    }
}