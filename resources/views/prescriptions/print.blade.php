@extends('layouts.print')
@section('title')
    <title>Vet N Pet - Prescription</title>
@endsection
@section('content')
    <div class="row" id="printid">
        <div class="col-md-12">
            <div class="card card-body printableArea">
                <h3><b>Prescription #</b> <span class="pull-right">{{$prescription->id}}</span></h3>
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <div class="float-left">
                            <address>
                                <img src="{{asset('assets/images/vnplogo.jpg')}}" width="120px">
                                <p class=" m-l-5">Plot No 369/1,
                                    <br/> Phase 3, Film Nagar
                                    <br/> Jubilee Hills
                                    <br/> Hyderabad - 500096</p>
                            </address>
                        </div>
                        <div class="float-right text-right">
                            <p class=""><b>Prescription Date :</b> <i class="fa fa-calendar"></i> {{$prescription->updated_at->format('d-m-Y')}}</p>
                            <address>
                                <h4>Prescription For,</h4>
                                <p class="m-l-30">{{$prescription->appointment->patient->name ? $prescription->appointment->patient->name : ''}}
                                    <span id="patttid" style="display:none">{{$prescription->appointment->patient_id}}</span>
                                    <br/> {{$prescription->appointment->patient->address}},
                                    <br/> <b>Prescribed By {{$prescription->appointment->doctor->name}}</b>.
                                </p>
                            </address>
                        </div>
                    </div>
                    <div class="col-md-12" id="vaccines">
                        <h4>Vaccination Details:</h4>
                        @foreach($vaccines as $v)
                            <div class='form-check form-check-inline'>
                                <input name='vaccines[]' class='form-check-input' type='checkbox' style="display: none" checked disabled="true" value='{{$v->id}}' id='vac{{$v->id}}'>
                                <label class='form-check-label' style="display: none" for='vac{{$v->id}}'>{{$v->name}}</label>
                            </div>
                        @endforeach
                    </div>
                    <div class="col-md-6">
                        <h4 class="m-t-20">Symptoms:</h4>
                        <div class="table-responsive" style="clear: both;">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-right">Symptom</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php
                                    $i = 1;
                                @endphp
                                @foreach($prescription->symptoms as $d)
                                    <tr>
                                        <td class="text-center">{{$i}}</td>
                                        <td class="text-right"> {{$d->name}} </td>
                                    </tr>
                                    @php
                                        $i++
                                    @endphp
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h4 class="m-t-20">Diagnoses:</h4>
                        <div class="table-responsive" style="clear: both;">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-right">Daignosis</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php
                                    $i = 1;
                                @endphp
                                @foreach($prescription->diagnosis as $d)
                                    <tr>
                                        <td class="text-center">{{$i}}</td>
                                        <td class="text-right">{{$d->name}}</td>
                                        @php
                                            $i++
                                        @endphp
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <h4 class="m-t-20">Medicines List:</h4>
                        <div class="table-responsive" style="clear: both;">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Medicine</th>
                                    <th class="text-right">Timing</th>
                                    <th class="text-right">Details</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php
                                    $i = 1;
                                @endphp
                                @foreach($prescription->medicinedets as $d)
                                    <tr>
                                        <td class="text-center">{{$i}}</td>
                                        <td>{{$d->medicine->name}}</td>
                                        <td class="text-right">
                                            {{$d->timing}}
                                        </td>
                                        <td class="text-right"> {{$d->duration}} </td>
                                    </tr>
                                    @php
                                        $i++
                                    @endphp
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <hr>
                        <div class="text-center">
                            <buttton class="btn btnpr btn-info" onclick="printit()"> Print Prescription </buttton>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            id = $('#patttid').text();
            var url = '/getvac/' + id;
            $.ajax({
                url: url,
                success: function (res) {
                    //console.log(res);
                    res.forEach(function (v) {
                        //console.log(v.expiry);
                        let id = '#vac' + v.vaccine_id;
                        let date = new Date(v.expiry);
                        let fdate = date.getDate() + "-" + (date.getMonth() + 1) + "-" + date.getFullYear();
                        let today = new Date();
                        let next_month = new Date();
                        next_month.setDate(today.getDate() + 30);
                        //console.log(next_month);

                        if (date > next_month) {
                            $(id).parent().children('label').attr('style', 'color: green;font-weight:bold');
                            $(id).attr('style', 'display: inline');
                            $(id).parent().children('label').append(' expires on ' + fdate);
                        } else if (date > today) {
                            $(id).parent().children('label').attr('style', 'color: orange;font-weight:bold');
                            $(id).attr('style', 'display: inline');
                            $(id).parent().children('label').append(' expiring on ' + fdate);
                        } else {
                            $(id).parent().children('label').attr('style', 'color: red;font-weight:bold');
                            $(id).attr('style', 'display: inline');
                            $(id).parent().children('label').append(' expired on ' + fdate);
                        }

                    });
                }
            });
        });
        function printit() {
            $('.btnpr').hide();
            window.print();
            window.close();
        }
    </script>

@endsection