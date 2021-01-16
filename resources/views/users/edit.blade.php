@extends('layouts.main')
@section('title')
    <title>Vet N Pet - New User</title>
@endsection
@section('breadcrum')
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Add New User</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Users</li>
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

                    <h4 class="card-title" style="text-align: center">Edit <strong>{{$user->name}}</strong></h4>
                    @include('includes.formerror')
                    {!! Form::open(['method'=>'PATCH', 'action' => ['UserController@update',$user->id]]) !!}
                    <div class="form-group">
                        {!! Form::label('name', 'Name:') !!}
                        {!! Form::text('name', $user->name, ['class'=>'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('email', 'Email:') !!}
                        {!! Form::text('email', $user->email, ['class'=>'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('password', 'Password:') !!}
                        {!! Form::password('password', ['class'=>'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('role_id', 'Role:') !!}
                        {!! Form::select('role_id', $roles ,$user->role_id, ['class'=>'form-control select22']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('is_active', 'Status:') !!}
                        {!! Form::select('is_active', array(1 => 'Active', 0 => 'Not Active') , $user->is_active , ['class'=>'form-control']) !!}
                    </div>
                    <div class="border-top">
                        <div class="card-body">
                            {!! Form::submit('Edit User', ['class'=>'btn btn-dribbble btn-block']) !!}
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
        });
    </script>

@endsection