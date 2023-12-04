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

@foreach($rooms as $r)
    <h1>Room: {{$r->room_number}}</h1>
    <table id="customers" style="width: 100%">
        <thead>
        <tr>
            <th style="width: 5%;">#</th>
            <th style="width: 30%;">Name</th>
            <th style="width: 20%;">Squadron</th>
            <th style="width: 10%;">Gender</th>
            <th style="width: 10%;">Flight</th>
            <th style="width: 5%;">Med</th>
            <th style="width: 10%;">Check #1</th>
            <th style="width: 10%;">Check #2</th>
        </tr>
        </thead>
        <tbody>
        @php
            $index = 1;
        @endphp
        @foreach($r->presentMembers() as $member)
            <tr>
                <td class="text-center">
                    {{ $index++ }}
                </td>
                <td class="text-center">
                    {{$member->member->last_name}}, {{$member->member->first_name}}
                </td>
                <td class="text-center">
                    {{ $member->member->unit }}
                </td>
                <td class="text-center">
                    {{ $member->member->GenderString }}
                </td>
                <td class="text-center">
                    @if($member->flight != null)
                        {{ $member->flight->name }}
                    @else
                        ~
                    @endif
                </td>
                <td class="text-center">
                    @if($member->member->medical_requirements != '')
                        Y
                    @endif
                </td>
                <td></td>
                <td></td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div style="break-after:page"></div>
@endforeach

</body>
</html>
