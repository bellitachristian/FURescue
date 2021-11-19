
<div class="modal fade"  id="selectpost" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
    <div class="modal-dialog" style="max-width: 50%;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">Select Pet to Post</h4>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
                    <table id="datatable" class="table table-light table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Age</th>
                                <th>Breed</th>
                                <th style="text-align:center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($animal as $animals)
                            <tr>
                                <td>{{$animals->id}}</td>
                                <td>
                                <img src="{{asset('uploads/animals/'.$animals->animal_image)}}" width="70px" height="70px" alt="">
                                </td>
                                <td>{{$animals->name}}</td>
                                <td>{{$animals->age}}</td>
                                <td>{{$animals->breed}}</td>
                                <td style="text-align:center">
                                <button type="button" id="postpet" data-id="{{$animals->id}}" class="btn btn-success">Select</button>
                                </td>
                            </tr> 
                        @endforeach
                        </tbody>
                    </table>
            </div>
    </div>  
</div>