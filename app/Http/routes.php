<?php

use App\Appointment;
use App\Bill;
use App\HealthPackage;
use App\Medicine;
use App\Package;
use App\Patient;
use App\Prescription;
use App\Vaccination;
use App\Vaccine;
use App\Events\SendSms;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use App\Http\Middleware\CheckAge;
use App\Http\Requests\AppointmentRequest;
use Illuminate\Http\Request;

Route::get('/api', function () {
    return view('appointments.api');
});

Route::get('/findid/{mobile}', function ($mobile) {
    $patient = Patient::where('mobile', $mobile)->first();
    return Response::json($patient);
});

Route::post('/createapp', function (AppointmentRequest $request) {
    $input = $request->all();
    $input['created_by'] = 'Created by API';
    $app = Appointment::create($input);
    $d = date_create($app->date);

    $date = date_format($d, 'd/m/Y');
    $patient = $app->patient;
    $name = $patient->name ?? '';
    $doc = $app->doctor->name ?? "Dr. Karnati";
    $id = $app->id;
    $message="Dear Customer, Appointment has been successfully booked for your pet, $name on $date. with $doc. Your Appointment id is $id. VetPet";

    $mobile = $patient->mobile;

    event(new SendSms($message, $mobile, "1507163912258936396"));


    return Response::json($app);
});

Route::post('/createnewapp', function(Request $request) {
    $name = $request->input('patient_name');
    $owner_name = $request->input('owner_name');
    $mobile = $request->input('mobile');
    $email = $request->input('email');
    $patient = Patient::create([
        'name' => $name,
        'ownername' => $owner_name,
        'mobile' => $mobile,
        'email' => $email,
        'created_by' => "Created by API"
    ]);
    $appdate = $request->input('date');
    $app = Appointment::create([
        'patient_id' => $patient->id,
        'doctor_id' => 2,
        'date' => $appdate,
        'created_by' => "Created by API"
    ]);
    $d = date_create($app->date);
    $doc = $app->doctor->name ?? "Dr. Karnati";
    $id = $app->id;

    $date = date_format($d, 'd/m/Y');
    $message="Dear Customer, Appointment has been successfully booked for your pet, $name on $date. with $doc. Your Appointment id is $id. VetPet";
    event(new SendSms($message, $mobile, "1507163912258936396"));


    return Response::json($app);
});

Route::auth();

//Route Group with Auth Middleware
Route::group(['middleware'=>['auth','authadv']], function (){
        //Dashboard Route
        Route::get('/', 'HomeController@index');

        //Users Route
        Route::resource('/users', 'UserController');

        //owners Routes
        Route::resource('/owners', 'OwnerController');

        //Patients Routes
        Route::resource('/patients', 'PatientController');

        //Appointments routes
        Route::resource('/appointments', 'AppointmentController');

        //Prescription routes
        Route::resource('/prescriptions', 'PrescriptionController');

        //Vaccination Routes
        Route::resource('/vaccinations', 'VaccinationController');

        //Health Package Routes
        Route::resource('/healthpackages', 'HealthPackageController');

        Route::get('/prescriptions/{id}/print', function ($id) {
            $prescription = Prescription::findOrFail($id);
            $vaccines = Vaccine::all();
            return view('prescriptions.print', compact(['prescription', 'vaccines']));
        });


        //symptom routes
        Route::resource('/symptoms', 'SymptomController');

        //Diagnoses routes
        Route::resource('/diagnoses', 'DiagnosisController');

        //medicine routes
        Route::resource('/medicines', 'MedicineController');

        //vaccines routes
        Route::resource('/vaccines', 'VaccineController');

        //Packages Routes
        Route::resource('/packages', 'PackageController');

        //billing routes
        Route::resource('/bills', 'BillingController');
        Route::get('/bills/{id}/print', function ($id) {
            $bill = Bill::findOrFail($id);
            $package = HealthPackage::with('package')->where('patient_id', $bill->patient_id)->orderBy('expiry', 'desc')->first();
            return view('bills.print', compact(['bill', 'package']));
        });

        //notifications route
        Route::get('/notifications', function () {
            return view('errors.503');
        });


        Route::get('/eightreports', function () {
            $start = Input::get('start');
            $end = Input::get('end');
            $out = 0;
            $in = 0;
            $other = 0;
            $on = 0;
            $invoice = 0;
            if (isset($start) and isset($end)) {
                $a = Appointment::all()->filter(function ($bill) {
                    $start = Input::get('start');
                    $end = Input::get('end');
                    return $bill->created_at->format('Y-m-d') > $start and $bill->created_at->format('Y-m-d') <= $end;
                })->count();
                $b = Bill::all()->filter(function ($bill) {
                    $start = Input::get('start');
                    $end = Input::get('end');
                    return $bill->created_at->format('Y-m-d') > $start and $bill->created_at->format('Y-m-d') <= $end;
                });
                $total = Bill::all()->filter(function ($bill) {
                    $start = Input::get('start');
                    $end = Input::get('end');
                    return $bill->created_at->format('Y-m-d') > $start and $bill->created_at->format('Y-m-d') <= $end;
                })->sum('nettotal');
                foreach ($b as $bill) {
                    if ($bill->type == 'outpatient') {
                        $out++;
                    } else if ($bill->type == 'inpatient') {
                        $in++;
                    } else if ($bill->type == 'boarding') {
                        $on++;
                    } else if ($bill->type == 'others') {
                        $other++;
                    } else {
                        $out++;
                    }
                    $invoice++;
                }
            }
            $c = array([
                'apps' => $a,
                'bills' => $invoice,
                'cases' => $invoice,
                'total' => $total,
                'in' => $in,
                'out' => $out,
                'on' => $on,
                'other' => $other,
            ]);
            $res = json_encode($c);
            return Response::json($res);
        });


        //Reports route
        Route::get('/reports', function () {
            $start = Input::get('start');
            $end = Input::get('end');
            if (isset($start) and isset($end)) {
                $type = Input::get('type');
                switch ($type) {
                    case 'bills':
                        $d = Bill::all()->filter(function ($bill) {
                            $start = Input::get('start');
                            $end = Input::get('end');
                            return $bill->created_at->format('Y-m-d') > $start and $bill->created_at->format('Y-m-d') <= $end;
                        });
                        $total = Bill::all()->filter(function ($bill) {
                            $start = Input::get('start');
                            $end = Input::get('end');
                            return $bill->created_at->format('Y-m-d') > $start and $bill->created_at->format('Y-m-d') <= $end;
                        })->sum('nettotal');
                        foreach ($d as $bill) {
                            $bill->pat = $bill->patient;
                            $bill->tot = $total;
                        }
                        break;
                    case 'patients':
                        $d = Patient::all()->filter(function ($patient) {
                            $start = Input::get('start');
                            $end = Input::get('end');
                            return $patient->created_at->format('Y-m-d') > $start and $patient->created_at->format('Y-m-d') <= $end;
                        })->load('species');
                        //return $d;
                        break;
                    case 'appointments':
                        $d = Appointment::all()->filter(function ($app) {
                            $start = Input::get('start');
                            $end = Input::get('end');
                            return $app->date > $start and $app->date <= $end;
                        });
                        foreach ($d as $app) {
                            $app->pat = $app->patient;
                            $app->doc = $app->doctor;
                        }
                        break;
                    case 'prescriptions':
                        $d = Prescription::all()->filter(function ($pre) {
                            $start = Input::get('start');
                            $end = Input::get('end');
                            return $pre->created_at->format('Y-m-d') > $start and $pre->created_at->format('Y-m-d') <= $end;
                        });
                        foreach ($d as $pre) {
                            $pre->pat = $pre->appointment->patient;
                            $pre->doc = $pre->appointment->doctor;
                            $pre->app = $pre->appointment;

                        }
                        break;
                }
                $res = json_encode($d);
                return Response::json($res);
            } else {
                $bills = Bill::all()->filter(function ($bill) {
                    $t = date('Y-m-d');
                    return $bill->created_at == $t;
                });
                $total = Bill::all()->filter(function ($bill) {
                    $t = date('Y-m-d');
                    return $bill->created_at == $t;
                })->sum('nettotal');
                //return $total;
                return view('reports', compact(['bills', 'total']));
            }
        });

        //reminders route

        Route::get('/reminders', function () {
            $t = date('Y-m-d');
            $reminders = Appointment::where('date', '>=', $t)->get()->load('prescription')->all();
            //return $reminders;
            return view('reminders', compact('reminders'));
        });
        Route::get('/getvac/{id}', function ($id) {
            $vaccination = Vaccination::where('patient_id', $id)
                ->select(DB::raw('*, max(expiry) as expiry'))
                ->orderBy('expiry', 'desc')
                ->groupBy('vaccine_id')
                ->get()->toArray();
            return Response::json($vaccination);
        });

        Route::post('/getad', function (Request $request) {
            $input = $request->all();
            $id = $input['id'];
            $app = Appointment::findOrFail($id);
            $vaccines = Vaccine::all();
            //$vaccinations = Vaccination::where('patient_id',$app->patient_id)->groupBy('vaccine_id')->latest('expiry')->get();
            $vaccinations = Vaccination::where('patient_id', $app->patient_id)
                ->select(DB::raw('*, max(expiry) as expiry'))
                ->orderBy('expiry', 'desc')
                ->groupBy('vaccine_id')
                ->get();
            $res = array(
                'status' => 'success',
                'id' => $app->patient->id ? $app->patient->id : "",
                'ownername' => $app->patient->ownername ? $app->patient->ownername : "",
                'name' => $app->patient->name ? $app->patient->name : '',
                'species' => $app->patient->species ? $app->patient->species->name : '',
                'age' => $app->patient->age ? $app->patient->age->format('d-m-Y') : '',
                'breed' => $app->patient->breed ? $app->patient->breed : '',
                'feeding_pattern' => $app->patient->feeding_pattern ? $app->patient->feeding_pattern : '',
                'date' => $app->date ? $app->date : '',
                'pre' => $app->patient->appointments,
                'vaccinations' => $vaccinations,
                'vaccines' => $vaccines,
            );
            return Response::json($res);
        });

        Route::post('/getped', function (Request $request) {
            $input = $request->all();
            $id = $input['id'];
            $app = Appointment::findOrFail($id);

            $res = array(
                'status' => 'success',
                'pres' => $app->prescription->id,
                'symptoms' => $app->prescription->symptoms,
                'diagnoses' => $app->prescription->diagnosis,
                'medicinedets' => $app->prescription->medicinedets,
                'notes' => $app->prescription->notes,
            );
            return Response::json($res);
        });
        Route::get('/getpreid/{id}', function ($id) {
            $app = Appointment::findOrFail($id)->load('prescription');
            $res = array(
                'status' => 'success',
                'preid' => $app->prescription->id
            );
            //return $app;
            return Response::json($res);

        });

        Route::get('/getmn/{id}', function ($id) {

            $app = Medicine::findOrFail($id);

            $res = array(
                'status' => 'success',
                'name' => $app->name,
            );
            return Response::json($res);
        });

        Route::post('/addpkg', function (Request $request) {
            $input = $request->all();
            $input['date'] = Carbon::today()->toDateString();
            $p = Package::find($input['package_id']);
            $t = new Carbon($input['date']);
            $input['expiry'] = $t->addMonths($p->validity);
            $pkg = HealthPackage::create($input)->load('package');
            return Response::json($pkg);
        });


        Route::post('/getpd', function (Request $request) {
            $input = $request->all();
            $id = $input['id'];
            $patient = \App\Patient::findOrFail($id);
            $package = HealthPackage::with('package')->where('patient_id', $id)->orderBy('expiry', 'desc')->first();

            $res = array(
                'status' => 'success',
                'id' => $patient->id ? $patient->id : '',
                'ownername' => $patient->ownername ? $patient->ownername : '',
                'name' => $patient->name ? $patient->name : '',
                'species' => $patient->species ? $patient->species->name : '',
                'age' => $patient->age ? $patient->age->format('d-m-Y') : '',
                'breed' => $patient->breed ? $patient->breed : '',
                'color' => $patient->color ? $patient->color : '',
                'package' => $package
            );
            return Response::json($res);
        });
        Route::get('/getdata', function () {
            return view('getdata');
        });
        Route::get('/onlineapps', function () {
            return view('onlineapps');
        });
        Route::post('/createpat', function (Request $request) {
            $input = $request->all();
            $input['created_by'] = 'Online API';
            $pat = Patient::create($input);
            return Response::json($pat);
        });
        
        Route::get('/getonlineapps', function () {
            $t = date('Y-m-d');
            $apps = Appointment::where('created_by', 'Created by API')->where('date', '>=', $t)->orderBy('date')->get()->load('patient')->all();
            //return $apps;
            $res = json_encode($apps);
            return Response::json($res);

        });

        Route::get('/sendsms/{id}', function ($id) {
            $app = Appointment::findOrFail($id);
            $message = "Dear Pet Parent, it's a friendly reminder that your PET is falling due for VET check up today for scheduled regimen at Vet N Pet. For further info 8885000588.";
            $mobile_number = $app->patient->mobile;
            event(new SendSms($message, $mobile_number, "1507163912229014687"));

            return response()->json(['success' => true, 'message' => "SMS Sent!"], 200);
        });

        Route::get('/sendreminders', function () {
            $t = date('Y-m-d');
            Appointment::whereDate('date', '<', $t)->where('status', '=', 'Scheduled')->update(['status' => 'Expired']);
            $apps = Appointment::where('date', $t)->get()->all();
            $res = [];
            foreach ($apps as $app) {
                $message = "Dear Pet Parent, it's a friendly reminder that your PET is falling due for VET check up today for scheduled regimen at Vet N Pet. For further info 8885000588.";
                $mobile_number = $app->patient->mobile;
                event(new SendSms($message, $mobile_number, "1507163912229014687"));
                array_push($res, $app->id);
            }
            return Response::json($res);
        });

        Route::get('/quickapp/{id}', function ($id) {
            $input['patient_id'] = $id;
            $authUser = auth()->user();
            //return $authUser;
            if ($authUser->role_id == 2) {
                $input['doctor_id'] = $authUser->id;
            } else {
                $input['doctor_id'] = 2;
            }
            $input['date'] = date('Y-m-d');
            $input['created_by'] = "Created via QuickApp";
            $app = Appointment::create($input);
            return Response::json($app);
        });

});

Route::get('/expired', 'HomeController@expire');