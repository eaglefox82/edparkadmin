<x-app-layout>
    <x-slot name="header">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Dietary Requirements ({{ $event->name }})</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </x-slot>

    <div class="card">
        <!-- /.card-header -->
        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Surname</th>
                    <th>First Name</th>
                    <th>Cert No.</th>
                    <th>Unit</th>
                    <th>Gender</th>
                    <th>Age</th>
                    <th>Dietary</th>
                </tr>
                </thead>
                <tbody>
                @foreach($event->dietaryMembers as $attendance)
                    <tr>
                        <td>{{ $attendance->member->last_name }}</td>
                        <td>{{ $attendance->member->first_name }}</td>
                        <td class="text-center">{{ $attendance->member->cert_no }}</td>
                        <td class="text-center">{{ $attendance->member->unit }}</td>
                        <td class="text-center">{{ $attendance->member->GenderString }}</td>
                        <td class="text-center">{{ $attendance->member->age }}</td>
                        <td class="text-center">
                            @if($attendance->member->dietary_requirements != '')
                                {{ $attendance->member->dietary_requirements }}
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
                    "responsive": true,
                    "lengthChange": false, "autoWidth": false,
                    "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
                    "paging": false,
                    "order": [[0, 'asc']]
                }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            });
        </script>
    </x-slot>
</x-app-layout>
