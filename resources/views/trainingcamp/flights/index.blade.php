<x-app-layout>
    <x-slot name="header">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Flights ({{ $event->name }})</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </x-slot>

    <div class="card">
        <!-- /.card-header -->
        <div class="card-header">
            <div class="card-tools">
                <ul class="pagination float-right">
                    <li class="page-item">
                        <a class="page-link"
                           href="{{ route('trainingcamp.flights.print.all', ['eventId' => $event->id]) }}"
                           target="_blank">Print All Flight Rolls</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="card-body">
            <!-- we are adding the accordion ID so Bootstrap's collapse plugin detects it -->
            <div id="accordion">
                @foreach($event->flights as $flight)
                    <div id="flight{{$flight->id}}" class="card">
                        <div class="card-header">
                            <h4 class="card-title w-100">
                                <a class="d-block w-100" data-toggle="collapse" href="#collapse{{$flight->id}}">
                                    {{ $flight->name }} - {{ $flight->members()->count() }} Members
                                </a>
                            </h4>

                            <div class="card-tools">
                                <ul class="pagination float-right">
                                    <li class="page-item">
                                        <a class="page-link" target="_blank"
                                           href="{{ route('trainingcamp.flights.print.single', ['eventId' => $event->id, 'flightId' => $flight->id]) }}">
                                            Print Roll</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div id="collapse{{$flight->id}}" class="collapse" data-parent="#accordion">
                            <div class="card-body">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Room</th>
                                        <th>In Camp</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php
                                        $index = 1;
                                    @endphp
                                    @foreach($flight->members() as $member)
                                        <tr>
                                            <td>{{$index++}}</td>
                                            <td>
                                                <a href="{{ route('trainingcamp.members.view', ['eventId' => $event->id, 'registrationId' => $member->id]) }}">{{$member->member->last_name}}
                                                    , {{$member->member->first_name}}</a>
                                            </td>
                                            <td>
                                                @if($member->room != null)
                                                    {{ $member->room->room_number }}
                                                @else
                                                    ~
                                                @endif
                                            </td>
                                            <td>
                                                @if($member->camp_checkin == null)
                                                    ~
                                                @else
                                                    @if($member->camp_checkout == null)
                                                        Yes
                                                    @else
                                                        Left Camp
                                                    @endif
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <!-- /.card-body -->
    </div>

    <x-slot name="scripts">

    </x-slot>
</x-app-layout>
