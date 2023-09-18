<x-app-layout>
    <x-slot name="header">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Accommodation ({{ $event->name }}) - Room: {{$room->room_number}}</h1>
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
                           target="_blank"
                           href="{{ route('trainingcamp.accommodation.print.single', ['eventId' => $event->id, 'roomId' => $room->id]) }}">Print Room Roll</a>
                    </li>
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
                    <th>Flight</th>
                    <th>Dietary</th>
                    <th>Medical</th>
                    <th>In Camp</th>
                </tr>
                </thead>
                <tbody>
                @foreach($room->members() as $attendance)
                    <tr>
                        <td class="text-center">
                            <a href="{{ route('trainingcamp.members.view', ['eventId' => $event->id, 'registrationId' => $attendance->id]) }}" class="btn btn-info">View</a>
                        </td>
                        <td>{{ $attendance->member->last_name }}</td>
                        <td>{{ $attendance->member->first_name }}</td>
                        <td class="text-center">{{ $attendance->member->cert_no }}</td>
                        <td class="text-center">{{ $attendance->member->unit }}</td>
                        <td class="text-center">{{ $attendance->member->gender }}</td>
                        <td class="text-center">{{ $attendance->member->age }}</td>
                        <td class="text-center">
                            @if($attendance->flight != null)
                                {{ $attendance->flight->name }}
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
                                ~
                            @else
                                @if($attendance->camp_checkout == null)
                                    Yes
                                @else
                                    Left Camp
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
                    "responsive": true, "lengthChange": false, "autoWidth": false,
                    "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
                    "paging": false
                }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            });
        </script>
    </x-slot>
</x-app-layout>
