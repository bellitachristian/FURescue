<!-- Add Animal Modal -->
<div class="modal fade"  id="AddAnimalModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Pet +</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
            <form action="/AnimalManagement"  method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body" id="response">
                    <div class="form-group row">
                        <div class="col-md"> 
                            <label class="text-sm">Upload Pet Image</label>
                            <input type="file" class="form-control form-control-sm" id="animal_image" name="animal_image" required  value ="{{old('animal_image')}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md"> 
                            <label class="text-sm">Name</label>
                            <input type="text" placeholder="Pet name" class="form-control form-control-sm" id="name" name="name" required  value ="{{old('name')}}">
                        </div>
                        <div class="col-md"> 
                            <label class="text-sm">Category</label>
                            <select class="form-control form-control-sm" id="category" required name="category">
                            <option value="">Select category</option>
                                @foreach($sheltercateg as $categories)
                                    @foreach($categories->category as $categ)
                                        <option value="{{$categ['id']}}">{{$categ['category_name']}}</option>
                                    @endforeach
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                            <div class="col-md"> 
                                <label class="text-sm">Breed</label>
                                <select class="form-control form-control-sm" id="breed" required name="breed">
                            
                                </select>
                            </div>
                        <div class="col-md"> 
                            <label class="text-sm">Gender</label>
                            <select class="form-control form-control-sm" id="gender" required name="gender">
                                <option value="">Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>       
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md"> 
                            <input type="number" placeholder="Pet's age" class="form-control form-control-sm" id="age" name="age" required  value ="{{old('age')}}">
                            <span><input type="radio" value="1" id="years" name="radiobtn"></span> <label style="padding-right:3px" class="text-sm">Years</label>  <span><input class="radio sm" id="months" name="radiobtn" value="2" type="radio"></span> <label class="text-sm">Months</label>
                        </div>
                        <div class="col-md"> 
                            <label class="text-sm">Pet Size</label>
                            <select class="form-control form-control-sm" id="size" required name="size">
                                <option value="">Select Pet's Size</option>
                                <option value="Big">Big</option>
                                <option value="Regular">Regular</option>
                                <option value="Small">Small</option>
                                <option value="Dwarf">Dwarf</option>
                            </select>
                        </div>
                         
                    </div>
                    <div class="form-group row">
                        <div class="col-md"> 
                            <label class="text-sm">Life stage according to age</label>
                            <select readOnly class="form-control form-control-sm" id="stage" required name="stage">
                                
                            </select>
                        </div>
                        <div class="col-md"> 
                            <label class="text-sm">Color</label>
                            <select class="form-control form-control-sm" id="color" required name="color">
                                <option value="">Select Color</option>
                                <option value="Black">Black</option>
                                <option value="White">White</option>
                                <option value="Brown">Brown</option>
                                <option value="Orange">Orange</option>
                                <option value="Tiger">Tiger</option>
                                <option value="Mixed">Mixed</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md"> 
                            <label class="text-sm">History</label>
                            <textarea class="form-control" placeholder="A brief history of pet" name="history" rows="3" id="info" required value ="{{old('info')}}"></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md"> 
                            <label class="text-sm">Additional Info</label>
                            <textarea class="form-control" placeholder="A brief description of pet" name="info" rows="3" id="info" required value ="{{old('info')}}"></textarea>
                        </div>
                     </div>     
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-danger" id="btn" type="submit">Save</button>
                </div>    
            </form>
        </div>
    </div>  
</div>