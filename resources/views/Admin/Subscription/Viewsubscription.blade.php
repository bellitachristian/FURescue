@extends("Admin.main")
@section("header")
Subscription
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
                   <a href="{{route('view.add.subscription')}}"><button class="btn btn-danger">Add Subscription +</button></a>
                    </div>
                </div>
    <!-- Policy Content -->
    <div class="card-body">
        <table id="datatable" class="table table-light table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Details</th>
                    <th>Price</th>
                    <th>Span</th>
                    <th>Post Credits</th>
                    <th style="text-align:center">Action</th>
                </tr>
            </thead>
            <tbody>
            @foreach($subscription as $sub)
                <tr>
                    <td>{{$sub->id}}</td>
                    <td>{{$sub->sub_name}}</td>
                    <td>
                        @foreach($sub->sub_desc as $desc)
                            <li>{{$desc}}</li>
                        @endforeach
                    </td>
                    <td>{{$sub->sub_price}}</td>
                    <td>{{$sub->sub_span}}</td>
                    <td>{{$sub->sub_credit}}</td>
                    <td style="text-align:center">
                        <a href="{{route('view.edit.subscription',$sub->id)}}" id="edit"><i class="fas fa-edit" data-toggle="tooltip" title="Edit">&#xE254;</i></a>
                        <a href="#" id="delete"><i class="fas fa-trash-alt" data-toggle="tooltip" title="Delete">&#xE872;</i></a>
                    </td>
                </tr> 
            @endforeach
            @if(empty($sub))   
                <h6 class="alert alert-danger">No data for subscription exist</h6>
            @endif
            </tbody>
        </table>
</div>

    <!-- Delete Subscription Modal -->
<div class="modal fade"  id="DeleteSub" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Remove Subscription </h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
            <form action="" method="POST" id="deleteform">
                @csrf
                <div class="modal-body">
                    <h6> Are you sure you want to proceed deletion?</h6>  
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-danger" type="submit">Proceed</button>
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

                $('#deleteform').attr('action','/Admin/deletesubscription/'+data[0]);
                $('#DeleteSub').modal('show');
            });
        });
    </script>

@endpush