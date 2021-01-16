@extends('layouts.main')
@section('title')
    <title>Vet N Pet - Edit Prescription</title>
@endsection
@section('breadcrum')
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Edit Prescription #{{$prescription->id}}</h4>
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
        <div class="col-md-4 appdet" style="margin: 0 auto">
            <div class="card sticky-top">
                <div class="card-body">
                    <table class="table table-hover">
                        <tbody>
                        <tr>
                            <td class="text-left">Patient's ID</td>
                            <td>:</td>
                            <td class="text-left patttid">{{$prescription->appointment->patient->id}}</td>
                        </tr>
                        <tr>
                            <td class="text-left">Patinet's Name</td>
                            <td>:</td>
                            <td class="text-left ownername">{{$prescription->appointment->patient->name ? $prescription->appointment->patient->name : ''}}</td>
                        </tr>
                        <tr>
                            <td class="text-left">Owners Name</td>
                            <td>:</td>
                            <td class="text-left name">{{$prescription->appointment->patient->ownername ? $prescription->appointment->patient->ownername : ''}}</td>
                        </tr>
                        <tr>
                            <td class="text-left">Spicies</td>
                            <td>:</td>
                            <td class="text-left species">{{$prescription->appointment->patient->species ? $prescription->appointment->patient->species->name : ''}}</td>
                        </tr>
                        <tr>
                            <td class="text-left">Age</td>
                            <td>:</td>
                            <td class="text-left age">{{$prescription->appointment->patient->age ? $prescription->appointment->patient->age->format('d-m-Y') : ''}}</td>
                        </tr>
                        <tr>
                            <td class="text-left">Breed</td>
                            <td>:</td>
                            <td class="text-left breed">{{$prescription->appointment->patient->breed ? $prescription->appointment->patient->breed : ''}}</td>
                        </tr>
                        <tr>
                            <td class="text-left">Feeding Pattern</td>
                            <td>:</td>
                            <td class="text-left feeding_pattern">{{$prescription->appointment->patient->feeding_pattern}}</td>
                        </tr>
                        <tr>
                            <td class="text-left">Appointment Date</td>
                            <td>:</td>
                            <td class="text-left date">{{$prescription->appointment->date->format('d-m-Y')}}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-8"  style="margin: 0 auto">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title" style="text-align: center">Edit Prescription</h4>
                    @include('includes.formerror')
                    {!! Form::open(['method'=>'PATCH', 'action' => ['PrescriptionController@update', $prescription->id]]) !!}
                    <div class="form-group">
                        {!! Form::label('appointment_id', 'Appointment ID:') !!}
                        {!! Form::select('appointment', $prescription , $prescription->appointment->id , ['class'=>'form-control', 'hidden'=>'hidden']) !!}
                        {!! Form::text('appointment_id', $prescription->appointment->id , ['class'=>'form-control', 'readonly'=>'readonly']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('symptoms', 'Symptoms:') !!}
                        {!! Form::select('symptoms[]', $symptoms , $prescription->symptoms->lists('id')->all(), ['class'=>'form-control select32','multiple'=>'multiple']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('diagnoses', 'Diagnoses:') !!}
                        {!! Form::select('diagnoses[]', $diagnoses , $prescription->diagnosis->lists('id')->all() , ['class'=>'form-control select32','multiple'=>'multiple']) !!}
                    </div>

                    <br>
                    <div id="vaccines">
                        <h4>Vaccination Details:</h4>
                        @foreach($vaccines as $v)
                            <div class='row'>
                                <div class='col-md-1 check' style='padding-top:10px;'>
                                    <input type='checkbox' name='vaccines_id[]' class='form-check' id='{{$v->id}}' value='{{$v->id}}'>
                                </div>
                                <div class='col-3'>
                                    <input class='form-control' value="{{$v->name}}" id="name{{$v->id}}" type='text' readonly>
                                    <label class='form-check-label' for="vac{{$v->id}}">No data Found</label>
                                </div>
                                <div class='col-4'>
                                    <input id="date{{$v->id}}" type='date' name='dates[]' class='form-control datee' disabled>
                                </div>
                                <div class='col-4'>
                                    <input name='expiry[]' id="exp{{$v->id}}" type='date' class='form-control expiryy' disabled>
                                </div>
                            </div>
                            <br>
                        @endforeach
                    </div>


                    <div id="medicine">
                        <h3 class="float-left">Medicines</h3>
                        <a onclick="addmedicine()" class="btn btn-primary float-right"><i class="fa fa-plus"></i></a>
                        <br>
                        <br>
                        @foreach($prescription->medicinedets as $d)
                            <div class="row align-items-center">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        {!! Form::label('medicines', 'Medicines:') !!}
                                        {!! Form::select('medicines[]', $medicines->lists('name', 'id')->all(), $d->medicine->id, ['class'=>'form-control select32']) !!}
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="timing">Timings:</label>
                                        @php
                                            $opts = array('M','A','N','MA','AN','MN','MAN');
                                        @endphp
                                        <select name='timing[]' class="form-control">

                                            @foreach($opts as $opt)
                                                <option value="{{$opt}}" @if($opt == $d->timing) selected @endif>{{$opt}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="duration">Details:</label>
                                        <input type="text" name='duration[]' value='{{$d->duration}}'  class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-1"><a class='btn btn-warning remove'><i class='fa fa-minus'></i></a></div>
                            </div>
                        @endforeach
                    </div>
                    {{--Previous Vaccination details--}}



                    <div class="form-group">
                        {!! Form::label('notes', 'Notes:') !!}
                        {!! Form::textarea('notes',$prescription->notes,['class'=>'form-control', 'rows' => 5, 'cols' => 40]) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('reminder', 'Reminder:') !!}
                        {!! Form::date('reminder', $prescription->reminder, ['class'=>'form-control']) !!}
                    </div>

                    <div class="border-top">
                        <div class="card-body">
                            {!! Form::submit('Update Prescription', ['class'=>'btn btn-primary btn-block']) !!}
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
        $(document).ready(function() {
            $('.select22').select2();
            id = $('.patttid').text();
            var url = '/getvac/' + id ;
            $.ajax({
                url: url,
                success: function (res) {
                    //console.log(res.vaccinations);
                    res.forEach(function (v) {
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
                        if (expiry > next_month) {
                            $(id).parent().children('label').attr('style', 'color: green;font-weight:bold');
                            $(id).parent().children('label').text(' expires on ' + fexpiry);

                        } else if (expiry > today) {
                            $(id).parent().children('label').attr('style', 'color: orange;font-weight:bold');
                            $(id).parent().children('label').text(' expiring on ' + fexpiry);
                        } else {
                            $(id).parent().children('label').attr('style', 'color: red;font-weight:bold');
                            $(id).parent().children('label').text(' expired on ' + fexpiry);
                        }
                    });
                }
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