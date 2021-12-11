@extends("petownertempmain")

@section("content")
 <div class="row justify-content-center">
        <!-- Dashboard Content -->
        <div class="col-xl-6 col-lg-7">
            <div class="card shadow mb-4">
                <!-- Dashboard header -->
                <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h5>Checking of Credentials</h5>
                </div>
                <!-- Content Body -->
                <div class="card-body">
                    <div class="chart-area">
                        <div>
                            <p>As of this moment, Admins are checking your credentials for security and authentication measures. A notification will pop up once they are done checking your valid documents.</p>
                            <p>Your patience is highly appreciated :) </p>
                        </div>
                        <hr>
                        <div>
                            <p>Note! If Admins have rejected the valid documents, that means your credentials being sent are not valid, you have 3 chances to re-upload your files again</p>
                            <p>Once you have used all your chances the system will automatically remove your account.</p>
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
        <a href="{{route('view.wait.petowner')}}"><button style="padding:10px" class="btn btn-danger">Upload Valid Documents</button></a>
    </div>
    @endif
@endsection