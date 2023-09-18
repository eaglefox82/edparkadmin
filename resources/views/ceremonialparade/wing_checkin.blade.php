<x-app-layout>
    <x-slot name="header">
        <div class="row mb-2">
            <div class="col-sm-12">
                <h1 class="m-0">Wing Check-In ({{ $event->name }}) - {{$wing->name}}</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </x-slot>

    <form method="POST" action="{{ route('ceremonialparade.wing.checkin', ['eventId' => $event->id, 'wingId' => $wing->id]) }}">
        @csrf
        <div class="card">
            <!-- /.card-header -->
            <div class="card-body">
                <dl>
                    <dt>Wing Name</dt>
                    <dd>{{$wing->name}}</dd>
                    <dt>Roll Strength</dt>
                    <dd>{{$wing->roll_strength()}}</dd>
                    <dt>Arm Band</dt>
                    <dd>
                        @if($rego != null)
                            {{ $rego->arm_band }}
                        @else
                            Not Set
                        @endif
                    </dd>
                    <hr/>
                    <dt>Wing Staff On Parade</dt>
                    <dd>
                        @php
                            $defaultNumber = '';
                            if($rego != null && $rego->on_parade > 0) {
                                $defaultNumber = $rego->on_parade;
                            }
                        @endphp
                        <input type="number" min="0" step="1"
                               name="on_parade"
                               class="form-control"
                               autofocus
                               required
                               value="{{ old('on_parade', $defaultNumber) }}">
                    </dd>
                    <dt>
                        <a href="{{ route('ceremonialparade.wing', ['eventId' => $event->id]) }}" class="btn btn-danger">Cancel</a>
                        <button class="btn btn-primary" type="submit">Check-In Wing</button>
                    </dt>
                </dl>
            </div>
            <!-- /.card-body -->
        </div>
    </form>

    <x-slot name="scripts">
    </x-slot>
</x-app-layout>
