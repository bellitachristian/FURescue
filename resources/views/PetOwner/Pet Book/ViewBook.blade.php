@extends("mainpetowner")
@section("header")
Pet Book
@endsection
@push("css")
<link href="{{url('css/petbook.css')}}" rel="stylesheet">   
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.2/css/jquery.dataTables.min.css"> 
@endpush
@section("content")

<div class="row">
    <div class="col-sm">
        <div class="card shadow mb-4">
            <div class="card-header">
              <a href="#" data-toggle="modal" data-target="#generatebook"><button style="padding:10px" class="btn btn-success"> <i style="padding-right:5px" class="fa fa-book"></i> Generate Pet Book</button></a>  
            </div>
            <div class="card-body">
                <div id="petbook" style="display:flex">

                </div>
            </div>
            <div class="card-footer">

            </div>
        </div>
    </div>
</div> 
@include('PetOwner.Pet Book.Modal.GenerateBook')
@endsection
@push("js")
<script src="{{url('https://cdn.datatables.net/1.11.2/js/jquery.dataTables.min.js')}}"></script>
<script type="text/javascript">
 $(document).ready(function(){
    var table = $('#datatable').DataTable();
    load_books();
    generate()
 })

function load_books()
    { 
        $.ajax({
        url:"{{ route('petbook.fetch.petowner') }}",
            success:function(data)
            {   
                $('#petbook').html(data);   
            }
        })
    }
function generate(){  
    var table = $('#datatable').DataTable();
        table.on('click','#generate', function(){
            $tr =$(this).closest('tr');
            if($($tr).hasClass('child')) {
                $tr=$tr.prev('.parent');
            }
            var data = table.row($tr).data();
            console.log(data[0]);

            $.ajax({
            url:"{{ route('petbook.generate.petowner') }}",
            data:{id:data[0]},
            success:function(data)
            {   
                confirm("Generated Successfully");
                location.reload();
            }
            })
        })
    }
$(document).on('click', '.petbook', function(){
    var id = $(this).attr('id');
        window.location.href ="/petbook/petowner/details/"+id
  });

</script>

@endpush
