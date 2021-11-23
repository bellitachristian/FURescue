@extends("main")
@section("header")
View Adopter Credentials
@endsection
@section("content")
<div class="row">
    <div class="col-sm">
        <div class="card shadow mb-4">
            <div class="card-header">
                <a href="{{route('adoption.request.shelter')}}"><button type="button" class="btn btn-danger">Back</button></a>
            </div>
            <div class="card-body">
            <img src="{{asset('phpcode/validid/'.$images->validId)}}" width="100%" height="600px" />
            </div>
        </div>
    </div>
</div>
@endsection