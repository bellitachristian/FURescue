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
        <div class="col-xl-4 col-lg-7">
            <div class="card shadow mb-4">
                <!-- Dashboard header -->
                <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    @if($both)
                        <h5 style="color:black">What life stage of {{$both}} pets do you cater?</h5>
                    @elseif($dog)
                        <h5 style="color:black">What life stage of a {{$dog}} do you cater?</h5>
                    @elseif($cat)
                    <h5 style="color:black">What life stage of a {{$cat}} do you cater?</h5>
                    @endif
                </div>
            </div>  
        </div>
    </div>
    @if($dog)
    @include('AnimalShelter.SettingUp.Dog')
    @elseif($cat)
    @include('AnimalShelter.SettingUp.Cat')
    @elseif($both)
    @include('AnimalShelter.SettingUp.Both')
    @endif

@endsection