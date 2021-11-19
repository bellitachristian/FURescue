@extends("PetOwner.Deactivation.deactmain")

@section("content")
 <div class="row justify-content-center">
        <!-- Dashboard Content -->
        <div class="col-xl-4 col-lg-3">
            <div class="card shadow mb-4">
                <!-- Dashboard header -->
                <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h5>Reactivation Zone</h5>
                </div>
                <!-- Content Body -->
                <div class="card-body">
                    <div class="col-sm">
                        <div>
                            <p>Click below in order to reactivate your account</p>
                        </div>
                        <hr>
                        <div>
                            <p>Wait patiently as the system is processing your request.</p>    
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div style="float:right">
                        <a href="{{route('request.reactivation.petowner',$petowner->id)}}"><button type="button" class="btn btn-success">Request reactivation</button></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection