@extends("Admin.main")
@section("header")
View Proof of Payment
@endsection

@section("content")
<div class="card shadow mb-4">
    <div class="card-header">
        <a href="{{route('view.proof.payment')}}"><button class="btn btn-secondary" type="button">Back</button></a>
    </div>
    <div class="card-body">
        @foreach($proof as $photo)
            <div style="text-align:center">
            @if($photo->shelter)
            <img src="{{asset('uploads/animal-shelter/uploaded-photos/'.$photo->imagename)}}" width="70%" height="650px" />
            @elseif($photo->petowner)
            <img src="{{asset('uploads/pet-owner/uploaded-photos/'.$photo->imagename)}}" width="70%" height="650px" />
            @endif
            </div>
        @endforeach
    </div>
</div>
@endsection

