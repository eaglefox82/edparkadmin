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
                                             href="{{ route('trainingcamp.members.register.member', ['eventId' => $event->id]) }}">Register
                            Member</a></li>
                </ul>
            </div>
        </div>
        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th data-priority="9" style="width: 60px">Action</th>
                    <th></th>
                    <th data-priority="0">Surname</th>
                    <th data-priority="1">First Name</th>
                    <th data-priority="2">Cert No.</th>
                    <th data-priority="6">Unit</th>
                    <th data-priority="8">Gender</th>
                    <th data-priority="7">Age</th>
                    <th data-priority="3">Room</th>
                    <th data-priority="4">Flight</th>
                    <th>Dietary</th>
                    <th>Medical</th>
                    <th data-priority="5">In Camp</th>
                </tr>
                </thead>
                <tbody>
                @foreach($event->members as $attendance)
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
                        <td class="text-center">{{ $attendance->member->GenderString }}</td>
                        <td class="text-center">{{ $attendance->member->age }}</td>
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
                                @if($attendance->day_visitor)
                                    <a href="{{ route('trainingcamp.members.day_checkin', ['eventId' => $event->id, 'registrationId' => $attendance->id]) }}"
                                       class="btn btn-success">Check-In</a>
                                @else
                                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-default"
                                            data-name="{{ $attendance->member->last_name }}, {{ $attendance->member->first_name }}"
                                            data-registration="{{ $attendance->id }}">
                                        Check-In
                                    </button>
                                @endif
                            @else
                                @if($attendance->camp_checkout == null)
                                    <a href="{{ route('trainingcamp.members.checkout', ['eventId' => $event->id, 'registrationId' => $attendance->id]) }}"
                                       class="btn btn-warning">Check-Out</a>
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

    <div class="modal fade" id="modal-default">
        <div class="modal-dialog">
            <form method="post" action="{{ route('trainingcamp.members.checkin', ['eventId' => $event->id]) }}">
                @csrf
                <input type="hidden" name="eventId" value="{{ $event->id }}">
                <input type="hidden" id="checkInRegoId" name="registrationId" value="0">
                <input type="hidden" name="form17a" value="0">

                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Member Check-In</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="checkInName">Name</label>
                            <input type="text" class="form-control" id="checkInName" disabled>
                        </div>

                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="form17a" name="form17a" value="1" checked>
                            <label class="form-check-label" for="form17a">Form 17a Provided</label>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Check-In Member</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </form>
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

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
                    "order": [[2, 'asc']],
                    initComplete: function () {
                        $('#example1_filter label input').focus();
                    }
                }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

                // Execute something when the modal window is shown.
                $('#modal-default').on('show.bs.modal', function (event) {
                    let button = $(event.relatedTarget); // Button that triggered the modal
                    let registrationId = button.data('registration'); // Extract info from data-* attributes
                    let name = button.data('name'); // Extract info from data-* attributes

                    let modal = $(this);
                    $('#checkInRegoId').val(registrationId);
                    modal.find('#checkInName').val(name);
                });
            });
        </script>
    </x-slot>
</x-app-layout>
