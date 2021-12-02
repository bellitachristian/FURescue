<div class="modal fade" id="confirm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Confirmation</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                    <div class="modal-body">
                        <p>Are you sure you have already receive the pet that has been requested for adoption?</p>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" stype="button" data-dismiss="modal">Cancel</button>
                        <a href="{{route('adoption.confirm',$generate->id)}}"><button class="btn btn-danger" type="submit">Confirm</button></a>
                    </div>
            </div>
        </div>
    </div>
