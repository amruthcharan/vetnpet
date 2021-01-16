<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\Http\Requests;
use App\Patient;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $patients = Patient::all()->count();
        $t = Date('Y-m-d');
/*        $r = date('Y-m-d',strtotime($t) + (24*3600*7));*/
        $apps = Appointment::whereDate('date','=',$t)->count();
        return view('index', compact(['user','patients','apps']));
    }

    public function expire()
    {
        return view('errors.503');
    }
}
