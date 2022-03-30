@extends("mainpetowner")
@section("header")
Adoption Policy
@endsection
@push("css")
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.2/css/jquery.dataTables.min.css">   
@endpush
@section("content")
<div class="row">
    <div class="col-md">
            <div class="card shadow mb-4">
                <!-- Policy header -->
                <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">

                    <div>
                    <button class="btn btn-danger" data-toggle="modal" data-target="#AddPolicy" >Add Adoption Policy +</button>
                    </div>
                    <div>
                        <a href="{{route('view_archived_policy.petowner')}}"><button class="btn btn-danger">View Archived Policy</button></a>
                    </div>
                </div>
    <!-- Policy Content -->
    <div class="card-body">
        <table id="datatable" class="table table-light table-hover">
            <thead>
                <tr>
                    <th> ID</th>
                    <th>Policy Content</th>
                    <th style="text-align:center">Action</th>
                </tr>
            </thead>
            <tbody>
            @foreach($policy as $pol)
                <tr>
                    <td>{{$pol->id}}</td>
                    <td>{{$pol->policy_content}}</td>
                    <td style="text-align:center">
                        <a href="#" id="edit"><i class="fas fa-edit" data-toggle="tooltip" title="Edit">&#xE254;</i></a>
                        <a href="#" id="delete"><i class="fas fa-trash-alt" data-toggle="tooltip" title="Move to Archive">&#xE872;</i></a>
                    </td>
                </tr> 
            @endforeach
            @if(empty($policy))   
                <h6 class="alert alert-danger">No data exist for adoption policy! Add Adoption Policy +</h6>
            @endif
            </tbody>
        </table>
</div>
<!-- Add Policy Modal -->
<div class="modal fade"  id="AddPolicy" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Adoption Policy +</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
            <form action="{{route('add.policy')}}"  method="POST">
                @csrf
                <div class="modal-body" id="response"> 
                    <div class="form-group row">
                        <div class="col-md"> 
                            <label class="text-sm">Policy Content</label>
                            <textarea class="form-control" placeholder="This is where you put policies and guidelines for adopters before they will adopt an animal." name="policy_content" rows="5" id="policy_content" required value ="{{old('policy_content')}}"></textarea>
                        </div>
                     </div>
                    
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-danger" id="btn" type="submit">Save</button>
                </div>    
            </form>
        </div>
    </div>  
</div>
    <!-- Delete Policy Modal -->
<div class="modal fade"  id="DeletePolicy" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Move Policy to Archive </h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
            <form action="" method="POST" id="deleteform">
                @csrf
                <div class="modal-body">
                    <h6> Are you sure you want to proceed moving adoption policy to archive?</h6>  
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-danger" type="submit">Proceed</button>
                </div>    
            </form>
        </div>
    </div> 
</div> 
<!-- Edit Policy Modal -->
<div class="modal fade"  id="EditPolicy" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Adoption Policy </h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
            <form action="" method="POST" id="editform">
                @csrf
                <div class="modal-body">
                <div class="form-group row">
                        <div class="col-md"> 
                            <label class="text-sm">Policy Content</label>
                            <textarea class="form-control" name="policy_content" rows="5" id="policy"></textarea>
                        </div>
                     </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-danger" type="submit">Update</button>
                </div>    
            </form>
        </div>
    </div> 
</div> 
@endsection
@push("js")
    <script src="https://cdn.datatables.net/1.11.2/js/jquery.dataTables.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function(){
          var table = $('#datatable').DataTable();
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

                $('#deleteform').attr('action','/AdoptionPolicy/delete/petowner/'+data[0]);
                $('#DeletePolicy').modal('show');
            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function(){
          var table = $('#datatable').DataTable();

            table.on('click','#edit', function(){
                $tr =$(this).closest('tr');
                var data = table.row($tr).data();
                if($($tr).hasClass('child')) {
                    $tr=$tr.prev('.parent');
                }
                var data = table.row($tr).data();
                console.log(data);

                $('#policy').val(data[1]);

                $('#editform').attr('action','/AdoptionPolicy/edit/petowner/'+data[0]);
                $('#EditPolicy').modal('show');
            });
        });
    </script>
@endpush