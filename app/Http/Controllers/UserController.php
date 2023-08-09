<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('name')->get();

        return view('users.index', [
            'users' => $users,
        ]);
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed',
        ]);

        $array = $request->only([
            'name',
            'email',
            'password',
        ]);
        $array['password'] = bcrypt($array['password']);
        User::create($array);

        return redirect()->route('users.index')
            ->with('success_message', 'Berhasil menambah user baru');
    }

    public function show($id)
    {
        dd($id);
    }

    public function edit($id)
    {
        $user = User::find($id);
        if (! $user) {
            return redirect()->route('users.index')
                ->with('error_message', 'User dengan id '.$id.' tidak ditemukan');
        }

        return view('users.edit', [
            'user' => $user,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'sometimes|nullable|confirmed',
        ]);

        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
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