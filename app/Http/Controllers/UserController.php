<?php

namespace App\Http\Controllers;

use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Finding Users
        $users = User::all();

        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //sending roles to form
        $roles = Role::lists('name','id');
        return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //creating var with user data
        $input = $request->all();

        //encryption of password
        $input['password'] = bcrypt($request->password);

        //creating new user
        User::create($input);

        $notification = array(
            'message' => 'User has been created!',
            'alert-type' => 'success',
            'head' => 'Success'
        );

        //redirecting back to users
        return redirect('/users')->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //Grabbing User Data
        $user = User::findOrFail($id);
        //grabbing roles
        $roles = Role::lists('name','id');
        return view('users.edit', compact(['user','roles']));

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
        //grabbing user data
        $user = User::find($id);

        if($request->password == ""){
            $input = $request->except('password');
        } else {
            $input['password'] = bcrypt($request->password);
        }
        $user->update($input);
        return redirect('/users');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //delete user
        User::findOrFail($id)->delete();

        /*$notification = array(
            'message' => 'I am a successful message!',
            'alert-type' => 'success'
        );*/
        $notification = array(
            'message' => 'User has been deleted!',
            'alert-type' => 'danger',
            'head' => 'Deleted'
        );

        return redirect('/users')->with($notification);
    }
}
