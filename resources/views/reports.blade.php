@extends('layouts.main')

@section('title')
    <title>Vet N Pet - Reports</title>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <!-- First Row Start-->
                        <!-- Column -->
                        <div class="col-md-6 col-lg-3">
                            <div class="card card-hover">
                                <div class="box bg-orange text-center">
                                    <h1 class="font-weight-bold text-white ccases"></h1>
                                    <h6 class="text-white">Cases</h6>
                                </div>
                            </div>
                        </div>
                        <!-- Column -->
                        <div class="col-md-6 col-lg-3">
                            <div class="card card-hover">
                                <div class="box bg-danger text-center">
                                    <h1 class="font-weight-bold text-white capps"></h1>
                                    <h6 class="text-white">Appointments</h6>
                                </div>
                            </div>
                        </div>
                        <!-- Column -->
                        <div class="col-md-6 col-lg-3">
                            <div class="card card-hover">
                                <div class="box bg-cyan text-center reminders">
                                    <h1 class="font-weight-bold text-white cinvoice"></h1>
                                    <h6 class="text-white">Invoices</h6>
                                </div>
                            </div>
                        </div>
                        <!-- Column -->
                        <div class="col-md-6 col-lg-3">
                            <div class="card card-hover">
                                <div class="box bg-success text-center online">
                                    <h1 class="font-light text-white">₹ <span class="ctotal"></span></h1>
                                    <h6 class="text-white">Total Amount</h6>
                                </div>
                            </div>
                        </div>
                        <!-- First Row End-->
                        <!-- Second Row Start-->
                        <!-- Column -->
                        <div class="col-md-6 col-lg-3">
                            <div class="card card-hover">
                                <div class="box bg-success text-center online">
                                    <h1 class="font-weight-bold text-white cout"></h1>
                                    <h6 class="text-white">Out Patient</h6>
                                </div>
                            </div>
                        </div>
                        <!-- Column -->
                        <div class="col-md-6 col-lg-3">
                            <div class="card card-hover">
                                <div class="box bg-cyan text-center reminders">
                                    <h1 class="font-weight-bold text-white cin"></h1>
                                    <h6 class="text-white">In-Patient</h6>
                                </div>
                            </div>
                        </div>
                        <!-- Column -->
                        <div class="col-md-6 col-lg-3">
                            <div class="card card-hover">
                                <div class="box bg-danger text-center">
                                    <h1 class="font-weight-bold text-white cboarding"></h1>
                                    <h6 class="text-white">Bording</h6>
                                </div>
                            </div>
                        </div>
                        <!-- Column -->
                        <div class="col-md-6 col-lg-3">
                            <div class="card card-hover">
                                <div class="box bg-orange text-center">
                                    <h1 class="font-weight-bold text-white cothers"></h1>
                                    <h6 class="text-white">Others</h6>
                                </div>
                            </div>
                        </div>
                        <!-- Second Row End-->
                    </div>
                    <div class="card-title">
                        <h4 class="float-left tabletitle">Today's Invoices</h4>
                        <div class="float-right">
                            <select class='tfilter'>
                                <option value="bills">Invoices</option>
                                <option value="patients">Patients</option>
                                <option value="appointments">Appointments</option>
                                <option value="prescriptions">Prescriptions</option>
                            </select>
                            <select class='dfilter'>
                                <option value="">Select An Option</option>
                                <option value="today" selected>Today</option>
                                <option value="yesterday">Yesterday</option>
                                <option value="week">This Week</option>
                                <option value="month">This Month</option>
                                <option value="year">This Year</option>
                                <option value="custom">Custom Range</option>
                            </select>
                            <div style="display: inline" class="picker">
                                <input type="text" class="start" name="start" placeholder="Select Start Date">
                                <input type="text" class="end" name="end" placeholder="Select End Date">
                                <button onclick="showdfilter()">X</button>
                            </div>
                        </div>
                    </div>
                    <br>

                    <div class="table-responsive">
                        <table id="zero_config" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Invoice Date</th>
                                <th>Patient Name</th>
                                <th>Owner name</th>
                                <th>Discount</th>
                                <th>Total</th>
                            </tr>
                            </thead>
                            <tbody id="easy_config">
                            @foreach($bills as $bill)
                                <tr>
                                    <td>{{$bill->id}}</td>
                                    <td>{{$bill->date}}</td>
                                    <td>{{$bill->patient->name}}</td>
                                    <td>{{$bill->patient->ownername}}</td>
                                    <td>{{$bill->grandtotal}}</td>
                                    <td>{{$bill->discount}}</td>
                                    <td>₹ {{$bill->nettotal}}</td>
                                </tr>
                            @endforeach
                            @php
                                if($total <> 0)
                                {
                                    echo '<tfoot><tr><td colspan=6><b>Total</b></td><td><b>₹ '.$total.'</b></td></tr></tfoot>';
                                }
                            @endphp
                        </table>
                        @php
                        echo "<h4 id='norec' style='text-align:center;";
                            if(!$bills->isEmpty()){
                                echo " display:none;";
                            }
                        echo "'>No records found</h4>";
                        @endphp
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')

    <script>
        $(document).ready(function () {
            $('.start').datepicker({
                autoclose: true,
                format: 'yyyy-mm-dd',
            });
            $('.end').datepicker({
                autoclose: true,
                format: 'yyyy-mm-dd',
            });
        });
        var start = new Date();
        var end = new Date();
        start.setDate(end.getDate()-1);
        start = start.toISOString().slice(0,10);
        end = end.toISOString().slice(0,10);
        var title2=" Invoices", title="Today's", type = 'bills', link;
            findval(start, end, title, title2, type);
        findEight(start,end);
        /*$('#zero_config').DataTable();*/
        $('.picker').hide();
        $('.dfilter').on('change', function(){
            var valu = $('.dfilter').val();
            if(valu == 'custom'){
                $('.picker').show();
                $('.dfilter').hide();
            }
            start = new Date();
            end = new Date();
            switch (valu) {
                case 'today':
                    start.setDate(end.getDate()-1);
                    title = "Today's";
                    break;
                case 'yesterday':
                    start.setDate( end.getDate() - 2 );
                    end.setDate(end.getDate() - 1)
                    title = "Yesterday's";
                    break;
                case 'week':
                    start.setDate( end.getDate() - 8 );
                    title = "This week";
                    break;
                case 'month':
                    start.setDate( end.getDate() - 31 );
                    title = "This Month";
                    break;
                case 'year':
                    start.setDate( end.getDate() - 365 );
                    title = "This Year";
                    break;
            }

            start = start.toISOString().slice(0,10);
            end = end.toISOString().slice(0,10);
            //console.log(end,start);
            findval(start, end, title, title2, type);
            findEight(start, end);
        });
        $('.start').on('change', function () {
            initfindval();
        });
        $('.end').on('change', function () {
            initfindval();
        });

        $('.tfilter').on('change', function(){
            type = $('.tfilter').val();
            switch (type) {
                case 'bills':
                    title2 = " Invoices";
                    break;
                case 'patients':
                    title2 = " Patients";
                    break;
                case 'appointments':
                    title2 = " Appointments";
                    break;
                case 'prescriptions':
                    title2 = " Prescriptions";
                    break;
            }
            findval(start, end, title, title2, type);
        });

        function initfindval(){
            endi = $('.end').val();
            starti = $('.start').val();
            endi = new Date(endi);
            starti = new Date(starti);
            endi.setDate(endi.getDate()+1);
            //console.log(starti);
            title = 'Custom Range';
            if(starti != 'Invalid Date' && endi != 'Invalid Date'){
                start = starti.toISOString().slice(0,10);
                end = endi.toISOString().slice(0,10);
                //console.log(endi);
                findval(start, end, title, title2, type);
                findEight(start,end);
            }
        }
        function findval(start,end,title,title2, type){
            var url = '/reports?start=' + start + '&end=' + end + '&type=' + type;
            $(document).ajaxStart(function(){
                $(".preloader").show();
            }).ajaxStop(function(){
                $(".preloader").fadeOut();
            });
            $.ajax({
                method: 'GET',
                url: url,
                success: function (res) {
                    var array = JSON.parse(res);
                    $('thead').empty();
                    $('#norec').hide();
                    $('tbody').empty();
                    $('.tabletitle').text(title+title2);
                    switch (type) {
                        case 'bills':
                            var head = '<tr><th>ID</th><th>Invoice Date</th><th>Patient Name</th><th>Owner name</th><th>Grand Total</th><th>Discount</th><th>Net Total</th></tr>';
                            var total = 0;
                            $.each(array, function (i, d) {
                                total = d.tot;
                                var row = $('<tr/>');
                                row.append($('<td/>',{
                                    text: d.id,
                                })).append($('<td/>',{
                                    text: moment(d.date).format('MM-DD-YYYY'),
                                })).append($('<td/>',{
                                    text: d.pat.name,
                                })).append($('<td/>',{
                                    text: d.pat.ownername,
                                })).append($('<td/>',{
                                    text: d.grandtotal,
                                })).append($('<td/>',{
                                    text: d.discount,
                                })).append($('<td/>',{
                                    text: '₹ ' + d.nettotal,
                                }));
                                $('tbody').append(row);
                                $('.total').text(d.tot);
                            });
                            break;
                        case 'patients':
                            var head = "<tr><th>ID</th><th>Name</th><th>Species</th><th>Age</th><th>Breed</th><th>Owner's Name</th><th>Actions</th></tr>";
                            $.each(array, function (i, d) {
                                //console.log(array);
                                //options = { day: 'numeric' ,month: 'numeric', year: 'numeric'};
                                var age = new Date(d.age).toLocaleDateString("en-IN");
                                //console.log(age);
                                var row = $('<tr/>');
                                var link = d.id ? '/patients/'+d.id : '';
                                row.append($('<td/>',{
                                    text: d.id ? d.id : '',
                                })).append($('<td/>',{
                                    text: d.name ? d.name : '',
                                })).append($('<td/>',{
                                    text: d.species ? d.species.name : '',
                                })).append($('<td/>',{
                                    text: d.age ? age : '',
                                })).append($('<td/>',{
                                    text: d.breed ? d.breed : '',
                                })).append($('<td/>',{
                                    text: d.ownername ? d.ownername : '',
                                })).append($('<td/>',{
                                    html: "<a class='btn btn-info btn-sm' href=" + link + ">View</a>",
                                }));
                                $('tbody').append(row);
                            });
                            break;
                        case 'appointments':
                            var head = '<tr><th>ID</th><th>Patient Name</th><th>Owner name</th><th>Doctor Name</th><th>Date</th></tr>';
                            $.each(array, function (i, d) {
                                var row = $('<tr/>');
                                var link = '/appointments/' + d.id;
                                row.append($('<td/>',{
                                    text: d.id,
                                })).append($('<td/>',{
                                    text: d.pat.name,
                                })).append($('<td/>',{
                                    text: d.pat.ownername,
                                })).append($('<td/>',{
                                    text: d.doc.name,
                                })).append($('<td/>',{
                                    text: moment(d.date).format('MM-DD-YYYY'),
                                }));
                                $('tbody').append(row);
                            });
                            break;
                        case 'prescriptions':
                            console.log('pres');
                            var head = '<tr><th>ID</th><th>Appointment Date</th><th>Patient Name</th><th>Owner name</th><th>Doctor Name</th><th>Actions</th></tr>';
                            $.each(array, function (i, d) {
                                var row = $('<tr/>');
                                var link = '/prescriptions/' + d.id;
                                row.append($('<td/>',{
                                    text: d.id,
                                })).append($('<td/>',{
                                    text: moment(d.app.date).format('MM-DD-YYYY'),
                                })).append($('<td/>',{
                                    text: d.pat.name,
                                })).append($('<td/>',{
                                    text: d.pat.ownername,
                                })).append($('<td/>',{
                                    text: d.doc.name,
                                })).append($('<td/>',{
                                    html: "<a class='btn btn-info btn-sm' href=" + link + ">View</a>",
                                }));
                                $('tbody').append(row);
                            });
                            break;
                    }
                    $('thead').append(head);
                    /*$('#easy_config').DataTable();*/
                    if(array == ''){
                        $('#norec').show();
                    } else {
                        if(type == 'bills'){
                            var row = $('<tr/>',{
                            }).append($('<td/>',{
                                text: 'Total',
                                colspan: 6,
                                style: ['text-align:center; font-weight:700;']
                            })).append($('<td/>',{
                                text: '₹ ' + total,
                                style: ['font-weight:700; text-align:right;'],
                            }));
                            $('tbody').append(row);
                        }
                    }
                }
            });
        }
        function showdfilter() {
            $('.picker').hide();
            $('.dfilter').show();
            $('.dfilter').val('');
        }
        function findEight() {
            var url = '/eightreports?start=' + start + '&end=' + end;
            $.ajax({
                method: 'GET',
                url: url,
                success: function (t) {
                    r = JSON.parse(t);
                    $('.ctotal').text(r[0].total);
                    $('.capps').text(r[0].apps);
                    $('.ccases').text(r[0].cases);
                    $('.cinvoice').text(r[0].bills);
                    $('.cin').text(r[0].in);
                    $('.cout').text(r[0].out);
                    $('.cboarding').text(r[0].on);
                    $('.cothers').text(r[0].other);
                    console.log(t);
                }
            });
        }

    </script>
@endsection