<?php

namespace App\Http\Controllers\Events\TrainingCamp;

use App\Http\Controllers\Controller;
use App\Models\TrainingCamp\TrainingCampEvent;
use App\Models\TrainingCamp\TrainingCampRoom;

class AccommodationController extends Controller
{
    public function index($eventId)
    {
        $event = TrainingCampEvent::query()->findOrFail($eventId);

        return view('trainingcamp.accommodation.index', compact('event'));
    }

    public function view($eventId, $roomId)
    {
        $event = TrainingCampEvent::query()->findOrFail($eventId);
        $room = TrainingCampRoom::query()->findOrFail($roomId);

        return view('trainingcamp.accommodation.view', compact('event', 'room'));
    }

    public function printAllRooms($eventId)
    {
        $event = TrainingCampEvent::query()->findOrFail($eventId);
        $rooms = $event->rooms()->get();

        return view('trainingcamp.accommodation.print_room', compact('rooms'));
    }

    public function printRoom($eventId, $roomId)
    {
        $event = TrainingCampEvent::query()->findOrFail($eventId);

        $rooms = $event->rooms()->where('id', $roomId)->get();

        return view('trainingcamp.accommodation.print_room', compact('rooms'));
    }
}
