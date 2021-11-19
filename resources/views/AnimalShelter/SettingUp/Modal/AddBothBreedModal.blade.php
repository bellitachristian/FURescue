<!-- Add Breed Modal -->
<div class="modal fade"  id="AddDogBreedModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Breed +</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
            <form action="{{route('bothbreed.add')}}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-md"> 
                            <label class="text-sm">Breed Name</label>
                            <input type="text" class="form-control form-control-sm" name="breed_dogname" required>
                        </div>
                    </div>
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-danger" type="submit">Save</button>
                </div>    
            </form>
        </div>
    </div> 
</div> 
<!-- Add Breed Modal -->
<div class="modal fade"  id="AddCatBreedModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Breed +</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
            <form action="{{route('bothbreed.add')}}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-md"> 
                            <label class="text-sm">Breed Name</label>
                            <input type="text" class="form-control form-control-sm" name="breed_catname" required>
                        </div>
                    </div>
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-danger" type="submit">Save</button>
                </div>    
            </form>
        </div>
    </div> 
</div> 
