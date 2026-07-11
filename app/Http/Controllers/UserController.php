<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->get();

        return view('users.index', compact('users'));
    }


    public function edit($id)
    {
        $user = User::findOrFail($id);

        $roles = Role::all();

        $permissions = Permission::all();

        return view('users.edit', compact(
            'user',
            'roles',
            'permissions'
        ));
    }


 
    public function update(Request $request, $id)
{
    $user = User::findOrFail($id);


    $request->validate([

        'name' => 'required|string|max:255',

        'email' => 'required|email|unique:users,email,'.$user->id,

        'role' => 'required|exists:roles,name',

        'status' => 'required|boolean',

    ]);


    $user->update([

        'name' => $request->name,

        'email' => $request->email,

        'status' => $request->status,

    ]);


    $user->syncRoles([
        $request->role
    ]);


    if($request->password){

        $request->validate([
            'password'=>'min:8|confirmed'
        ]);


        $user->update([

            'password'=>bcrypt($request->password)

        ]);

    }


    return redirect('/users')
        ->with('success','Utilisateur modifié avec succès');

}

public function create()
{
    $roles = Role::all();

    return view('users.create', compact('roles'));
}



public function store(Request $request)
{
    $request->validate([

        'name' => 'required|string|max:255',

        'email' => 'required|email|unique:users,email',

        'password' => 'required|min:8|confirmed',

        'role' => 'required|exists:roles,name',

    ]);


    $user = User::create([

        'name' => $request->name,

        'email' => $request->email,

        'password' => bcrypt($request->password),

    ]);


    $user->assignRole($request->role);


    return redirect('/users')
        ->with('success', 'Utilisateur créé avec succès');

}

public function destroy($id)
{
    $user = User::findOrFail($id);


    if(auth()->id() == $user->id){

        return redirect('/users')
            ->with('error','Vous ne pouvez pas supprimer votre propre compte');

    }


    $user->delete();


    return redirect('/users')
        ->with('success','Utilisateur supprimé');
}
}