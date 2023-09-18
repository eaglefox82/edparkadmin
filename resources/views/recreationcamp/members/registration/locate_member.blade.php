<x-app-layout>
    <x-slot name="header">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Register Member ({{ $event->name }})</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </x-slot>

    <div class="card">
        <!-- /.card-header -->
        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th style="width: 60px"></th>
                    <th>Surname</th>
                    <th>First Name</th>
                    <th>Cert No.</th>
                    <th>Unit</th>
                    <th>Gender</th>
                    <th>Age</th>
                </tr>
                </thead>
                <tbody>
                @foreach($members as $member)
                    <tr>
                        <td class="text-center">
                            <a href="{{ route('recreationcamp.members.register.member.view', ['eventId' => $event->id, 'memberId' => $member->id]) }}" class="btn btn-info">Register</a>
                        </td>
                        <td>{{ $member->last_name }}</td>
                        <td>{{ $member->first_name }}</td>
                        <td class="text-center">{{ $member->cert_no }}</td>
                        <td class="text-center">{{ $member->unit }}</td>
                        <td class="text-center">{{ $member->GenderString }}</td>
                        <td class="text-center">{{ $member->age }}</td>
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
                    "order": [[1, 'asc']],
                    initComplete: function () {
                        $('#example1_filter label input').focus();
                    }
                }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            });
        </script>
    </x-slot>
</x-app-layout>
