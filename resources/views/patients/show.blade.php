@extends('layouts.main')
@section('title')
    <title>Vet N Pet - {{$patient->name}}</title>
@endsection

@section('breadcrum')
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">{{$patient->name}}</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <span class="text-right"><a class="btn btn-sm btn-success" onclick="window.history.back();">back</a></span>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
@endsection

@section('content')

    <div class="row">
        <!-- column -->
        <div class="col-md-6 col-sm-12">
            <!-- Card -->
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h4 class="float-left">Owner Details</h4>
                        <a class='float-right' href="{{route('patients.edit',$patient->id)}}"><i class="ti-pencil-alt"></i></a>
                    </div>
                    <div class="table-responsive m-t-40" style="clear: both;">
                        <table class="table table-hover">
                            <tbody>
                            <tr>
                                <td class="text-left">Patient id</td>
                                <td>:</td>
                                <td class="text-left">{{$patient->id}}</td>
                            </tr>
                            <tr>
                                <td class="text-left">Owner Name</td>
                                <td>:</td>
                                <td class="text-left">{{$patient->ownername}}</td>
                            </tr>
                            <tr>
                                <td class="text-left">Mobile Number</td>
                                <td>:</td>
                                <td class="text-left">{{$patient->mobile}}</td>
                            </tr>
                            <tr>
                                <td class="text-left">Email Address</td>
                                <td>:</td>
                                <td class="text-left">{{$patient->email}}</td>
                            </tr>
                            <tr>
                                <td class="text-left">Address</td>
                                <td>:</td>
                                <td class="text-left">{{$patient->address}}</td>
                            </tr>
                            <tr>
                                <td class="text-left">Health Package</td>
                                <td>:</td>
                                @if($package)
                                <td class="text-left" style="color:{{$package->expiry > \Carbon\Carbon::today() ? 'green' : 'red'}}"><b>{{$package->package->name}} Package </b><br>Expires on {{$package->expiry->format('d-m-Y')}}
                                    <a href="{{route('healthpackages.edit', $package->id)}}"><i class="ti-pencil-alt"></i></a></td>
                                @else
                                    <td>
                                        <a href="{{route('healthpackages.create','patid='.$patient->id)}}" class="btnn btn-cyan btn-sm"> Add Package</a>
                                    </td>
                                @endif
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Appointments Card -->
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h4 class="float-left">Appointments</h4>
                        <a class='float-right' href="{{route('appointments.create','patid='.$patient->id)}}"><b><i class="ti-plus"></i></b></a>
                    </div>
                    <div class="table-responsive m-t-40" style="clear: both;">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Doctor Name</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            @foreach($patient->appointments as $appointment)
                                <tbody>
                                <tr>
                                    <td class="text-left">{{$appointment->id}}</td>
                                    <td>{{$appointment->doctor->name}}</td>
                                    <td class="text-left">{{$appointment->date->format('d-m-Y')}}</td>
                                    <td class="text-left">
                                        @if($appointment->prescription)
                                            <a href='{{url('/prescriptions/'.$appointment->prescription->id.'/print')}}' target="popup" onclick="window.open('{{url('prescriptions/'.$appointment->prescription->id.'/print')}}','popup','width=1300,height=700,location=0,scrollbars=no,resizable=no'); return false;">View Prescription</a>
                                        @else
                                            {{$appointment->status}}
                                        @endif
                                    </td>
                                </tr>
                                </tbody>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
            @if(!$patient->vaccinations->isEmpty())
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">
                            <h4 class="float-left">Vaccination Details</h4>
                            <a class='float-right' href="{{route('vaccinations.create','patid='.$patient->id)}}"><i class="ti-plus"></i></a>
                        </div>
                        <div class="table-responsive m-t-40" style="clear: both;">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Vaccine Name</th>
                                    <th>Date</th>
                                    <th>Expiry</th>
                                    <th>Action</th>
                                </tr>
                                </thead>


                                @foreach($patient->vaccinations as $v)
                                    <tbody>
                                    <tr class="{{$v->expiry < \Carbon\Carbon::today() ?  'table-danger' : 'table-success'}}">
                                        <td class="text-left">{{$v->id}}</td>
                                        <td>{{$v->vaccine->name}}</td>
                                        <td class="text-left">{{$v->date->format('d-m-Y')}}</td>
                                        <td class="text-left">{{$v->expiry->format('d-m-Y')}}</td>
                                        <td class="text-left"><a href="{{route('vaccinations.edit',$v->id)}}" class="btn btn-primary btn-xs">Edit</a></td>
                                    </tr>
                                    </tbody>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
                @else
                <center>
                    <p>No Vaccination Details Found</p>
                <a class="btn btn-dribbble btn-sm" href="{{route('vaccinations.create','patid='.$patient->id)}}">Add Vaccination Details</a></center>
            @endif
        </div>
        <!-- column -->
        <div class="col-md-6 col-sm-12">
            <!-- Card -->
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h4 class="float-left">Patient Details</h4>
                        <a class='float-right' href="{{route('patients.edit',$patient->id)}}"><i class="ti-pencil-alt"></i></a>
                    </div>
                    <div class="table-responsive m-t-40" style="clear: both;">
                        <table class="table table-hover">
                            <tbody>
                            <tr>
                                <td class="text-left">Name</td>
                                <td>:</td>
                                <td class="text-left">{{$patient->name}}</td>
                            </tr>
                            <tr>
                                <td class="text-left">Species</td>
                                <td>:</td>
                                <td class="text-left">{{$patient->species ? $patient->species->name : ''}}</td>
                            </tr>
                            <tr>
                                <td class="text-left">Gender</td>
                                <td>:</td>
                                <td class="text-left">{{$patient->gender}}</td>
                            </tr>
                            <tr>
                                <td class="text-left">Age</td>
                                <td>:</td>
                                <td class="text-left">{{$patient->age ? $patient->age->format('d-m-Y') : ''}}</td>
                            </tr>
                            <tr>
                                <td class="text-left">Breed</td>
                                <td>:</td>
                                <td class="text-left">{{$patient->breed}}</td>
                            </tr>
                            <tr>
                                <td class="text-left">Feeding Pattern</td>
                                <td>:</td>
                                <td class="text-left">{{$patient->feeding_pattern}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Card -->
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h4 class="float-left">Invoices</h4>
                        <a class='float-right' href="{{route('bills.create','patid='.$patient->id)}}"><b><i class="ti-plus"></i></b></a>
                    </div>
                    <div class="table-responsive m-t-40" style="clear: both;">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Date</th>
                                <th>Net Amount</th>
                                <th>Discount</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            @foreach($patient->bills as $bill)
                                <tbody>
                                <tr>
                                    <td class="text-left">{{$bill->id}}</td>
                                    <td>{{$bill->date->format('d-m-Y')}}</td>
                                    <td class="text-left">{{$bill->nettotal}}</td>
                                    <td class="text-left">{{$bill->discount}}</td>
                                    <td class="text-left"><a href="{{url('/bills/'.$bill->id.'/print')}}" target="popup" onclick="window.open('{{url('bills/'.$bill->id.'/print')}}','popup','width=1300,height=700,location=0,scrollbars=no,resizable=no'); return false;">View Invoice</a></td>
                                </tr>
                                </tbody>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row"></div>
@endsection
@section('scripts')
    <script>
        $(document).on('click','#help', function () {
            var hello = $('.datelp').val();
            console.log(hello);
        });
    </script>
@endsection