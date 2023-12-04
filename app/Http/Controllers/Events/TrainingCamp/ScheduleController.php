<?php

namespace App\Http\Controllers\Events\TrainingCamp;

use App\Http\Controllers\Controller;
use App\Models\TrainingCamp\TrainingCampEvent;
use App\Models\TrainingCamp\TrainingCampMeal;
use App\Models\TrainingCamp\TrainingCampMealCheckin;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ScheduleController extends Controller
{
    /**
     * @param $eventId
     * @return Factory|View|Application
     */
    public function index($eventId): Factory|View|Application
    {
        $event = TrainingCampEvent::query()->findOrFail($eventId);

        return view('trainingcamp.schedule.index', compact('event'));
    }
}
