@extends('layouts.main')
@section('title')
    <title>Vet N Pet - New Patient</title>
@endsection
@section('breadcrum')
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Add New Patient</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
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
    <div class="row" style="margin: 0 auto">
        <div class="col-md-6"  style="margin: 0 auto">
            <div class="card">
                <div class="card-body">
                    @include('includes.formerror')
                    {!! Form::open(['method'=>'POST', 'action' => 'PatientController@store']) !!}
                        <div class="form-group">
                            {!! Form::label('ownername', 'Owner Name:') !!}
                            {!! Form::text('ownername', null, ['class'=>'form-control']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('address', 'Address:') !!}
                            {!! Form::textarea('address', null, ['class'=>'form-control', 'rows' => 8, 'cols' => 40]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('mobile', 'Mobile Number:') !!}
                            {!! Form::text('mobile', null, ['class'=>'form-control']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('email', 'Email Address:') !!}
                            {!! Form::text('email', null, ['class'=>'form-control']) !!}
                        </div>
                </div>
            </div>
        </div>
        <div class="col-md-6"  style="margin: 0 auto">
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        {!! Form::label('name', 'Name:') !!}
                        {!! Form::text('name', null, ['class'=>'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('species_id', 'Species:') !!}
                        {!! Form::select('species_id', $species ,null, ['class'=>'form-control select32']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('gender', 'Gender:') !!}
                        {!! Form::select('gender', $gender = array(''=>'Select An Option', 'Male'=>'Male', 'Female'=>'Female') ,null, ['class'=>'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('age', 'Age:') !!}
                        {!! Form::date('age', null, ['class'=>'form-control']) !!}
                        {{--<div class="input-group-prepend">--}}
                            {{--{!! Form::text('years', null, ['class'=>'form-control']) !!}--}}
                            {{--<span class="input-group-text">Years</span>--}}
                            {{--{!! Form::text('months', null, ['class'=>'form-control']) !!}--}}
                            {{--<span class="input-group-text">Months</span>--}}
                            {{--{!! Form::text('days', null, ['class'=>'form-control']) !!}--}}
                            {{--<span class="input-group-text">Days</span>--}}
                        {{--</div>--}}
                    </div>
                    <div class="form-group">
                        {!! Form::label('breed', 'Breed:') !!}
                        {!! Form::text('breed', null, ['class'=>'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('feeding_pattern', 'Feeding Pattern:') !!}
                        {!! Form::select('feeding_pattern', $feeding_pattern = array(''=>'Select An Option', 'Homemade Food'=>'Homemade Food', 'Pet Food'=>'Pet Food', 'Mixed'=>'Mixed Food') ,null, ['class'=>'form-control select22']) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="border-top">
                <div class="card-body">
                    {!! Form::submit('Register Patient', ['class'=>'btn btn-primary btn-block genpat']) !!}
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection

@section('scripts')
<script>
    $(document).on('click', '.genpat', function(){
        $(".preloader").show();
    });
    $(document).ready(function() {
        $('.select22').select2();
    });

    $('.select32').select2({
        placeholder: "Select or add species",
        tags: true,
        tokenSeparators: [","],
        createTag: function(newTag) {
            return {
                id: newTag.term,
                text: newTag.term + ' (new)'
            };
        }
    });
</script>

@endsection