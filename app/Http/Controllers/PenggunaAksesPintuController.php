<?php

namespace App\Http\Controllers;

use App\Models\AksesPintu;
use App\Models\AksesPintuRequest;
use App\Models\User;
use App\Notifications\PenggunaCreateAksesPintuNotification;
use App\Notifications\PenggunaEditAksesPintuNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class PenggunaAksesPintuController extends Controller
{
    public function create()
    {
        if (auth()->user()->akses) {
            return redirect()->route('home')
                ->with('success_message', 'Akses Sudah Dibuat/Diminta');
        }

        return view('akses.pengguna.create', []);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id_rfid' => 'required',
            'pin' => 'required|same:pin_confirmation',
            'pin_confirmation' => 'required',
        ]);
        $data['status'] = 'tidak-aktif';
        $aksesPintu = AksesPintu::create($data);

        // Retrieve all users with roles other than 'pengguna'
        $users = User::where('role', '<>', 'pengguna')->get();

        // Send the notification to these users
        Notification::send($users, new PenggunaCreateAksesPintuNotification($aksesPintu));

        return redirect()->route('home')
            ->with('success_message', 'Berhasil menambah Akses baru');
    }

    public function edit($id)
    {
        return view('akses.pengguna.edit', [
            'akses' => AksesPintu::find($id),
        ]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'id_rfid' => 'required',
            'pin' => 'required|same:pin_confirmation',
            'pin_confirmation' => 'required',
        ]);

        $aksesPintuRequest = AksesPintuRequest::create([
            'user_id' => auth()->id(),
            'id_rfid' => $data['id_rfid'],
            'pin' => $data['pin'],
        ]);

        // Retrieve all users with roles other than 'pengguna'
        $users = User::where('role', '<>', 'pengguna')->get();

        // Send the notification to these users
        Notification::send($users, new PenggunaEditAksesPintuNotification($aksesPintuRequest));

        return redirect()->route('home')
            ->with('success_message', 'Berhasil merubah Akses');
    }
}
