@extends('layouts.main')

@section('title')
    <title>Vet N Pet - Reminders</title>
@endsection

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Reminders</h5>
                <div class="table-responsive">
                    <table id="zero_config" class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th>Patient ID</th>
                            <th>Pet Name</th>
                            <th>Owner Name</th>
                            <th>Mobile Number</th>
                            <th>Email</th>
                            <th>Reminder Date</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($reminders as $rem)
                            @if($rem->prescription == null && $rem->patient)
                                <tr>
                                    <td>{{$rem->patient->id}}</td>
                                    <td>{{$rem->patient->name ? $rem->patient->name : ''}}</td>
                                    <td>{{$rem->patient->ownername ? $rem->patient->ownername : ''}}</td>
                                    <td><a href="tel:{{$rem->patient->mobile ? $rem->patient->mobile : ''}}">{{$rem->patient->mobile ? $rem->patient->mobile : ''}}</a></td>
                                    <td><a href="mailto:{{$rem->patient->email ? $rem->patient->email : ''}}">{{$rem->patient->email ? $rem->patient->email : ''}}</a></td>
                                    <td>{{date('d-m-Y', strtotime($rem->date))}}</td>
                                    <td><button class="btn btn-danger sendsms">Send SMS</button></td>
                                </tr>
                            @endif
                        @endforeach
                    </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
@section('scripts')
    <script>
        $('#zero_config').DataTable({"order": [5,'asc']});

        $('table').delegate('.sendsms','click', function(){
            var aid = $(this).closest('tr').find('td').eq(0).html();
            $(document).ajaxStart(function(){
                $(".preloader").show();
            }).ajaxStop(function(){
                $(".preloader").fadeOut();
            });
            $.ajax({
                url : "/sendsms/"+aid,
                success:function(d){
                    var obj = JSON.parse(d);
                    toastr.success("SMS sent! Remaining balance is: " + obj.remainingcredits);
                    console.log(obj);

                },
                error:function (e) {
                    console.log(JSON.stringify(e));
                }
            });
        });
    </script>
@endsection