@extends('layouts.main')
@section('title')
    <title>Vet N Pet - New Prescription</title>
@endsection
@section('breadcrum')
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">New Prescription</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Prescriptions</li>
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
        <div class="col-lg-4 col-md-12 appdet" style="margin: 0 auto">
            <div class="card sticky-top">
                <div class="card-body">
                    <table class="table table-hover">
                        <tbody>
                        <tr>
                            <td class="text-left">Patient's ID</td>
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
                            <td class="text-left">Feeding Pattern</td>
                            <td>:</td>
                            <td class="text-left feeding_pattern"></td>
                        </tr>
                        <tr>
                            <td class="text-left">Appointment Date</td>
                            <td>:</td>
                            <td class="text-left date"></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-8 col-md-12"  style="margin: 0 auto">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title" style="text-align: center">New Prescription</h4>
                    @include('includes.formerror')
                    {!! Form::open(['method'=>'POST', 'action' => 'PrescriptionController@store']) !!}
                        <div class="form-group">
                            {!! Form::label('appointment_id', 'Appointment:') !!}
                            {{ csrf_field() }}
                            {!! Form::select('appointment_id', $appointments , app('request')->input('appid') ? app('request')->input('appid') : null , ['class'=>'form-control appid select22']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('symptoms', 'Symptoms:') !!}
                            {!! Form::select('symptoms[]', $symptoms , null , ['class'=>'form-control select32','multiple'=>'multiple']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('diagnoses', 'Diagnoses:') !!}
                            {!! Form::select('diagnoses[]', $diagnoses , null , ['class'=>'form-control select32','multiple'=>'multiple']) !!}
                        </div>
                        {{--previous prescriptions--}}
                        <div id="pres"></div>
                        {{--Previous Vaccination details--}}
                        <br>
                        <div id="vaccines">

                        </div>
                        <div id="medicine">
                            <br>
                            <h3 class="float-left">Medicines</h3>
                            <a onclick="addmedicine()" class="btn btn-primary float-right"><i class="fa fa-plus"></i></a>
                            <br>
                            <br>
                        </div>

                        <div class="form-group">
                            {!! Form::label('notes', 'Notes:') !!}
                            {!! Form::textarea('notes',null,['class'=>'form-control', 'rows' => 5, 'cols' => 40]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('reminder', 'Reminder:') !!}
                            {!! Form::date('reminder', null, ['class'=>'form-control remdate']) !!}
                        </div>
                        <div class="border-top">
                            <div class="card-body">
                                {!! Form::submit('Submit', ['class'=>'btn btn-primary btn-block genpre']) !!}
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
    $(document).on('click', '.genpre', function(){
        $(".preloader").show();
    });
    $(document).ready(function() {
        $('.select22').select2();
        $('.appdet').hide();
        $('#pres').hide();

        var today = new Date();
        var dd = today.getDate()+1;
        var mm = today.getMonth()+1;
        var yyyy = today.getFullYear();

        var today = mm + '/' + dd + '/' + yyyy;
        $('remdate').datepicker({
            minDate: today,
        });
    });

    $('.select32').select2({
        placeholder: "Start typing...",
        tags: true,
        tokenSeparators: [","],
        createTag: function(newTag) {
            return {
                id: newTag.term,
                text: newTag.term + ' (new)'
            };
        }
    });
    
    function addmedicine() {
        $('#medicine').append("<div class=\"row align-items-center\"><div class=\"col-md-4\"><div class=\"form-group\"><label for=\"medicine\">Medicine:</label><select name='medicines[]' class=\"form-control select32\">@foreach($medicines as $medicine)<option value='{{$medicine->id}}'>{{$medicine->name}}</option>@endforeach</select></div></div><div class=\"col-md-3\"><div class=\"form-group\"><label for=\"timing\">Timings:</label><select name='timing[]' class=\"form-control\"><option>M</option><option>A</option><option>N</option><option>MA</option><option>AN</option><option>MN</option><option>MAN</option></select></div></div><div class=\"col-md-4\"><div class=\"form-group\"><label for=\"duration\">Details:</label><input type=\"text\" name='duration[]' class=\"form-control\"></div></div><div class=\"col-md-1\"><a class='btn btn-warning remove'><i class='fa fa-minus'></i></a></div></div>");
        $('.select32').select2({
            placeholder: "Start typing...",
            tags: true,
            tokenSeparators: [","],
            createTag: function (newTag) {
                return {
                    id: newTag.term,
                    text: newTag.term + ' (new)'
                };
            }
        });
    }
    $(document).on('click', '.remove', function (){
        $(this).closest('.row').remove();
    });

    $('.appid').on('change', function () {
        getpdd();
    });

    if($('.appid')){
        getpdd();
    }

    function getpdd(){
        $('#pres').hide();
        $('#pres').html("<h4 class='float-left'>Previous Records:  </h4>");
        $('.appdet').hide();
        var token = '{{ Session::token() }}';
        var id = parseInt($('.appid').val());
        var url = '/getad' ;
        $.ajax({
            method: 'POST',
            url: url,
            data:{id : id, _token : token},
            success: function (res) {
                $('#vaccines').empty();
                //console.log(res);
                $('.patttid').text(res.id);
                $('.ownername').text(res.name);
                $('.name').text(res.ownername);
                $('.species').text(res.species);
                $('.age').text(res.age);
                $('.feeding_pattern').text(res.feeding_pattern);
                $('.breed').text(res.breed);
                let d = new Date(res.date.date);
                let fd = d.getDate() + "-" + (d.getMonth() + 1) + "-" + d.getFullYear();
                $('.date').text(fd);
                $('#vaccines').append("<h4>Vaccination Details:</h4> <div class='row'><div class='col-md-1'></div><div class='col-md-3'>Vaccine Name:</div><div class='col-md-4'>Vaccination Date:</div><div class='col-md-4'>Expiry:</div></div>");
                res.vaccines.forEach(function (va){
                    //$('#vaccines').append("<div class='form-check form-check-inline'><input name='vaccines[]' class='form-check-input' type='checkbox' value='" + va.id + "'id='vac" + va.id + "'> <label class='form-check-label' for='vac" + va.id + "'>" + va.name + "</label></div>");
                    $('#vaccines').append("<div class='row'><div class='col-md-1 check' style='padding-top:10px;'><input type='checkbox' name='vaccines_id[]' class='form-check' id='vac" + va.id + "' value='" + va.id + "'></div><div class='col-3'><input class='form-control' value=' " + va.name + " ' id='name" + va.id + "' type='text' readonly> <label class='form-check-label' for='vac" + va.id + "'>No data Found</label></div><div class='col-4'><input id='date" + va.id + "' type='date' name='dates[]' class='form-control datee' disabled></div><div class='col-4'><input name='expiry[]' id='exp" + va.id + "' type='date' class='form-control expiryy' disabled></div></div><br>");
                });
                //console.log(res.vaccinations);
                res.vaccinations.forEach(function (v) {
                    let id = '#name' + v.vaccine_id;
                    //let vid = '#vac' + v.vaccine_id;
                    let did = '#date' + v.vaccine_id;
                    let eid = '#exp' + v.vaccine_id;
                    let expiry = new Date(v.expiry);
                    let date = new Date(v.date);
                    let fexpiry = expiry.getDate() + "-" + (expiry.getMonth() + 1) + "-" + expiry.getFullYear();
                    let today = new Date();
                    let next_month = new Date();
                    next_month.setDate(today.getDate() + 30);
                    //console.log(next_month);
                    $(did).val(date.toISOString().split('T')[0]);
                    $(eid).val(expiry.toISOString().split('T')[0]);
                    if(expiry > next_month){
                        $(id).parent().children('label').attr('style', 'color: green;font-weight:bold');
                        $(id).parent().children('label').text(' expires on ' + fexpiry);

                    } else if(expiry > today){
                        $(id).parent().children('label').attr('style', 'color: orange;font-weight:bold');
                        $(id).parent().children('label').text(' expiring on ' + fexpiry);
                    }else {
                        $(id).parent().children('label').attr('style', 'color: red;font-weight:bold');
                        $(id).parent().children('label').text(' expired on ' + fexpiry);
                    }

                });
                $('.appdet').show();
                let ij = 0;
                let url = new URL(window.location.href);
                let appId = url.searchParams.get("appid");
                // appId = $('.appid').val();
                res.pre.forEach(function (preapp) {
                    if(preapp.status == 'Completed'){
                        ij++;
                        if (appId == preapp.id) {
                            var url = '/getpreid/'+preapp.id;
                            $.ajax({
                                url: url,
                                success: function (d) {
                                    console.log(d);
                                    let link = '/prescriptions/' + d.preid + '/edit';
                                    window.location.replace(link);
                                    return false;
                                }
                            });
                            // let url = '/prescriptions/' + preapp.id + '/edit';
                            // window.location.replace(url);
                        }
                        let link = '/prescriptions/' + preapp.id + '/print';
                        function easyPopup() {
                            window.open(link,'popup','width=1300,height=700,location=0,scrollbars=no,resizable=no');
                            return false;
                        }
                        $("<span>&nbsp;</span><a class='btn btn-outline-secondary btn-xs apppre' target='popup'>" + preapp.id +"</a>").appendTo('#pres');
                    }
                });
                if(ij==0){
                    $('#pres').html("<center><h4 class='btn-danger'>No Previous Records Found</h4></center>");
                }
                $('#pres').show();
            }
        });
    }

    $(document).on('click','.apppre',function () {
        var appid = $(this).text();
        var url = '/getpreid/'+appid;
        $.ajax({
            url: url,
            success: function (d) {
                console.log(d);
                let link = '/prescriptions/' + d.preid + '/print';
                window.open(link, 'popup', 'width=1300,height=700,location=0,scrollbars=no,resizable=no');
                return false;
            }
        })
    });

    $(document).delegate('.check','click', function () {
        if($(this).find('.form-check').prop("checked")){
            $(this).closest('.row').find('.datee').prop("disabled",false);
            $(this).closest('.row').find('.datee').prop("required",true);
            $(this).closest('.row').find('.datee').val("");
            $(this).closest('.row').find('.expiryy').prop("disabled",false);
            $(this).closest('.row').find('.expiryy').prop("required",true);
            $(this).closest('.row').find('.expiryy').val("");
        } else {
            $(this).closest('.row').find('.datee').prop("disabled",true);
            $(this).closest('.row').find('.expiryy').prop("disabled",true);
        }

        //console.log(varr);
    });

</script>

@endsection