<?php

namespace App\Http\Controllers;

use App\Http\Requests\AksesPintuRequest;
use App\Http\Resources\AksesPintuResource;
use App\Models\AksesPintu;
use App\Models\User;

class AksesPintuController extends Controller
{
    public function index()
    {
        if (auth()->user()->role == 'pengguna') {
            abort(403);
        }

        return view('akses.index', [
            'aksesPintu' => AksesPintu::get(),
        ]);
    }

    public function create()
    {
        if (auth()->user()->role == 'pengguna') {
            abort(403);
        }

        return view('akses.create', [
            'users' => User::where('role', 'pengguna')->orderBy('name')->get(),
        ]);
    }

    public function store(AksesPintuRequest $request)
    {
        if (auth()->user()->role == 'pengguna') {
            abort(403);
        }
        $data = $request->validated();
        $data['status'] = 'tidak-aktif';
        AksesPintu::create($data);

        return redirect()->route('akses.index')
            ->with('success_message', 'Berhasil menambah Akses baru');
    }

    public function print()
    {
        if (auth()->user()->role == 'pengguna') {
            abort(403);
        }
        $aksesPintus = AksesPintu::with('user')->get();

        return AksesPintuResource::collection($aksesPintus)->response()->getData(true)['data'];
    }

    public function updateApprovedAt($id)
    {
        if (auth()->user()->role == 'pengguna') {
            abort(403);
        }
        $akses = AksesPintu::find($id);
        if ($akses->approved_at) {
            $akses->status = 'tidak-aktif';
            $akses->approved_at = null;
        } else {
            $akses->status = 'aktif';
            $akses->approved_at = now();
        }
        $akses->save();

        return redirect()->back();
    }

    public function edit($id)
    {
        if (auth()->user()->role == 'pengguna') {
            abort(403);
        }

        return view('akses.edit', [
            'akses' => AksesPintu::find($id),
            'users' => User::where('role', 'pengguna')->orderBy('name')->get(),
        ]);
    }

    public function update(AksesPintuRequest $request, $id)
    {
        if (auth()->user()->role == 'pengguna') {
            abort(403);
        }
        $data = $request->validated();
        AksesPintu::find($id)->update($data);

        return redirect()->route('akses.index')
            ->with('success_message', 'Berhasil merubah Akses baru');
    }

    public function destroy($id)
    {
        if (auth()->user()->role == 'pengguna') {
            abort(403);
        }
        AksesPintu::find($id)->delete();

        return redirect()->route('akses.index')
            ->with('success_message', 'Berhasil Menghapus Data');
    }
}
