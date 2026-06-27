<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    public function index()
    {
        if (auth()->user()->isAdmin()) {
            $projects = Project::latest()->get();
        } else {
            $projects = Project::where('user_id', auth()->id())
                ->latest()
                ->get();
        }

        return view('projects.index', compact('projects'));
    }

    public function create()
    {
        return view('projects.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'technologies' => 'required',
            'github_url' => 'nullable|url',
            'live_url' => 'nullable|url',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $thumbnail = null;

        if ($request->hasFile('thumbnail')) {
            $thumbnail = $request->file('thumbnail')
                ->store('projects', 'public');
        }

        Project::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'description' => $request->description,
            'technologies' => $request->technologies,
            'github_url' => $request->github_url,
            'live_url' => $request->live_url,
            'thumbnail' => $thumbnail,
        ]);

        return redirect()->route('projects.index')
            ->with('success', 'Project Created');
    }

    public function show(Project $project)
    {
    }

    public function edit(Project $project)
    {
        if (
            auth()->user()->isAuthor() &&
            auth()->id() != $project->user_id
        ) {
            abort(403);
        }

        return view('projects.edit', compact('project'));
    }

    public function update(Request $request, Project $project)
    {
        if (
            auth()->user()->isAuthor() &&
            auth()->id() != $project->user_id
        ) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'technologies' => 'required',
            'github_url' => 'nullable|url',
            'live_url' => 'nullable|url',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('thumbnail')) {

            if ($project->thumbnail) {
                Storage::disk('public')->delete($project->thumbnail);
            }

            $thumbnail = $request->file('thumbnail')
                ->store('projects', 'public');
        } else {
            $thumbnail = $project->thumbnail;
        }

        $project->update([
            'title' => $request->title,
            'description' => $request->description,
            'technologies' => $request->technologies,
            'github_url' => $request->github_url,
            'live_url' => $request->live_url,
            'thumbnail' => $thumbnail,
        ]);

        return redirect()->route('projects.index')
            ->with('success', 'Project Updated');
    }

    public function destroy(Project $project)
    {
        if (
            auth()->user()->isAuthor() &&
            auth()->id() != $project->user_id
        ) {
            abort(403);
        }

        if ($project->thumbnail) {
            Storage::disk('public')->delete($project->thumbnail);
        }

        $project->delete();

        return redirect()->route('projects.index')
            ->with('success', 'Project Deleted');
    }
}