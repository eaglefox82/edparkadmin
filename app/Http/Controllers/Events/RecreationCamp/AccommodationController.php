<?php

namespace App\Http\Controllers\Events\RecreationCamp;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\RecreationCamp\RecreationCampEvent;
use App\Models\RecreationCamp\RecreationCampRoom;

class AccommodationController extends Controller
{
    public function index($eventId)
    {
        $event = RecreationCampEvent::query()->findOrFail($eventId);

        return view('recreationcamp.accommodation.index', compact('event'));
    }

    public function view($eventId, $roomId)
    {
        $event = RecreationCampEvent::query()->findOrFail($eventId);
        $room = RecreationCampRoom::query()->findOrFail($roomId);

        return view('recreationcamp.accommodation.view', compact('event', 'room'));
    }

    public function printAllRooms($eventId)
    {
        $event = RecreationCampEvent::query()->findOrFail($eventId);
        $rooms = $event->rooms()->get();

        return view('recreationcamp.accommodation.print_room', compact('rooms'));
    }

    public function printRoom($eventId, $roomId)
    {
        $event = RecreationCampEvent::query()->findOrFail($eventId);

        $rooms = $event->rooms()->where('id', $roomId)->get();

        return view('recreationcamp.accommodation.print_room', compact('rooms'));
    }
}
