@extends('layouts.print')
@section('title')
    <title>Vet N Pet - Invoice</title>
@endsection
@section('breadcrum')
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">View Invoice</h4>
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
    <div class="row" id="printid">
        <div class="col-md-12">
            <div class="card card-body printableArea">
                <h3><b>Invoice #</b> <span class="pull-right">{{$bill->id}}</span></h3>
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <div class="float-left">
                            <address>
                                <img src="{{asset('assets/images/vnplogo.jpg')}}" width="120px">
                                <p class="m-l-5" style="font-size:16px;">Plot No 369/1,
                                    <br/> Phase 3, Film Nagar
                                    <br/> Jubilee Hills
                                    <br/> Hyderabad - 500096</p>
                            </address>
                        </div>
                        <div class="float-right text-right">
                            <p style="font-size:16px;"><b>Invoice Date :</b> <i class="fa fa-calendar"></i> {{$bill->created_at}}</p>
                            <address>
                                <h4>Invoice is For,</h4>
                                <p class="m-l-30" style="font-size:16px;"><b>Name</b> - {{$bill->patient->name}}
                                    <br/> {{$bill->patient->address}},
                                    <br/> <b>Breed</b> - {{$bill->patient->breed}},
                                    <br/> <b>Invoice Prepared by {{$bill->created_by}}</b>.
                                </p>
                                @if($package)
                                    <p style="font-weight: bold; color:{{$package->expiry > \Carbon\Carbon::today() ? 'green' : 'red'}}">{{$package->package->name}} Package {{$package->expiry > \Carbon\Carbon::today() ? 'is Active' : 'Expired'}}</p>
                                @endif
                            </address>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <h4 class="m-t-20">Medicines List:</h4>
                        <div class="table-responsive" style="clear: both;" style="font-size:16px;">
                            <table class="table table-hover" style="font-size:16px;">
                                <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Particulars</th>
                                    <th class="text-right">Amount</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php
                                    $i = 1;
                                @endphp
                                @foreach($bill->billcomponents as $d)
                                    <tr>
                                        <td class="text-center">{{$i}}</td>
                                        <td>{{$d->name}}</td>
                                        <td class="text-right">
                                            {{$d->amount}}
                                        </td>
                                    </tr>
                                    @php
                                        $i++
                                    @endphp
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-12" style="font-size:13px;">
                        <div class="pull-right m-t-30 text-right">
                            <p>Sub - Total amount: ₹ {{$bill->grandtotal}}</p>
                            @php
                                if(strchr($bill->discount,"%") == ""){
                                    $ret = '₹ ' . $bill->discount;
                                } else {
                                    $ret = $bill->discount;
                                }
                            @endphp
                            <p>discount : {{$ret}}</p>
                            <p>Payment Mode : {{$bill->mode}}</p>
                            <hr>
                            <h3><b>Total :</b> ₹ {{$bill->nettotal}}</h3>
                        </div>
                        <div class="clearfix"></div>
                        <hr>
                        <div class="text-center">
                            <buttton class="btn btnpr btn-info" onclick="printit()"> Print Prescription </buttton>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        function printit() {
            $('.btnpr').hide();
            window.print();
            window.close();
        }
    </script>
@endsection