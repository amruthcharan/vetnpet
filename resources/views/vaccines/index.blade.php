@extends('layouts.main')
@section('title')
    <title>Vet N Pet - Vaccines</title>
@endsection

@section('breadcrum')
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Vaccines</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Vaccines</li>
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
                        <h4>Vaccines List</h4>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="table-responsive">
                                <table id="owners" class="table table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Validity</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(isset($vaccines))
                                        @foreach($vaccines as $vaccine)
                                        <tr>
                                                <td>{{$vaccine->id}}</td>
                                                <td>{{$vaccine->name}}</td>
                                                <td>{{$vaccine->validity}} Months</td>
                                                <td>
                                                    <a class="btn btn-dribbble" href="{{route('vaccines.edit', $vaccine->id)}}">Edit</a>
                                                    {{--<a href="javascript:void(0)" data-toggle="modal" id="edit" data-id="{{$symptom->name}}" data-target="#edit-symptom" class="btn btn-info waves-effect waves-light">Edit</a>--}}
                                                    @if (auth()->user()->role_id === 1)
                                                    {!! Form::open(['method'=>'DELETE', 'action' => ['VaccineController@destroy',$vaccine->id]]) !!}
                                                        {!! Form::submit('Delete', ['class'=>'btn btn-danger']) !!}
                                                    {!! Form::close() !!}
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-1"></div>
                        <div class="col-5">
                            {!! Form::open(['method'=>'POST', 'action' => 'VaccineController@store', 'class'=>'']) !!}
                            <div class="form-group">
                                {!! Form::label('name', 'Vaccine Name:') !!}
                                {!! Form::text('name', null, ['class'=>'form-control']) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('validity', 'Validity in months:') !!}
                                {!! Form::number('validity', null, ['class'=>'form-control']) !!}
                            </div>
                            <div class="card-body">
                                {!! Form::submit('Add New Vaccine', ['class'=>'btn btn-primary btn-block gensymp']) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).on('click', '.gensymp', function(){
            $(".preloader").show();
        });
    </script>
@endsection