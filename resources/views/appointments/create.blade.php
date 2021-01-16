@extends('layouts.main')
@section('title')
    <title>Vet N Pet - New Appointment</title>
@endsection
@section('breadcrum')
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Add New Appointment</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
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
    <div class="row" style="margin: 0 auto">
        <div class="col-md-6 appdet" style="margin: 0 auto">
            <div class="card sticky-top">
                <div class="card-body">
                    <table class="table table-hover">
                        <tbody>
                        <tr>
                            <td class="text-left">Patient ID</td>
                            <td>:</td>
                            <td class="text-left patttid"></td>
                        </tr>
                        <tr>
                            <td class="text-left">Owners Name</td>
                            <td>:</td>
                            <td class="text-left ownername"></td>
                        </tr>
                        <tr>
                            <td class="text-left">Name</td>
                            <td>:</td>
                            <td class="text-left name"></td>
                        </tr>
                        <tr>
                            <td class="text-left">Spicies</td>
                            <td>:</td>
                            <td class="text-left species"></td>
                        </tr>
                        <tr>
                            <td class="text-left">Age</td>
                            <td>:</td>
                            <td class="text-left age"></td>
                        </tr>
                        <tr>
                            <td class="text-left">Breed</td>
                            <td>:</td>
                            <td class="text-left breed"></td>
                        </tr>
                        <tr>
                            <td class="text-left">Color</td>
                            <td>:</td>
                            <td class="text-left color"></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6"  style="margin: 0 auto">
            <div class="card">
                <div class="card-body">
                    <div class="float-right"><a class="btn btn-danger" href="{{route('patients.create')}}">Create New Patient</a></div>
                    <div class="card-title">
                        <h4 class="text-center">New Appointment</h4>
                    </div>
                    @include('includes.formerror')
                    {!! Form::open(['method'=>'POST', 'action' => 'AppointmentController@store']) !!}
                        <div class="form-group">
                            {!! Form::label('patient_id', '* Patient:') !!}
                            {!! Form::select('patient_id', $patients , app('request')->input('patid') ? app('request')->input('patid') : null , ['class'=>'form-control patid select22']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('doctor_id', '* Doctor:') !!}
                            {!! Form::select('doctor_id', $doctors , null , ['class'=>'form-control']) !!}
                        </div>
                    @php
                        $date = \Carbon\Carbon::now();
                    @endphp
                        <div class="form-group">
                            {!! Form::label('date', '* Date:') !!}
                            {!! Form::date('date', null, ['class'=>'form-control', 'min'=>$date->toDateString()]) !!}
                        </div>
                        <div class="border-top">
                            <div class="card-body">
                                {!! Form::submit('Book Appointment', ['class'=>'btn btn-primary btn-block genapp']) !!}
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    $(document).on('click', '.genapp', function(){
        $(".preloader").show();
    });
    $(document).ready(function() {

        $('.select22').select2();
        $('.appdet').hide();
    });

    $('.select32').select2({
        placeholder: "Select or add species",
        tags: true,
        tokenSeparators: [","],
        createTag: function(newTag) {
            return {
                id: newTag.term,
                text: newTag.term + ' (new)'
            };
        }
    });
    $('.patid').on('change', function () {
        getpd();
    });
    if($('.patod')){
        getpd();
    }

    function getpd(){
        $('.appdet').hide();
        var token = '{{ Session::token() }}';
        var id = parseInt($('.patid').val());
        var url = '/getpd' ;
        $.ajax({
            method: 'POST',
            url: url,
            data:{id : id, _token : token},
            success: function (res) {
                $('.patttid').text(res.id);
                $('.ownername').text(res.name);
                $('.name').text(res.ownername);
                $('.species').text(res.species);
                $('.age').text(res.age);
                $('.color').text(res.color);
                $('.breed').text(res.breed);
                $('.appdet').show();
            }
        });
    }

</script>

@endsection