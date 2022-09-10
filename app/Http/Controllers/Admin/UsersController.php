<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddAdminRequest;
use App\Models\User;
use App\Traits\Imageable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    use Imageable;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function manageAdmins()
    {
        $this->authorize('rootPermission', Auth::user());
        $admins = User::where('is_admin', 1)
                    ->whereRaw('deleted IS NULL')
                    ->get();
        return view('admin.pages.manage_admins', compact('admins'));                
    }

    public function addAdmin()
    {
        $this->authorize('rootPermission', Auth::user());
        return view('admin.pages.add_admin');
    }

    public function createAdmin(AddAdminRequest $request)
    {
        $this->authorize('rootPermission', Auth::user());
        if($request->image){
            $image = $this->saveImage($request->image, 'assets/images/profiles');
        }
        User::create([
            'name'  => $request->user_name,
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'picture'      => $image,
            'email'      => $request->email,
            'password'   => bcrypt($request->password),
            'is_admin'   => 1,
            'role'       => $request->role
        ]);
        return redirect()->to(route('admin.manage.admins'))->with('info_message', 'Admin created successfully');
    }

    public function editAdmin($admin_id)
    {
        $this->authorize('rootPermission', Auth::user());
        $user = User::findOrFail($admin_id);
        $admins = User::where('id', $admin_id)->get();
        return view('admin.pages.edit_admin', compact('admins'));
    }

    public function modifyAdmin(AddAdminRequest $request)
    {
        $this->authorize('rootPermission', Auth::user());
        if($request->image){
            $image = $this->saveImage($request->image, 'assets/images/profiles');
        }
        $user = User::findOrFail($request->id);

        $user->name  = $request->user_name;
        $user->first_name  = $request->first_name;
        $user->last_name  = $request->last_name;
        $user->picture  = $image;
        $user->email  = $request->email;
        $user->password  = bcrypt($request->password);

        $user->save();
        return redirect()->to(route('admin.manage.admins'))->with('info_message', 'Admin edited successfully');
    }

    public function deleteAdmin($admin_id)
    {
        $this->authorize('rootPermission', Auth::user());
        $user = User::findOrFail($admin_id);
        $user->delete();
        return redirect()->to(route('admin.manage.admins'))->with('info_message', 'Admin deleted successfully');
    }
    

    /////////////////////////////////////////////////////////////////////////////////////////////////////


    public function manageUsers()
    {
        $this->authorize('superAdminPermission', Auth::user());
        $users = User::where('is_admin', 0)
                    ->get();
        return view('admin.pages.manage_users', compact('users'));                
    }

    public function addUser()
    {
        $this->authorize('superAdminPermission', Auth::user());
        return view('admin.pages.add_user');
    }

    public function createUser(AddAdminRequest $request)
    {
        $this->authorize('superAdminPermission', Auth::user());
        if($request->image){
            $image = $this->saveImage($request->image, 'assets/images/profiles');
        }
        User::create([
            'name'  => $request->user_name,
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'picture'      => $image,
            'email'      => $request->email,
            'password'   => bcrypt($request->password),
            'is_admin'   => 0,
        ]);
        return redirect()->to(route('admin.manage.users'))->with('info_message', 'User created successfully');
    }

    public function editUser($user_id)
    {
        $this->authorize('superAdminPermission', Auth::user());
        $user = User::findOrFail($user_id);
        $users = User::where('id', $user_id)->get();
        return view('admin.pages.edit_user', compact('users'));
    }

    public function modifyUser(AddAdminRequest $request)
    {
        $this->authorize('superAdminPermission', Auth::user());
        if($request->image){
            $image = $this->saveImage($request->image, 'assets/images/profiles');
        }
        $user = User::findOrFail($request->id);

        $user->name  = $request->user_name;
        $user->first_name  = $request->first_name;
        $user->last_name  = $request->last_name;
        $user->picture  = $image;
        $user->email  = $request->email;
        $user->password  = bcrypt($request->password);

        $user->save();
        return redirect()->to(route('admin.manage.users'))->with('info_message', 'User edited successfully');
    }

    public function deleteUser($user_id)
    {
        $this->authorize('superAdminPermission', Auth::user());
        $user = User::findOrFail($user_id);
        $user->delete();
        return redirect()->to(route('admin.manage.users'))->with('info_message', 'User deleted successfully');
    }

    public function viewUser($user_id)
    {
        $this->authorize('superAdminPermission', Auth::user());
        $user = User::find($user_id);
        $user->admin_id = Auth::id();
        $user->save();
        Auth::login($user);
        return redirect()->to('home');
    }
}
