@extends("Admin.main")
@section("header")
Dashboard
@endsection
@section("content")
<!-- Begin Page Content -->
<div class="row">

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            <a href=""><h5 style="font-weight:bold">Registered Shelters</h5></a></div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{$countshelter}}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-home fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-success shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                    <a href="" style="color:#5cb85c"><h5 style="font-weight:bold">Registered Pet Owners</h5></a></div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{$countpetowner}}</div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-paw fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-info shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                        <a href=""style="color:#5bc0de"><h5 style="font-weight:bold">Registered Adopters</h5></a>
                    </div>
                    <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{$countadopter}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-users fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>


    <!-- Pending Requests Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-warning shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                    <a href=""style="color:#f0ad4e"><h5 style="font-weight:bold">Total Revenue</h5></a></div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">PHP {{$revenue}}</div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-money-bill-wave-alt fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

@endsection

