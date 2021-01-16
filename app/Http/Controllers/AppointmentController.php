<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\Http\Requests\AppointmentRequest;
use App\Patient;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $appointments = Appointment::all()->load('prescription', 'patient');
        //return $appointments;
        return view('appointments.index', compact('appointments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $patients = Patient::lists('id','id');
        $doctors = User::where('role_id',2)->lists('name','id')->all();
        /*$doctors=[];
        foreach($docs as $doc){
            $key = $doc->id;
            $value = $doc->name;
            $doctors = $doctors + array($key=>$value);
        }*/
        //return $patients;
        //return $doctors;
        return view('appointments.create', compact(['patients','doctors']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AppointmentRequest $request)
    {
        //
        $input = $request->all();
        $input['created_by'] = Auth::user()->name;
        $app=Appointment::create($input);
        $notification = array(
            'message' => 'Appointment has been booked!',
            'alert-type' => 'success',
            'head' => 'Success'
        );

        $username = "vetnpet";
        $password = "gETSRI@71";

        $d = date_create($app->date);

        $date = date_format($d,'d/m/Y');
        $name = $app->patient->name ? $app->patient->name : '';
        $message="Dear Customer, Appointment has been successfully booked for your pet, " . $name . " on " . $date . ". Your Appointment id is " . $app->id . ". @ VetnPet Hospital Film Nagar";

        $sender="VetPet"; //ex:INVITE

        $mobile_number=$app->patient->mobile;


        $url = "login.bulksmsgateway.in/sendmessage.php?user=".urlencode($username)."&password=".urlencode($password)."&mobile=".urlencode($mobile_number)."&message=".urlencode($message)."&sender=".urlencode($sender)."&type=".urlencode('3');

        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $output = curl_exec($ch);

        curl_close($ch);



        //redirecting back to users
        return redirect('/appointments')->with($notification);
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
        $appointment = Appointment::findOrFail($id);
        $docs = User::all('name','id','role_id')->where('role_id',2);
        $doctors=[];
        foreach($docs as $doc){
            $key = $doc->id;
            $value = $doc->name;
            $doctors = $doctors + array($key=>$value);
        }
        return view('appointments.edit', compact(['appointment','doctors']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AppointmentRequest $request, $id)
    {
        //
        $input = $request->all();
        $appointment = Appointment::find($id);
        //return $appointment;
        $input['patient_id'] = $request->patient_id;
        $input['updated_by'] = Auth::user()->name;
        $input['status'] = "Scheduled";
        //return $input;
        $appointment->update($input);
        //return $appointment;
        $notification = array(
            'message' => 'Appointment has been updated!',
            'alert-type' => 'info',
            'head' => 'Updated'
        );
        return redirect('/appointments')->with($notification);
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
