@extends("sheltertempmain")
@section("header")
Welcome Animal Shelter!
@endsection
@push('css')
<link href="{{url('css/secondintro.css')}}" rel="stylesheet">
@endpush
@section("content")
 <div class="row">
        <!-- Dashboard Content -->
        <div class="col-xl col-lg-3">
            <div class="card shadow mb-4">
                <!-- Dashboard header -->
                <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h5>Set Up the Animal Shelter's Adoption Fee. Select fee categories below:</h5> 
                </div>
            </div>  
        </div>
    </div>
@if($dog)
@include('AnimalShelter.SettingUp.DogFee')
@elseif($cat)
@include('AnimalShelter.SettingUp.CatFee')
@elseif($both)
@include('AnimalShelter.SettingUp.BothFee')
@endif

@endsection
