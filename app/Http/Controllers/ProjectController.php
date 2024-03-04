<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::all();
        return inertia('ProjectsView', [
            'projects' => $projects
        ]);
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

        $project = Project::create($data);

        if ($project) {
            return redirect()->route('projects.index')->with('success', [
                'type' => 'success',
                'title' => 'Registro creado correctamente',
                'message' => 'Proyecto creado con éxito'
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        $project->general_objectives = json_decode($project->general_objectives);
        $project->specific_objectives = json_decode($project->specific_objectives);
        return view('projects.edit', compact('project'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        $request['general_objectives'] = json_encode($request['general_objectives']);
        $request['specific_objectives'] = json_encode($request['specific_objectives']);

        $project->update($request->all());
        return redirect()->route('projects.index')->with('success', [
            'type' => 'success',
            'title' => 'Registro actualizado correctamente',
            'message' => 'Proyecto actualizado con éxito'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $project->delete();
        return redirect()->route('projects.index')->with('danger', [
            'type' => 'success',
            'title' => 'Registro eliminado correctamente',
            'message' => 'Proyecto eliminado con éxito'
        ]);
    }
}
