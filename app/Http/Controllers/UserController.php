<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        if (auth()->user()->role == 'pengguna') {
            abort(403);
        }

        return view('users.index', [
            'users' => User::orderBy('name')->get(),
        ]);
    }

    public function create()
    {
        if (auth()->user()->role == 'pengguna') {
            abort(403);
        }

        $roles = [
            'pengguna',
            'admin',
            'superadmin',
        ];

        return view('users.create', [
            'roles' => $roles,
        ]);
    }

    public function store(Request $request)
    {
        if (auth()->user()->role == 'pengguna') {
            abort(403);
        }

        $request->validate([
            'photo' => 'required',
            'name' => 'required',
            'role' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed',
        ]);

        $array = $request->only([
            'name',
            'email',
            'role',
            'password',
        ]);
        $array['password'] = bcrypt($array['password']);

        $image_path = $request->file('photo')->store('photo', 'public');

        $array['photo'] = $image_path;

        User::create($array);

        return redirect()->route('users.index')
            ->with('success_message', 'Berhasil menambah user baru');
    }

    public function show($id)
    {
        if (auth()->user()->role == 'pengguna') {
            abort(403);
        }

        dd($id);
    }

    public function edit($id)
    {
        if (auth()->user()->role == 'pengguna') {
            abort(403);
        }

        $user = User::find($id);
        $roles = [
            'pengguna',
            'admin',
            'superadmin',
        ];
        if (! $user) {
            return redirect()->route('users.index')
                ->with('error_message', 'User dengan id '.$id.' tidak ditemukan');
        }

        return view('users.edit', [
            'roles' => $roles,
            'user' => $user,
        ]);
    }

    public function update(Request $request, $id)
    {
        if (auth()->user()->role == 'pengguna') {
            abort(403);
        }

        $request->validate([
            'photo' => 'nullable',
            'name' => 'required',
            'role' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'sometimes|nullable|confirmed',
        ]);

        $user = User::find($id);
        $user->photo = $request->file('photo')->store('photo', 'public') ?? $user->photo;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        if ($request->password) {
            $user->password = bcrypt($request->password);
        }

        $user->save();
        // DB::table('model_has_roles')->where('model_id', $id)->delete();

        // $user->assignRole($request->input('roles'));

        return redirect()->route('users.index')
            ->with('success_message', 'Berhasil mengubah user');
    }

    public function destroy(Request $request, $id)
    {
        if (auth()->user()->role == 'pengguna') {
            abort(403);
        }

        $user = User::find($id);

        if ($id == $request->user()->id) {
            return redirect()->route('users.index')
                ->with('error_message', 'Anda tidak dapat menghapus diri sendiri.');
        }

        if ($user) {
            $user->delete();
        }

        return redirect()->route('users.index')
            ->with('success_message', 'Berhasil menghapus user');
    }
}
