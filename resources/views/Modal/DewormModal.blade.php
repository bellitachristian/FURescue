<!-- Edit Deworm Modal -->
<div class="modal fade"  id="Editdeworm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Deworm </h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
            <form action="/deworm/editdeworm" method="POST" id="editform1">
                @csrf
                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-md"> 
                            <label class="text-sm">Deworm Name</label>
                            <input type="text" class="form-control form-control-sm" id="deworm_name" name="dew_name">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md"> 
                            <label class="text-sm">Description</label>
                            <textarea class="form-control" name="desc" id="deworm_desc" rows="3"></textarea>
                        </div>
                    </div>
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-danger" type="submit">Update</button>
                </div>    
            </form>
        </div>
    </div> 
</div> 
<!-- Delete Deworm Modal -->
<div class="modal fade"  id="Deletedeworm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Move Deworm to Archive </h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
            <form action="/deworm/deletedeworm" method="POST" id="deleteform1">
                @csrf
                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-md"> 
                            <label class="text-sm">Deworm Name</label>
                            <input type="text" disabled class="form-control form-control-sm" id="dew_name" name="dew_name">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md"> 
                            <label class="text-sm">Description</label>
                            <textarea type="hidden" disabled class="form-control" name="desc" id="dew_desc" rows="3"></textarea>
                        </div>
                    </div>
                    <h6> Are you sure you want to proceed moving deworm to archive?</h6>  
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-danger" type="submit">Proceed</button>
                </div>    
            </form>
        </div>
    </div> 
</div> 

    <!-- Add Deworming Modal -->
<div class="modal fade"  id="AddDeworm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Deworming +</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
            <form action="/vaccine/deworm" method="POST">
                @csrf
                <div class="modal-body" id="response">
                    <div class="form-group row">
                        <div class="col-md"> 
                            <label class="text-sm">Deworming Name</label>
                            <input type="text" class="form-control form-control-sm" name="dew_name" required  value ="{{old('desc')}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md"> 
                            <label class="text-sm">Description</label>
                            <textarea class="form-control" name="desc" rows="3" required value ="{{old('desc')}}"></textarea>
                        </div>
                    </div>
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-danger" type="submit">Save</button>
                </div>    
            </form>
        </div>
    </div> 
</div>  