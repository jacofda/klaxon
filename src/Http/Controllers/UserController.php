<?php

namespace Jacofda\Klaxon\Http\Controllers;

use App\User;
use Jacofda\Klaxon\Models\{Calendar, City, Client, Company, Contact, Country};
use App\Classes\Klaxon\Mail\User\NewAccount;
use Illuminate\Http\Request;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{

    public function index()
    {
        if(request()->input())
        {
            $users = Role::find(request('role'))->users;
        }
        else
        {
            $users = User::all();
        }
        $roles = Role::all();
        return view('jacofda::core.users.index', compact('roles', 'users'));
    }

    public function create()
    {
        $roles = Role::pluck('name', 'id');
        $provinces = City::uniqueProvinces();
        $countries = Country::listCountries();
        $companies[''] = '';
        $companies += Company::pluck('rag_soc', 'id')->toArray();

        $clients = Client::contact()->pluck('nome', 'id')->toArray();
        $clientsSelected = [];

        return view('jacofda::core.users.create', compact('roles', 'provinces', 'countries', 'companies', 'clients', 'clientsSelected'));
    }

    public function store()
    {
        $this->validate(request(),[
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'nome' => 'required',
            'cognome' => 'required',
            'role_id' => 'required'
        ]);

        $user = new User;
            $user->email = request('email');
            $user->password = bcrypt(request('password'));
        $user->save();

        ;
        $user->assignRole(Role::find(request('role_id')));

        $contact = Contact::createOrUpdate(new Contact, request()->input(), $user->id);

        Calendar::create(['user_id' => $user->id]);

        if(request('email'))
        {
            \Mail::to($user->email)->send(new NewAccount($user, request('password')));
        }

        return redirect(route('users.index'))->with('message', 'Utente Creato');
    }

    public function edit($id)
    {
        $roles = Role::pluck('name', 'id');
        $provinces = City::uniqueProvinces();
        $countries = Country::listCountries();
        $companies[''] = '';
        $companies += Company::pluck('rag_soc', 'id')->toArray();
        $element = User::findOrFail($id);

        $clients = Client::contact()->pluck('nome', 'id')->toArray();
        $clientsSelected = [];
        if($element->contact()->exists())
        {
            $clientsSelected = $element->contact->clients()->pluck('id')->toArray();
        }


        return view('jacofda::core.users.edit', compact('roles', 'provinces', 'countries', 'companies', 'element', 'clients', 'clientsSelected'));
    }

    public function update($id)
    {
        $user = User::findOrFail($id);

        $this->validate(request(),[
            'email' => 'required|string|email|unique:users,email,'.$user->id.',id',
            'nome' => 'required',
            'cognome' => 'required',
            'role_id' => 'required'
        ]);

        $user->email = request('email');
        $user->save();

        $roles = Role::whereIn('id', request('role_id'))->pluck('name')->toArray();
        $user->syncRoles($roles);

        Contact::createOrUpdate($user->contact, request()->input(), $user->id);

        return redirect(route('users.index'))->with('message', 'Utente Modificato');
    }

    public function permissions($id)
    {
        $allPermissions = Permission::all();
        $permissions = [];
        foreach ($allPermissions as $permission)
        {
            $arr = explode('.',$permission->name);
            $permissions[$arr[0]][] = [
                'id' => $permission->id,
                'action' => $arr[1]
            ];
        }
        $utente = User::find($id);
        $role = $utente->roles()->first();


        return view('jacofda::core.users.permissions', compact('utente', 'role', 'permissions') );
    }

//api/direct-permissions/{user_id}
     public function permissionUpdate($id)
     {
         $user = User::find($id);
         $permission = Permission::find(request('id'));

         if(request('add') == 'true')
         {
             $user->givePermissionTo($permission->name);
             $azione = 'aggiunto';
         }
         else
         {
             $user->revokePermissionTo($permission->name);
             $azione = 'revocato';
         }

         $arr = explode('.',$permission->name);


         return 'Permesso '.trans('permissions.'.$arr[0]).' '.trans('permissions.'.$arr[1]).' '.$azione.' a '.$user->contact->fullname;
     }

}
