<?php

namespace App\Http\Controllers\Events\TrainingCamp;

use App\Http\Controllers\Controller;
use App\Models\TrainingCamp\TrainingCampEvent;

class FlightsController extends Controller
{
    public function index($eventId)
    {
        $event = TrainingCampEvent::query()->findOrFail($eventId);

        return view('trainingcamp.flights.index', compact('event'));
    }

    public function printAllFlights($eventId)
    {
        $event = TrainingCampEvent::query()->findOrFail($eventId);
        $flights = $event->flights()->get();

        return view('trainingcamp.flights.print_flight', compact('flights'));
    }

    public function printFlight($eventId, $flightId)
    {
        $event = TrainingCampEvent::query()->findOrFail($eventId);

        $flights = $event->flights()->where('id', $flightId)->get();

        return view('trainingcamp.flights.print_flight', compact('flights'));
    }
}
