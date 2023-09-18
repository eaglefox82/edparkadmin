<?php

namespace App\Http\Controllers\Events\TrainingCamp;

use App\Http\Controllers\Controller;
use App\Models\TrainingCamp\TrainingCampEvent;
use App\Models\TrainingCamp\TrainingCampInspectionField;
use App\Models\TrainingCamp\TrainingCampInspectionResult;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class UniformInspectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param $eventId
     * @return Application|Factory|View
     */
    public function index($eventId): View|Factory|Application
    {
        $event = TrainingCampEvent::query()->findOrFail($eventId);

        return view('trainingcamp.uniforminspection.index', compact('event'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param $eventId
     * @return Application|Factory|View
     */
    public function create($eventId): View|Factory|Application
    {
        $event = TrainingCampEvent::query()->findOrFail($eventId);

        $fields = $event->inspection_fields()->get();

        return view('trainingcamp.uniforminspection.create', compact('event', 'fields'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param $eventId
     * @return Application|Redirector|RedirectResponse
     * @throws ValidationException
     * @throws ValidationException
     */
    public function store(Request $request, $eventId): Redirector|RedirectResponse|Application
    {
        //Validation
        Validator::make($request->all(), [
            'name' => 'required',
            'displayOrder' => ['required', 'numeric', 'min:0'],
        ])->validate();

        $event = TrainingCampEvent::query()->findOrFail($eventId);

        $order = $request->get('displayOrder');
        $sortOrder = $order + 1;

        //Push Fields down the list
        $fields = $event->inspection_fields()->where('display_order', '>=', $sortOrder)->get();
        foreach ($fields as $f) {
            $f->display_order += 1;
            $f->save();
        }

        $newField = new TrainingCampInspectionField();
        $newField->event_id = $eventId;
        $newField->name = $request->get('name');
        $newField->display_order = $sortOrder;
        $newField->save();

        $this->resetDisplayOrder($eventId);

        return redirect(route('trainingcamp.uniforminspection.index', ['eventId' => $eventId]))
            ->with('success', 'Inspection Field Created');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $eventId
     * @param $fieldId
     * @return Application|Factory|View
     */
    public function edit($eventId, $fieldId): View|Factory|Application
    {
        $event = TrainingCampEvent::query()->findOrFail($eventId);

        $fields = $event->inspection_fields()->get();
        $field = TrainingCampInspectionField::query()->where('event_id', $eventId)->find($fieldId);

        return view('trainingcamp.uniforminspection.edit', compact('event', 'fields', 'field'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $eventId
     * @param $fieldId
     * @return Application|Redirector|RedirectResponse
     * @throws ValidationException
     */
    public function update(Request $request, $eventId, $fieldId): Redirector|RedirectResponse|Application
    {
        //Validation
        Validator::make($request->all(), [
            'name' => 'required',
            'displayOrder' => ['required', 'numeric', 'min:0'],
        ])->validate();

        $event = TrainingCampEvent::query()->findOrFail($eventId);

        $order = $request->get('displayOrder');
        $sortOrder = $order + 1;

        //Push Fields down the list
        $fields = $event->inspection_fields()->where('display_order', '>=', $sortOrder)->get();
        foreach ($fields as $f) {
            $f->display_order += 1;
            $f->save();
        }

        $field = TrainingCampInspectionField::query()->where('event_id', $eventId)->find($fieldId);
        $field->name = $request->get('name');
        $field->display_order = $sortOrder;
        $field->save();

        $this->resetDisplayOrder($eventId);

        return redirect(route('trainingcamp.uniforminspection.index', ['eventId' => $eventId]))
            ->with('success', 'Inspection Field Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $eventId
     * @param int $fieldId
     * @return Application|RedirectResponse|Redirector
     */
    public function destroy($eventId, $fieldId): Redirector|RedirectResponse|Application
    {
        $field = TrainingCampInspectionField::query()->where('event_id', $eventId)->find($fieldId);
        if ($field != null) {
            $field->delete();
        }

        $this->resetDisplayOrder($eventId);

        return redirect(route('trainingcamp.uniforminspection.index', ['eventId' => $eventId]))
            ->with('success', 'Inspection Field Deleted');
    }

    /**
     * @param $eventId
     * @return void
     */
    private function resetDisplayOrder($eventId): void
    {
        $fields = TrainingCampInspectionField::query()->where('event_id', $eventId)->orderBy('display_order')->get();
        $order = 1;
        foreach ($fields as $f) {
            $f->display_order = $order++;
            $f->save();
        }
    }

    /**
     * @param $eventId
     * @return Application|Factory|View
     */
    public function inspectionResults($eventId): View|Factory|Application
    {
        $event = TrainingCampEvent::query()->findOrFail($eventId);

        //Member Results
        $results = $event->members()->whereHas('inspection_results')->get();

        //Field Results
        $fields = array();
        foreach ($event->inspection_fields as $field) {
            $fields[] = array(
                'name' => $field->name,
                'average_points' => $field->averagePoints()
            );
        }

        //Unit Results
        $unitData = array();
        foreach ($results as $mem) {
            if (array_key_exists($mem->member->unit, $unitData)) {
                $unit = $unitData[$mem->member->unit];
            } else {
                $unit = array(
                    'name' => $mem->member->unit,
                    'count' => 0,
                    'points' => 0
                );
            }

            $unit['count'] += 1;
            $unit['points'] += $mem->inspection_results()->sum('points_lost');

            $unitData[$mem->member->unit] = $unit;
        }

        $judgeData = array();
        $judges = TrainingCampInspectionResult::query()
            ->where('event_id', $eventId)
            ->select('inspected_by')
            ->distinct()
            ->get();

        foreach ($judges as $judge) {
            $judgeResults = TrainingCampInspectionResult::query()
                ->where('event_id', $eventId)
                ->where('inspected_by', $judge->inspected_by)
                ->groupBy('member_id')
                ->selectRaw('member_id, SUM(points_lost) as lost')
                ->get();

            $points = 0;
            foreach ($judgeResults as $judgeResult) {
                $points += $judgeResult->lost;
            }

            $judgeData[$judge->inspected_by] = array(
                'name' => $judge->inspected_by,
                'count'=> sizeof($judgeResults),
                'points' => $points
            );
        }

        return view('trainingcamp.uniforminspection.results',
            compact('event', 'results', 'unitData', 'fields', 'judgeData'));
    }

    public function deleteInspection($eventId, $memberId)
    {
        $inspectionResults = TrainingCampInspectionResult::query()
            ->where('event_id', $eventId)
            ->where('member_id', $memberId)
            ->get();

        foreach ($inspectionResults as $result) {
            $result->delete();
        }

        return redirect(route('trainingcamp.uniforminspection.view', ['eventId' => $eventId]))
            ->with('success', 'Inspect Removed');
    }
}
