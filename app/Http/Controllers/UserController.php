<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\User;

class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $users = User::with('roles')->get();
        return response()->json($users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $user = User::create([
            'name' => $request['name'],
            'surname' => $request['surname'],
            'email' => $request['email'],
            'password' => bcrypt($request['password']),
        ]);
        $user->assignRole($request['rol']);
        return response()->json(['message' => 'El usuario ha sido creado'], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (!$request->ajax()) return redirect('/');
        $user = User::find($id);
        $user->fill([
            'name' => request('name'),
            'surname' => request('surname'),
            'email' => request('email'),
        ])->save();

        $user->syncRoles($request['rol']);
        return response()->json(['message' => 'El usuario ha sido modificado'], 201);
    }
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if (Storage::delete('public/' . $user->image)) {
            User::destroy($id);
        }

        return response()->json(["message" => "Ha sido eliminado"]);
    }
    public function available($id)
    {
        $users = User::findOrFail($id);
        $users->status = '1';
        $users->save();
        return response()->json(["message" => "Ha sido activado"]);
    }
    public function locked($id)
    {
        $users = User::findOrFail($id);
        $users->status = '0';
        $users->save();
        return response()->json(["message" => "Ha sido Bloqueado"]);
    }

    public function updatepassword(Request $request, $id)
    {
        $user = User::find($id);
        $user->fill([
            $user['password'] = bcrypt($request['password'])

        ])->save();
        return response()->json(['message' => 'El password ha sido cambiado'], 201);
    }
}