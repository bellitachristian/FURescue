@extends("petownertempmain")
@section("header")
Welcome Pet Owner!
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
                        <h5 style="color:black">Life stage of {{$both}} </h5>
                    @elseif($dog)
                        <h5 style="color:black">Life stage of a {{$dog}} </h5>
                    @elseif($cat)
                    <h5 style="color:black">Life stage of a {{$cat}} </h5>
                    @endif
                </div>
            </div>  
        </div>
    </div>
    @if($dog)
    @include('PetOwner.SettingUp.Dog')
    @elseif($cat)
    @include('PetOwner.SettingUp.Cat')
    @elseif($both)
    @include('PetOwner.SettingUp.Both')
    @endif

@endsection
@push('js')
<script>
    $(document).ready(function(){
    $('input[type="checkbox"]').attr('checked', status);
});
</script>
@endpush