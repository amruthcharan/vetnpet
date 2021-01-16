@extends('layouts.main')
@section('title')
    <title>Vet N Pet - Packages</title>
@endsection

@section('breadcrum')
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Packages</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Packages</li>
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
                        <h4>Packages List</h4>
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
                                    @if(isset($packages))
                                        @foreach($packages as $package)
                                        <tr>
                                                <td>{{$package->id}}</td>
                                                <td>{{$package->name}}</td>
                                                <td>{{$package->validity}} Months</td>
                                                <td>
                                                    <a class="btn btn-dribbble" href="{{route('packages.edit', $package->id)}}">Edit</a>
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
                            {!! Form::open(['method'=>'POST', 'action' => 'PackageController@store', 'class'=>'']) !!}
                            <div class="form-group">
                                {!! Form::label('name', 'Package Name:') !!}
                                {!! Form::text('name', null, ['class'=>'form-control']) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('validity', 'Validity in months:') !!}
                                {!! Form::number('validity', null, ['class'=>'form-control']) !!}
                            </div>
                            <div class="card-body">
                                {!! Form::submit('Add New Package', ['class'=>'btn btn-primary btn-block gensymp']) !!}
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