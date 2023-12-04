<x-app-layout>
    <x-slot name="header">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Uniform Inspection Fields ({{ $event->name }})</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </x-slot>

    <div class="card">
        <!-- /.card-header -->
        <div class="card-header">
            <div class="card-tools">
                <ul class="pagination float-right">
                    <li class="page-item">
                        <a class="page-link"
                           href="{{ route('trainingcamp.uniforminspection.new', ['eventId' => $event->id]) }}">New Field</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Display Order</th>
                    <th style="width: 120px"></th>
                </tr>
                </thead>
                <tbody>
                @foreach($event->inspection_fields as $field)
                    <tr>
                        <td class="text-center">{{ $field->name }}</td>
                        <td class="text-center">{{ $field->display_order }}</td>
                        <td class="text-center">
                            <a href="{{ route('trainingcamp.uniforminspection.edit', ['eventId' => $event->id, 'fieldId' => $field->id]) }}"
                               class="btn btn-info">Edit</a>
                            <a href="{{ route('trainingcamp.uniforminspection.delete', ['eventId' => $event->id, 'fieldId' => $field->id]) }}"
                               class="btn btn-danger">Delete</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
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
                    "paging": false,
                    "order": [[1, 'asc']]
                }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            });
        </script>
    </x-slot>
</x-app-layout>
