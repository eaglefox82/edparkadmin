<?php

namespace App\Http\Controllers\Events\RecreationCamp;

use App\Http\Controllers\Controller;
use App\Models\RecreationCamp\RecreationCampEvent;
use Illuminate\Http\Request;

class RecreationCampController extends Controller
{
    public function index($eventId)
    {
        $event = RecreationCampEvent::query()->findOrFail($eventId);

        $rooms = array();
        foreach ($event->rooms as $room) {
            $rooms[] = array(
                'name' => $room->room_number,
                'registered' => $room->members()->where('camp_checkin', '=', null)->count(),
                'in_camp' => $room->members()->where('camp_checkin', '<>', null)->count()
            );
        }

        $teams = array();
        foreach ($event->teams as $team) {
            $teams[] = array(
                'name' => $team->name,
                'registered' => $team->allMembers()->where('camp_checkin', '=', null)->count(),
                'in_camp' => $team->allMembers()->where('camp_checkin', '<>', null)->count()
            );
        }

        return view('recreationcamp.index', compact('event', 'rooms', 'teams'));
    }

    public function accounting($eventId)
    {
        $event = RecreationCampEvent::query()->findOrFail($eventId);

        $units = array();
        foreach ($event->members as $attendee)
        {
            $units[$attendee->member->unit][] = $attendee;
        }

        return view('recreationcamp.accounting', compact('event', 'units'));
    }

    public function campReport($eventId)
    {
        $event = RecreationCampEvent::query()->findOrFail($eventId);

        //Overall Data
        $totalRegistered = $event->members()->count();
        $attendingMembers = $event->members()->where('camp_checkin', '<>', null);
        $totalAttended = $attendingMembers->count();

        $totalCadets = 0;
        $totalOfficers = 0;
        $nonAal = 0;
        foreach ($attendingMembers->get() as $mem) {
            if ($mem->member->type == 0 || $mem->member->type == 2) {
                $nonAal++;
                continue;
            }

            if ($mem->member->Age < 18) {
                $totalCadets++;
            } else {
                $totalOfficers++;
            }
        }

        //Gender Data
        $female = $event->members()->where('camp_checkin', '<>', null)->whereHas('member', function ($query) {
            return $query->where('gender', '=', 2);
        })->count();
        $male = $event->members()->where('camp_checkin', '<>', null)->whereHas('member', function ($query) {
            return $query->where('gender', '=', 1);
        })->count();

        //Unit Data
        $units = array();
        foreach ($event->members as $attendee)
        {
            $units[$attendee->member->unit][] = $attendee;
        }

        ksort($units);

        return view('recreationcamp.reports.overall',
            compact('event', 'units', 'totalRegistered', 'totalAttended', 'nonAal', 'female', 'male', 'totalCadets', 'totalOfficers'));
    }
}
