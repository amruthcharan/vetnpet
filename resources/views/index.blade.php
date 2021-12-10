@extends('layouts.main')

@section('title')
    <title>Vet N Pet - Dashboard</title>
@endsection

@section('content')

    <div class="row" id="grids">
        <!-- First Row Start-->
        <!-- Column -->
        <div class="col-md-6 col-lg-3">
            <div class="card card-hover">
                <div class="box bg-orange text-center">
                    <h1 class="font-weight-bold text-white">{{$patients}}</h1>
                    <h6 class="text-white">Patients Registered</h6>
                </div>
            </div>
        </div>
        <!-- Column -->
        <div class="col-md-6 col-lg-3">
            <div class="card card-hover">
                <div class="box bg-danger text-center">
                    <h1 class="font-weight-bold text-white">{{$apps}}</h1>
                    <h6 class="text-white">Appointments Today</h6>
                </div>
            </div>
        </div>
        <!-- Column -->
        <div class="col-md-6 col-lg-3">
            <div class="card card-hover">
                <div class="box bg-cyan text-center send-reminders">
                    <h1 class="font-weight-bold text-white"><i class="mdi mdi-send"></i></h1>
                    <h6 class="text-white">Send All Reminders</h6>
                </div>
            </div>
        </div>
        <!-- Column -->
        <div class="col-md-6 col-lg-3">
            <div class="card card-hover">
                <div class="box bg-success text-center reminders">
                    <h1 class="font-light text-white"><i class="mdi mdi-access-point"></i></h1>
                    <h6 class="text-white">Reminders</h6>
                </div>
            </div>
        </div>
        <!-- First Row End-->

        <!-- Second Row Start-->
        <!-- Column -->
        <div class="col-md-6 col-lg-3">
            <div class="card card-hover newpatient">
                <div class="box bg-success text-center">
                    <h1 class="font-light text-white"><i class="mdi mdi-new-box"></i></h1>
                    <h6 class="text-white">New Patient</h6>
                </div>
            </div>
        </div>
        <!-- Column -->
        <div class="col-md-6 col-lg-3">
            <div class="card card-hover newappointment">
                <div class="box bg-orange text-center">
                    <h1 class="font-light text-white"><i class="mdi mdi-new-box"></i></h1>
                    <h6 class="text-white">New Appointment</h6>
                </div>
            </div>
        </div>
        <!-- Column -->
        <div class="col-md-6 col-lg-3">
            <div class="card card-hover newprescription">
                <div class="box bg-danger text-center">
                    <h1 class="font-light text-white"><i class="mdi mdi-new-box"></i></h1>
                    <h6 class="text-white">New Prescription</h6>
                </div>
            </div>
        </div>
        <!-- Column -->
        <div class="col-md-6 col-lg-3">
            <div class="card card-hover billing">
                <div class="box bg-cyan text-center">
                    <h1 class="font-light text-white"><i class="mdi mdi-new-box"></i></h1>
                    <h6 class="text-white">New Invoice</h6>
                </div>
            </div>
        </div>
        <!-- Second Row End-->

        <!-- Third Row Start-->
        <!-- Column -->
        <div class="col-md-6 col-lg-3">
            <div class="card card-hover patients">
                <div class="box bg-cyan text-center">
                    <h1 class="font-light text-white"><i class="mdi mdi-account-switch"></i></h1>
                    <h6 class="text-white">Patients List</h6>
                </div>
            </div>
        </div>
        <!-- Column -->
        <div class="col-md-6 col-lg-3">
            <div class="card card-hover appointments">
                <div class="box bg-success text-center">
                    <h1 class="font-light text-white"><i class="mdi mdi-account-box"></i></h1>
                    <h6 class="text-white">View Appointments</h6>
                </div>
            </div>
        </div>
        <!-- Column -->
        <div class="col-md-6 col-lg-3">
            <div class="card card-hover prescriptions">
                <div class="box bg-orange text-center">
                    <h1 class="font-light text-white"><i class="mdi mdi-newspaper"></i></h1>
                    <h6 class="text-white">View Prescriptions</h6>
                </div>
            </div>
        </div>
        <!-- Column -->
        <div class="col-md-6 col-lg-3">
            <div class="card card-hover reports">
                <div class="box bg-danger text-center">
                    <h1 class="font-light text-white"><i class="mdi mdi-repeat"></i></h1>
                    <h6 class="text-white">View Reports</h6>
                </div>
            </div>
        </div>
        <!-- Third Row End-->

        <!-- Fourth Row Start-->
        <!-- Column -->
        <div class="col-md-6 col-lg-3">
            <div class="card card-hover diagnoses">
                <div class="box bg-danger text-center">
                    <h1 class="font-light text-white"><i class="mdi mdi-database-plus"></i></h1>
                    <h6 class="text-white">Diagnoses List</h6>
                </div>
            </div>
        </div>
        <!-- Column -->
        <div class="col-md-6 col-lg-3">
            <div class="card card-hover symptoms">
                <div class="box bg-cyan text-center">
                    <h1 class="font-light text-white"><i class="mdi mdi-view-list"></i></h1>
                    <h6 class="text-white">Symptoms List</h6>
                </div>
            </div>
        </div>
        <!-- Column -->
        <div class="col-md-6 col-lg-3">
            <div class="card card-hover medicines">
                <div class="box bg-success text-center">
                    <h1 class="font-light text-white"><i class="mdi mdi-medical-bag"></i></h1>
                    <h6 class="text-white">Medicines List</h6>
                </div>
            </div>
        </div>
        <!-- Column -->
        <div class="col-md-6 col-lg-3">
            <div class="card card-hover vaccines">
                <div class="box bg-orange text-center">
                    <h1 class="font-light text-white"><i class="mdi mdi-package-variant-closed"></i></h1>
                    <h6 class="text-white">Vaccines List</h6>
                </div>
            </div>
        </div>
    </div>
    <!-- Fourth Row End-->
    @endsection
@section('scripts')
    <script>
        $('#zero_config').DataTable();

        $(document).on('click','.patients', function () {
            window.location.href = "/patients";
        });
        $(document).on('click','.newpatient', function () {
            window.location.href = "/patients/create";
        });
        $(document).on('click','.appointments', function () {
            window.location.href = "/appointments";
        });
        $(document).on('click','.newappointments', function () {
            window.location.href = "/appointments/create";
        });
        $(document).on('click','.prescriptions', function () {
            window.location.href = "/prescriptions";
        });
        $(document).on('click','.newprescription', function () {
            window.location.href = "/prescriptions/create";
        });
        $(document).on('click','.reminders', function () {
            window.location.href = "/reminders";
        });
        $(document).on('click','.reports', function () {
            window.location.href = "/reports";
        });
        $(document).on('click','.symptoms', function () {
            window.location.href = "/symptoms";
        });
        $(document).on('click','.medicines', function () {
            window.location.href = "/medicines";
        });
        $(document).on('click','.diagnoses', function () {
            window.location.href = "/diagnoses";
        });
        $(document).on('click','.vaccines', function () {
            window.location.href = "/vaccines";
        });
        $(document).on('click','.billing', function () {
            window.location.href = "/bills/create";
        });
        $(document).on('click','.send-reminders', function () {
            let count=0;
            let remaining;
            $(document).ajaxStart(function(){
                $(".preloader").show();
            }).ajaxStop(function(){
                $(".preloader").fadeOut();
            });
            $.ajax({
                url : "/sendreminders",
                success:function(d){
                    if(d.length > 0){
                        toastr.success("Reminders sent!");
                    } else {
                        toastr.warning("No Reminders to send!");
                    }
                },
                error:function (e) {
                    console.log(JSON.stringify(e));
                }
            });

        });

    </script>
@endsection