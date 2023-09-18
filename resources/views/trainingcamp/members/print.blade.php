<!DOCTYPE html>
<html>
<head>
    <!-- Theme style -->
    <style>
        .text-center {
            text-align: center;
        }

        .button {
            background-color: #4CAF50; /* Green */
            border: none;
            color: white;
            padding: 0px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            border-radius: 8px;
        }

        @media print
        {
            .no-print, .no-print *
            {
                display: none !important;
            }
        }
    </style>
</head>
<body>
    @if (!isset($noContinue))
        <div class="text-center">
            <a href="{{ route('trainingcamp.members.checkin.final', ['eventId' => $event->id, 'registrationId' => $registration->id]) }}"
               class="button no-print">
                <h2>Continue</h2>
            </a>
        </div>
    @endif

    <h1 class="text-center">{{ $event->name }}</h1>
    <h3 class="text-center">Camp Check-In Information</h3>

    <hr>
    <p class="text-center">Member</p>
    <h2 class="text-center">
        {{ $registration->member->last_name }}, {{ $registration->member->first_name }}
    </h2>

    <hr>
    <p class="text-center">Flight</p>
    <h2 class="text-center">
        {{ $registration->flight->name }}
    </h2>

    <hr>
    <p class="text-center">Room</p>
    <h2 class="text-center">
        @if($registration->room != null)
            {{ $registration->room->room_number }}
        @else
            No Room Allocated
        @endif
    </h2>

    <hr>

    <script src="{{ asset('styles/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('styles/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script type="text/javascript">

        $(document).ready(function () {
            window.print();
        });

    </script>
</body>
</html>
