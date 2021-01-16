@extends('layouts.main')
@section('title')
    <title>Vet N Pet - Billing</title>
@endsection

@section('breadcrum')
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Invoice</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Invoice</li>
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
                        <h4 class="float-left">Invoice List</h4>
                        <a class='btn btn-primary btn-sm float-right' href="{{url('/bills/create')}}"><i class="ti-plus"></i><strong> New</strong></a>
                    </div>

                    <div class="table-responsive">
                        <table id="appointments" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Date</th>
                                <th>Patient Name</th>
                                <th>Owner Name</th>
                                <th>Invoice Total</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(isset($bills))
                                @foreach($bills as $bill)
                                    <tr>
                                        <td>{{$bill->id}}</td>
                                        <td>{{$bill->created_at->format('d-m-Y')}}</td>
                                        <td>{{$bill->patient->name}}</td>
                                        <td>{{$bill->patient->ownername}}</td>
                                        <td>{{$bill->nettotal}}</td>
                                        <td>
                                            <a class="btn btn-success" href="{{route('bills.show', $bill->id)}}">View</a>
                                            @if(Auth::user()->role_id == 1)
                                                <a class="btn btn-dribbble" href="{{route('bills.edit', $bill->id)}}">Edit</a>
                                            @endif
                                            <a class="btn btn-info" href="{{'/patients/'.$bill->patient->id}}">Patient Info</a>
                                            <a class="btn btn-dark" href="{{url('bills/'.$bill->id.'/print')}}" target="popup" onclick="window.open('{{url('bills/'.$bill->id.'/print')}}','popup','width=1300,height=700,location=0,scrollbars=no,resizable=no'); return false;"> Print Invoice </a>
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