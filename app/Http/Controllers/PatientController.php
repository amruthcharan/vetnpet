<?php

namespace App\Http\Controllers;

use App\HealthPackage;
use App\Http\Requests\PatientRequest;
use App\Owner;
use App\Patient;
use App\Species;
use App\Vaccine;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $patients = Patient::all()->load(['vaccinations' => function($q){
            return $q->select(DB::raw('*, max(expiry) as expiry'))
                ->orderBy('vaccine_id', 'asc')
                ->orderBy('expiry', 'desc')
                ->groupBy('vaccine_id')
                ->get()->toArray();
        }]);
        $vaccines = Vaccine::all();


        //return $patients;
        return view('patients.index', compact(['patients','vaccines']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //$owners = Owner::lists('name','id');
        $species = Species::lists('name', 'id');

        return view('patients.create', compact('species'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PatientRequest $request)
    {
        //
        $input = $request->all();
        $species['name'] = $input['species_id'];
        if(intval($species['name']) == 0){
            $newspecies = Species::create($species);
            $input['species_id'] = $newspecies->id;
        }
        $input['created_by'] = Auth::user()->name;
        /*$now = \Carbon\Carbon::now();
        $y = $request->years;
        $m = $request->months;
        $d = $request->days;
        $input['age'] = $now->subYear($y)->subMonths($m)->subDays($d);*/
        Patient::create($input);
        $notification = array(
            'message' => 'patient has been created!',
            'alert-type' => 'success',
            'head' => 'Success'
        );
        return redirect('/patients')->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $patient = Patient::findOrFail($id)->load('vaccinations');
        $package = HealthPackage::where('patient_id',$id)->orderBy('expiry', 'desc')->first();
        return view('patients.show', compact(['patient', 'package']));
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
        $patient = Patient::findOrFail($id);
        $species = Species::lists('name','id');
        return view('patients.edit', compact(['patient','species']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PatientRequest $request, $id)
    {
        //
        $input = $request->all();
        $species['name'] = $input['species_id'];
        if(intval($species['name']) == 0){
            $newspecies = Species::create($species);
            $input['species_id'] = $newspecies->id;
        }
        $patient = Patient::find($id);
        $input['updated_by'] = Auth::user()->name;
        /*$now = \Carbon\Carbon::now();
        $y = $request->years;
        $m = $request->months;
        $d = $request->days;
        $input['age'] = $now->subYear($y)->subMonths($m)->subDays($d);*/
        $patient->update($input);
        $notification = array(
            'message' => 'patient has been updated!',
            'alert-type' => 'info',
            'head' => 'Update'
        );
        return redirect('/patients')->with($notification);
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
