<?php

namespace App\Http\Controllers;

use App\Models\AksesPintu;
use App\Models\User;
use App\Notifications\PenggunaCreateAksesPintuNotification;
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
        $data['user_id'] = auth()->id();
        $data['status'] = 'tidak-aktif';
        $aksesPintu = AksesPintu::create($data);

        // Retrieve all users with roles other than 'pengguna'
        $users = User::where('role', '<>', 'pengguna')->get();

        // Send the notification to these users
        Notification::send($users, new PenggunaCreateAksesPintuNotification($aksesPintu));

        return redirect()->route('home')
            ->with('success_message', 'Berhasil menambah Akses baru');
    }
}
