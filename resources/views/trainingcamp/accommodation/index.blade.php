<x-app-layout>
    <x-slot name="header">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Accommodation ({{ $event->name }})</h1>
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
                           href="{{ route('trainingcamp.accommodation.print.all', ['eventId' => $event->id]) }}">Print
                            All Room Rolls</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th data-priority="4" style="width: 60px"></th>
                    <th></th>
                    <th data-priority="1">Room Number</th>
                    <th data-priority="2">Capacity</th>
                    <th data-priority="3">Currently Allocated</th>
                </tr>
                </thead>
                <tbody>
                @foreach($event->rooms as $room)
                    <tr>
                        <td class="text-center">
                            <a href="{{ route('trainingcamp.accommodation.view', ['eventId' => $event->id, 'roomId' => $room->id]) }}"
                               class="btn btn-info">View</a>
                        </td>
                        <td></td>
                        <td class="text-center">{{ $room->room_number }}</td>
                        <td class="text-center">{{ $room->capacity }}</td>
                        <td class="text-center">{{ $room->members()->count() }}</td>
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
