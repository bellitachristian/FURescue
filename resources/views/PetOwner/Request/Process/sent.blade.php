@extends("mainpetowner")
@section("header")
Sent Request
@endsection
@push("css")
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.2/css/jquery.dataTables.min.css">   
@endpush
@section("content")
<div class="row">
    <div class="col-sm">
        <div class="card shadow mb-4">
            <div class="card-header">
                <a href=""><button type="button" class="btn btn-danger">Cancel All</button></a>
            </div>
            <div class="card-body">
                <table id="datatable" class="table table-light table-hover">
                    <thead>
                        <tr>
                            <th style="text-align:center"><input input id="all" type="checkbox"></th>
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
                            <td style="text-align:center"><input type="checkbox" class="item" name="" id="" value="{{$animal->id}}"></td>
                            <td>{{$shelter->id}}</td>
                            <td>
                                <img src="{{asset('uploads/animal-shelter/profile/'.$shelter->shelter->profile)}}" width="70px" height="70px" alt="">
                            </td>
                            <td>{{$shelter->shelter->shelter_name}}</td>
                            <td style="text-align:center">
                                <a href="{{route('review',$shelter->shelter->id)}}"><i class="far fa-eye"></i></a>
                            </td >
                            <td style="text-align:center">
                                <a href="{{url('/PetOwner/cancel/'.$shelter->id.'/'.$shelter->shelter->id)}}"><button type="button" class="btn btn-danger">Cancel Request</button></a>       
                            </td>
                        </tr> 
                    @endforeach
                    @if(empty($shelter))   
                        <h6 class="alert alert-danger">No sent request</h6>
                    @endif
                    </tbody>
                </table>
            </div>
            <div class="card-header">
                <a href="{{route('view.request.adoption')}}"><button type="button" class="btn btn-secondary">Back</button></a>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script src="https://cdn.datatables.net/1.11.2/js/jquery.dataTables.min.js"></script>

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