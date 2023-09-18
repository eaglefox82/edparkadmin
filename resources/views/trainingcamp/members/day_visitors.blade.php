<x-app-layout>
    <x-slot name="header">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Day Visitors ({{ $event->name }})</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </x-slot>

    <div class="card">
        <!-- /.card-header -->
        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th data-priority="7" style="width: 60px"></th>
                    <th></th>
                    <th data-priority="0">Surname</th>
                    <th data-priority="1">First Name</th>
                    <th data-priority="2">Cert No.</th>
                    <th data-priority="3">Unit</th>
                    <th data-priority="4">Age</th>
                    <th data-priority="5">Flight</th>
                    <th data-priority="6">In Camp</th>
                </tr>
                </thead>
                <tbody>
                @foreach($event->dayMembers as $attendance)
                    <tr>
                        <td class="text-center">
                            <a href="{{ route('trainingcamp.members.view', ['eventId' => $event->id, 'registrationId' => $attendance->id]) }}"
                               class="btn btn-info">View</a>
                        </td>
                        <td></td>
                        <td>{{ $attendance->member->last_name }}</td>
                        <td>{{ $attendance->member->first_name }}</td>
                        <td class="text-center">{{ $attendance->member->cert_no }}</td>
                        <td class="text-center">{{ $attendance->member->unit }}</td>
                        <td class="text-center">{{ $attendance->member->age }}</td>
                        <td class="text-center">
                            @if($attendance->flight != null)
                                <a href="{{ route('trainingcamp.flights.index', ['eventId' => $event->id]) }}#flight{{$attendance->flight->id}}">
                                    {{ $attendance->flight->name }}
                                </a>
                            @else
                                ~
                            @endif
                        </td>
                        <td class="text-center">
                            @if($attendance->camp_checkin == null)
                                <a href="{{ route('trainingcamp.members.day_checkin', ['eventId' => $event->id, 'registrationId' => $attendance->id]) }}"
                                   class="btn btn-success">Check-In</a>
                            @else
                                @if($attendance->camp_checkout == null)
                                    <a href="{{ route('trainingcamp.members.checkout', ['eventId' => $event->id, 'registrationId' => $attendance->id]) }}"
                                       class="btn btn-warning">Day Check-Out</a>
                                @else
                                    <a href="{{ route('trainingcamp.members.day_checkin', ['eventId' => $event->id, 'registrationId' => $attendance->id]) }}"
                                       class="btn btn-success">Check-In</a>
                                @endif
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
                    "responsive": {
                        "details": {
                            "type": 'column',
                            "target": 'tr'
                        }
                    },
                    "columnDefs": [{
                        "className": 'control',
                        "orderable": false,
                        "targets": 1
                    }],
                    "lengthChange": false, "autoWidth": false,
                    "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
                    "paging": false,
                    "order": [[2, 'asc']]
                }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            });
        </script>
    </x-slot>
</x-app-layout>
