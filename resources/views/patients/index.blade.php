@extends('layouts.main')
@section('title')
    <title>Vet N Pet - Patients</title>
@endsection

@section('breadcrum')
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Patients</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Patients</li>
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
                        <h4 class="float-left">Patients List</h4>
                        <a class='btn btn-primary btn-sm float-right' href="{{route('patients.create')}}"><i class="ti-plus"></i><strong> New</strong></a>
                    </div>

                    <div class="table-responsive">
                        <table id="owners" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Age</th>
                                <th>Owner Name</th>
                                <th>Species</th>
                                <th>Breed</th>
                                <th>Mobile</th>
                                <th>Gender</th>
                                <th>Feeding Pattern</th>
                                <th>Created On</th>
                                @foreach($vaccines as $vac)
                                    <th>{{$vac->name}}</th>
                                @endforeach
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(isset($patients))
                                @foreach($patients as $patient)
                                    <tr>
                                        <td>{{$patient->id}}</td>
                                        <td>{{$patient->name}}</td>
                                        <td>{{$patient->age ? $patient->age->format('d-m-Y') : ''}}</td>
                                        <td>{{$patient->ownername ? $patient->ownername : ""}}</td>
                                        <td>{{$patient->species ? $patient->species->name : ""}}</td>
                                        <td>{{$patient->breed ? $patient->breed : ""}}</td>
                                        <td>{{$patient->mobile ? $patient->mobile : ""}}</td>
                                        <td>{{$patient->gender ? $patient->gender : ""}}</td>
                                        <td>{{$patient->feeding_pattern ? $patient->feeding_pattern : ""}}</td>
                                        <td>{{$patient->created_at ? $patient->created_at->format('d-m-Y') : ''}}</td>
                                        @foreach($vaccines as $vac)
                                            @php $j = true; @endphp
                                            @for($i=0;$i < count($patient->vaccinations); $i++)
                                                @if($patient->vaccinations[$i]->vaccine_id   == $vac->id)
                                                <td>
                                                    <div style='font-weight: bold; {{$patient->vaccinations[$i]->expiry > \Carbon\Carbon::today() ? 'color:green;' : 'color:red;'}}'>{{$patient->vaccinations[$i]->expiry->format('d-m-Y')}}</div>
                                                </td>
                                                    @php $j = false @endphp
                                                @endif
                                            @endfor
                                            @if($j)
                                                <td>Not Found</td>
                                            @endif
                                        @endforeach
                                        <td>
                                            <a class="btn btn-dribbble" href="{{route('patients.edit', $patient->id)}}">Edit</a>
                                            <a class="btn btn-info" href="{{route('patients.show', $patient->id)}}">Patient Info</a>
                                            <button class="btn btn-warning" onclick="quickAppointment({{$patient->id}})">Quick Appointment</button>
                                            <a class="btn btn-success" href="{{'/bills/create?patid='.$patient->id}}">Invoice</a>
                                            {{--<a href="javascript:void(0)" data-toggle="modal" data-target="#delete-user" class="btn btn-info waves-effect waves-light">Delete</a>--}}
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('scripts')
    <script>
        var Table = $('#owners').DataTable({
            "order": [0,'desc'],
        });
        yadcf.init(Table , [{
            column_number: 4,
            select_type: 'select2',
            select_type_options: {

                placeholder: '',
                allowClear: true  // show 'x' (remove) next to selection inside the select itself
            },
            column_data_type: "html",
            html_data_type: "text",
            filter_reset_button_text: false // hide yadcf reset button
        }, {
            column_number: 5,
            select_type: 'select2',
            select_type_options: {
                placeholder: '',
                allowClear: true  // show 'x' (remove) next to selection inside the select itself
            },
            column_data_type: "html",
            html_data_type: "text",
            filter_reset_button_text: false // hide yadcf reset button
        }, {
            column_number: 7,
            select_type: 'select2',
            select_type_options: {

                placeholder: '',
                allowClear: true  // show 'x' (remove) next to selection inside the select itself
            },
            column_data_type: "html",
            html_data_type: "text",
            filter_reset_button_text: false // hide yadcf reset button
        }, {
            column_number: 8,
            select_type: 'select2',
            select_type_options: {
                placeholder: '',
                allowClear: true  // show 'x' (remove) next to selection inside the select itself
            },
            column_data_type: "html",
            html_data_type: "text",
            filter_reset_button_text: false // hide yadcf reset button
        }]);

        @if(Session::has('message'))
        var type = "{{ Session::get('alert-type') }}";

        switch(type){
            case 'info':
                toastr.info("{{session('message')}}", "{{session('head')}}");
                break;
            case 'success':
                toastr.success("{{session('message')}}", "{{session('head')}}");
                break;
            case 'danger':
                toastr.error("{{session('message')}}", "{{session('head')}}");
                break;
            case 'warning':
                toastr.warning("{{session('message')}}", "{{session('head')}}");
                break;
        }
        @endif
        function quickAppointment(pid) {
            var url = '/quickapp/' + pid;
            $(document).ajaxStart(function(){
                $(".preloader").show();
            }).ajaxStop(function(){
                $(".preloader").fadeOut();
            });
            $.ajax({
                method: 'GET',
                url: url,
                success: function (res) {
                    window.location.assign('/prescriptions/create?appid='+res.id);
                }
            });
        }
    </script>
@endsection