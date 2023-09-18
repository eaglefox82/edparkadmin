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

class MealScheduleController extends Controller
{

    /**
     * @param $eventId
     * @return Factory|View|Application
     */
    public function createMealSchedule($eventId): Factory|View|Application
    {
        $event = TrainingCampEvent::query()->findOrFail($eventId);

        return view('trainingcamp.schedule.createMeal', compact('event'));
    }

    /**
     * @param Request $request
     * @param $eventId
     * @return Redirector|Application|RedirectResponse
     * @throws ValidationException
     */
    public function storeMealSchedule(Request $request, $eventId): Redirector|Application|RedirectResponse
    {
        //Validation
        Validator::make($request->all(), [
            'meal_name' => 'required',
            'start_time' => ['required', 'date'],
        ])->validate();

        $event = TrainingCampEvent::query()->findOrFail($eventId);

        $meal = new TrainingCampMeal();
        $meal->event_id = $event->id;
        $meal->name = $request->get('meal_name');
        $meal->start_time = Carbon::createFromFormat('d/m/Y H:i', $request->get('start_time'));
        $meal->save();

        return redirect(route('trainingcamp.schedule.index', ['eventId' => $eventId]));
    }

    /**
     * @param $eventId
     * @param $mealId
     * @return Redirector|Application|RedirectResponse
     */
    public function deleteMealSchedule($eventId, $mealId): Redirector|Application|RedirectResponse
    {
        $meal = TrainingCampMeal::query()
            ->where('event_id', $eventId)
            ->find($mealId);

        if ($meal != null) {
            $meal->delete();
        }

        return redirect(route('trainingcamp.schedule.index', ['eventId' => $eventId]))
            ->with('success', 'Meal Schedule Deleted');
    }

    /**
     * @param $eventId
     * @param $mealId
     * @return Factory|View|Redirector|Application|RedirectResponse
     */
    public function viewMeal($eventId, $mealId): Factory|View|Redirector|Application|RedirectResponse
    {
        $event = TrainingCampEvent::query()->findOrFail($eventId);
        $meal = $event->meals()->find($mealId);
        if ($meal == null) {
            return redirect(route('trainingcamp.schedule.index', ['eventId' => $eventId]))
                ->with('error', 'Invalid Meal Selection');
        }

        $notPresent = $event->members()
            ->where('camp_checkin', '<>', null)
            ->where('camp_checkout', null)
            ->with('meal_checkins')
            ->whereDoesntHave('meal_checkins', function ($query) use ($mealId){
                $query->where('meal_id', $mealId);
            })
            ->get();

        $present = $meal->checkins()->get();

        return view('trainingcamp.schedule.meal_view', compact('event', 'meal', 'notPresent', 'present'));
    }

    public function markMemberPresent($eventId, $mealId, $memberId)
    {
        $event = TrainingCampEvent::query()->findOrFail($eventId);
        $meal = $event->meals()->find($mealId);
        if ($meal == null) {
            return redirect(route('trainingcamp.schedule.index', ['eventId' => $eventId]))
                ->with('error', 'Invalid Meal Selection');
        }

        $member = $event->members()->find($memberId);
        if ($member == null) {
            return redirect(route('trainingcamp.schedule.meals.view', ['eventId' => $eventId, 'mealId' => $mealId]))
                ->with('error', 'Invalid Member');
        }

        $checkIn = $meal->checkins()->where('member_id', $member->id)->first();
        if ($checkIn == null) {
            $checkIn = new TrainingCampMealCheckin();
            $checkIn->event_id = $event->id;
            $checkIn->meal_id = $meal->id;
            $checkIn->member_id = $member->id;
            $checkIn->save();
        }

        return redirect(route('trainingcamp.schedule.meals.view', ['eventId' => $eventId, 'mealId' => $mealId]))
            ->with('success', $member->member->last_name . ', ' . $member->member->first_name . ' - Marked Present');
    }
}
