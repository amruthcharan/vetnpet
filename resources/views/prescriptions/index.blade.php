@extends('layouts.main')
@section('title')
    <title>Vet N Pet - Prescriptions</title>
@endsection

@section('breadcrum')
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Prescriptions</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
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
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h4 class="float-left">Prescriptions List</h4>
                        <a class='btn btn-primary btn-sm float-right' href="{{route('prescriptions.create')}}"><i class="ti-plus"></i><strong> New</strong></a>
                    </div>

                    <div class="table-responsive">
                        <table id="appointments" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Patient Name</th>
                                <th>Patient ID</th>
                                <th>Appointment ID</th>
                                <th>Appointment Date</th>
                                <th>Doctor Name</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(isset($prescriptions))
                                @foreach($prescriptions as $prescription)
                                    @if($prescription->appointment && $prescription->appointment->patient)
                                    <tr>
                                        <td>{{$prescription->id}}</td>
                                        <td>{{$prescription->appointment->patient->name ? $prescription->appointment->patient->name : ''}}</td>
                                        <td>{{$prescription->appointment->patient->id}}</td>
                                        <td>{{$prescription->appointment->id}}</td>
                                        <td>{{date('d-m-Y', strtotime($prescription->appointment->date))}}</td>
                                        <td>{{$prescription->appointment->doctor->name}}</td>
                                        <td>
                                            <a class="btn btn-success" href="{{route('prescriptions.show', $prescription->id)}}">View</a>
                                            <a class="btn btn-dribbble" href="{{route('prescriptions.edit', $prescription->id)}}">Edit</a>
                                            <a class="btn btn-info" href="{{'/patients/'.$prescription->appointment->patient->id}}">Patient Info</a>
                                            <a class="btn btn-dark" href="{{url('prescriptions/'.$prescription->id.'/print')}}" target="popup" onclick="window.open('{{url('prescriptions/'.$prescription->id.'/print')}}','popup','width=1300,height=700,location=0,scrollbars=no,resizable=no'); return false;"> Print</a>
                                            {{--<a href="javascript:void(0)" data-toggle="modal" data-target="#delete-user" class="btn btn-info waves-effect waves-light">Delete</a>--}}
                                        </td>
                                    </tr>
                                    @endif
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
        $('#appointments').DataTable({
            "order": [0,'desc']
        });

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
    </script>
@endsection