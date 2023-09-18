<?php

namespace App\Http\Controllers\Events\CadetOfTheYear;

use App\Http\Controllers\Controller;
use App\Models\CadetOfTheYear\CadetOfTheYearEvent;
use App\Models\CadetOfTheYear\CadetOfTheYearInspectionField;
use App\Models\CadetOfTheYear\CadetOfTheYearInspectionResult;
use Composer\Console\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\View\Factory;
use Illuminate\View\View;

class CadetOfTheYearController extends Controller
{
    public function index($eventId)
    {
        $event = CadetOfTheYearEvent::query()->findOrFail($eventId);

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

        $judgeData = array();
        $judges = CadetOfTheYearInspectionResult::query()
            ->where('event_id', $eventId)
            ->select('inspected_by')
            ->distinct()
            ->get();

        foreach ($judges as $judge) {
            $judgeResults = CadetOfTheYearInspectionResult::query()
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
                'count' => sizeof($judgeResults),
                'points' => $points
            );
        }

        return view('cadet_of_the_year.uniforminspection.results', compact('event', 'results', 'fields', 'judgeData'));
    }

    public function deleteInspection($eventId, $memberId)
    {
        $inspectionResults = CadetOfTheYearInspectionResult::query()
            ->where('event_id', $eventId)
            ->where('member_id', $memberId)
            ->get();

        foreach ($inspectionResults as $result) {
            $result->delete();
        }

        return redirect(route('cadet_comp.index', ['eventId' => $eventId]))
            ->with('success', 'Inspect Removed');
    }

    /**
     * Display a listing of the resource.
     *
     * @param $eventId
     * @return Application|Factory|View
     */
    public function fields_index($eventId): View|Factory|Application
    {
        $event = CadetOfTheYearEvent::query()->findOrFail($eventId);

        return view('cadet_of_the_year.uniforminspection.index', compact('event'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param $eventId
     * @return Application|Factory|View
     */
    public function create($eventId): View|Factory|Application
    {
        $event = CadetOfTheYearEvent::query()->findOrFail($eventId);

        $fields = $event->inspection_fields()->get();

        return view('cadet_of_the_year.uniforminspection.create', compact('event', 'fields'));
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

        $event = CadetOfTheYearEvent::query()->findOrFail($eventId);

        $order = $request->get('displayOrder');
        $sortOrder = $order + 1;

        //Push Fields down the list
        $fields = $event->inspection_fields()->where('display_order', '>=', $sortOrder)->get();
        foreach ($fields as $f) {
            $f->display_order += 1;
            $f->save();
        }

        $newField = new CadetOfTheYearInspectionField();
        $newField->event_id = $eventId;
        $newField->name = $request->get('name');
        $newField->display_order = $sortOrder;
        $newField->save();

        $this->resetDisplayOrder($eventId);

        return redirect(route('cadet_comp.uniforminspection.index', ['eventId' => $eventId]))
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
        $event = CadetOfTheYearEvent::query()->findOrFail($eventId);

        $fields = $event->inspection_fields()->get();
        $field = CadetOfTheYearInspectionField::query()->where('event_id', $eventId)->find($fieldId);

        return view('cadet_of_the_year.uniforminspection.edit', compact('event', 'fields', 'field'));
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

        $event = CadetOfTheYearEvent::query()->findOrFail($eventId);

        $order = $request->get('displayOrder');
        $sortOrder = $order + 1;

        //Push Fields down the list
        $fields = $event->inspection_fields()->where('display_order', '>=', $sortOrder)->get();
        foreach ($fields as $f) {
            $f->display_order += 1;
            $f->save();
        }

        $field = CadetOfTheYearInspectionField::query()->where('event_id', $eventId)->find($fieldId);
        $field->name = $request->get('name');
        $field->display_order = $sortOrder;
        $field->save();

        $this->resetDisplayOrder($eventId);

        return redirect(route('cadet_comp.uniforminspection.index', ['eventId' => $eventId]))
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
        $field = CadetOfTheYearInspectionField::query()->where('event_id', $eventId)->find($fieldId);
        if ($field != null) {
            $field->delete();
        }

        $this->resetDisplayOrder($eventId);

        return redirect(route('cadet_comp.uniforminspection.index', ['eventId' => $eventId]))
            ->with('success', 'Inspection Field Deleted');
    }

    /**
     * @param $eventId
     * @return void
     */
    private function resetDisplayOrder($eventId): void
    {
        $fields = CadetOfTheYearInspectionField::query()->where('event_id', $eventId)->orderBy('display_order')->get();
        $order = 1;
        foreach ($fields as $f) {
            $f->display_order = $order++;
            $f->save();
        }
    }
}
