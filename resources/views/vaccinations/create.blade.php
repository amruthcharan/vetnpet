@extends('layouts.main')
@section('title')
    <title>Vet N Pet - New Vaccination</title>
@endsection
@section('breadcrum')
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Add New Vaccination</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Vaccinations</li>
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
                            <td class="text-left">Patient ID</td>
                            <td>:</td>
                            <td class="text-left patttid"></td>
                        </tr>
                        <tr>
                            <td class="text-left">Owners Name</td>
                            <td>:</td>
                            <td class="text-left ownername"></td>
                        </tr>
                        <tr>
                            <td class="text-left">Name</td>
                            <td>:</td>
                            <td class="text-left name"></td>
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
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6"  style="margin: 0 auto">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title" style="text-align: center">New Vaccination</h4>
                    @include('includes.formerror')
                    {!! Form::open(['method'=>'POST', 'action' => 'VaccinationController@store']) !!}
                        <div class="form-group">
                            {!! Form::label('patient_id', '* Patient:') !!}
                            {!! Form::select('patient_id', $patients , app('request')->input('patid') ? app('request')->input('patid') : null , ['class'=>'form-control patid select22']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('vaccine_id', '* Vaccine:') !!}
                            {!! Form::select('vaccine_id', $vaccines , null , ['class'=>'form-control select22']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('date', '* Date:') !!}
                            {!! Form::date('date', null, ['class'=>'form-control']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('expiry', '* Date:') !!}
                            {!! Form::date('expiry', null, ['class'=>'form-control']) !!}
                        </div>
                        <div class="border-top">
                            <div class="card-body">
                                {!! Form::submit('Add Vaccine', ['class'=>'btn btn-primary btn-block gensymp']) !!}
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
        $('.appdet').hide();
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
    $('.patid').on('change', function () {
        getpd();
    });
    if($('.patod')){
        getpd();
    }

    function getpd(){
        $('.appdet').hide();
        var token = '{{ Session::token() }}';
        var id = parseInt($('.patid').val());
        var url = '/getpd' ;
        $.ajax({
            method: 'POST',
            url: url,
            data:{id : id, _token : token},
            success: function (res) {
                $('.patttid').text(res.id);
                $('.ownername').text(res.name);
                $('.name').text(res.ownername);
                $('.species').text(res.species);
                $('.age').text(res.age);
                $('.breed').text(res.breed);
                $('.appdet').show();
            }
        });
    }

    $(document).on('click', '.gensymp', function(){
        $(".preloader").show();
    });
</script>
@endsection

</script>

@endsection