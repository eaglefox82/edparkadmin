<?php

namespace App\Http\Controllers\Events\CeremonialParade;

use App\Http\Controllers\Controller;
use App\Models\CeremonialParade\CeremonialParadeEvent;
use App\Models\CeremonialParade\CeremonialParadeUnitCheckIn;
use App\Models\Squadron;
use App\Models\Wing;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CeremonialParadeController extends Controller
{
    //
    public function index($eventId)
    {
        $event = CeremonialParadeEvent::query()->find($eventId);

        $wingsOnParade = array();
        foreach ($event->wings as $wingRecord) {
            if ($wingRecord->checked_in == null) {
                continue;
            }

            $wingsOnParade[] = array(
              'name' => $wingRecord->wing->name,
              'on_parade' => $wingRecord->on_parade + $event->wingUnitAttendance($wingRecord->wing)
            );
        }

        $squadrons = $event->squadrons()->where('checked_in', '<>', null)->orderBy('on_parade', 'desc')->get();

        return view('ceremonialparade.index', compact('event', 'wingsOnParade', 'squadrons'));
    }

    public function squadrons($eventId)
    {
        $event = CeremonialParadeEvent::query()->find($eventId);

        $squadrons = Squadron::query()->where('active', 1)->get();

        $presentSquadrons = array();
        foreach ($event->squadrons as $checkedIn) {
            $presentSquadrons[$checkedIn->squadron_id] = $checkedIn;
        }

        return view('ceremonialparade.squadrons', compact('event', 'squadrons', 'presentSquadrons'));
    }

    public function squadrons_load($eventId)
    {
        $event = CeremonialParadeEvent::query()->find($eventId);
        $squadrons = Squadron::query()->where('active', 1)->get();

        $presentSquadrons = array();
        foreach ($event->squadrons as $checkedIn) {
            $presentSquadrons[$checkedIn->squadron_id] = $checkedIn;
        }

        foreach ($squadrons as $sqn) {
            if (!array_key_exists($sqn->id, $presentSquadrons)) {
                $rego = new CeremonialParadeUnitCheckIn();
                $rego->event_id = $eventId;
                $rego->squadron_id = $sqn->id;
                $rego->on_parade = 0;
                $rego->save();
            }
        }

        return redirect(route('ceremonialparade.squadron', ['eventId' => $eventId]))
            ->with('success', 'Active Squadrons Loaded Into Event');
    }

    public function squadron_checkin($eventId, $sqnId)
    {
        $event = CeremonialParadeEvent::query()->find($eventId);
        $squadron = Squadron::query()->find($sqnId);
        if ($squadron == null) {
            return redirect(route('ceremonialparade.squadron', ['eventId' => $eventId]));
        }

        $rego = $event->squadrons()->where('squadron_id', $sqnId)->first();

        return view('ceremonialparade.squadron_checkin', compact('event', 'squadron', 'rego'));
    }

    public function process_squadron_checkin($eventId, $sqnId, Request $request)
    {
        //Validation
        Validator::make($request->all(), [
            'on_parade' => 'required|numeric|min:1',
        ])->validate();

        $event = CeremonialParadeEvent::query()->find($eventId);
        $squadron = Squadron::query()->find($sqnId);
        if ($squadron == null) {
            return redirect(route('ceremonialparade.squadron', ['eventId' => $eventId]));
        }

        $onParade = $request->get('on_parade');

        //Check for existing registration
        $rego = $event->squadrons()->where('squadron_id', $sqnId)->first();
        if ($rego == null) {
            $rego = new CeremonialParadeUnitCheckIn();
            $rego->event_id = $eventId;
            $rego->squadron_id = $sqnId;
        }
        $rego->checked_in = Carbon::now();
        $rego->on_parade = $onParade;
        $rego->roll_strength = $squadron->members()->whereIn('type', [1, 3])->count();
        $rego->save();

        return redirect(route('ceremonialparade.squadron', ['eventId' => $eventId]))
            ->with('success', $squadron->name . ' Squadron Checked-In');
    }

    public function wings($eventId)
    {
        $event = CeremonialParadeEvent::query()->find($eventId);

        $wings = Wing::query()->where('active', 1)->get();

        $presentWings = array();
        foreach ($event->wings as $checkedIn) {
            $presentWings[$checkedIn->wing_id] = $checkedIn;
        }

        return view('ceremonialparade.wings', compact('event', 'wings', 'presentWings'));
    }

    public function wings_load($eventId)
    {
        $event = CeremonialParadeEvent::query()->find($eventId);

        $wings = Wing::query()->where('active', 1)->get();

        $presentWings = array();
        foreach ($event->wings as $checkedIn) {
            $presentWings[$checkedIn->wing_id] = $checkedIn;
        }

        foreach ($wings as $wing) {
            if (!array_key_exists($wing->id, $presentWings)) {
                $rego = new CeremonialParadeUnitCheckIn();
                $rego->event_id = $eventId;
                $rego->wing_id = $wing->id;
                $rego->on_parade = 0;
                $rego->save();
            }
        }

        return redirect(route('ceremonialparade.wing', ['eventId' => $eventId]))
            ->with('success', 'Active Wings Loaded Into Event');
    }

    public function wing_checkin($eventId, $wingId)
    {
        $event = CeremonialParadeEvent::query()->find($eventId);
        $wing = Wing::query()->find($wingId);
        if ($wing == null) {
            return redirect(route('ceremonialparade.wing', ['eventId' => $eventId]));
        }

        $rego = $event->wings()->where('wing_id', $wingId)->first();

        return view('ceremonialparade.wing_checkin', compact('event', 'wing', 'rego'));
    }

    public function process_wing_checkin($eventId, $wingId, Request $request)
    {
        //Validation
        Validator::make($request->all(), [
            'on_parade' => 'required|numeric|min:0',
        ])->validate();

        $event = CeremonialParadeEvent::query()->find($eventId);
        $wing = Wing::query()->find($wingId);
        if ($wing == null) {
            return redirect(route('ceremonialparade.wing', ['eventId' => $eventId]));
        }

        $onParade = $request->get('on_parade');

        //Check for existing registration
        $rego = $event->wings()->where('wing_id', $wingId)->first();
        if ($rego == null) {
            $rego = new CeremonialParadeUnitCheckIn();
            $rego->event_id = $eventId;
            $rego->wing_id = $wingId;
        }
        $rego->checked_in = Carbon::now();
        $rego->on_parade = $onParade;
        $rego->roll_strength = $wing->roll_strength();
        $rego->save();

        return redirect(route('ceremonialparade.wing', ['eventId' => $eventId]))->with('success', $wing->name . ' Wing Checked-In');
    }
}
