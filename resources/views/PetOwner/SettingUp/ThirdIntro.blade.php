@extends("petownertempmain")
@section("header")
Welcome Pet Owner!
@endsection
@push('css')
<link href="{{url('css/secondintro.css')}}" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.2/css/jquery.dataTables.min.css">     
@endpush
@section("content")
 <div class="row">
        <!-- Dashboard Content -->
        <div class="col-xl col-lg-3">
            <div class="card shadow mb-4">
                <!-- Dashboard header -->
                <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    @if($cat == "Cat")
                    <h5>What cat breeds do you want to be adopted?</h5>
                    <div>
                    <button class="btn btn-danger" data-toggle="modal" data-target="#AddCatBreedModal" style="float:right">Add Breed +</button> 
                    </div>                         
                    @elseif($dog == "Dog")
                    <h5>What dog breeds do you want to be adopted?</h5>
                    <div>
                    <button class="btn btn-danger" data-toggle="modal" data-target="#AddDogBreedModal" style="float:right">Add Breed +</button> 
                    </div>  
                    @elseif($both == "Both")
                    <h5>What cat and dog breeds do you want to be adopted?</h5>
                    <div>
                    <button style=" margin-right:5px" class="btn btn-danger" data-toggle="modal" data-target="#AddDogBreedModal1">Add Dog Breed +</button>
                    <button class="btn btn-danger" data-toggle="modal" data-target="#AddCatBreedModal1">Add Cat Breed +</button> 
                    </div>
                    @endif
                </div>
            </div>  
        </div>
    </div>
@if($dog)
@include('PetOwner.SettingUp.DogBreed')
@include('PetOwner.Pop.AddDog')
@elseif($cat)
@include('PetOwner.SettingUp.CatBreed')
@include('PetOwner.Pop.AddCat')
@elseif($both)
@include('PetOwner.SettingUp.Bothbreed')
@include('PetOwner.Pop.AddBoth')
@endif
@endsection
@push('js')
<script src="https://cdn.datatables.net/1.11.2/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
    $('#datatable').DataTable({searching: false, paging: false, info: false});
    var table = $('#datatable').DataTable();
    table.on('click','#delete', function(){
        $tr =$(this).closest('tr');
        var data = table.row($tr).data();
        if($($tr).hasClass('child')) {
            $tr=$tr.prev('.parent');
        }
        var data = table.row($tr).data();
        console.log(data);

        $('#Deletebreed').modal('show');
    });
});
</script>

<script type="text/javascript">
    $(document).ready(function(){
    var table = $('#datatable').DataTable();
    table.on('click','#delete', function(){
        $tr =$(this).closest('tr');
        var data = table.row($tr).data();
        if($($tr).hasClass('child')) {
            $tr=$tr.prev('.parent');
        }
        var data = table.row($tr).data();
        console.log(data);

        $('#DeleteDogbreed').modal('show');
    });
});
</script>

<script type="text/javascript">
    $(document).ready(function(){
    $('#datatable2').DataTable({searching: false, paging: false, info: false});
    var table = $('#datatable2').DataTable();
    table.on('click','#delete', function(){
        $tr =$(this).closest('tr');
        var data = table.row($tr).data();
        if($($tr).hasClass('child')) {
            $tr=$tr.prev('.parent');
        }
        var data = table.row($tr).data();
        console.log(data);

        $('#DeleteDogbreed').modal('show');
    });
});
</script>

<script type="text/javascript">
    $(document).ready(function(){
    $('#datatable1').DataTable({searching: false, paging: false, info: false});
    var table = $('#datatable1').DataTable();
    table.on('click','#delete', function(){
        $tr =$(this).closest('tr');
        var data = table.row($tr).data();
        if($($tr).hasClass('child')) {
            $tr=$tr.prev('.parent');
        }
        var data = table.row($tr).data();
        console.log(data);

        $('#Deletebreed').modal('show');
    });
});
</script>

@endpush