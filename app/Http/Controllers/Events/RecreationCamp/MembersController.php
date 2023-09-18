<?php

namespace App\Http\Controllers\Events\RecreationCamp;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Member;
use App\Models\RecreationCamp\RecreationCampEvent;
use App\Models\RecreationCamp\RecreationCampMember;
use App\Models\RecreationCamp\RecreationCampRoom;
use App\Models\RecreationCamp\RecreationCampTeam;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MembersController extends Controller
{
    public function index($eventId)
    {
        $event = RecreationCampEvent::query()->findOrFail($eventId);

        return view('recreationcamp.members.index', compact('event'));
    }

    public function view($eventId, $registrationId)
    {
        $event = RecreationCampEvent::query()->findOrFail($eventId);
        $registration = RecreationCampMember::query()->findOrFail($registrationId);

        return view('recreationcamp.members.view', compact('event', 'registration'));
    }

    public function edit($eventId, $registrationId)
    {
        $event = RecreationCampEvent::query()->findOrFail($eventId);
        $registration = RecreationCampMember::query()->findOrFail($registrationId);
        $teams = RecreationCampTeam::query()->orderBy('name')->get();
        $rooms = RecreationCampRoom::query()->orderBy('room_number')->get();

        return view('recreationcamp.members.edit', compact('event', 'registration', 'teams', 'rooms'));
    }

    public function update($eventId, $registrationId, Request $request)
    {
        //Validation
        Validator::make($request->all(), [
            'dietary_requirements' => 'nullable|string|max:200',
            'medical_requirements' => 'nullable|string|max:200',
            'team' => 'required|numeric',
            'room' => 'required|numeric',
        ])->validate();

        $registration = RecreationCampMember::query()->find($registrationId);
        if ($registration == null) {
            return redirect(route('recreationcamp.members.index'))->with('error', 'Invalid Registration');
        }

        $registration->team_id = $request->get('team');
        $registration->room_id = $request->get('room');
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

        return redirect(route('recreationcamp.members.view', ['eventId' => $eventId, 'registrationId' => $registrationId]))
            ->with('success', 'Details successfully updated');
    }

    public function medicalMembers($eventId)
    {
        $event = RecreationCampEvent::query()->findOrFail($eventId);

        return view('recreationcamp.members.medical', compact('event'));
    }

    public function dietaryMembers($eventId)
    {
        $event = RecreationCampEvent::query()->findOrFail($eventId);

        return view('recreationcamp.members.dietary', compact('event'));
    }

    public function locateByMember($eventId)
    {
        $event = RecreationCampEvent::query()->findOrFail($eventId);
        $members = Member::query()->where('active', true)->orderBy('last_name')->orderBy('first_name')->get();

        return view('recreationcamp.members.registration.locate_member', compact('event', 'members'));
    }

    public function registerByMember($eventId, $memberId)
    {
        $event = RecreationCampEvent::query()->findOrFail($eventId);
        $member = Member::query()->findOrFail($memberId);
        $teams = RecreationCampTeam::query()->orderBy('name')->get();
        $rooms = RecreationCampRoom::query()->orderBy('room_number')->get();

        return view('recreationcamp.members.registration.member', compact('event', 'member', 'teams', 'rooms'));
    }

    public function storeMemberRegistration($eventId, Request $request)
    {
        //Validation
        Validator::make($request->all(), [
            'memberId' => 'required',
            'dietary_requirements' => 'nullable|string|max:200',
            'medical_requirements' => 'nullable|string|max:200',
            'team' => 'required|numeric',
            'room' => 'required|numeric',
        ])->validate();

        $memberId = $request->get('memberId');
        $registration = RecreationCampMember::query()->where('member_id', $memberId)->first();
        if ($registration == null) {
            $registration = new RecreationCampMember();
            $registration->event_id = $eventId;
            $registration->member_id = $memberId;
        }

        $registration->team_id = $request->get('team');
        $registration->room_id = $request->get('room');
        $registration->save();

        $member = Member::query()->find($memberId);
        if ($request->has('dietary_requirements') && $request->get('dietary_requirements') != null) {
            $member->dietary_requirements = $request->get('dietary_requirements');
        }
        if ($request->has('medical_requirements') && $request->get('medical_requirements') != null) {
            $member->medical_requirements = $request->get('medical_requirements');
        }
        $member->save();

        return redirect(route('recreationcamp.members.register.member', ['eventId' => $eventId]))
            ->with('success', $member->first_name . ' ' . $member->last_name . ' successfully registered to Camp');
    }

    public function locateByUnit($eventId)
    {
        $event = RecreationCampEvent::query()->findOrFail($eventId);

        return view('recreationcamp.members.registration.unit', compact('event'));
    }

    public function registerByUnit($eventId, $unitId)
    {

    }

    public function storeByUnit($eventId, Request $request)
    {

    }

    public function campCheckIn($eventId, $registrationId)
    {
        $registration = RecreationCampMember::query()->find($registrationId);
        if ($registration != null ) {
            if ($registration->camp_checkin != null) {
                return redirect(route('recreationcamp.members.index', ['eventId' => $eventId]))
                    ->with('success', $registration->member->first_name . ' ' . $registration->member->last_name . ' already checked into Camp');
            }

            $registration->camp_checkin = Carbon::now();
            $registration->save();

            return redirect(route('recreationcamp.members.index', ['eventId' => $eventId]))
                ->with('success', $registration->member->first_name . ' ' . $registration->member->last_name . ' successfully checked into Camp');
        }

        return redirect(route('recreationcamp.members.index', ['eventId' => $eventId]));
    }
}
