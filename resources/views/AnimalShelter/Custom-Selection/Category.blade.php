@extends("main")
@section("header")
Category
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
                <div id="category">

                </div>
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
load_category();
function load_category()
    { 
        $.ajax({
        url:"{{ route('load.category') }}",
            success:function(data)
            {   
                $('#category').html(data);   
            }
        })
    }
    $(document).on('click', '.apply', function(){
    var name = $(this).attr('id');
    console.log(name)
    $.ajax({
      url:"{{ route('selection.add') }}",
      data:{name : name},
      success:function(data){
        confirm('Applied Successfully!');
        load_category();
      }
    })
  });
</script>

@endpush