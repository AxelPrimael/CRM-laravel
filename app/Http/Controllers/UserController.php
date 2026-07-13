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
        $users = User::with('roles', 'permissions')->get();

        return view('users.index', compact('users'));
    }



    public function create()
    {
        $roles = Role::all();

        $permissions = Permission::all();


        return view('users.create', compact(
            'roles',
            'permissions'
        ));
    }



    public function store(Request $request)
    {

        $request->validate([

            'name'=>'required|string|max:255',

            'email'=>'required|email|unique:users,email',

            'password'=>'required|min:8|confirmed',

            'role'=>'required|exists:roles,name',

            'permissions'=>'nullable|array',

            'permissions.*'=>'exists:permissions,name',

        ]);



        $user = User::create([

            'name'=>$request->name,

            'email'=>$request->email,

            'password'=>bcrypt($request->password),

        ]);



        // Ajouter le rôle

        $user->assignRole($request->role);



        // Ajouter les permissions

        $user->syncPermissions(
            $request->permissions ?? []
        );



        return redirect('/users')
            ->with('success','Utilisateur créé avec succès');

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


            'name'=>'required|string|max:255',


            'email'=>'required|email|unique:users,email,'.$user->id,


            'role'=>'required|exists:roles,name',


            'status'=>'required|boolean',


            'permissions'=>'nullable|array',


            'permissions.*'=>'exists:permissions,name',


            'password'=>'nullable|min:8|confirmed',


        ]);





        $user->update([


            'name'=>$request->name,


            'email'=>$request->email,


            'status'=>$request->status,


        ]);





        // Modifier le rôle

        $user->syncRoles([

            $request->role

        ]);





        // Modifier les permissions

        $user->syncPermissions(

            $request->permissions ?? []

        );





        // Modifier mot de passe si rempli

        if($request->password){


            $user->update([

                'password'=>bcrypt($request->password)

            ]);


        }





        return redirect('/users')

            ->with('success','Utilisateur modifié avec succès');


    }






    public function destroy($id)
    {

        $user = User::findOrFail($id);



        if(auth()->id() == $user->id){


            return redirect('/users')

            ->with('error',
            'Vous ne pouvez pas supprimer votre propre compte');


        }




        $user->delete();




        return redirect('/users')

        ->with('success',
        'Utilisateur supprimé');

    }

}