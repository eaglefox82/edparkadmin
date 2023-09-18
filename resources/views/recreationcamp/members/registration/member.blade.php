<x-app-layout>
    <x-slot name="header">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Register Member ({{ $event->name }}) - {{$member->last_name}}, {{$member->first_name}}</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </x-slot>

    <form method="POST" action="{{ route('recreationcamp.members.register.member', ['eventId' => $event->id]) }}">
        @csrf
        <input type="hidden" name="memberId" value="{{$member->id}}">
        <div class="card">
            <!-- /.card-header -->
            <div class="card-body">
                <dl>
                    <dt>Certificate Number</dt>
                    <dd>{{$member->cert_no}}</dd>
                    <dt>Last Name</dt>
                    <dd>{{$member->last_name}}</dd>
                    <dt>First Name</dt>
                    <dd>{{$member->first_name}}</dd>
                    <dt>Unit</dt>
                    <dd>{{$member->unit}}</dd>
                    <dt>Age</dt>
                    <dd>{{$member->age}}</dd>
                    <dt>Gender</dt>
                    <dd>{{$member->GenderString}}</dd>
                    <dt>Dietary Requirements</dt>
                    <dd>
                        <textarea name="dietary_requirements" class="form-control">{{ old('dietary_requirements', $member->dietary_requirements) }}</textarea>
                    </dd>
                    <dt>Medical</dt>
                    <dd>
                        <textarea name="medical_requirements"
                                  class="form-control">{{ old('medical_requirements', $member->medical_requirements) }}</textarea>
                    </dd>
                    <hr/>
                    <dt>Team</dt>
                    <dd>
                        <select class="form-control" name="team">
                            @foreach($teams as $t)
                                <option value="{{ $t->id }}"
                                        @if(old('team', 0) == $t->id) selected @endif>{{ $t->name }}</option>
                            @endforeach
                        </select>
                    </dd>
                    <dt>Room</dt>
                    <dd>
                        <select class="form-control" name="room">
                            @foreach($rooms as $r)
                                <option value="{{ $r->id }}"
                                        @if(old('room', 0) == $r->id) selected @endif>{{ $r->room_number }}</option>
                            @endforeach
                        </select>
                    </dd>
                    <dt>
                        <button class="btn btn-primary" type="submit">Register Member</button>
                    </dt>
                </dl>
            </div>
            <!-- /.card-body -->
        </div>
    </form>

    <x-slot name="scripts">
    </x-slot>
</x-app-layout>
