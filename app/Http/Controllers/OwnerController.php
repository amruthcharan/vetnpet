<?php

namespace App\Http\Controllers;

use App\Owner;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class OwnerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $owners = Owner::all();
        return view('owners.index', compact('owners'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('owners.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $input = $request->all();
        $input['created_by'] = Auth::user()->name;
        Owner::create($input);
        $notification = array(
            'message' => 'Owner has been created!',
            'alert-type' => 'success',
            'head' => 'Success'
        );
        return redirect('/owners')->with($notification);
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
        //
        $owner = Owner::findOrFail($id);

        return view('owners.edit', compact('owner'));

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
        //
        $owner = Owner::find($id);
        $input = $request->all();
        $input['updated_by'] = Auth::user()->name;

        $owner->update($input);

        $notification = array(
            'message' => 'Owner has been updated!',
            'alert-type' => 'info',
            'head' => 'Update Done!'
        );

        return redirect('/owners')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
