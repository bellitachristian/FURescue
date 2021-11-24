@extends("Admin.main")
@section("header")
View Adoption payment credentials
@endsection
@section("content")
<div class="row">
    <div class="col-sm">
        <div class="card shadow mb-4">
            <div class="card-header">
                <a href="{{route('adoption.payment')}}"><button type="button" class="btn btn-danger">Back</button></a>
            </div>
            <div class="card-body">
            <img src="{{asset('phpcode/payment/'.$images->proof)}}" width="100%" height="600px" />
            </div>
        </div>
    </div>
</div>
@endsection