<form action="{{route('catbreed.save.petowner')}}" method="POST">
@csrf

<main style="margin-top:30px" class="grid">
    <label class="option_item">
    <input type="checkbox" name="cat[]" value="Puspin" class="checkbox">
    <div class="option_inner kitten">
        <img src="{{asset('images/junior.png')}}" height="230" width="220" alt="Puspin">
        <div class="tickmark"></div>
            <h2 style="color:black; font-weight:bold">Puspin</h2>
        <p style="color:black">Pusang Pinoy(Philippine cat)</p>
    </div>
    </label>  
    <label class="option_item">
    <input type="checkbox"  name="cat[]" value="Cross-breed" class="checkbox">
    <div class="option_inner junior">
        <img src="{{asset('images/prime.jpg')}}" height="230" width="220"  alt="Cross-breed">
        <div class="tickmark"></div> 
            <h2 style="color:black; font-weight:bold">Cross-breed</h2>
            <input type="text" class="form-control sm" placeholder="Specify cross-breed">
    </div>
    </label>
    <label class="option_item">
        <table id="datatable" class="table table-light table-hover">
            <thead>
                <tr>
                    <th hidden>ID</th>
                    <th>Breed Name</th>
                    <th>Action</th>
                </tr>
            </thead>    
            <tbody>
                @foreach($breed as $breeds)
                <tr>
                    <td hidden>{{$breeds->id}}</td>
                    <td>{{$breeds->breed_name}}</td>
                    <td>
                        <a href="#" id="delete"><i class="fas fa-trash-alt"title="Delete">&#xE872;</i></a>
                    </td>
                </tr>
                @endforeach
                @if(empty($breeds))
                    <h6 style="font-weight:bold" class="alert alert-secondary">"No other breeds being added"</h6>
                @endif
            </tbody>
        </table>    
    </label>
    <label for=""></label>
    <label for=""></label>
    <div class="btn">
    <button style="margin-top:50%" type="submit">Proceed</button>
    </div>
</main>  
</form>

<!-- Delete Breed Modal -->
@if(empty($breeds))
@else
<div class="modal fade"  id="Deletebreed" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete Added Breed </h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
            <form action="{{route('catbreed.delete.petowner')}}" method="POST" id="deleteform">
                @csrf
                <input hidden type="text"name="id" value="{{$breeds->id}}">
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

@endif
