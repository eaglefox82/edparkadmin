<?php

namespace App\Http\Controllers\AAL;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\Member;
use App\Models\Squadron;
use App\Models\Wing;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class NasApiController extends Controller
{
    public function syncNasData()
    {
        $this->updateUnits();

        $this->updateMembers();

        return "Completed";
    }

    private function updateUnits()
    {
        $response = Http::withHeaders([
            'X-AAL-KEY' => env('AAL_NAS_API_KEY', '')
        ])->get('https://admin.airleague.com.au/api/units.json?all=0');

        if (!$response->successful()) {
            return;
        }

        $data = $response->json()['data'];
        foreach ($data as $unit) {
            if (str_contains($unit['name'], 'Group')) {
                $this->AddOrUpdateGroup($unit);
            } elseif (str_contains($unit['name'], 'Wing')) {
                $this->AddOrUpdateWing($unit);
            } else {
                $this->AddOrUpdateSquadron($unit);
            }
        }
    }

    private function AddOrUpdateSquadron(mixed $unit)
    {
        $squadron = Squadron::query()->find($unit['id']);
        if ($squadron == null) {
            $squadron = new Squadron();
            $squadron->id = $unit['id'];
            $squadron->wing_id = 0;
        }

        $squadron->name = $unit['name'];
        $squadron->active = $unit['current_status_id'] == 1 || $unit['current_status_id'] == 2;
        $squadron->save();
    }

    private function AddOrUpdateWing(mixed $unit)
    {
        $wing = Wing::query()->find($unit['id']);
        if ($wing == null) {
            $wing = new Wing();
            $wing->id = $unit['id'];
            $wing->group_id = 0;
        }

        $wing->name = $unit['name'];
        $wing->active = $unit['current_status_id'] == 1 || $unit['current_status_id'] == 2;
        $wing->save();
    }

    private function AddOrUpdateGroup(mixed $unit)
    {
        $group = Group::query()->find($unit['id']);
        if ($group == null) {
            $group = new Group();
            $group->id = $unit['id'];
        }

        $group->name = $unit['name'];
        $group->active = $unit['current_status_id'] == 1 || $unit['current_status_id'] == 2;
        $group->save();
    }

    private function updateMembers()
    {
        Member::query()->update(['active' => false]);

        $response = Http::withHeaders([
            'X-AAL-KEY' => env('AAL_NAS_API_KEY', '')
        ])->get('https://admin.airleague.com.au/api/members.json?all=0');

        if (!$response->successful()) {
            return;
        }

        $members = $response->json()['data'];
        foreach ($members as $details) {
            $member = Member::query()->find($details['id']);
            if ($member == null) {
                $member = new Member();
                $member->id = $details['id'];
            }

            $member->cert_no = $details['membership_number'];
            $member->last_name = $details['name']['last'];
            $member->first_name = $details['name']['first'];
            $member->dob = $details['date_of_birth'];
            $member->doj = $details['date_of_joining'];
            $member->type = $details['current_status_id'];
            $member->active = true;
            $member->gender = $details['gender'];
            $member->current_rank = '';

            $this->SetMemberUnit($member, $details);

            $member->save();
        }
    }

    private function SetMemberUnit(Member $member, mixed $details)
    {
        $group = Group::query()->find($details['current_unit_id']);
        if ($group != null) {
            $member->group_id = $group->id;
            return;
        }

        $wing = Wing::query()->find($details['current_unit_id']);
        if ($wing != null) {
            $member->wing_id = $wing->id;
            return;
        }

        $squadron = Squadron::query()->find($details['current_unit_id']);
        if ($squadron != null) {
            $member->squadron_id = $squadron->id;
        }
    }
}
