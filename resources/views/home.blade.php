@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <h1 class="m-0 text-dark">Dashboard</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-stripped">
                            <tr>
                                <th>Nama</th>
                                <td>:</td>
                                <td>{{ auth()->user()->name }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>:</td>
                                <td>{{ auth()->user()->email }}</td>
                            </tr>
                            @if (auth()->user()->akses && auth()->user()->akses->approved_at)
                                <tr>
                                    <th>ID RFID</th>
                                    <td>:</td>
                                    <td>
                                        {{ auth()->user()->akses->id_rfid }}
                                        @if (!auth()->user()->requestakses)
                                            <a href="{{ route('pengguna.edit', auth()->user()->akses) }}"
                                                class="mb-1 btn btn-warning">
                                                Edit <i class="fa fa-edit"></i>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
