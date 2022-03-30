@extends("mainpetowner")
@section("header")
Donate
@endsection
@push("css")
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.2/css/jquery.dataTables.min.css">   
@endpush
@section("content")

<div style="margin-top:1%" class="row">
    <div class="col-sm">
        <div class="card shadow mb-4">
            <div class="card-header">
                <a href=""><button type="button" class="btn btn-danger">Donate Selected</button></a>
            </div>
            <div class="card-body">
                <table id="datatable" class="table table-light table-hover">
                    <thead>
                        <tr>
                            <th style="text-align:center"><input id="all" type="checkbox"></th>
                            <th>ID</th>
                            <th>Profile</th>
                            <th>Name</th>
                            <th style="text-align:center">View Shelter Details</th>
                            <th style="text-align:center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($shelters as $shelter)
                        <tr>
                            <td style="text-align:center"><input type="checkbox" class="item" name="" id="" value="{{$shelter->id}}"></td>
                            <td>{{$shelter->id}}</td>
                            <td>
                                <img src="{{asset('uploads/animal-shelter/profile/'.$shelter->profile)}}" width="70px" height="70px" alt="">
                            </td>
                            <td>{{$shelter->shelter_name}}</td>
                            <td style="text-align:center">
                                <a href="{{route('shelter.details.view',$shelter->id)}}"><i class="far fa-eye"></i></a>
                            </td>
                            <td style="text-align:center">
                                <a href="#" id="donate"><button type="button" data-toggle="modal" class="btn btn-success">Donate</button></a>       
                            </td>
                        </tr> 
                    @endforeach
                    @if(empty($shelter))   
                        <h6 class="alert alert-danger">No shelters available to donate</h6>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal fade"  id="donation" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Donate</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>   
                </div>
            <form action=""  method="POST" id="donateform">
                @csrf
                <div class="modal-body" id="response"> 
                    <div class="form-group row">
                        <div class="col-md"> 
                            <label class="text-sm">Your donation: </label>
                            <input type="number" name="donate">
                        </div>
                     </div>
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-danger" id="btn" type="submit">Proceed</button>
                </div>    
            </form>
        </div>
    </div>  
</div>
@endsection
@push('js')
<script src="https://cdn.datatables.net/1.11.2/js/jquery.dataTables.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function(){
          var table = $('#datatable').DataTable();

            table.on('click','#donate', function(){
                $tr =$(this).closest('tr');
                var data = table.row($tr).data();
                if($($tr).hasClass('child')) {
                    $tr=$tr.prev('.parent');
                }
                var data = table.row($tr).data();
                console.log(data);

                $('#donateform').attr('action','/PetOwner/donate/'+data[1]);
                $('#donation').modal('show');
            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function(){
          var table = $('#datatable').DataTable();
          $("#all").change(function(){
              $("input:checkbox").prop("checked",$(this).prop("checked"))
          })
          $(".item").change(function(){
              if($(this).prop("checked")==false){
                  $("#all").prop("checked",false)
              }
              if($(".item:checked").length == $("item").length){
                  $("#all").prop("checked",true)
              }
          })
        });
    </script>
@endpush