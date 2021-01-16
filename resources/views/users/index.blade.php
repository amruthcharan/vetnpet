@extends('layouts.main')
@section('title')
    <title>Vet N Pet - Users</title>
@endsection

@section('breadcrum')
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Users</h4>
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
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h4 class="float-left">Users List</h4>
                        <a class='btn btn-primary btn-sm float-right' href="{{route('users.create')}}"><i class="ti-plus"></i><strong> New</strong></a>
                    </div>

                    <div class="table-responsive">
                        <table id="users" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(isset($users))
                                @foreach($users as $user)
                                    <tr>
                                        <td><a href="{{route('users.edit', $user->id)}}">{{$user->name}}</a></td>
                                        <td>{{$user->email}}</td>
                                        <td>{{$user->role->name}}</td>
                                        <td>{{$user->is_active == 1 ? 'Active' : 'Not Active'}}</td>
                                        <td>
                                            <a class="btn btn-dribbble" href="{{route('users.edit', $user->id)}}">Edit</a>
                                            <a href="javascript:void(0)" data-toggle="modal" data-target="#delete-user" class="btn btn-info waves-effect waves-light">Delete</a>
                                            {{--{!! Form::open(['method'=>"DELETE", 'action'=>['UserController@destroy', $user->id]]) !!}
                                            {!! Form::submit('Delete', ['class'=>'btn btn-info']) !!}
                                            {!! Form::close() !!}--}}
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
    @include('includes.model')
@endsection


@section('scripts')
    <script>
        $('#users').DataTable({
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