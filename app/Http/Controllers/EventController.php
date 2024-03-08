<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        $event = new Event();
        $event->user_id = $request->manager;
        $event->title = $request->title;
        $event->description = $request->description;
        $event->activity_type = $request->activity_type;
        $event->link = $request->link;
        $event->location = $request->location;
        $event->start_date = $request->start;
        $event->end_date = $request->end;
        $event->duration = $request->duration;
        $event->color = $request->color;

        $event->save();
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        $event->user_id = $request->manager;
        $event->title = $request->title;
        $event->description = $request->description;
        $event->activity_type = $request->activity_type;
        $event->link = $request->link;
        $event->location = $request->location;
        $event->start_date = $request->start;
        $event->end_date = $request->end;
        $event->duration = $request->duration;
        $event->color = $request->color;
        $event->save();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        $event->delete();
    }
}
