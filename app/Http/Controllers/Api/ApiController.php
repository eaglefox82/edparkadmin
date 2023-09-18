<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CadetOfTheYear\CadetOfTheYearEvent;
use App\Models\CadetOfTheYear\CadetOfTheYearInspectionResult;
use App\Models\CadetOfTheYear\CadetOfTheYearParticipant;
use App\Models\CeremonialParade\CeremonialParadeEvent;
use App\Models\Member;
use App\Models\RecreationCamp\RecreationCampEvent;
use App\Models\TrainingCamp\TrainingCampEvent;
use App\Models\TrainingCamp\TrainingCampInspectionField;
use App\Models\TrainingCamp\TrainingCampInspectionResult;
use App\Models\TrainingCamp\TrainingCampMealCheckin;
use App\Models\TrainingCamp\TrainingCampMember;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApiController extends Controller
{
    private $apiKey = 'b5c8dba6-cb00-4016-8a3c-83ea11d909b8';

    private function isRequestApiKeyValid(Request $request): bool
    {
        return $request->hasHeader('X-AAL-API-KEY') && $request->header('X-AAL-API-KEY') == $this->apiKey;
    }

    public function getEvents(Request $request): JsonResponse
    {
        if (!$this->isRequestApiKeyValid($request)) {
            return response()->json(array('status' => 'Unauthorized'), 401);
        }

        $events = array();
        $recCamps = RecreationCampEvent::query()->where('active', true)->orderByDesc('from_date')->get();
        foreach ($recCamps as $camp) {
            if ($camp->from_date >= Carbon::now()) {
                $events[] = array(
                    'id' => $camp->id,
                    'name' => $camp->name,
                    'eventType' => 1,
                );
            }
        }

        $parades = CeremonialParadeEvent::query()->where('active', true)->orderByDesc('event_date')->get();
        foreach ($parades as $parade) {
            if ($parade->event_date >= Carbon::now()) {
                $events[] = array(
                    'id' => $parade->id,
                    'name' => $parade->name,
                    'eventType' => 2,
                );
            }
        }

        $trainingCamps = TrainingCampEvent::query()->where('active', true)->orderByDesc('from_date')->get();
        foreach ($trainingCamps as $camp) {
            if (Carbon::parse($camp->to_date)->addDay() >= Carbon::now()) {
                $events[] = array(
                    'id' => $camp->id,
                    'name' => $camp->name,
                    'eventType' => 3,
                );
            }
        }

        $cadetComps = CadetOfTheYearEvent::query()->where('active', true)->orderByDesc('event_date')->get();
        foreach ($cadetComps as $cadetComp) {
            if ($cadetComp->event_date >= Carbon::today()) {
                $events[] = array(
                    'id' => $cadetComp->id,
                    'name' => $cadetComp->name,
                    'eventType' => 4,
                );
            }
        }

        return response()->json(array(
            'status' => 'success',
            'data' => $events
        ));
    }

    #region Training Camp API
    public function getSchedule(Request $request): JsonResponse
    {
        if (!$this->isRequestApiKeyValid($request)) {
            return response()->json(array('status' => 'Unauthorized'), 401);
        }

        return response()->json(array(
            'status' => 'success',
            'data' => array()
        ));
    }

    public function getMeals(Request $request, $eventId): JsonResponse
    {
        if (!$this->isRequestApiKeyValid($request)) {
            return response()->json(array('status' => 'Unauthorized'), 401);
        }

        if ($eventId == 0) {
            return response()->json(array('status' => 'Invalid Data'), 400);
        }

        $event = TrainingCampEvent::query()->find($eventId);
        if ($event == null) {
            return response()->json(array('status' => 'Invalid Data'), 400);
        }

        $meals = array();
        foreach ($event->meals as $meal) {
            $meals[] = array(
                'id' => $meal->id,
                'name' => $meal->name,
                'startTime' => Carbon::parse($meal->start_time)->format('Y-m-d H:i:s'),
                'presentCount' => $meal->checkins()->count()
            );
        }

        return response()->json(array(
            'status' => 'success',
            'inCamp' => $event->members()->where('camp_checkin', '<>', null)->where('camp_checkout', null)->count(),
            'meals' => $meals
        ));
    }

    public function mealCheckIn(Request $request, $eventId): JsonResponse
    {
        if (!$this->isRequestApiKeyValid($request)) {
            return response()->json(array('status' => 'Unauthorized'), 401);
        }

        $data = json_decode($request->getContent(), true);

        //Validation
        Validator::make($data, [
            'MealId' => ['required', 'numeric'],
            'CertNo' => ['required', 'string'],
        ])->validate();

        $event = TrainingCampEvent::query()->find($eventId);
        if ($event == null) {
            return response()->json(array('status' => 'Invalid Data'), 400);
        }

        $meal = $event->meals()->where('id', $data['MealId'])->first();
        if ($meal == null) {
            return response()->json(array('status' => 'Invalid Data'), 400);
        }

        $member = Member::query()->where('cert_no', $data['CertNo'])->first();
        if ($member == null) {
            return response()->json(array('status' => 'Invalid Member'), 400);
        }

        $campAttendee = $event->members()->where('member_id', $member->id)->first();
        if ($campAttendee == null) {
            return response()->json(array('status' => 'Member Not Registered In Training Camp'), 400);
        } else if ($campAttendee->camp_checkin == null) {
            return response()->json(array('status' => 'Member Not Checked Into Training Camp'), 400);
        }

        $checkIn = $meal->checkins()->where('member_id', $campAttendee->id)->first();
        if ($checkIn == null) {
            $checkIn = new TrainingCampMealCheckin();
            $checkIn->event_id = $event->id;
            $checkIn->meal_id = $meal->id;
            $checkIn->member_id = $campAttendee->id;
            $checkIn->save();
        }

        return response()->json(array(
            'status' => 'success',
            'memberName' => $member->last_name . ', ' . $member->first_name,
            'updatedCount' => $meal->checkins()->count()
        ));
    }

    public function getMemberInspection(Request $request, $eventId, $certNo): JsonResponse
    {
        if (!$this->isRequestApiKeyValid($request)) {
            return response()->json(array('status' => 'Unauthorized'), 401);
        }

        if ($eventId == 0 || $certNo == '') {
            return response()->json(array('status' => 'Invalid Data'), 400);
        }

        $event = TrainingCampEvent::query()->find($eventId);
        if ($event == null) {
            return response()->json(array('status' => 'Invalid Data'), 400);
        }

        $member = Member::query()->where('cert_no', $certNo)->first();
        if ($member == null) {
            return response()->json(array('status' => 'Invalid Member'), 400);
        }

        $campAttendee = $event->members()->where('member_id', $member->id)->first();
        if ($campAttendee == null) {
            return response()->json(array('status' => 'Member Not Registered In Training Camp'), 400);
        } else if ($campAttendee->camp_checkin == null) {
            return response()->json(array('status' => 'Member Not Checked Into Training Camp'), 400);
        }

        //Build Member Data
        $memberData = array(
            'id' => $campAttendee->id,
            'certNo' => $member->cert_no,
            'name' => $member->last_name . ', ' . $member->first_name,
            'age' => $member->age,
            'unit' => $member->unit,
            'rank' => ''
        );

        $inspectionFields = array();
        foreach ($event->inspection_fields as $field) {
            $inspectionFields[] = array(
                'id' => $field->id,
                'name' => $field->name,
                'displayOrder' => (int)$field->display_order,
            );
        }

        return response()->json(array(
            'status' => 'success',
            'member' => $memberData,
            'inspectionFields' => $inspectionFields
        ));
    }

    public function storeMemberInspection(Request $request, $eventId): JsonResponse
    {
        if (!$this->isRequestApiKeyValid($request)) {
            return response()->json(array('status' => 'Unauthorized'), 401);
        }

        $data = json_decode($request->getContent(), true);

        //Validation
        Validator::make($data, [
            'MemberId' => ['required', 'numeric'],
            'InspectedBy' => ['required', 'string'],
            'UniformInspection' => ['required']
        ])->validate();

        $event = TrainingCampEvent::query()->find($eventId);
        if ($event == null) {
            return response()->json(array('status' => 'Invalid Data'), 400);
        }

        $campAttendee = $event->members()->where('id', $data['MemberId'])->first();
        if ($campAttendee == null) {
            return response()->json(array('status' => 'Invalid Member in Training Camp'), 400);
        }

        $existingResults = $campAttendee->inspection_results()->get();
        foreach ($data['UniformInspection'] as $inspection) {
            $result = null;
            foreach ($existingResults as $existing) {
                if ($existing->field_id == $inspection['Id']) {
                    $result = $existing;
                    break;
                }
            }

            if ($result == null) {
                $result = new TrainingCampInspectionResult();
                $result->event_id = $eventId;
                $result->member_id = $campAttendee->id;
                $result->field_id = $inspection['Id'];
            }

            $result->inspected_by = $data['InspectedBy'];
            $result->points_lost = $inspection['PointsLost'];
            $result->save();
        }

        return response()->json(array(
            'status' => 'success'
        ));
    }
    #endregion

    #region Cadet of the Year API

    public function getCadetOfTheYearInspection(Request $request, $eventId, $certNo): JsonResponse
    {
        if (!$this->isRequestApiKeyValid($request)) {
            return response()->json(array('status' => 'Unauthorized'), 401);
        }

        if ($eventId == 0 || $certNo == '') {
            return response()->json(array('status' => 'Invalid Data'), 400);
        }

        $event = CadetOfTheYearEvent::query()->find($eventId);
        if ($event == null) {
            return response()->json(array('status' => 'Invalid Data'), 400);
        }

        $member = Member::query()->where('cert_no', $certNo)->first();
        if ($member == null) {
            return response()->json(array('status' => 'Invalid Member'), 400);
        }

        //Build Member Data
        $memberData = array(
            'id' => $member->id,
            'certNo' => $member->cert_no,
            'name' => $member->last_name . ', ' . $member->first_name,
            'age' => $member->age,
            'unit' => $member->unit,
            'rank' => ''
        );

        $inspectionFields = array();
        foreach ($event->inspection_fields as $field) {
            $inspectionFields[] = array(
                'id' => $field->id,
                'name' => $field->name,
                'displayOrder' => (int)$field->display_order,
            );
        }

        return response()->json(array(
            'status' => 'success',
            'member' => $memberData,
            'inspectionFields' => $inspectionFields
        ));
    }

    public function storeCadetOfTheYearInspection(Request $request, $eventId): JsonResponse
    {
        if (!$this->isRequestApiKeyValid($request)) {
            return response()->json(array('status' => 'Unauthorized'), 401);
        }

        $data = json_decode($request->getContent(), true);

        //Validation
        Validator::make($data, [
            'MemberId' => ['required', 'numeric'],
            'InspectedBy' => ['required', 'string'],
            'UniformInspection' => ['required']
        ])->validate();

        $event = CadetOfTheYearEvent::query()->find($eventId);
        if ($event == null) {
            return response()->json(array('status' => 'Invalid Data'), 400);
        }

        $member = Member::query()->where('id', $data['MemberId'])->first();
        if ($member == null) {
            return response()->json(array('status' => 'Invalid Member'), 400);
        }

        $eventMember = $event->members()->where('member_id', $data['MemberId'])->first();
        if ($eventMember == null) {
           $eventMember = new CadetOfTheYearParticipant();
           $eventMember->event_id = $eventId;
           $eventMember->member_id = $data['MemberId'];
           $eventMember->save();
        }

        $existingResults = $eventMember->inspection_results()->get();
        foreach ($data['UniformInspection'] as $inspection) {
            $result = null;
            foreach ($existingResults as $existing) {
                if ($existing->field_id == $inspection['Id']) {
                    $result = $existing;
                    break;
                }
            }

            if ($result == null) {
                $result = new CadetOfTheYearInspectionResult();
                $result->event_id = $eventId;
                $result->member_id = $eventMember->id;
                $result->field_id = $inspection['Id'];
            }

            $result->inspected_by = $data['InspectedBy'];
            $result->points_lost = $inspection['PointsLost'];
            $result->save();
        }

        return response()->json(array(
            'status' => 'success'
        ));
    }

    #endregion
}
