<?php

namespace App\View\Components;

use App\Models\CadetOfTheYear\CadetOfTheYearEvent;
use App\Models\CeremonialParade\CeremonialParadeEvent;
use App\Models\Event;
use App\Models\RecreationCamp\RecreationCampEvent;
use App\Models\TrainingCamp\TrainingCampEvent;
use Carbon\Carbon;
use Illuminate\View\Component;

class AppLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        $title = '';
        $header = '';
        $scripts = '';

        $events = array();
        $oldEvents = array();
        $recCamps = RecreationCampEvent::query()->where('active', true)->orderByDesc('from_date')->get();
        foreach ($recCamps as $camp) {
            if ($camp->to_date < Carbon::now()) {
                $oldEvents[] = $camp;
            } else {
                $events[] = $camp;
            }
        }

        $parades = CeremonialParadeEvent::query()->where('active', true)->orderByDesc('event_date')->get();
        foreach ($parades as $parade) {
            if ($parade->event_date < Carbon::now()) {
                $oldEvents[] = $parade;
            } else {
                $events[] = $parade;
            }
        }

        $trainingCamps = TrainingCampEvent::query()->where('active', true)->orderByDesc('from_date')->get();
        foreach ($trainingCamps as $camp) {
            if ($camp->to_date < Carbon::now()) {
                $oldEvents[] = $camp;
            } else {
                $events[] = $camp;
            }
        }

        $cadetComps = CadetOfTheYearEvent::query()->where('active', true)->orderByDesc('event_date')->get();
        foreach ($cadetComps as $cadetComp) {
            if ($cadetComp->event_date < Carbon::today()) {
                $oldEvents[] = $cadetComp;
            } else {
                $events[] = $cadetComp;
            }
        }

        return view('layouts.app', compact('header', 'title', 'scripts', 'events', 'oldEvents'));
    }
}
