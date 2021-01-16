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
                <h4 class="page-title">Edit Invoice</h4>
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
        <div class="col-md-9"  style="margin: 0 auto">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title" style="text-align: center">Edit Invoice</h4>
                    @include('includes.formerror')
                    {!! Form::open(['method'=>'PATCH', 'action' => ['BillingController@update',$bill->id]]) !!}
                    <div class="form-group">
                        {!! Form::label('patient_id', '* Patient ID:') !!}
                        {!! Form::text('patient_id' , $bill->patient_id , ['class'=>'form-control patid', 'readonly'=>'readonly']) !!}
                    </div>
                    <div>
                        <h4 class="float-lg-left">Health Package:&nbsp;</h4>
                        <span class="package">
                            @if($package)
                                @php
                                $color = $package->expiry > \Carbon\Carbon::today() ? 'green' : 'red';
                                $date = $package->expiry > \Carbon\Carbon::today() ? "expires on " . $package->expiry->format('d-m-Y'): "expired on " . $package->expiry->format('d-m-Y');
                                @endphp
                                <span class="package" style="color:{{$color}}"><b>{{$package->package->name . " Package - ". $date}}</b></span>
                            @else
                                No Package Found!
                                <a class="btn btn-outline-secondary btn-xs" onclick="openModal();">Add Package</a>
                            @endif
                        </span>
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
                        @foreach($bill->billcomponents as $d)
                            <div class="row align-items-center">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="component">Component:</label>
                                        <input type='text' name='component[]' value="{{$d->name}}" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="amount">Amount:</label>
                                        <input type="number" name='amount[]' value="{{$d->amount}}" class="form-control bill billing">
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <a class='btn btn-warning remove'>
                                        <i class='fa fa-minus'></i>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="form-group">
                        {!! Form::label('discount', 'Discount:') !!}
                        {!! Form::text('discount',$bill->discount,['class'=>'form-control discount']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('mode', 'Payment Mode:') !!}
                        {!! Form::text('mode', $bill->mode, ['class'=>'form-control']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('total', 'Total:') !!}
                        {!! Form::text('nettotal',$bill->nettotal,['class'=>'form-control total', 'readonly'=>'readonly']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::text('grandtotal',$bill->grandtotal,['class'=>'form-control grandtotal', 'hidden'=>'hidden']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('date', 'Date:') !!}
                        {!! Form::date('date', $bill->date, ['class'=>'form-control', 'readonly'=>'readonly']) !!}
                    </div>
                    <div class="border-top">
                        <div class="card-body">
                            {!! Form::submit('Update Invoice', ['class'=>'btn btn-primary btn-block']) !!}
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

        function openModal() {
            $('#pkgmodal').modal();
        }
    </script>

@endsection