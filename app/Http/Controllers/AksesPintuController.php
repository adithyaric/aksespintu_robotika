<?php

namespace App\Http\Controllers;

use App\Http\Requests\AksesPintuRequest;
use App\Http\Resources\AksesPintuResource;
use App\Models\AksesPintu;
use App\Models\AksesPintuRequest as ModelsAksesPintuRequest;
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

    public function accept($id)
    {
        if (auth()->user()->role == 'pengguna') {
            abort(403);
        }
        // Retrieve the AksesPintu with the given id
        $aksesPintu = AksesPintu::findOrFail($id);

        // Change the status of the AksesPintu to 'aktif'
        // and set the approved_at timestamp
        $aksesPintu->update([
            'status' => 'aktif',
            'approved_at' => now(),
        ]);

        return redirect()->route('home')
            ->with('success_message', 'AksesPintu has been accepted');
    }

    public function aksesPintuRequests()
    {
        $requests = ModelsAksesPintuRequest::with('user')->get();

        return view('admin.akses-pintu-requests', compact('requests'));
    }

    public function approveAksesPintuRequest(ModelsAksesPintuRequest $aksesPintuRequest)
    {
        AksesPintu::where('user_id', $aksesPintuRequest->user_id)->update([
            'id_rfid' => $aksesPintuRequest->id_rfid,
            'pin' => $aksesPintuRequest->pin,
        ]);

        $aksesPintuRequest->delete();

        return redirect()->route('akses.akses-pintu-requests.index')
            ->with('success_message', 'Berhasil menyetujui perubahan Akses baru');
    }

    public function rejectAksesPintuRequest(ModelsAksesPintuRequest $aksesPintuRequest)
    {
        $aksesPintuRequest->delete();

        return redirect()->route('akses.akses-pintu-requests.index')
            ->with('success_message', 'Berhasil menolak perubahan Akses baru');
    }
}
