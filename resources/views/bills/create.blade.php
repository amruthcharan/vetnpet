@extends('layouts.main')
@section('title')
    <title>Vet N Pet - Billing</title>
@endsection
@section('breadcrum')
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">New Invoice</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Invoice</li>
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
        <div class="col-lg-4 col-md-12 appdet" style="margin: 0 auto">
            <div class="card sticky-top">
                <div class="card-body">
                    <table class="table table-hover">
                        <tbody>
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
                            <td class="text-left">Species</td>
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
                            <td class="text-left">Health Package</td>
                            <td>:</td>
                            <td class="package"></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-8 col-md-12"  style="margin: 0 auto">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title" style="text-align: center">New Invoice</h4>
                    @include('includes.formerror')
                    {!! Form::open(['method'=>'POST', 'action' => 'BillingController@store']) !!}
                        <div class="form-group">
                            {!! Form::label('patient_id', '* Patient ID:') !!}
                            {!! Form::select('patient_id', $patients , app('request')->input('patid') ? app('request')->input('patid') : null , ['class'=>'form-control patid select22']) !!}
                        </div>
                        <div>
                            <h4 class="float-lg-left">Health Package:&nbsp;</h4>
                            <span class="package"></span>
                        </div>
                        <br>
                        <div class="form-group">
                            {!! Form::label('type', '* Patient Type:') !!}
                            {!! Form::select('type', ['outpatient'=>'Out Patient', 'inpatient'=>'In Patient','boarding'=>'Boarding', 'others'=>'Others'] , null , ['class'=>'form-control']) !!}
                        </div>

                        <div id="component">
                            <h3 class="float-left">Components</h3>
                            <a onclick="addcomponent()" class="btn btn-primary float-right"><i class="fa fa-plus"></i></a>
                            <br>
                            <br>
                        </div>
                        <div class="form-group">
                            {!! Form::label('discount', 'Discount:') !!}
                            {!! Form::text('discount',null,['class'=>'form-control discount']) !!}
                        </div>

                        <div class="form-group">
                            {!! Form::label('mode', 'Payment Mode:') !!}
                            {!! Form::text('mode', null, ['class'=>'form-control']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('nettotal', 'Total:') !!}
                            {!! Form::text('nettotal',null,['class'=>'form-control total', 'readonly'=>'readonly']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::text('grandtotal',null,['class'=>'form-control grandtotal', 'hidden'=>'hidden']) !!}
                        </div>

                        @php
                            $t=date('Y-m-d');
                        @endphp
                        <div class="form-group">
                            {!! Form::label('date', 'Date:') !!}
                            {!! Form::date('date', $t, ['class'=>'form-control', 'readonly'=>'readonly']) !!}
                        </div>

                        <div class="border-top">
                            <div class="card-body">
                                {!! Form::submit('Generate Invoice', ['class'=>'btn btn-primary btn-block genbill']) !!}
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

    <!-- Modal  -->
    <div class="modal fade none-border" id="pkgmodal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Package</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <td>Package Name</td>
                    <td>:</td>
                    <td>
                        <select name="pkgid" id="pkgid" class="form-control">
                            @foreach($packages as $p)
                                <option value="{{$p->id}}">{{$p->name}}</option>
                            @endforeach
                        </select>
                        <br>
                        <button class="btn btn-secondary btn-block" onclick="addPkg();">Add Package</button>
                    </td>
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
            total = 0;
            displayTotal(total);
        });
        var dumpVal = 0;
        var tot = parseInt($('.grandtotal').val());
        tot = returnZeroIfNothing(tot);

        function addcomponent() {
            $('#component').append("<div class=\"row align-items-center\"><div class=\"col-md-5\"><div class=\"form-group\"><label for=\"component\">Component:</label><input type='text' name='component[]' class=\"form-control\"></div></div><div class=\"col-md-5\"><div class=\"form-group\"><label for=\"amount\">Amount:</label><input type=\"number\" name='amount[]' class=\"form-control billing\"></div></div><div class=\"col-md-1\"><a class='btn btn-warning remove'><i class='fa fa-minus'></i></a></div></div>");
        }

        $(document).on('click', '.remove', function (){
            var deletedNumber = $(this).closest('.row').find("input[name='amount[]']").val();
            deletedNumber = parseInt(deletedNumber);
            deletedNumber = returnZeroIfNothing(deletedNumber);
            tot -= deletedNumber;
            $('.grandtotal').val(tot);
            total = calcTotalAfterDiscount(tot);
            displayTotal(total);
            $(this).closest('.row').remove();
        });
        $(document).on('click', '.genbill', function(){
            $(".preloader").show();
        });

        //return '0' if no value in the field.
        function returnZeroIfNothing(value){
            var res = "";
            res = res + Number.isInteger(value);
            if (res == 'false'){
                value = 0;
            }
            return value;
        }

        function findDiscount() {
            //find discount
            var discount = parseInt($(".discount").val());

            //check weather discount presented or not!
            discount = returnZeroIfNothing(discount);
            return discount;
        }
        function findDiscountType() {
            //determine the discount type
            var n = $('.discount').val().toString().search('%');
            return n;
        }

        $(document).on('change ', '.billing', function (){
            $(this).addClass('bill2');
            var currentValue = parseInt($(".bill2").val());
            var previousValue = findPreviousValue();

            tot -= previousValue;
            tot += currentValue;
            $('.grandtotal').val(tot);
            $(this).removeClass('bill2');
            total = calcTotalAfterDiscount(tot);
            displayTotal(total);
        });

        $(document).on('focus', '.billing', function () {
            $(this).addClass('biller');
            //find any value presented
            dumpVal = parseInt($(".biller").val());
            dumpVal = returnZeroIfNothing(dumpVal);
            $(this).removeClass('biller');
        });

        function findPreviousValue() {
            var previousVal = dumpVal;
            dumpVal = 0;
            return previousVal;
        }

        function calcTotalAfterDiscount(total) {
            var discount = findDiscount();
            var n = findDiscountType();
            if(n>0){
                total = total - (total * (discount / 100));
            } else {
                total = total - discount;
            }
            return total;
        }

        function displayTotal(total) {
            $('.total').val(total);
        }

        $(document).on('change', '.discount', function () {
            total = calcTotalAfterDiscount(tot);
            displayTotal(total);
        });

        $(document).ready(function() {
            $('.select22').select2({
                placeholder: {
                    id: '0', // the value of the option
                    text: 'Select Patient'
                }
            });
        });

        $('.patid').on('change', function () {
            /*$('#pres').hide();
            $('#pres').html("<h4 class='float-left'>Previous Records</h4>");*/
            getpd();
        });
        if($('.patid')){
            getpd();
        }
        function getpd() {
            $('.appdet').hide();
            var token = '{{ Session::token() }}';
            var id = parseInt($('.patid').val());
            var url = '/getpd' ;
            $.ajax({
                method: 'POST',
                url: url,
                data:{id : id, _token : token},
                success: function (res) {
                    $('.ownername').text(res.name);
                    $('.name').text(res.ownername);
                    $('.species').text(res.species);
                    $('.age').text(res.age);
                    $('.breed').text(res.breed);
                    package = isExpired(res.package);
                    $('.package').html(res.package ? "<span style='color:" + package+"'><b>"+res.package.package.name+" Package</b> Expires on " + moment(Date.parse(res.package.expiry)).format('DD-MMM-YYYY')+"</span>": "<span>No package found!</span> <a class='btn btn-xs btn-outline-secondary' onclick='openModal();'>Add Package</a>");
                    $('.appdet').show();
                }
            });
        }

        function isExpired(p) {
            if(p != null){
                e = moment(p.expiry);
                color = e>moment() ? 'green' : 'red';
                return color;
            } else {
                return false;
            }
        }
        function openModal() {
            $('#pkgmodal').modal();
        }

        function addPkg() {
            ptid = $('.patid').val();
            pkgid = $('#pkgid').val();
            var url = '/addpkg' ;
            var token = '{{ Session::token() }}';
            $.ajax({
                method: 'POST',
                url: url,
                data: {package_id: pkgid, patient_id: ptid, _token: token},
                success: function (res) {
                    console.log(res);
                    $('.package').html(res ? "<span style='color:green'><b>"+res.package.name+" Package</b> Expires on " + moment(Date.parse(res.expiry)).format('DD-MMM-YYYY')+"</span>": "<span>No package found!</span> <a class='btn btn-xs btn-outline-secondary' onclick='openModal();'>Add Package</a>");
                }
            });
            $('#pkgmodal').modal('hide');
        }

    </script>

@endsection