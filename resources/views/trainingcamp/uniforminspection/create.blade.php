<x-app-layout>
    <x-slot name="header">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Create Inspection Field ({{ $event->name }})</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </x-slot>

    <form method="POST" action="{{ route('trainingcamp.uniforminspection.new.save', ['eventId' => $event->id]) }}">
        @csrf
        <div class="card">
            <div class="card-body">
                <dl>
                    <dt>Name</dt>
                    <dd>
                        <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Name" required autofocus>
                    </dd>
                    <dt>Display Order</dt>
                    <dd>
                        <select id="displayOrder" name="displayOrder" class="form-control" required>
                            <option value="0">-- FIRST --</option>
                            @foreach($fields as $f)
                                <option value="{{$f->display_order}}" @if($loop->last) selected @endif>{{$f->name}}</option>
                            @endforeach
                        </select>
                        <span class="help-block">This inspection field will be displayed after the selected.</span>
                    </dd>
                </dl>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <div class="card-tools">
                    <ul class="pagination">
                        <li class="page-item">
                            <a class="page-link"
                               href="{{ route('trainingcamp.uniforminspection.index', ['eventId' => $event->id]) }}">Cancel</a>
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
    </x-slot>
</x-app-layout>
