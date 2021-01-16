<?php

namespace App\Http\Controllers;

use App\HealthPackage;
use App\Package;
use App\Patient;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;

class HealthPackageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $healthpackages = HealthPackage::all();
        return view('healthpackages.index', compact('healthpackages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $packages = Package::lists('name', 'id');
        $patients = Patient::lists('id','id');
        return view('healthpackages.create', compact(['packages', 'patients']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $p = Package::find($input['package_id']);
        $t = new Carbon($input['date']);
        $input['expiry'] = $t->addMonths($p->validity);

        $hp = HealthPackage::create($input);

        return redirect(route('patients.show',$hp->patient_id));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $packages = Package::lists('name', 'id');
        $healthpackage = HealthPackage::findOrFail($id);
        return view('healthpackages.edit', compact(['packages', 'healthpackage']));
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
        $input = $request->all();
        $p = Package::find($input['package_id']);
        $t = new Carbon($input['date']);
        $input['expiry'] = $t->addMonths($p->validity);
        $healthpackage = HealthPackage::find($id);
        $healthpackage->update($input);
        return redirect(route('patients.show',$healthpackage->patient_id));
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
