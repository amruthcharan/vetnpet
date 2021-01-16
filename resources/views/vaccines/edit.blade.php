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
                <h4 class="page-title">Edit Vaccine</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
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
    <div class="row" style="margin: 0 auto">
        <div class="col-md-6"  style="margin: 0 auto">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title" style="text-align: center">Edit <strong>{{$vaccine->name}}</strong></h4>
                    @include('includes.formerror')
                    {!! Form::open(['method'=>'PATCH', 'action' => ['VaccineController@update',$vaccine->id]]) !!}
                    <div class="form-group">
                        {!! Form::label('name', 'Vaccine Name:') !!}
                        {!! Form::text('name', $vaccine->name, ['class'=>'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('validity', 'Validity in months:') !!}
                        {!! Form::number('validity', $vaccine->validity, ['class'=>'form-control']) !!}
                    </div>
                    <div class="border-top">
                        <div class="card-body">
                            {!! Form::submit('Update Vaccine', ['class'=>'btn btn-dribbble btn-block']) !!}
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection