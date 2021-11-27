<div class="modal fade" id="error" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Feedback</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="{{route('reject',$resp->id)}}" method="POST">  
                    @csrf
                    <div class="modal-body">
                        <textarea name="feedback" id="" class="form-control" cols="30" rows="10"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" stype="button" data-dismiss="modal">Cancel</button>
                        <button class="btn btn-danger" type="submit">Send</button>
                    </div>
                </form>
            </div>
        </div>
    </div>