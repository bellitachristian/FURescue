@extends("Admin.main")
@section("header")
Reports
@endsection
@push("css")
<style>
.bg-light-primary {
    background-color: #f9fbff!important;
}
.pb-6, .py-6 {
    padding-bottom: 3.75rem!important;
}
.pt-6, .py-6 {
    padding-top: 3.75rem!important;
}
.hover-scale, .hover-scale:hover {
    transition: transform .2s ease-in;
}
.card {
    position: relative;
    display: flex;
    flex-direction: column;
    min-width: 0;
    word-wrap: break-word;
    background-color: #fff;
    background-clip: border-box;
    border: 1px solid rgba(0,0,0,.125);
    border-radius: .4rem;
    box-shadow: 0 20px 27px 0 rgb(0 0 0 / 5%);
}
.card-body {
    flex: 1 1 auto;
    min-height: 1px;
    padding: 1.25rem;
}
</style>
@endpush
@section("content")
<div class="container">
    <div class="row row-cols-lg-3 row-cols-md-2 row-cols-1 text-center justify-content-center px-xl-6 aos-init aos-animate" data-aos="fade-up">
        <div class="col my-3">
            <div class="card border-hover-primary hover-scale">
                <div class="card-body">
                    <div class="text-primary mb-3">
                        <img src="{{asset('images/animalshelter.png')}}" style="height: 70px; width: 70px;">
                    </div>
                    <h6 class="font-weight-bold mb-3">List of Animal Shelters</h6>
                    
                </div>
                <div class="card-footer bg-transparent "><a href="{{route('view.shelters')}}" class="btn btn-primary">View History</a></div>
            </div>
        </div>
        <div class="col my-3">
            <div class="card border-hover-primary hover-scale">
                <div class="card-body">
                    <div class="text-primary mb-3">
                        <img src="{{asset('images/petowner.jpg')}}" style="height: 70px; width: 70px;">
                    </div>
                    <h6 class="font-weight-bold mb-3">List of Pet Owners</h6>
                    
                </div>
                <div class="card-footer bg-transparent "><a href="{{route('view.petowners')}}" class="btn btn-primary">View History</a></div>
            </div>
        </div>
        <div class="col my-3">
            <div class="card border-hover-primary hover-scale">
                <div class="card-body">
                    <div class="text-primary mb-3">
                        <img src="{{asset('images/adopters.png')}}" style="height: 70px; width: 70px;">
                    </div>
                    <h6 class="font-weight-bold mb-3">List of Adopters</h6>
                    
                </div>
                <div class="card-footer bg-transparent "><a href="{{route('view.adopters')}}" class="btn btn-primary">View History</a></div>
            </div>
        </div>
        <div class="col my-3">
            <div class="card border-hover-primary hover-scale">
                <div class="card-body">
                    <div class="text-primary mb-3">
                        <img src="{{asset('images/transfer.png')}}" style="height: 70px; width: 70px;">
                    </div>
                    <h6 class="font-weight-bold mb-3">Transferred Payment</h6>
                </div>
                <div class="card-footer bg-transparent "><a href="{{route('view.transfer.history')}}" class="btn btn-primary">View History</a></div>
            </div>
        </div>    
        <div class="col my-3">
            <div class="card border-hover-primary hover-scale">
                <div class="card-body">
                    <div class="text-primary mb-3">
                        <img src="{{asset('images/revenue.png')}}" style="height: 70px; width: 70px;">
                    </div>
                    <h6 class="font-weight-bold mb-3">Revenue</h6>
                </div>
                <div class="card-footer bg-transparent "><a href="" class="btn btn-primary">View History</a></div>
            </div>
        </div>            
    </div>
</div>
@endsection