@extends("mainpetowner")
@section("header")
Post Pet
@endsection
@push("css")
<link href="{{url('css/introshelter.css')}}" rel="stylesheet">   
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.2/css/jquery.dataTables.min.css"> 
@endpush
@section("content")

<div class="row">
    <div class="col-sm">
        <div class="card">
            <div class="card-body">
                <div>
                    <a href="#" data-toggle="modal" data-target="#selectpost"><button style="padding:10px" class="btn btn-success"> <i style="padding-right:5px" class="fa fa-book"></i>Post Pet</button></a>  
                </div>
                <div style="padding:10px" id="post">

                </div>
            </div> 
        </div>
    </div>
</div>  
@include('PetOwner.Post Pet.Modal.selectpost')    
@endsection
@push("js")
<script src="{{url('https://cdn.datatables.net/1.11.2/js/jquery.dataTables.min.js')}}"></script>
<script type="text/javascript">
 $(document).ready(function(){
    var table = $('#datatable').DataTable();
    load_post();
    createpost()
 })
 $(document).on('click', '#edit', function(){
    var id = $(this).val();
    console.log(id)
    window.location.href ="/postpet/viewupdatepost/petowner/"+id   
});
$(document).on('click', '#remove', function(){
    var id = $(this).val();
    console.log(id)
    $.ajax({
      url:"/postpet/postdelete/petowner/"+id,
      success:function(){
        confirm('Removed Successfully!');
        location.reload();
        load_post();
      }
    })
});
function load_post()
    { 
        $.ajax({
        url:"{{ route('post.load.petowner') }}",
            success:function(data)
            {   
                $('#post').html(data);   
            }
        })
    }
function createpost(){  
    var table = $('#datatable').DataTable();
        table.on('click','#postpet', function(){
            $tr =$(this).closest('tr');
            if($($tr).hasClass('child')) {
                $tr=$tr.prev('.parent');
            }
            var data = table.row($tr).data();
            console.log(data[0]);

            window.location.href ="/postpet/create/petowner/"+data[0]
        })
    }
</script>

@endpush
