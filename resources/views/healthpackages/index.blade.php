@extends('layouts.main')
@section('title')
    <title>Vet N Pet - Health Packages</title>
@endsection

@section('breadcrum')
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Health Packages</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Health Packages</li>
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
                        <h4 class="float-left">Health Packages List</h4>
                        <a class='btn btn-primary btn-sm float-right' href="{{route('healthpackages.create')}}"><i class="ti-plus"></i><strong> New</strong></a>
                    </div>

                    <div class="table-responsive">
                        <table id="healthpackages" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Patient Name</th>
                                <th>Vaccine Name</th>
                                <th>Date</th>
                                <th>Expiry</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(isset($healthpackages))
                                @foreach($healthpackages as $hp)
                                    @if($hp->patient)
                                    <tr>
                                        <td>{{$hp->id}}</td>
                                        <td>{{$hp->patient->name ? $hp->patient->name : ''}}</td>
                                        <td>{{$hp->package->name ? $hp->package->name : ""}}</td>
                                        <td>{{date('d-m-Y', strtotime($hp->date))}}</td>
                                        <td>{{date('d-m-Y', strtotime($hp->expiry))}}</td>
                                        <td>
                                            <a class="btn btn-info" href="{{route('healthpackages.edit', $hp->id)}}">Edit</a>
                                            <a class="btn btn-danger" href="{{route('patients.show', $hp->patient->id)}}">Patient Info</a>
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
        $('#healthpackages').DataTable({
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