@extends("sheltertempmain")

@section("content")
<div  class="row ">
    <div class="col-sm-3">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                        <a style="color:#42ba96"><h5 style="font-weight:bold;">Chances Remaining</h5></div></a> 
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{$shelter->grace}}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-paw fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
 <div class="row justify-content-center">
        <!-- Dashboard Content -->
        <div class="col-xl-6 col-lg-7">
            <div class="card shadow mb-4">
                <!-- Dashboard header -->
                <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h5>Rechecking of Valid Documents</h5>
                </div>
                <!-- Content Body -->
                <div class="card-body">
                    <div class="chart-area">
                        <div>
                            <p>As of this moment, Admins are checking your shelter credentials for security and authentication measures. A notification will pop up once they are done checking your valid documents.</p>
                            <p>Your patience is highly appreciated :) </p>
                        </div>
                        <hr>
                        <div>
                            <p>Note! If Admins have rejected your valid documents, that means your credentials being sent are not valid you can try uploading your files again.</p>
                            <br>
                            <p>Yours truly,</p> 
                            <p>furescue team</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if($check == 0)
    <div class="row" style="float:right;margin-right:25%">
        <a href="{{route('view.wait')}}"><button style="padding:10px" class="btn btn-danger">Upload Valid Documents</button></a>
    </div>
    @endif
@endsection