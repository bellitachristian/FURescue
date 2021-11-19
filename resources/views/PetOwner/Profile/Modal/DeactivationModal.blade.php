<div class="modal fade"  id="deactivate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Account Deactivation</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
            <form action="{{ route('deactivate.petowner') }}" method="POST">
                @csrf
                <div class="modal-body">
                <div class="form-group row">
                        <input type="text" hidden name="petowner" value="{{$petowner->id}}">
                        <div class="col-md" style="text-align:center"> 
                            <label class="text-sm">Current Password</label><br>
                            <input type="password" required name="password">
                        </div>
                     </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-danger" type="submit">Proceed</button>
                </div>    
            </form>
        </div>
    </div> 
</div> 