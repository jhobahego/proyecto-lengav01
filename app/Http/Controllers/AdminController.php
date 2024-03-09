<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Project;
use App\Models\User;
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

        $users = User::all();
        $projects = Project::all();

        return inertia('Admin/AdminView', compact(['events', 'users', 'projects']));
    }

}
