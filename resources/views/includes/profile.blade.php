<!-- ============================================================== -->
<!-- User profile and search -->
<!-- ============================================================== -->
<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark pro-pic" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="{{Auth::user()->photo ? Auth::user()->photo->file: 'https://placehold.it/50x50'}}" alt="user" class="rounded-circle" width="31" height="31"></a>
    <div class="dropdown-menu dropdown-menu-right user-dd animated">
        <a class="dropdown-item" href="#"><i class="ti-user m-r-5 m-l-5"></i><strong> {{Auth::user() ? Auth::user()->name: ""}}</strong></a>
        {{--<a class="dropdown-item" href="javascript:void(0)"><i class="ti-wallet m-r-5 m-l-5"></i> My Balance</a>
        <a class="dropdown-item" href="javascript:void(0)"><i class="ti-email m-r-5 m-l-5"></i> Notifications</a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="javascript:void(0)"><i class="ti-settings m-r-5 m-l-5"></i> Account Setting</a>
        <div class="dropdown-divider"></div>--}}
        <a class="btn btn-dark btn-block" href="{{url('/logout')}}"><i class="fa fa-power-off m-r-5 m-l-5"></i> Logout</a>
        {{--<div class="dropdown-divider"></div>
        <div class="p-l-30 p-10"><a href="javascript:void(0)" class="btn btn-sm btn-success btn-rounded">View Profile</a></div>--}}
    </div>
</li>
<!-- ============================================================== -->
<!-- User profile and search -->
<!-- ============================================================== -->