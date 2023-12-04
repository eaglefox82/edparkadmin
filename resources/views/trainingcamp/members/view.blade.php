<x-app-layout>
    <x-slot name="header">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Member ({{ $event->name }}) - {{$registration->member->last_name}}, {{$registration->member->first_name}}</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </x-slot>

    <div class="card">
        <!-- /.card-header -->
        <div class="card-header">
            <div class="card-tools">
                <ul class="pagination float-right">
                    <li class="page-item">
                        <a class="page-link" href="{{ route('trainingcamp.members.checkin', ['eventId' => $event->id, 'registrationId' => $registration->id]) }}">Check-In</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="card-body">
            <dl>
                <dt>Certificate Number</dt>
                <dd>{{$registration->member->cert_no}}</dd>
                <dt>Last Name</dt>
                <dd>{{$registration->member->last_name}}</dd>
                <dt>First Name</dt>
                <dd>{{$registration->member->first_name}}</dd>
                <dt>Unit</dt>
                <dd>{{$registration->member->unit}}</dd>
                <dt>Age</dt>
                <dd>{{$registration->member->age}}</dd>
                <dt>Gender</dt>
                <dd>{{$registration->member->GenderString}}</dd>
                <dt>Dietary Requirements</dt>
                <dd>
                    @if($registration->member->dietary_requirements != '')
                        {{ $registration->member->dietary_requirements }}
                    @else
                        ~
                    @endif
                </dd>
                <dt>Medical</dt>
                <dd>
                    @if($registration->member->medical_requirements != '')
                        {{ $registration->member->medical_requirements }}
                    @else
                        ~
                    @endif
                </dd>
                <hr/>
                <dt>Flight</dt>
                <dd>
                    @if($registration->flight != null)
                        <a href="{{ route('trainingcamp.flights.index', ['eventId' => $event->id]) }}#flight{{$registration->flight->id}}">{{ $registration->flight->name }}</a>
                    @else
                        ~
                    @endif
                </dd>
                <dt>Room</dt>
                <dd>
                    @if($registration->room != null)
                        <a href="{{ route('trainingcamp.accommodation.view', ['eventId' => $event->id, 'roomId' => $registration->room->id]) }}">{{ $registration->room->room_number }}</a>
                    @else
                        ~
                    @endif
                </dd>
                <dt>Band Training</dt>
                <dd>
                    @if($registration->band_training)
                        Yes
                    @else
                        No
                    @endif
                </dd>
                <dt>Day Visitor</dt>
                <dd>
                    @if($registration->day_visitor)
                        Yes
                    @else
                        No
                    @endif
                </dd>
            </dl>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <div class="card-tools">
                <ul class="pagination">
                    <li class="page-item">
                        <a class="page-link" href="{{ route('trainingcamp.members.edit', ['eventId' => $event->id, 'registrationId' => $registration->id]) }}">
                            Edit Member Details
                        </a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" target="_blank"
                           href="{{ route('trainingcamp.members.checkin.print_page', ['eventId' => $event->id, 'registrationId' => $registration->id]) }}">
                            Print Check-In Summary
                        </a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" target="_blank"
                           href="{{ route('trainingcamp.members.print_slip', ['eventId' => $event->id, 'registrationId' => $registration->id]) }}">
                            Print Member Slip
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <x-slot name="scripts">
    </x-slot>
</x-app-layout>
