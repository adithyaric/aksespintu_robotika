@extends('adminlte::page')

@section('title', ' Request Edit Akses')

@section('content_header')
    <h1 class="m-0 text-dark"> Request Edit Akses</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered table-stripped">
                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th>ID RFID</th>
                                    <th>PIN</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($requests as $request)
                                    <tr>
                                        <td>{{ $request->user->name }}</td>
                                        <td>{{ $request->id_rfid }}</td>
                                        <td>{{ $request->pin }}</td>
                                        <td>
                                            <a href="{{ route('admin.akses-pintu-requests.approve', $request->id) }}" class="btn btn-success mb-2">
                                                Approve <i class="fa fa-plus"></i>
                                            </a>
                                            <a href="{{ route('admin.akses-pintu-requests.reject', $request->id) }}" class="btn btn-danger mb-2">
                                                Reject <i class="fa fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <form action="" id="delete-form" method="post">
        @method('delete')
        @csrf
    </form>
    <script>
        $('#example2').DataTable({
            "responsive": true,
        });

        function notificationBeforeDelete(event, el) {
            event.preventDefault();
            if (confirm('Apakah anda yakin akan menghapus data ? ')) {
                $("#delete-form").attr('action', $(el).attr('href'));
                $("#delete-form").submit();
            }
        }
    </script>
@endpush
