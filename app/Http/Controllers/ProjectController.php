<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        $projects = Project::all();
        return inertia('ProjectsView', compact('projects', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $data['general_objectives'] = json_encode($data['general_objectives']);
        $data['specific_objectives'] = json_encode($data['specific_objectives']);

        Project::create($data);
        return redirect()->route('projects.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        $manager = User::find($project->manager);
        return inertia('Projects/ProjectShow', compact('project', 'manager'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        $request['general_objectives'] = json_encode($request['general_objectives']);
        $request['specific_objectives'] = json_encode($request['specific_objectives']);

        $project->update($request->all());
        return redirect()->route('projects.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $project->delete();
        return redirect()->route('projects.index');
    }
}
