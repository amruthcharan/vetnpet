@extends('layouts.main')
@section('title')
    <title>Vet N Pet - Online Appointments</title>
@endsection

@section('breadcrum')
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Online Appointments</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Appointments</li>
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
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h4 class="float-left">Appointments</h4>
                        {{--<button class='btn btn-primary btn-sm float-right getrequests'><i class="ti-plus"></i><strong> Get Requests</strong></button>--}}
                    </div>

                    <div class="table-responsive">
                        <table id="appointments" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>Patient ID</th>
                                <th>Patient Name</th>
                                <th>Owner Name</th>
                                <th>Mobile</th>
                                <th>Email</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody class="tbody">

                            </tbody>
                        </table>
                        <span style='text-align: center;' class="error"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal  -->
    <div class="modal fade none-border" id="appmodal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Create Appointment</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                @php
                    use App\User;
                    $doctors = User::all('name','id','role_id')->where('role_id',2);
                    /*$doctors=[];
                    foreach($docs as $doc){
                        $key = $doc->id;
                        $value = $doc->name;
                        $doctors = $doctors + array($key=>$value);
                    }*/
                @endphp

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                                <div class="form-group">
                                    <label for="patiid">Patient ID:</label>
                                    <input type="text" class="form-control" id="patiid" readonly>
                                </div>
                            @php
                                $d = \Carbon\Carbon::now();
                            @endphp
                                <div class="form-group">
                                    <label for="patidate">Date:</label>
                                    <input type="date" class="form-control" min="{{$d->toDateString()}}" id="patidate">
                                </div>
                                <div class="form-group">
                                    <label for="doctor">Doctor:</label>
                                    <select class="form-control" id="doctor_id">
                                        @foreach($doctors as $doctor)
                                        <option value="{{$doctor->id}}">{{$doctor->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            <div style="text-align:center;">

                                <a class="btn btn-default" style="color:white;" id="createapp"> Create Appointment</a>
                                <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END MODAL -->
@endsection


@section('scripts')
    <script>
        $('#appointments').DataTable();
        getdetails();
        function getdetails(){
            var actionbtn;
            var url = '/getonlineapps';
            $(document).ajaxStart(function(){
                $(".preloader").show();
            }).ajaxStop(function(){
                $(".preloader").fadeOut();
            });
            $('error').empty();
            $.ajax({
                url: url,
                dataType: "json",
                success:function(d){
                    $('.tbody').empty();
                    $('error').empty();
                    //console.log(d);
                    $.each(JSON.parse(d), function(k,v){
                        console.log(v);
                        actionbtn = "<a href='/patients/" + v.patient_id + "' class='btn btn-info'>Patient Details</a>";
                        console.log(actionbtn);
                        $('.tbody').append("<tr><td>" + v.patient_id + "</td><td>" + v.patient.name + "</td><td>" + v.patient.ownername + "</td><td>" + v.patient.mobile + "</td><td>" + v.patient.email + "</td><td>" + v.date + "</td><td>" + actionbtn + "</td></tr>");

                    });
                },
                error:function (d) {
                    $('.tbody').empty();
                    $('.error').append("<h3>"+d.responseJSON.message+"</h3>");
                }
            });
        }
    </script>
@endsection