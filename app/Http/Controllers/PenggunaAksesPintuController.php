<?php

namespace App\Http\Controllers;

use App\Models\AksesPintu;
use Illuminate\Http\Request;

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
        AksesPintu::create($data);

        return redirect()->route('home')
            ->with('success_message', 'Berhasil menambah Akses baru');
    }
}
