<x-app-layout>
    <x-slot name="header">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Meal Schedules ({{ $event->name }})</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </x-slot>

    <div class="card">
        <div class="card-header">
            <div class="card-tools">
                <ul class="pagination float-right">
                    <li class="page-item">
                        <a class="page-link"
                           href="{{ route('trainingcamp.schedule.meals.create', ['eventId' => $event->id]) }}">New
                            Meal</a>
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
                    <th data-priority="0" class="text-center">Name</th>
                    <th data-priority="1" class="text-center">Start Time</th>
                    <th data-priority="3" class="text-center">Present</th>
                </tr>
                </thead>
                <tbody>
                @foreach($event->meals as $meal)
                    <tr>
                        <td class="text-center">
                            <a href="{{ route('trainingcamp.schedule.meals.view', ['eventId' => $event->id, 'mealId' => $meal->id]) }}"
                               class="btn btn-info">View</a>
                        </td>
                        <td></td>
                        <td class="text-center">{{ $meal->name }}</td>
                        <td class="text-center">{{ \Carbon\Carbon::parse($meal->start_time)->format('D d M y H:i') }}</td>
                        <td class="text-center">{{ $meal->checkins()->count() }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>

{{--    <div class="card">--}}
{{--        <div class="card-header">--}}
{{--            <h4>Lesson Periods</h4>--}}
{{--            <div class="card-tools">--}}
{{--                <ul class="pagination float-right">--}}
{{--                    <li class="page-item">--}}
{{--                        <a class="page-link"--}}
{{--                           href="#">New Lesson Period</a>--}}
{{--                    </li>--}}
{{--                </ul>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <div class="card-body">--}}
{{--            <table id="periods" class="table table-bordered table-striped">--}}
{{--                <thead>--}}
{{--                <tr>--}}
{{--                    <th style="width: 60px"></th>--}}
{{--                    <th class="text-center">Date</th>--}}
{{--                    <th class="text-center">Start Time</th>--}}
{{--                    <th class="text-center">End Time</th>--}}
{{--                    <th class="text-center">Lessons Allocated</th>--}}
{{--                </tr>--}}
{{--                </thead>--}}
{{--                <tbody>--}}
{{--                <tr>--}}
{{--                    <td class="text-center">--}}
{{--                        <a href="#" class="btn btn-info">View</a>--}}
{{--                    </td>--}}
{{--                    <td class="text-center">[DATE]</td>--}}
{{--                    <td class="text-center">[START TIME]</td>--}}
{{--                    <td class="text-center">[FINISH TIME]</td>--}}
{{--                    <td class="text-center">[LESSONS]</td>--}}
{{--                </tr>--}}
{{--                </tbody>--}}
{{--            </table>--}}
{{--        </div>--}}
{{--        <!-- /.card-body -->--}}
{{--    </div>--}}

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
                    "paging": true,
                    "order": [[3, 'asc']]
                }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

                // $("#periods").DataTable({
                //     "responsive": true, "lengthChange": false, "autoWidth": false,
                //     "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
                //     "paging": false,
                //     "order": [[1, 'asc'], [2, 'asc']]
                // }).buttons().container().appendTo('#periods_wrapper .col-md-6:eq(0)');
            });
        </script>
    </x-slot>
</x-app-layout>
