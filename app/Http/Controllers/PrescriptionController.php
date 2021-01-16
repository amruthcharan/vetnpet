<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\Diagnosis;
use App\Http\Requests\PrescriptionRequest;
use App\Medicine;
use App\MedicineDetails;
use App\Patient;
use App\Prescription;
use App\Symptom;
use App\User;
use App\Vaccination;
use App\Vaccine;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PrescriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $prescriptions = Prescription::all();

        return view('prescriptions.index', compact('prescriptions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $docs = User::all('name','id','role_id')->where('role_id',2);
        $appointments = Appointment::where('status','=','Scheduled')->lists('id','id');
        $symptoms = Symptom::lists('name','id');
        $diagnoses = Diagnosis::lists('name','id');
        $medicines = Medicine::all();
        $vaccines = Vaccine::all();
        return view('prescriptions.create',compact(['appointments','symptoms','diagnoses', 'medicines', 'vaccines']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PrescriptionRequest $request)
    {
        //
        $input = $request->all();
        $symptoms= [];
        $syms = $request->symptoms ? $request->symptoms : [];
        if($request->symptoms <> "") {
            for ($i = 0; $i < count($syms); $i++) {
                if (intval($syms[$i]) == 0) {
                    $symp = array('name' => $syms[$i]);
                    $newsymptom = Symptom::create($symp);
                    $symptoms[$i] = $newsymptom->id;

                } else {
                    $symptoms[$i] = intval($syms[$i]);
                }
            }
        }
        
        $diagnoses= [];
        $dias = $request->diagnoses ? $request->diagnoses : [];
        if($diagnoses <> "") {
            for ($i = 0; $i < count($dias); $i++) {
                if (intval($dias[$i]) == 0) {
                    $dia = array('name' => $dias[$i]);
                    $newdiagnosis = Diagnosis::create($dia);
                    $diagnoses[$i] = $newdiagnosis->id;
                } else {
                    $diagnoses[$i] = intval($dias[$i]);
                }
            }
        }
        $input['symptoms'] = $symptoms;
        $input['diagnoses'] = $diagnoses;
        $input['created_by'] = Auth::user()->name;
        $prescription = Prescription::create($input);
        $appiid = $prescription->appointment_id;
        Appointment::find($appiid)->update(['status'=>'Completed']);

        $prescription->Diagnosis()->sync($diagnoses, false);
        $prescription->Symptoms()->sync($symptoms,false);
        
        $t = date('Y-m-d');
        if($prescription->reminder > $t){
            $app = array(
                'doctor_id'=>$prescription->appointment()->get()->all()[0]->doctor_id,
                'patient_id'=>$prescription->appointment()->get()->all()[0]->patient_id,
                'date'=>$prescription->reminder,
                'created_by' => "Added Automatically by System Reminders"
            );

            $appl = Appointment::create($app);
            if($appl){
                //sms code
                $username = "vetnpet";
                $password = "gETSRI@71";
                $d = date_create($appl->date);
                $date = date_format($d,'d/m/Y');
                $name = $appl->patient->name ? $appl->patient->name : '';
                $message="Dear Customer, Appointment has been successfully booked for your pet, " . $name . " on " . $date . " with" . $appl->doctor->name . ". Your Appointment id is " . $appl->id . ".";
                $sender="VetPet"; //ex:INVITE
                $mobile_number=$appl->patient->mobile;
                $url = "login.bulksmsgateway.in/sendmessage.php?user=".urlencode($username)."&password=".urlencode($password)."&mobile=".urlencode($mobile_number)."&message=".urlencode($message)."&sender=".urlencode($sender)."&type=".urlencode('3');
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $output = curl_exec($ch);
                curl_close($ch);
                // sms code
            }
        }
        $medicines = $request->medicines;
        $timing = $request->timing;
        $duration = $request->duration;
        if($medicines <> "") {
            for ($i = 0; $i < count($medicines); $i++) {
                //return $medicines[$i];
                if (intval($medicines[$i]) == 0) {
                    $symp = array('name' => $medicines[$i]);
                    $newmedicine = Medicine::create($symp);
                    $medicines[$i] = $newmedicine->id;
                } else {
                    $medicines[$i] = intval($medicines[$i]);
                }
                $medicinedetails = array('prescription_id'=>$prescription->id, 'medicine_id'=>$medicines[$i],'timing'=>$timing[$i],'duration'=>$duration[$i]);
                MedicineDetails::create($medicinedetails);
            }
        }

        $vaccines = $request->vaccines_id;
        $expiry = $request->expiry;
        $dates = $request->dates;
        if($vaccines <> "") {
            for ($i = 0; $i < count($vaccines); $i++) {
                $va = Vaccine::find($vaccines[$i]);
                $vac = array(
                    'vaccine_id' => $vaccines[$i],
                    'patient_id' => $prescription->appointment()->get()->all()[0]->patient_id,
                    'date' => $dates[$i],
                    'expiry' => $expiry[$i],
                );
                $vacc = Vaccination::create($vac);
            }
        }


        return redirect('/prescriptions');
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
        $prescription = Prescription::findOrFail($id)->load('appointment');
        //return $prescription->medicinedets;
        $vaccines = Vaccine::all();
        return view('prescriptions.show', compact(['prescription', 'vaccines']));
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
        $prescription = Prescription::findOrFail($id);
        $medicines = Medicine::all();
        $symptoms = Symptom::lists('name','id');
        $diagnoses = Diagnosis::lists('name','id');
        $vaccines = Vaccine::all();
        return view('prescriptions.edit', compact(['prescription','medicines','diagnoses','symptoms', 'vaccines']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PrescriptionRequest $request, $id)
    {
        // return $request->all();

        $vaccines = $request->vaccines_id;


        $prescription = Prescription::find($id);
        $input = $request->all();
        $symptoms= [];
        $syms = $request->symptoms ? $request->symptoms : [];
        if($request->symptoms <> "") {
            for ($i = 0; $i < count($syms); $i++) {
                if (intval($syms[$i]) == 0) {
                    $symp = array('name' => $syms[$i]);
                    $newsymptom = Symptom::create($symp);
                    $symptoms[$i] = $newsymptom->id;

                } else {
                    $symptoms[$i] = intval($syms[$i]);
                }
            }
        }
        
        $diagnoses= [];
        $dias = $request->diagnoses ? $request->diagnoses : [];
        if($diagnoses <> "") {
            for ($i = 0; $i < count($dias); $i++) {
                if (intval($dias[$i]) == 0) {
                    $dia = array('name' => $dias[$i]);
                    $newdiagnosis = Diagnosis::create($dia);
                    $diagnoses[$i] = $newdiagnosis->id;
                } else {
                    $diagnoses[$i] = intval($dias[$i]);
                }
            }
        }
        $input['symptoms'] = $symptoms;
        $input['diagnoses'] = $diagnoses;
        $input['updated_by'] = Auth::user()->name;
        // return $input;
        $prescription->update($input);
        $prescription->Symptoms()->sync($symptoms,false);
        $prescription->Diagnosis()->sync($diagnoses, false);
        $t = date('Y-m-d');
        if($prescription->reminder > $t){
            $app = array(
                'doctor_id'=>$prescription->appointment()->get()->all()[0]->doctor_id,
                'patient_id'=>$prescription->appointment()->get()->all()[0]->patient_id,
                'date'=>$prescription->reminder,
                'created_by' => "Added Automatically by System Reminders"
            );

            $appl = Appointment::create($app);
            if($appl){
                //sms code
                $username = "vetnpet";
                $password = "gETSRI@71";
                $d = date_create($appl->date);
                $date = date_format($d,'d/m/Y');
                $name = $appl->patient->name ? $appl->patient->name : '';
                $message="Dear Customer, Appointment has been successfully booked for your pet, " . $name . " on " . $date . " with " . $appl->doctor->name . ". Your Appointment id is " . $appl->id . ".";
                $sender="VetPet"; //ex:INVITE
                $mobile_number=$appl->patient->mobile;
                $url = "login.bulksmsgateway.in/sendmessage.php?user=".urlencode($username)."&password=".urlencode($password)."&mobile=".urlencode($mobile_number)."&message=".urlencode($message)."&sender=".urlencode($sender)."&type=".urlencode('3');
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $output = curl_exec($ch);
                curl_close($ch);
                // sms code
            }
        }

        $medicine = $prescription->medicinedets()->get();
        $medicines = $request->medicines;
        $timing = $request->timing;
        $duration = $request->duration;

        foreach ($medicine as $d){
            $i = $d->id;
            MedicineDetails::find($i)->delete();
        }


        if($medicines <> "") {
            for ($i = 0; $i < count($medicines); $i++) {
                //return $medicines[$i];
                if (intval($medicines[$i]) == 0) {
                    $symp = array('name' => $medicines[$i]);
                    $newmedicine = Medicine::create($symp);
                    $medicines[$i] = $newmedicine->id;
                } else {
                    $medicines[$i] = intval($medicines[$i]);
                }
                $medicinedetails = array('prescription_id'=>$prescription->id, 'medicine_id'=>$medicines[$i],'timing'=>$timing[$i],'duration'=>$duration[$i]);
                MedicineDetails::create($medicinedetails);
            }
        }

        $vaccines = $request->vaccines_id;
        $expiry = $request->expiry;
        $dates = $request->dates;
        if($vaccines <> "") {
            for ($i = 0; $i < count($vaccines); $i++) {
                $va = Vaccine::find($vaccines[$i]);
                $vac = array(
                    'vaccine_id' => $vaccines[$i],
                    'patient_id' => $prescription->appointment()->get()->all()[0]->patient_id,
                    'date' => $dates[$i],
                    'expiry' => $expiry[$i],
                );
                $vacc = Vaccination::create($vac);
            }
        }

        return redirect('/prescriptions/'.$id);
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
