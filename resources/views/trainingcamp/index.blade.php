<x-app-layout>
    <x-slot name="header">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">{{ $event->name }}</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </x-slot>

    <div class="row">
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $event->members()->count() }}</h3>

                    <p>Members Registered</p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
            </div>
        </div>

        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $event->checkedInMembers()->count() }}</h3>

                    <p>Members In Camp</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
            </div>
        </div>
        <!-- ./col -->
    </div>

    <div class="row">
        <div class="col-sm-12">
            <!-- BAR CHART -->
            <div class="card card-danger">
                <div class="card-header">
                    <h3 class="card-title">Accommodation</h3>
                </div>
                <div class="card-body">
                    <div class="chart">
                        <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <!-- BAR CHART -->
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Flights</h3>
                </div>
                <div class="card-body">
                    <div class="chart">
                        <canvas id="teamsChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>

    <x-slot name="scripts">
        <script>
            var areaChartData = {
                labels  : [ @foreach($rooms as $r) '{{ $r['name'] }}', @endforeach],
                datasets: [
                    {
                        label               : 'Registered',
                        backgroundColor     : 'rgba(210, 214, 222, 1)',
                        borderColor         : 'rgba(210, 214, 222, 1)',
                        pointRadius         : false,
                        pointColor          : 'rgba(210, 214, 222, 1)',
                        pointStrokeColor    : '#c1c7d1',
                        pointHighlightFill  : '#fff',
                        pointHighlightStroke: 'rgba(220,220,220,1)',
                        data                : [@foreach($rooms as $r) '{{ $r['registered'] }}', @endforeach]
                    },
                    {
                        label               : 'In Camp',
                        backgroundColor     : 'rgba(60,141,188,0.9)',
                        borderColor         : 'rgba(60,141,188,0.8)',
                        pointRadius          : false,
                        pointColor          : '#3b8bba',
                        pointStrokeColor    : 'rgba(60,141,188,1)',
                        pointHighlightFill  : '#fff',
                        pointHighlightStroke: 'rgba(60,141,188,1)',
                        data                : [@foreach($rooms as $r) '{{ $r['in_camp'] }}', @endforeach]
                    },
                ]
            }

            //-------------
            //- BAR CHART -
            //-------------
            var barChartCanvas = $('#barChart').get(0).getContext('2d')
            var barChartData = $.extend(true, {}, areaChartData)

            var barChartOptions = {
                responsive              : true,
                maintainAspectRatio     : false,
                datasetFill             : false
            }

            new Chart(barChartCanvas, {
                type: 'bar',
                data: barChartData,
                options: barChartOptions
            })

            var teamsChartDataSet = {
                labels  : [ @foreach($flights as $r) '{{ $r['name'] }}', @endforeach],
                datasets: [
                    {
                        label               : 'Registered',
                        backgroundColor     : 'rgba(210, 214, 222, 1)',
                        borderColor         : 'rgba(210, 214, 222, 1)',
                        pointRadius         : false,
                        pointColor          : 'rgba(210, 214, 222, 1)',
                        pointStrokeColor    : '#c1c7d1',
                        pointHighlightFill  : '#fff',
                        pointHighlightStroke: 'rgba(220,220,220,1)',
                        data                : [@foreach($flights as $r) '{{ $r['registered'] }}', @endforeach]
                    },
                    {
                        label               : 'In Camp',
                        backgroundColor     : 'rgba(60,141,188,0.9)',
                        borderColor         : 'rgba(60,141,188,0.8)',
                        pointRadius          : false,
                        pointColor          : '#3b8bba',
                        pointStrokeColor    : 'rgba(60,141,188,1)',
                        pointHighlightFill  : '#fff',
                        pointHighlightStroke: 'rgba(60,141,188,1)',
                        data                : [@foreach($flights as $r) '{{ $r['in_camp'] }}', @endforeach]
                    },
                ]
            }

            //-------------
            //- Team CHART -
            //-------------
            var teamChartCanvas = $('#teamsChart').get(0).getContext('2d')
            var teamChartData = $.extend(true, {}, teamsChartDataSet)

            var teamChartOptions = {
                responsive              : true,
                maintainAspectRatio     : false,
                datasetFill             : false
            }

            new Chart(teamChartCanvas, {
                type: 'bar',
                data: teamsChartDataSet,
                options: teamChartOptions
            })
        </script>
    </x-slot>
</x-app-layout>
