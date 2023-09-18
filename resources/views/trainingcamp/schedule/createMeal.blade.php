<x-app-layout>
    <x-slot name="header">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Create Meal Schedule ({{ $event->name }})</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </x-slot>

    <form method="POST" action="{{ route('trainingcamp.schedule.meals.create.save', ['eventId' => $event->id]) }}">
        @csrf
        <div class="card">
            <div class="card-body">
                <dl>
                    <dt>Meal Name</dt>
                    <dd>
                        <input type="text" class="form-control" name="meal_name" value="{{ old('meal_name') }}" placeholder="Meal Name" required>
                    </dd>
                    <dt>Start Time</dt>
                    <dd>
                        <div class="input-group date" id="reservationdatetime" data-target-input="nearest">
                            <input type="text" class="form-control datetimepicker-input" data-target="#reservationdatetime"
                                   name="start_time" value="{{ old('start_time') }}" required/>
                            <div class="input-group-append" data-target="#reservationdatetime" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                    </dd>
                </dl>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <div class="card-tools">
                    <ul class="pagination">
                        <li class="page-item">
                            <a class="page-link"
                               href="{{ route('trainingcamp.schedule.index', ['eventId' => $event->id]) }}">Cancel</a>
                        </li>
                        <li class="page-item">
                            <button class="btn btn-success" type="submit">Create</button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </form>

    <x-slot name="scripts">
        <script>
            //Date and time picker
            $('#reservationdatetime')
                .datetimepicker({
                    defaultDate: "{{ $event->from_date }}",
                    icons: { time: 'far fa-clock' },
                    format: 'DD/MM/yyyy HH:mm'
                });
        </script>
    </x-slot>
</x-app-layout>
