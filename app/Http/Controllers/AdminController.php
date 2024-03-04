<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::all();
        $events = $events->map(function ($event) {
            return [
                "id" => $event->id,
                "manager" => $event->user_id,
                "title" => $event->title,
                "description" => $event->description,
                "activity_type" => $event->activity_type,
                "link" => $event->link,
                "location" => $event->location,
                "start" => $event->start_date,
                "end" => $event->end_date,
                "duration" => $event->duration,
                "color" => $event->color,
            ];
        });

        // return inertia('Admin/AdminView', compact('events'));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
