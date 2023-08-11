@extends('adminlte::page')

@section('title', 'Edit Akses')

@section('content_header')
    <h1 class="m-0 text-dark">Edit Akses</h1>
@stop

@section('content')
    <form action="{{ route('akses.update', $akses->id) }}" method="post">
        @method('PUT')
        @csrf
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <div class="form-group">
                            <label for="">Pengguna</label>
                            <x-adminlte-select2 id="users" name="user_id" class="form-control">
                                <option value="" selected> =====>Pilih Pengguna<===== </option>
                                    @foreach ($users as $user)
                                    <option value="{{ $user->id }}" {{ old('user_id', $akses->user_id) == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </x-adminlte-select2>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputName">RFID</label>
                            <input type="text" class="form-control @error('id_rfid') is-invalid @enderror"
                                id="exampleInputName" placeholder="RFID" name="id_rfid" value="{{ old('id_rfid', $akses->id_rfid) }}">
                            @error('id_rfid')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="exampleInputName">PIN</label>
                            <input type="password" class="form-control @error('pin') is-invalid @enderror"
                                id="exampleInputName" placeholder="PIN" name="pin" value="{{ old('pin') }}">
                            @error('pin')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="exampleInputName">Konfirmasi PIN</label>
                            <input type="password" class="form-control @error('pin_confirmation') is-invalid @enderror"
                                id="exampleInputName" placeholder="Konfirmasi PIN" name="pin_confirmation" value="{{ old('pin_confirmation') }}">
                            @error('pin_confirmation')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('akses.index') }}" class="btn btn-default">
                            Batal
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
@stop
