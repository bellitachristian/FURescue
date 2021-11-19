@extends("main")
@section("header")
Adoption Fee
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@push('css')
<link href="{{url('css/introshelter.css')}}" rel="stylesheet">   
@endpush
@section('content')
<div class="row">
    <div class="col-sm">
        <div class="card shadow mb-4">
            <div class="card-header">
            </div>
            <div class="card-body">
                <form action="" method="POST" id="petfees">
                <div id="adoption">

                </div>
                </form>
            </div>
            <div class="card-footer">
                <a href="{{route('selection.view')}}"><button type="button" class="btn btn-danger">Back</button></a>
            </div>
        </div>
    </div>
</div>

@endsection
@push('js')
<script type="text/javascript">
load_adoption();
function load_adoption()
    { 
        $.ajax({
        url:"{{ route('load.adoption') }}",
            success:function(data)
            {   
                $('#adoption').html(data);   
            }
        })
    }
    $(document).on('click', '.apply', function(){
    var name = $(this).attr('id');
    console.log(name)
    $.ajax({
      url:"{{ route('selection.addadoptionfee') }}",
      data:{name : name},
      success:function(data){
        confirm('Applied Successfully!');
        load_adoption();
      }
    })
  });


  $(document).on('submit', '#petfees', function(e){
    var name = $(this).attr('id')
    console.log(name)
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
      e.preventDefault();
      let catfee = $("#catfee").val();
      let dogfee = $("#dogfee").val();
      let catid = $("#catid").val();
      let dogid = $("#dogid").val();
     
      $.ajax({
        url: "{{route('selection.adoption.savefee')}}",
        type:"POST",
        data:{
          catfee:catfee, 
          dogfee:dogfee,
          catid:catid,
          dogid:dogid,
        },
        success:function(data){
          confirm('Set Successfully')
          location.reload(); 
        },
        error: function(error) {
         alert('Something went wrong')
        }
       }); 
       return false;

  });

</script>

@endpush