<?php

namespace App\Http\Controllers;

use App\Bill;
use App\BillComponents;
use App\HealthPackage;
use App\Http\Requests\BilingRequest;
use App\Package;
use App\Patient;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class BillingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $bills = Bill::all();

        return view('bills.index', compact('bills'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $patients = Patient::orderBy('id')->lists('id','id');
        $packages = Package::all();
        return view('bills.create',compact(['patients', 'packages']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BilingRequest $request)
    {
        //
        $input = $request->all();
        //return $input;
        $input['created_by'] = Auth::user()->name;
        $bill = Bill::create($input);
        $components = $request->component;
        $id = $bill->id;
        //return $id;
        $amount = $request->amount;
        if($components <> ""){
            for($i=0;$i<count($components);$i++){
                $billdetails = array('bill_id'=>$bill->id, 'name'=>$components[$i], 'amount' => $amount[$i]);
                BillComponents::create($billdetails);
            }
        }

        return redirect('/bills/'.$id);
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
        $bill = Bill::findOrFail($id);
        $package = HealthPackage::with('package')->where('patient_id',$bill->patient_id)->orderBy('expiry', 'desc')->first();
        return view('bills.show',compact(['bill', 'package']));
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
        $bill = Bill::findOrFail($id)->load('patient');
        $packages = Package::all();
        $package = HealthPackage::with('package')->where('patient_id',$bill->patient_id)->orderBy('expiry', 'desc')->first();
        return view('bills.edit', compact(['bill','package', 'packages']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BilingRequest $request, $id)
    {
        //
        $bill = Bill::find($id);
        $input = $request->all();
        $input['updated_by'] = Auth::user()->name;
        $bill->update($input);
        $components = $request->component;
        $amount = $request->amount;
        $component = $bill->billcomponents()->get();
        foreach($component as $d){
            $i = $d->id;
            BillComponents::find($i)->delete();
        }
        if($components <> ""){
            for($i=0;$i<count($components);$i++){
                $billdetails = array('bill_id'=>$bill->id, 'name'=>$components[$i], 'amount' => $amount[$i]);
                BillComponents::create($billdetails);
            }
        }

        return redirect('/bills/'.$bill->id);
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
