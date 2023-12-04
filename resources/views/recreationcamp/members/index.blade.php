<x-app-layout>
    <x-slot name="header">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Members ({{ $event->name }})</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </x-slot>

    <div class="card">
        <!-- /.card-header -->
        <div class="card-header">
            <div class="card-tools">
                <ul class="pagination float-right">
{{--                    <li class="page-item"><a class="page-link" href="#">Register Members By Unit</a></li>--}}
                    <li class="page-item"><a class="page-link"
                                             href="{{ route('recreationcamp.members.register.member', ['eventId' => $event->id]) }}">Register
                            Member</a></li>
                </ul>
            </div>
        </div>
        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th style="width: 60px"></th>
                    <th>Surname</th>
                    <th>First Name</th>
                    <th>Cert No.</th>
                    <th>Unit</th>
                    <th>Gender</th>
                    <th>Age</th>
                    <th>Room</th>
                    <th>Team</th>
                    <th>Dietary</th>
                    <th>Medical</th>
                    <th>In Camp</th>
                </tr>
                </thead>
                <tbody>
                @foreach($event->members as $attendance)
                    <tr>
                        <td class="text-center">
                            <a href="{{ route('recreationcamp.members.view', ['eventId' => $event->id, 'registrationId' => $attendance->id]) }}"
                               class="btn btn-info">View</a>
                        </td>
                        <td>{{ $attendance->member->last_name }}</td>
                        <td>{{ $attendance->member->first_name }}</td>
                        <td class="text-center">{{ $attendance->member->cert_no }}</td>
                        <td class="text-center">{{ $attendance->member->unit }}</td>
                        <td class="text-center">{{ $attendance->member->GenderString }}</td>
                        <td class="text-center">{{ $attendance->member->age }}</td>
                        <td class="text-center">
                            @if($attendance->room != null)
                                <a href="{{ route('recreationcamp.accommodation.view', ['eventId' => $event->id, 'roomId' => $attendance->room->id]) }}">
                                    {{ $attendance->room->room_number }}
                                </a>
                            @else
                                ~
                            @endif
                        </td>
                        <td class="text-center">
                            @if($attendance->team != null)
                                <a href="{{ route('recreationcamp.teams.index', ['eventId' => $event->id]) }}#team{{$attendance->team->id}}">
                                    {{ $attendance->team->name }}
                                </a>
                            @else
                                ~
                            @endif
                        </td>
                        <td class="text-center">
                            @if($attendance->member->dietary_requirements != '')
                                {{ $attendance->member->dietary_requirements }}
                            @else
                                ~
                            @endif
                        </td>
                        <td class="text-center">
                            @if($attendance->member->medical_requirements != '')
                                {{ $attendance->member->medical_requirements }}
                            @else
                                ~
                            @endif
                        </td>
                        <td class="text-center">
                            @if($attendance->camp_checkin == null)
                                <a href="{{ route('recreationcamp.members.checkin', ['eventId' => $event->id, 'registrationId' => $attendance->id]) }}"
                                   class="btn btn-success">Check-In</a>
                            @else
                                Yes
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
            });
        </script>
    </x-slot>
</x-app-layout>
