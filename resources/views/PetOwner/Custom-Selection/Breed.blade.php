@extends("mainpetowner")
@section("header")
Breed
@endsection
@push('css')
<link href="{{url('css/secondintro.css')}}" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.2/css/jquery.dataTables.min.css">   
@endpush
@section('content')
<div class="row">
    <div class="col-sm">
        <div class="card shadow mb-4">
            <div class="card-header">
                @if($catcheck > 0 && $dogcheck == 0)
                    <div>
                    <button class="btn btn-success" data-toggle="modal" data-target="#AddCatBreedModal">Add Cat Breed +</button> 
                    </div>                         
                    @elseif($dogcheck > 0 && $catcheck == 0)
                    <div>
                    <button class="btn btn-success" data-toggle="modal" data-target="#AddDogBreedModal">Add Dog Breed +</button> 
                    </div>  
                    @elseif($dogcheck > 0 && $catcheck > 0)
                    <div>
                    <button style=" margin-right:10px" class="btn btn-success" data-toggle="modal" data-target="#AddCatBreedModal">Add Cat Breed +</button> 
                    <button class="btn btn-success" data-toggle="modal" data-target="#AddDogBreedModal">Add Dog Breed +</button>
                    </div>
                    @endif
            </div>
            <div class="card-body">
                <main style ="margin-top:30px; display:flex" class="grid-new" >
                    @if($dogcheck > 0 && $catcheck == 0)
                    <label class="option-items">
                        <table id="datatable1" class="table table-light table-hover">
                            <thead>
                                <tr>
                                    <th hidden>ID</th>
                                    <th>Breed Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>    
                            <tbody>
                                @foreach($breed1 as $breeds)
                                <tr>
                                    <td hidden>{{$breeds->id}}</td>
                                    <td>{{$breeds->breed_name}}</td>
                                    <td>
                                        <a href="#" id="delete"><i class="fas fa-trash-alt"title="Delete">&#xE872;</i></a>
                                    </td>
                                </tr>
                                @endforeach
                                @if(empty($breeds))
                                    <h6 style="font-weight:bold" class="alert alert-secondary">"No other breeds being added"</h6>
                                @endif
                            </tbody>
                        </table>  
                    </label>  
                    @endif()
                    @if($catcheck > 0 && $dogcheck == 0)
                    <label class="option-items">
                        <table id="datatable" class="table table-light table-hover">
                            <thead>
                                <tr>
                                    <th hidden>ID</th>
                                    <th>Breed Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>    
                            <tbody>
                                @foreach($breed as $cats)
                                <tr>
                                    <td hidden>{{$cats->id}}</td>
                                    <td>{{$cats->breed_name}}</td>
                                    <td>
                                        <a href="#" id="delete1"><i class="fas fa-trash-alt"title="Delete">&#xE872;</i></a>
                                    </td>
                                </tr>
                                @endforeach
                                @if(empty($cats))
                                    <h6 style="font-weight:bold" class="alert alert-secondary">"No other breeds being added"</h6>
                                @endif
                            </tbody>
                        </table>  
                    </label>  
                    @endif()
                    @if($catcheck > 0 && $dogcheck > 0)
                    <label class="option-items">
                        <table id="datatable" class="table table-light table-hover">
                            <thead>
                                <tr>
                                    <th hidden>ID</th>
                                    <th>Cat Breed Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>    
                            <tbody>
                                @foreach($breed as $cats)
                                <tr>
                                    <td hidden>{{$cats->id}}</td>
                                    <td>{{$cats->breed_name}}</td>
                                    <td>
                                        <a href="#" id="delete1"><i class="fas fa-trash-alt"title="Delete">&#xE872;</i></a>
                                    </td>
                                </tr>
                                @endforeach
                                @if(empty($cats))
                                    <h6 style="font-weight:bold" class="alert alert-secondary">"No other breeds being added"</h6>
                                @endif
                            </tbody>
                        </table>  
                    </label>  
                    <label class="option-items">
                        <table id="datatable1" class="table table-light table-hover">
                            <thead>
                                <tr>
                                    <th hidden>ID</th>
                                    <th>Dog Breed Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>    
                            <tbody>
                                @foreach($breed1 as $breeds)
                                <tr>
                                    <td hidden>{{$breeds->id}}</td>
                                    <td>{{$breeds->breed_name}}</td>
                                    <td>
                                        <a href="#" id="delete"><i class="fas fa-trash-alt"title="Delete">&#xE872;</i></a>
                                    </td>
                                </tr>
                                @endforeach
                                @if(empty($breeds))
                                    <h6 style="font-weight:bold" class="alert alert-secondary">"No other breeds being added"</h6>
                                @endif
                            </tbody>
                        </table>  
                    </label>  
                    @endif()
                </main>
            </div>
            <div class="card-footer">
            <a href="{{route('selection.view.petowner')}}"><button type="button" class="btn btn-danger">Back</button></a>
            </div>
        </div>
    </div>
</div>
@if($catcheck > 0 && $dogcheck == 0)
@include('PetOwner.Custom-Selection.Modal.Add_catbreed')
@elseif($dogcheck > 0 && $catcheck == 0)
@include('PetOwner.Custom-Selection.Modal.Add_dogbreed')
@elseif($catcheck > 0 && $dogcheck > 0)
@include('PetOwner.Custom-Selection.Modal.Add_catbreed')
@include('PetOwner.Custom-Selection.Modal.Add_dogbreed')
@endif
@endsection
@push('js')
<script src="https://cdn.datatables.net/1.11.2/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    var table = $('#datatable').DataTable();
    table.on('click','#delete1', function(){
        $tr =$(this).closest('tr');
        var data = table.row($tr).data();
        if($($tr).hasClass('child')) {
            $tr=$tr.prev('.parent');
        }
        var data = table.row($tr).data();
        console.log(data);
        $('#deleteform').attr('action','/customselection/deletecat_breed/petowner/'+data[0]);
        $('#DeleteCatbreed').modal('show'); 
    });
    
});
$(document).ready(function(){
    var table = $('#datatable1').DataTable();
    table.on('click','#delete', function(){
        $tr =$(this).closest('tr');
        var data = table.row($tr).data();
        if($($tr).hasClass('child')) {
            $tr=$tr.prev('.parent');
        }
        var data = table.row($tr).data(); 
        console.log(data);
        $('#deleteform1').attr('action','/customselection/deletedog_breed/petowner/'+data[0]);
        $('#DeleteDogbreed').modal('show');
    });
});
</script>

@endpush