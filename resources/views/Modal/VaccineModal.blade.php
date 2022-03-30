<!-- Add Vaccine Modal -->
<div class="modal fade"  id="AddVaccine" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Vaccine +</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
            <form action="/vaccine/vac" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-md"> 
                            <label class="text-sm">Vaccine Name</label>
                            <input type="text" class="form-control form-control-sm" name="vac_name" required  value ="{{old('vac_name')}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md"> 
                            <label class="text-sm">Description</label>
                            <textarea class="form-control" name="desc" rows="3"  required value ="{{old('desc')}}"></textarea>
                        </div>
                    </div>
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-danger" type="submit">Save</button>
                </div>    
            </form>
        </div>
    </div> 
</div> 

<!-- Edit Vaccine Modal -->
<div class="modal fade"  id="EditVaccine" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Vaccine </h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
            <form action="/vaccine/editvac" method="POST" id="editform">
                @csrf
                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-md"> 
                            <label class="text-sm">Vaccine Name</label>
                            <input type="text" class="form-control form-control-sm" id="name" name="vac_name">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md"> 
                            <label class="text-sm">Description</label>
                            <textarea class="form-control" name="desc" id="desc" rows="3"></textarea>
                        </div>
                    </div>
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-danger" type="submit">Update</button>
                </div>    
            </form>
        </div>
    </div> 
</div> 
<!-- Delete Vaccine Modal -->
<div class="modal fade"  id="DeleteVaccine" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Move Vaccine to Archive</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
            <form action="/vaccine/deletevac" method="POST" id="deleteform">
                @csrf
                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-md"> 
                            <label class="text-sm">Vaccine Name</label>
                            <input type="text" disabled class="form-control form-control-sm" id="vac_name" name="vac_name">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md"> 
                            <label class="text-sm">Description</label>
                            <textarea type="hidden" disabled class="form-control" name="desc" id="vac_desc" rows="3"></textarea>
                        </div>
                    </div>
                    <h6> Are you sure you want to proceed moving vaccine to archive?</h6>  
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-danger" type="submit">Proceed</button>
                </div>    
            </form>
        </div>
    </div> 
</div> 