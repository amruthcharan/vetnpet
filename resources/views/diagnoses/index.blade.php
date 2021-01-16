@extends('layouts.main')
@section('title')
    <title>Vet N Pet - Diagnoses</title>
@endsection

@section('breadcrum')
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Diagnoses</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Diagnoses</li>
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
                        <h4 class="float-left">Diagnoses List</h4>
                        <div class="float-right">
                            {!! Form::open(['method'=>'POST', 'action' => 'DiagnosisController@store', 'class'=>'form-inline']) !!}
                            <div class="form-group">
                                {!! Form::label('name', 'Diagnosis:') !!}
                                {!! Form::text('name', null, ['class'=>'form-control']) !!}
                            </div>
                            <div class="card-body">
                                {!! Form::submit('Add', ['class'=>'btn btn-primary gensymp']) !!}
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table id="owners" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(isset($diagnoses))
                                @foreach($diagnoses as $diagnosis)
                                    <tr>
                                        <td>{{$diagnosis->id}}</td>
                                        <td>{{$diagnosis->name}}</td>
                                        <td>
                                            <a class="btn btn-dribbble" href="{{route('diagnoses.edit', $diagnosis->id)}}">Edit</a>
                                            {{--<a href="javascript:void(0)" data-toggle="modal" id="edit" data-id="{{$symptom->name}}" data-target="#edit-symptom" class="btn btn-info waves-effect waves-light">Edit</a>--}}
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
        $(document).on('click', '.gensymp', function(){
            $(".preloader").show();
        });
    </script>
@endsection