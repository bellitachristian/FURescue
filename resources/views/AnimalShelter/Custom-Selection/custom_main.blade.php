@extends("main")
@section("header")
Customize Selection
@endsection
@push('css')
<link href="{{url('css/introshelter.css')}}" rel="stylesheet">   
@endpush
@section('content')
<div class="row">
    <div class="col-sm">
        <div class="card shadow mb-4">
            <div class="card-body">
            <main style ="margin-top:30px" class="grid">
    <article>
        <img src="{{asset('images/dogs_cats.jpg')}}"  height="300" width="400" alt="">
        <div class="text">
            <a href="{{route('selection.category')}}"><button style="margin-top:10px" class="btn btn-danger">CATEGORY</button>
            </a>
        </div>
    </article>  
    <article>
        <img src="https://wallpaperaccess.com/full/1122476.jpg" height="300" width="400" alt="">
        <div class="text">
            <a href="{{route('selection.breed')}}"><button style="margin-top:10px" class="btn btn-danger">BREED</button>
            </a>
        </div>
    </article>  
    <article>
        <img src="https://i.pinimg.com/originals/26/98/bf/2698bfc861235f13ef276c7e7006b221.png" height="300" width="400" alt="">
        <div class="text">
            <a href="{{route('selection.adoption')}}"><button style="margin-top:10px; " class="btn btn-danger">ADOPTION FEE</button>
            </a>
        </div>
    </article>  
    </main>   
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')


@endpush