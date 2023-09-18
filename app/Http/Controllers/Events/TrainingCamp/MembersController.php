<?php

namespace App\Http\Controllers\Events\TrainingCamp;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\TrainingCamp\TrainingCampEvent;
use App\Models\TrainingCamp\TrainingCampFlight;
use App\Models\TrainingCamp\TrainingCampMember;
use App\Models\TrainingCamp\TrainingCampRoom;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MembersController extends Controller
{
    public function index($eventId)
    {
        $event = TrainingCampEvent::query()->findOrFail($eventId);

        return view('trainingcamp.members.index', compact('event'));
    }

    public function bandTraining($eventId)
    {
        $event = TrainingCampEvent::query()->findOrFail($eventId);

        return view('trainingcamp.members.band', compact('event'));
    }

    public function dayVisitors($eventId)
    {
        $event = TrainingCampEvent::query()->findOrFail($eventId);

        return view('trainingcamp.members.day_visitors', compact('event'));
    }

    public function view($eventId, $registrationId)
    {
        $event = TrainingCampEvent::query()->findOrFail($eventId);
        $registration = TrainingCampMember::query()->findOrFail($registrationId);

        return view('trainingcamp.members.view', compact('event', 'registration'));
    }

    public function edit($eventId, $registrationId)
    {
        $event = TrainingCampEvent::query()->findOrFail($eventId);
        $registration = TrainingCampMember::query()->findOrFail($registrationId);
        $flights = TrainingCampFlight::query()->orderBy('name')->get();
        $rooms = TrainingCampRoom::query()->orderBy('room_number')->get();

        return view('trainingcamp.members.edit', compact('event', 'registration', 'flights', 'rooms'));
    }

    public function update($eventId, $registrationId, Request $request)
    {
        //Validation
        Validator::make($request->all(), [
            'dietary_requirements' => 'nullable|string|max:200',
            'medical_requirements' => 'nullable|string|max:200',
            'flight' => 'required|numeric',
            'room' => 'required|numeric',
            'band_training' => 'required|string',
            'day_visitor' => 'required|string',
        ])->validate();

        $registration = TrainingCampMember::query()->find($registrationId);
        if ($registration == null) {
            return redirect(route('trainingcamp.members.index'))->with('error', 'Invalid Registration');
        }

        $registration->flight_id = $request->get('flight');
        $registration->room_id = $request->get('room');
        $registration->band_training = false;
        if ($request->get('band_training') == 'true') {
            $registration->band_training = true;
        }
        $registration->day_visitor = false;
        if ($request->get('day_visitor') == 'true') {
            $registration->day_visitor = true;
        }
        $registration->save();

        if ($request->has('dietary_requirements') && $request->get('dietary_requirements') != null) {
            $registration->member->dietary_requirements = $request->get('dietary_requirements');
        } else {
            $registration->member->dietary_requirements = '';
        }

        if ($request->has('medical_requirements') && $request->get('medical_requirements') != null) {
            $registration->member->medical_requirements = $request->get('medical_requirements');
        } else {
            $registration->member->medical_requirements = '';
        }
        $registration->member->save();

        return redirect(route('trainingcamp.members.view', ['eventId' => $eventId, 'registrationId' => $registrationId]))
            ->with('success', 'Details successfully updated');
    }

    public function medicalMembers($eventId)
    {
        $event = TrainingCampEvent::query()->findOrFail($eventId);

        return view('trainingcamp.members.medical', compact('event'));
    }

    public function dietaryMembers($eventId)
    {
        $event = TrainingCampEvent::query()->findOrFail($eventId);

        return view('trainingcamp.members.dietary', compact('event'));
    }

    public function locateByMember($eventId)
    {
        $event = TrainingCampEvent::query()->findOrFail($eventId);
        $members = Member::query()->where('active', true)->orderBy('last_name')->orderBy('first_name')->get();

        return view('trainingcamp.members.registration.locate_member', compact('event', 'members'));
    }

    public function registerByMember($eventId, $memberId)
    {
        $event = TrainingCampEvent::query()->findOrFail($eventId);
        $member = Member::query()->findOrFail($memberId);
        $flights = TrainingCampFlight::query()->orderBy('name')->get();
        $rooms = TrainingCampRoom::query()->orderBy('room_number')->get();

        return view('trainingcamp.members.registration.member', compact('event', 'member', 'flights', 'rooms'));
    }

    public function storeMemberRegistration($eventId, Request $request)
    {
        //Validation
        Validator::make($request->all(), [
            'memberId' => 'required',
            'dietary_requirements' => 'nullable|string|max:200',
            'medical_requirements' => 'nullable|string|max:200',
            'flight' => 'required|numeric',
            'room' => 'required|numeric',
            'band_training' => 'required|string',
            'day_visitor' => 'required|string',
        ])->validate();

        $memberId = $request->get('memberId');
        $registration = TrainingCampMember::query()->where('member_id', $memberId)->first();
        if ($registration == null) {
            $registration = new TrainingCampMember();
            $registration->event_id = $eventId;
            $registration->member_id = $memberId;
        }

        $registration->flight_id = $request->get('flight');
        $registration->room_id = $request->get('room');
        $registration->band_training = false;
        if ($request->get('band_training') == 'true') {
            $registration->band_training = true;
        }
        $registration->day_visitor = false;
        if ($request->get('day_visitor') == 'true') {
            $registration->day_visitor = true;
        }
        $registration->save();

        $member = Member::query()->find($memberId);
        if ($request->has('dietary_requirements') && $request->get('dietary_requirements') != null) {
            $member->dietary_requirements = $request->get('dietary_requirements');
        }
        if ($request->has('medical_requirements') && $request->get('medical_requirements') != null) {
            $member->medical_requirements = $request->get('medical_requirements');
        }
        $member->save();

        return redirect(route('trainingcamp.members.register.member', ['eventId' => $eventId]))
            ->with('success', $member->first_name . ' ' . $member->last_name . ' successfully registered to Camp');
    }

    public function campCheckIn(Request $request, $eventId)
    {
        //Validation
        Validator::make($request->all(), [
            'eventId' => 'required',
            'registrationId' => 'required|numeric|min:1',
            'form17a' => 'required',
        ])->validate();

        $registrationId = $request->get('registrationId');

        $registration = TrainingCampMember::query()->find($registrationId);
        if ($registration != null) {
            if ($registration->camp_checkin != null) {
                return redirect(route('trainingcamp.members.index', ['eventId' => $eventId]))
                    ->with('success', $registration->member->first_name . ' ' . $registration->member->last_name . ' already checked into Camp');
            }

            $registration->form17a_received = false;
            if ($request->get('form17a') == '1') {
                $registration->form17a_received = true;
            }
            $registration->camp_checkin = Carbon::now();
            $registration->save();

            return redirect(route('trainingcamp.members.checkin.print', ['eventId' => $eventId, 'registrationId' => $registrationId]));
        }

        return redirect(route('trainingcamp.members.index', ['eventId' => $eventId]));
    }

    public function dayCheckIn($eventId, $registrationId)
    {
        $registration = TrainingCampMember::query()->find($registrationId);
        if ($registration != null) {
            $registration->camp_checkin = Carbon::now();
            $registration->save();

            return redirect()->back()
                ->with('success', $registration->member->first_name . ' ' . $registration->member->last_name . ' successfully checked into Camp');
        }

        return redirect(route('trainingcamp.members.index', ['eventId' => $eventId]));
    }

    public function campCheckOut($eventId, $registrationId)
    {
        $registration = TrainingCampMember::query()->find($registrationId);
        if ($registration != null) {
            $registration->camp_checkout = Carbon::now();
            $registration->save();

            return redirect()->back()
                ->with('success', $registration->member->first_name . ' ' . $registration->member->last_name . ' successfully checked out of Camp');
        }

        return redirect(route('trainingcamp.members.index', ['eventId' => $eventId]));
    }

    public function printCheckIn($eventId, $registrationId)
    {
        $event = TrainingCampEvent::query()->findOrFail($eventId);
        $registration = TrainingCampMember::query()->find($registrationId);
        if ($registration == null) {
            return redirect(route('trainingcamp.members.index', ['eventId' => $eventId]));
        }

        return view('trainingcamp.members.print', compact('event', 'registration'));
    }

    public function printCheckInPage($eventId, $registrationId)
    {
        $event = TrainingCampEvent::query()->findOrFail($eventId);
        $registration = TrainingCampMember::query()->find($registrationId);
        if ($registration == null) {
            return redirect(route('trainingcamp.members.index', ['eventId' => $eventId]));
        }

        $noContinue = true;
        return view('trainingcamp.members.print', compact('event', 'registration', 'noContinue'));
    }

    public function checkinFinal($eventId, $registrationId)
    {
        $registration = TrainingCampMember::query()->find($registrationId);
        if ($registration != null) {
            return redirect(route('trainingcamp.members.index', ['eventId' => $eventId]))
                ->with('success', $registration->member->first_name . ' ' . $registration->member->last_name . ' successfully checked into Camp');
        }

        return redirect(route('trainingcamp.members.index', ['eventId' => $eventId]));
    }

    public function printMemberSlip($eventId, $registrationId)
    {
        $event = TrainingCampEvent::query()->findOrFail($eventId);
        $registration = TrainingCampMember::query()->find($registrationId);
        if ($registration == null) {
            return redirect(route('trainingcamp.members.index', ['eventId' => $eventId]));
        }

        return view('trainingcamp.members.member_slip_qr', compact('event', 'registration'));
    }
}
