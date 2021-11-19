@extends("petownertempmain")
@section("header")
Welcome Pet Owner!
@endsection
@push('css')
<link href="{{url('css/introshelter.css')}}" rel="stylesheet">   
@endpush
@section("content")
 <div class="row">
        <!-- Dashboard Content -->
        <div class="col-xl-3 col-lg-7">
            <div class="card shadow mb-4">
                <!-- Dashboard header -->
                <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h5 style="color:black">What pets do you want to be adopted?</h5>
                </div>
            </div>
        </div>
    </div>
    <main style ="margin-top:30px" class="grid">
    <article>
        <img src="http://iroislandrescue.org/wp-content/uploads/2021/05/aspins-scaled.jpg" height="300" width="400" alt="Dog">
        <div class="text">  
            <form action="{{route('second.intro.petowner')}}" method="POST">
                @csrf
                <input type="text" hidden  name="dogs" value="Dog">
                <h3>Dogs</h3>
                <button type="submit">Click Me</button>
            </form>
        </div>
    </article>  
    <article>
        <img src="https://i.pinimg.com/originals/69/9f/e8/699fe836279adb96aee682e5b80bffbc.jpg"  height="300" width="400" alt="Dog">
        <div class="text">
            <form action="{{route('second.intro.petowner')}}" method="POST">
                @csrf
                <input type="text" hidden  name="cats" value="Cat">
                <h3>Cats</h3>
                <button type="submit">Click Me</button>
            </form>
        </div>
    </article>  
    <article>
        <img src="{{asset('images/dogs_cats.jpg')}}"  height="300" width="400" alt="">
        <div class="text">
            <form action="{{route('second.intro.petowner')}}" method="POST">
                @csrf
                <input type="text" hidden  name="boths" value="Both">
                <h3>Both</h3>
                <button type="submit">Click Me</button>
            </form>
        </div>
    </article>  
    </main>   
@endsection