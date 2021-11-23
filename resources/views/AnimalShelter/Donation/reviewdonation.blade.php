@extends("main")
@section("header")
View Donation Proof
@endsection
@section("content")
<div class="row">
    <div class="col-sm">
        <div class="card shadow mb-4">
            <div class="card-header">
                <a href="{{route('view.donation')}}"><button type="button" class="btn btn-danger">Back</button></a>
            </div>
            <div class="card-body">
            <img src="{{asset('phpcode/donation/'.$images->donor_photo)}}" width="100%" height="600px" />
            </div>
        </div>
    </div>
</div>
@endsection