<x-app-layout>
    <x-slot name="header">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Meal Attendance ({{ $event->name }}) - {{ $meal->name }}</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </x-slot>

    <div class="row">
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $event->checkedInMembers()->count() }}</h3>

                    <p>Members In Camp</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
            </div>
        </div>
        <!-- ./col -->

        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ sizeof($notPresent) }}</h3>

                    <p>Members Missing Check-In</p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ sizeof($present) }}</h3>

                    <p>Members Present</p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <!-- /.card-header -->
        <div class="card-header">
            <h4>Missing Members</h4>
        </div>
        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Cert No</th>
                    <th>Surname</th>
                    <th>First Name</th>
                    <th>Unit</th>
                    <th>Room</th>
                    <th>Flight</th>
                    <th style="width: 60px"></th>
                </tr>
                </thead>
                <tbody>
                @foreach($notPresent as $attendance)
                    <tr>
                        <td>{{ $attendance->member->cert_no }}</td>
                        <td>{{ $attendance->member->last_name }}</td>
                        <td>{{ $attendance->member->first_name }}</td>
                        <td class="text-center">{{ $attendance->member->unit }}</td>
                        <td class="text-center">
                            @if($attendance->room != null)
                                <a href="{{ route('trainingcamp.accommodation.view', ['eventId' => $event->id, 'roomId' => $attendance->room->id]) }}">
                                    {{ $attendance->room->room_number }}
                                </a>
                            @else
                                ~
                            @endif
                        </td>
                        <td class="text-center">
                            @if($attendance->flight != null)
                                <a href="{{ route('trainingcamp.flights.index', ['eventId' => $event->id]) }}#flight{{$attendance->flight->id}}">
                                    {{ $attendance->flight->name }}
                                </a>
                            @else
                                ~
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('trainingcamp.schedule.meals.mark_present', ['eventId' => $event->id, 'mealId' => $meal->id, 'memberId' => $attendance->id]) }}"
                               class="btn btn-success">
                                Present
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
            </table>
        </div>
        <!-- /.card-body -->
    </div>

    <div class="card">
        <!-- /.card-header -->
        <div class="card-header">
            <h4>Present Members</h4>
        </div>
        <div class="card-body">
            <table id="presentMembers" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Cert No</th>
                    <th>Surname</th>
                    <th>First Name</th>
                    <th>Unit</th>
                    <th>Room</th>
                    <th>Flight</th>
                </tr>
                </thead>
                <tbody>
                @foreach($present as $checkin)
                    <tr>
                        <td>{{ $checkin->member->member->cert_no }}</td>
                        <td>{{ $checkin->member->member->last_name }}</td>
                        <td>{{ $checkin->member->member->first_name }}</td>
                        <td class="text-center">{{ $checkin->member->member->unit }}</td>
                        <td class="text-center">
                            @if($checkin->member->room != null)
                                <a href="{{ route('trainingcamp.accommodation.view', ['eventId' => $event->id, 'roomId' => $checkin->member->room->id]) }}">
                                    {{ $checkin->member->room->room_number }}
                                </a>
                            @else
                                ~
                            @endif
                        </td>
                        <td class="text-center">
                            @if($checkin->member->flight != null)
                                <a href="{{ route('trainingcamp.flights.index', ['eventId' => $event->id]) }}#flight{{$checkin->member->flight->id}}">
                                    {{ $checkin->member->flight->name }}
                                </a>
                            @else
                                ~
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
            </table>
        </div>
        <!-- /.card-body -->
    </div>

    <x-slot name="scripts">
        <script>
            $(function () {
                $("#example1").DataTable({
                    "responsive": true, "lengthChange": false, "autoWidth": false,
                    "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
                    "order": [[1, 'asc']],
                    initComplete: function () {
                        $('#example1_filter label input').focus();
                    }
                }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

                $("#presentMembers").DataTable({
                    "responsive": true, "lengthChange": false, "autoWidth": false,
                    "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
                    "order": [[1, 'asc']]
                }).buttons().container().appendTo('#presentMembers_wrapper .col-md-6:eq(0)');
            });
        </script>
    </x-slot>
</x-app-layout>
