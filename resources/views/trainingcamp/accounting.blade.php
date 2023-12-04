<x-app-layout>
    <x-slot name="title">
        Accounting ({{ $event->name }})
    </x-slot>

    <x-slot name="header">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Accounting ({{ $event->name }})</h1>
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
                           href="#">Print Report</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Unit</th>
                    <th>Registered</th>
                    <th>Attended</th>
                    <th>Fees For Attended</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($units as $unitName => $members)
                        @php
                            $totalMembers = sizeof($members);
                            $present = 0;
                            foreach ($members as $mem) {
                                if ($mem->camp_checkin != null) {
                                    $present++;
                                }
                            }
                        @endphp
                        <tr>
                            <td>{{ $unitName }}</td>
                            <td class="text-center">{{ $totalMembers }}</td>
                            <td class="text-center">{{ $present }}</td>
                            <td class="text-right">${{ number_format($present * $event->camp_fee, 2) }}</td>
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
                    "order": [[0, 'asc']]
                }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            });
        </script>
    </x-slot>
</x-app-layout>
