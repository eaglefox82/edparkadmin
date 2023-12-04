<x-app-layout>
    <x-slot name="header">
        <div class="row mb-2">
            <div class="col-sm-12">
                <h1 class="m-0">Squadron Check-In ({{ $event->name }}) - {{$squadron->name}}</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </x-slot>

    <form method="POST" action="{{ route('ceremonialparade.squadron.checkin', ['eventId' => $event->id, 'sqnId' => $squadron->id]) }}">
        @csrf
        <div class="card">
            <!-- /.card-header -->
            <div class="card-body">
                <dl>
                    <dt>Squadron Name</dt>
                    <dd>{{$squadron->name}}</dd>
                    <dt>Roll Strength</dt>
                    <dd>{{$squadron->roll_strength()}}</dd>
                    <dt>Arm Band</dt>
                    <dd>
                        @if($rego != null)
                            {{ $rego->arm_band }}
                        @else
                            Not Set
                        @endif
                    </dd>
                    <hr/>
                    <dt>On Parade</dt>
                    <dd>
                        @php
                            $defaultNumber = '';
                            if($rego != null && $rego->on_parade > 0) {
                                $defaultNumber = $rego->on_parade;
                            }
                        @endphp
                        <input type="number" min="1" step="1"
                               name="on_parade"
                               class="form-control"
                               autofocus
                               required
                               value="{{ old('on_parade', $defaultNumber) }}">
                    </dd>
                    <dt>
                        <a href="{{ route('ceremonialparade.squadron', ['eventId' => $event->id]) }}" class="btn btn-danger">Cancel</a>
                        <button class="btn btn-primary" type="submit">Check-In Squadron</button>
                    </dt>
                </dl>
            </div>
            <!-- /.card-body -->
        </div>
    </form>

    <x-slot name="scripts">
    </x-slot>
</x-app-layout>
