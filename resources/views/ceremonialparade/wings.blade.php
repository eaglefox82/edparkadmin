<x-app-layout>
    <x-slot name="header">
        <div class="row mb-2">
            <div class="col-sm-12">
                <h1 class="m-0">Wings Check-In ({{ $event->name }})</h1>
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
                           href="{{ route('ceremonialparade.wing.load', ['eventId' => $event->id]) }}">Load Wings</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Wing</th>
                    <th>Arm Band</th>
                    <th>Roll Strength</th>
                    <th>Checked-In</th>
                    <th>On Parade</th>
                    <th>Attendance</th>
                </tr>
                </thead>
                <tbody>
                @foreach($wings as $wing)
                    @php
                        $members = $wing->roll_strength();
                        $record = null;
                        $wingTotal = 0;
                        if (array_key_exists($wing->id, $presentWings)) {
                            $record = $presentWings[$wing->id];
                            $wingTotal = $record->on_parade + $event->wingUnitAttendance($wing);
                        }
                    @endphp
                    @php

                    @endphp
                    <tr>
                        <td class="text-center">{{ $wing->name }}</td>
                        <td class="text-center">
                            @if($record != null)
                                {{ $record->arm_band }}
                            @endif
                        </td>
                        <td class="text-center">
                            @if($record == null || $record->roll_strength == null)
                                {{ $members }}
                            @else
                                {{ $record->roll_strength }}
                            @endif
                        </td>
                        <td class="text-center">
                            @if($record == null || $record->checked_in == null)
                                <a href="{{ route('ceremonialparade.wing.checkin', ['eventId' => $event->id, 'wingId' => $wing->id]) }}"
                                   class="btn btn-success">Check-In</a>
                            @else
                                Yes
                            @endif
                        </td>
                        <td class="text-center">
                            @if($record == null || $record->checked_in == null)
                                ~
                            @else
                                {{ $wingTotal }}
                            @endif
                        </td>
                        <td class="text-center">
                            @if($record == null || $record->checked_in == null)
                                ~
                            @else
                                @if($wingTotal > 0 && $record->roll_strength > 0)
                                    {{ number_format($wingTotal / $record->roll_strength * 100, 2) }}%
                                @else
                                    N/A
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
                    "paging": false,
                    "order": [[0, 'asc']],
                    initComplete: function () {
                        $('#example1_filter label input').focus();
                    }
                }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            });
        </script>
    </x-slot>
</x-app-layout>
