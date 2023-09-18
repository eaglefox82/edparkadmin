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
                    <h3>{{ $event->squadrons()->where('checked_in', '<>', null)->count() }}</h3>

                    <p>Squadrons Checked-In</p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $event->wings()->where('checked_in', '<>', null)->count() }}</h3>

                    <p>Wings Checked-In</p>
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
                    <h3>{{ $event->squadrons()->sum('on_parade') + $event->wings()->sum('on_parade') }}</h3>

                    <p>Members On Parade</p>
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
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Squadrons On Parade</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                    <table class="table">
                        <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th class="text-center">Squadron</th>
                            <th class="text-center">Unit Attendance</th>
                            <th class="text-center">On Parade</th>
                            <th class="text-center">Roll Strength</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($squadrons as $index=>$s)
                            <tr>
                                <td>{{$index + 1}}.</td>
                                <td>{{ $s->unitName() }}</td>
                                <td>
                                    @if($s->on_parade > 0 && $s->roll_strength > 0)
                                        @php
                                            $unitPercent = number_format($s->on_parade / $s->roll_strength * 100, 2) . '%';
                                        @endphp
                                        <div class="progress progress-xs">
                                            <div class="progress-bar progress-bar-danger" style="width: {{ $unitPercent }}"></div>
                                        </div>
                                        {{$unitPercent}}
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td class="text-center">
                                    {{ $s->on_parade }}
                                </td>
                                <td class="text-center">{{ $s->roll_strength }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <!-- PIE CHART -->
            <div class="card card-danger">
                <div class="card-header">
                    <h3 class="card-title">Wings On Parade</h3>
                </div>
                <div class="card-body">
                    <canvas id="pieChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>

    <x-slot name="scripts">
        <script>
            var donutData        = {
                labels: [ @foreach($wingsOnParade as $w) '{{ $w['name'] }}', @endforeach],
                datasets: [
                    {
                        data: [@foreach($wingsOnParade as $w) '{{ $w['on_parade'] }}', @endforeach],
                    }
                ]
            }

            //-------------
            //- PIE CHART -
            //-------------
            // Get context with jQuery - using jQuery's .get() method.
            var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
            var pieData        = donutData;
            var pieOptions     = {
                maintainAspectRatio : false,
                responsive : true,
                plugins: {
                    colorschemes: {
                        scheme: 'brewer.Paired12'
                    }
                }
            }
            //Create pie or douhnut chart
            // You can switch between pie and douhnut using the method below.
            new Chart(pieChartCanvas, {
                type: 'pie',
                data: pieData,
                options: pieOptions
            })
        </script>
    </x-slot>
</x-app-layout>
