<!-- Delete Animal Modal -->
<div class="modal fade"  id="DeleteAnimal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete Animal </h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
            <form action="/AnimalManagement" method="POST" id="deleteform">
                @csrf
                <div class="modal-body">
                    <h6> Are you sure you want to proceed deletion?</h6>  
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-success" type="submit">Proceed</button>
                </div>    
            </form>
        </div>
    </div> 
</div> 