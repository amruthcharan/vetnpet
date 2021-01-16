@extends('layouts.main')
@section('title')
    <title>Vet N Pet - Update Health Package</title>
@endsection
@section('breadcrum')
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Edit Health Package</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
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
    <div class="row" style="margin: 0 auto">
        <div class="col-md-6 appdet" style="margin: 0 auto">
            <div class="card sticky-top">
                <div class="card-body">
                    <table class="table table-hover">
                        <tbody>

                        <tr>
                            <td class="text-left">Name</td>
                            <td>:</td>
                            <td class="text-left name"></td>
                        </tr>
                        <tr>
                            <td class="text-left">Owners Name</td>
                            <td>:</td>
                            <td class="text-left ownername"></td>
                        </tr>
                        <tr>
                            <td class="text-left">Spicies</td>
                            <td>:</td>
                            <td class="text-left species"></td>
                        </tr>
                        <tr>
                            <td class="text-left">Age</td>
                            <td>:</td>
                            <td class="text-left age"></td>
                        </tr>
                        <tr>
                            <td class="text-left">Breed</td>
                            <td>:</td>
                            <td class="text-left breed"></td>
                        </tr>
                        <tr>
                            <td class="text-left">Color</td>
                            <td>:</td>
                            <td class="text-left color"></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6"  style="margin: 0 auto">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title" style="text-align: center">Edit Health Package</h4>
                    @include('includes.formerror')
                    {!! Form::open(['method'=>'PATCH', 'action' => ['HealthPackageController@update',$healthpackage->id]]) !!}
                    <div class="form-group">
                        {!! Form::label('patient_id', '* Patient:') !!}
                        {!! Form::text('patient_id', $healthpackage->patient->id , ['class'=>'form-control pat_id', 'readonly'=>'readonly']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('package_id', '* Vaccine:') !!}
                        {!! Form::select('package_id', $packages , $healthpackage->vaccine_id , ['class'=>'form-control select22']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('date', '* Date:') !!}
                        {!! Form::date('date', $healthpackage->date, ['class'=>'form-control']) !!}
                    </div>
                    <div class="border-top">
                        <div class="card-body">
                            {!! Form::submit('Update Health Package', ['class'=>'btn btn-dribbble btn-block']) !!}
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
            getpd();
        });
        $('.select32').select2({
            placeholder: "Select an Option",
            tags: true,
            tokenSeparators: [","],
            createTag: function(newTag) {
                return {
                    id: newTag.term,
                    text: newTag.term + ' (new)'
                };
            }
        });

        function getpd(){
            $('.appdet').hide();
            var token = '{{ Session::token() }}';
            var id = parseInt($('#patient_id').val());
            //console.log(id);
            var url = '/getpd' ;
            $.ajax({
                method: 'POST',
                url: url,
                data:{id : id, _token : token},
                success: function (res) {
                    $('.ownername').text(res.ownername);
                    $('.name').text(res.name);
                    $('.species').text(res.species);
                    $('.age').text(res.age);
                    $('.color').text(res.color);
                    $('.breed').text(res.breed);
                    $('.appdet').show();
                }
            });
        }
    </script>
@endsection