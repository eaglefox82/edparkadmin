<!DOCTYPE html>
<html>
<head>
    <style>
        .text-center {
            text-align: center;
        }

        #customers {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        #customers td, #customers th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        #customers tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #customers tr:hover {
            background-color: #ddd;
        }

        #customers th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: center;
            background-color: #525252;
            color: white;
        }
    </style>
</head>
<body>

<h1>{{$event->name}} - Camp Report</h1>

<h2>Members Registered: {{ $totalRegistered }}</h2>

<h2>Members Attended: {{ $totalAttended }}</h2>

<h2>Registered vs Attended: @if($totalAttended == 0 || $totalRegistered == 0)
        0.00%
    @else
        {{ number_format($totalAttended / $totalRegistered * 100, 2) }}%
    @endif
</h2>

<h2>Member Genders</h2>
<table id="customers" style="width: 100%">
    <thead>
    <tr>
        <th class="text-center" style="width: 25%">Female</th>
        <th class="text-center" style="width: 25%">Female %</th>
        <th class="text-center" style="width: 25%">Male</th>
        <th class="text-center" style="width: 25%">Male %</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td class="text-center">{{ $female }}</td>
        <td class="text-center">
            @if($female == 0 || $totalAttended == 0)
                0.00%
            @else
                {{ number_format($female / $totalAttended * 100, 2) }}%
            @endif
        </td>
        <td class="text-center">{{ $male }}</td>
        <td class="text-center">
            @if($male == 0 || $totalAttended == 0)
                0.00%
            @else
                {{ number_format($male / $totalAttended * 100, 2) }}%
            @endif
        </td>
    </tr>
    </tbody>
</table>

<h2>Cadets, Officers, Associate/Non-AAL</h2>
<table id="customers" style="width: 100%">
    <thead>
    <tr>
        <th class="text-center" style="width: 33%">Cadets</th>
        <th class="text-center" style="width: 33%">Officers</th>
        <th class="text-center" style="width: 34%">Assoc/Non-AAL</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td class="text-center">{{ $totalCadets }}</td>
        <td class="text-center">{{ $totalOfficers }}</td>
        <td class="text-center">{{ $nonAal }}</td>
    </tr>
    </tbody>
</table>

<div style="break-after:page"></div>

<h2>Units</h2>
<table id="customers" style="width: 100%">
    <thead>
    <tr>
        <th class="text-center" style="width: 30%">Name</th>
        <th class="text-center" style="width: 20%">Registered</th>
        <th class="text-center" style="width: 10%">Cadets</th>
        <th class="text-center" style="width: 10%">Officers</th>
        <th class="text-center" style="width: 10%">Assoc/Non-AAL</th>
        <th class="text-center" style="width: 20%">% Attended</th>
    </tr>
    </thead>
    <tbody>
    @foreach($units as $unitName => $members)
        @php
            $totalUnitMembers = sizeof($members);
            $cadets = 0;
            $officers = 0;
            $other = 0;
            foreach ($members as $mem) {
                if ($mem->camp_checkin != null) {
                    if ($mem->member->type == 0 || $mem->member->type == 2) {
                        $other++;
                        continue;
                    }

                    if ($mem->member->Age < 18) {
                        $cadets++;
                    } else {
                        $officers++;
                    }
                }
            }
        @endphp
        <tr>
            <td>{{ $unitName }}</td>
            <td class="text-center">{{ $totalUnitMembers }}</td>
            <td class="text-center">{{ $cadets }}</td>
            <td class="text-center">{{ $officers }}</td>
            <td class="text-center">{{ $other }}</td>
            <td class="text-center">
                @if($cadets + $officers + $other == 0)
                    0.00%
                @else
                    {{ number_format(($cadets + $officers + $other) / $totalUnitMembers * 100, 2) }}%
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

</body>
</html>
