<x-app-layout>
    <x-slot name="header">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Edit Member ({{ $event->name }}) - {{$registration->member->last_name}}
                    , {{$registration->member->first_name}}</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </x-slot>

    <form method="POST" action="{{ route('trainingcamp.members.edit', ['eventId' => $event->id, 'registrationId' => $registration->id]) }}">
        @csrf
        <div class="card">
            <div class="card-body">
                <dl>
                    <dt>Certificate Number</dt>
                    <dd>{{$registration->member->cert_no}}</dd>
                    <dt>Last Name</dt>
                    <dd>{{$registration->member->last_name}}</dd>
                    <dt>First Name</dt>
                    <dd>{{$registration->member->first_name}}</dd>
                    <dt>Unit</dt>
                    <dd>{{$registration->member->unit}}</dd>
                    <dt>Age</dt>
                    <dd>{{$registration->member->age}}</dd>
                    <dt>Gender</dt>
                    <dd>{{$registration->member->GenderString}}</dd>
                    <dt>Dietary Requirements</dt>
                    <dd>
                        <textarea name="dietary_requirements"
                                  class="form-control">{{ old('dietary_requirements', $registration->member->dietary_requirements) }}</textarea>
                    </dd>
                    <dt>Medical</dt>
                    <dd>
                    <textarea name="medical_requirements"
                              class="form-control">{{ old('medical_requirements', $registration->member->medical_requirements) }}</textarea>
                    </dd>
                    <hr/>
                    <dt>Flight</dt>
                    <dd>
                        <select class="form-control" name="flight">
                            @foreach($flights as $t)
                                <option value="{{ $t->id }}"
                                        @if(old('flight', $registration->flight_id) == $t->id) selected @endif>{{ $t->name }}</option>
                            @endforeach
                        </select>
                    </dd>
                    <dt>Room</dt>
                    <dd>
                        <select class="form-control" name="room">
                            <option value="0"
                                    @if(old('room', $registration->room_id) == 0) selected @endif>** Day Only **</option>
                            @foreach($rooms as $r)
                                <option value="{{ $r->id }}"
                                        @if(old('room', $registration->room_id) == $r->id) selected @endif>{{ $r->room_number }}</option>
                            @endforeach
                        </select>
                    </dd>
                    <dt>Band Training</dt>
                    <dd>
                        <select class="form-control" name="band_training">
                            <option value="true" @if($registration->band_training) selected @endif>Yes</option>
                            <option value="false" @if(!$registration->band_training) selected @endif>No</option>
                        </select>
                    </dd>
                    <dt>Day Visitor</dt>
                    <dd>
                        <select class="form-control" name="day_visitor">
                            <option value="true" @if($registration->day_visitor) selected @endif>Yes</option>
                            <option value="false" @if(!$registration->day_visitor) selected @endif>No</option>
                        </select>
                    </dd>
                </dl>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <div class="card-tools">
                    <ul class="pagination">
                        <li class="page-item">
                            <a class="page-link"
                               href="{{ route('trainingcamp.members.view', ['eventId' => $event->id, 'registrationId' => $registration->id]) }}">Cancel</a>
                        </li>
                        <li class="page-item">
                            <button class="btn btn-success" type="submit">Save</button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </form>

    <x-slot name="scripts">
    </x-slot>
</x-app-layout>
