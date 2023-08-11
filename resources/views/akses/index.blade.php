@extends('adminlte::page')

@section('title', 'Minta Akses')

@section('content_header')
    <h1 class="m-0 text-dark">Minta Akses</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <a href="{{ route('akses.create') }}" class="btn btn-primary mb-2">
                        Tambah <i class="fa fa-plus"></i>
                    </a>
                    <a href="{{ route('akses.print') }}" class="btn btn-info mb-2">
                        Print <i class="fa fa-print"></i>
                    </a>


                    <div class="table-responsive">
                        <table class="table table-hover table-bordered table-stripped">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Tgl</th>
                                    <th>Nama</th>
                                    <th>RFID</th>
                                    <th>Status</th>
                                    <th>Tgl di Setujui</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @foreach ($aksesPintu as $akses)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $akses->created_at->format('d-M-Y') }}</td>
                                        <td>{{ $akses->user->name }}</td>
                                        <td>{{ $akses->id_rfid }}</td>
                                        <td>{{ $akses->status }}</td>
                                        <td>{{ $akses->approved_at ? $akses->approved_at->format('d-M-Y') : 'Belum di Setujui' }}
                                        </td>
                                        <td>
                                            @if ($akses->approved_at)
                                                <a href="{{ route('akses.approved_at', $akses) }}"
                                                    class="mb-1 btn btn-success">
                                                    Terima <i class="fa fa-info"></i>
                                                </a>
                                            @else
                                                <a href="{{ route('akses.approved_at', $akses) }}"
                                                    class="mb-1 btn btn-danger">
                                                    Tolak <i class="fa fa-info-circle"></i>
                                                </a>
                                            @endif
                                            <hr />
                                            <a href="{{ route('akses.edit', $akses) }}" class="mb-1 btn btn-warning">
                                                Edit <i class="fa fa-edit"></i>
                                            </a>
                                            <a href="{{ route('akses.destroy', $akses) }}"
                                                onclick="notificationBeforeDelete(event, this)" class="mb-1 btn btn-danger">
                                                Delete <i class="fa fa-trash"></i>
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
@stop

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
