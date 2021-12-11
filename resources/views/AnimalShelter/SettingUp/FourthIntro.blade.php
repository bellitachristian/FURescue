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
                    <h5>Adoption Fee categories:</h5> 
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
@push('js')
<script type="text/javascript">
$(document).ready(function(){
    $('input[type="checkbox"]').attr('checked', status);
});
</script>
@endpush