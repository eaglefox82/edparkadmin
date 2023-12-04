<x-app-layout>
    <x-slot name="header">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Dashboard ({{ $event->name }})</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </x-slot>

    <div class="card">
        <div class="card-header">
            <h4>Member Inspection</h4>
        </div>
        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th class="text-center">Cert #</th>
                    <th class="text-center">Surname</th>
                    <th class="text-center">First Name</th>
                    <th class="text-center">Unit</th>
                    <th class="text-center">Points Lost</th>
                    <th class="text-center">Judged By</th>
                    <th style="width: 120px"></th>
                </tr>
                </thead>
                <tbody>
                @foreach($results as $mem)
                    <tr>
                        <td class="text-center">{{ $mem->member->cert_no }}</td>
                        <td class="text-center">{{ $mem->member->last_name }}</td>
                        <td class="text-center">{{ $mem->member->first_name }}</td>
                        <td class="text-center">{{ $mem->member->unit }}</td>
                        <td class="text-center">{{ $mem->inspection_results()->sum('points_lost') }}</td>
                        <td class="text-center">{{ $mem->inspection_results()->first()->inspected_by }}</td>
                        <td class="text-center">
                            <a href="{{ route('cadet_comp.uniforminspection.result.delete', ['eventId' => $event->id, 'memberId' => $mem->id]) }}"
                               class="btn btn-danger">Delete</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>

    <div class="card">
        <div class="card-header">
            <h4>Average Points Lost By Field</h4>
        </div>
        <div class="card-body">
            <div class="chart">
                <canvas id="barChart"
                        style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
            </div>
        </div>
        <!-- /.card-body -->
    </div>

    <div class="card">
        <div class="card-header">
            <h4>Results By Judge</h4>
        </div>
        <div class="card-body">
            <table id="judgeData" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th class="text-center">Name</th>
                    <th class="text-center">Members Inspected</th>
                    <th class="text-center">Avg Points Taken</th>
                </tr>
                </thead>
                <tbody>
                @foreach($judgeData as $data)
                    <tr>
                        <td class="text-center">{{ $data['name'] }}</td>
                        <td class="text-center">{{ $data['count'] }}</td>
                        <td class="text-center">{{ number_format($data['points'] / $data['count'], 1) }}</td>
                    </tr>
                @endforeach
                </tbody>
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
                    "paging": true,
                    "order": [[1, 'asc']]
                }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

                $("#judgeData").DataTable({
                    "responsive": true, "lengthChange": false, "autoWidth": false,
                    "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
                    "paging": false,
                    "order": [[0, 'asc']]
                }).buttons().container().appendTo('#judgeData_wrapper .col-md-6:eq(0)');
            });

            var areaChartData = {
                labels: [@foreach($fields as $f) '{{ $f['name'] }}', @endforeach],
                datasets: [
                    {
                        label: 'Avg Points Lost',
                        backgroundColor: 'rgba(60,141,188,0.9)',
                        borderColor: 'rgba(60,141,188,0.8)',
                        pointRadius: false,
                        pointColor: '#3b8bba',
                        pointStrokeColor: 'rgba(60,141,188,1)',
                        pointHighlightFill: '#fff',
                        pointHighlightStroke: 'rgba(60,141,188,1)',
                        data: [@foreach($fields as $f) '{{ $f['average_points'] }}', @endforeach]
                    }
                ]
            }

            //-------------
            //- BAR CHART -
            //-------------
            var barChartCanvas = $('#barChart').get(0).getContext('2d')
            var barChartData = $.extend(true, {}, areaChartData)

            var barChartOptions = {
                responsive: true,
                maintainAspectRatio: false,
                datasetFill: false,
                scales: {
                    yAxes: [{
                        display: true,
                        ticks: {
                            beginAtZero: true   // minimum value will be 0.
                        }
                    }]
                }
            }

            new Chart(barChartCanvas, {
                type: 'bar',
                data: barChartData,
                options: barChartOptions
            })
        </script>
    </x-slot>
</x-app-layout>
