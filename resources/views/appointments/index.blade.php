@extends('layouts.main')
@section('title')
    <title>Vet N Pet - Appointments</title>
@endsection

@section('breadcrum')
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Appointments</h4>
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
                        <h4 class="float-left">Appointments List</h4>
                        <a class='btn btn-primary btn-sm float-right' href="{{route('appointments.create')}}"><i class="ti-plus"></i><strong> New</strong></a>
                    </div>

                    <div class="table-responsive">
                        <table id="appointments" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Patient Name</th>
                                <th>Owner Name</th>
                                <th>Doctor Name</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(isset($appointments))
                                @foreach($appointments as $appointment)
                                    @if($appointment->patient)
                                    <tr>
                                        <td>{{$appointment->id}}</td>
                                        <td>{{$appointment->patient->name ?? ''}}</td>
                                        <td>{{$appointment->patient->ownername ?? ""}}</td>
                                        <td>{{$appointment->doctor->name ?? ''}}</td>
                                        <td>{{date('d-m-Y', strtotime($appointment->date))}}</td>
                                        <td>{{$appointment->status}}</td>
                                        <td>
                                            @if($appointment->status <> 'Expired')
                                                <a class="btn btn-dribbble" href="{{route('appointments.edit', $appointment->id)}}">Edit</a>
                                                <a class="btn {{$appointment->status == 'Scheduled' ? 'btn-warning': "btn-success"}}"  href="{{$appointment->prescription <> null ? 'prescriptions/'.$appointment->prescription->id : 'prescriptions/create?appid='. $appointment->id}}">Prescription</a>
                                            @endif
                                            <a class="btn btn-info" href="{{'patients/'.  $appointment->patient->id}}">Patient Info</a>
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