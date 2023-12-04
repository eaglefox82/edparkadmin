<?php

namespace App\Http\Controllers\Events\RecreationCamp;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\RecreationCamp\RecreationCampEvent;

class TeamsController extends Controller
{
    public function index($eventId)
    {
        $event = RecreationCampEvent::query()->findOrFail($eventId);

        return view('recreationcamp.teams.index', compact('event'));
    }

    public function printAllTeams($eventId)
    {
        $event = RecreationCampEvent::query()->findOrFail($eventId);
        $teams = $event->teams()->get();

        return view('recreationcamp.teams.print_team', compact('teams'));
    }

    public function printTeam($eventId, $teamId)
    {
        $event = RecreationCampEvent::query()->findOrFail($eventId);

        $teams = $event->teams()->where('id', $teamId)->get();

        return view('recreationcamp.teams.print_team', compact('teams'));
    }
}
