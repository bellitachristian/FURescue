@extends("Admin.main")
@section("header")
Add New Subscription
@endsection
@push("css")
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta2/dist/css/bootstrap-select.min.css">
<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
@endpush
@section("content")
<div class="card shadow mb-4">
    <div class="card-header">
        <a href="{{route('view.subscription')}}"><button class="btn btn-secondary">Back</button></a>
    </div>
        <form method="POST" id="insert_form">
            @csrf
            <div class="card-body">
                <span id="error"></span>
                <div style="display:flex">
                    <div class="col-md">
                        <label class ="text-sm">Subscription Name</label>
                        <input type="text" name="name" required class="form-control" id="">
                    </div>
                    <div class="col-md">
                        <label class ="text-sm">Subscription Price</label>
                        <input type="number" name="price" required class="form-control" id="">
                    </div>
                    <div class="col-md">
                        <label class ="text-sm">Subscription Span</label>
                        <input type="number" id="span" name="span" required class="form-control" id="">
                        <select class="form-control form-control-sm" required name="length">
                            <option value="day">Day</option>
                            <option value="month">Month</option>
                            <option value="year">Year</option>
                        </select>
                        <br>        
                    </div>
                    <div class="col-md">
                        <label class ="text-sm">Post Credits</label>
                        <input type="text" name="credits" required class="form-control" id="">
                        <br>
                    </div>
                </div>
                <div class="table-responsive">
                    <div class="col-sm">
                        <table class="table table-bordered" id="description">
                            <tr>
                                <th>Subscription Details</th>
                                <th style="text-align:center">
                                    <button type="button" name="add" class="btn btn-success btn-sm add"><i class="fa fa-plus"></i></button>
                                </th>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div style="text-align:center">
                    <button type="submit" id="submit_button" class="btn btn-danger">Save</button>
                </div>
            </div>
    </form>
</div>
@endsection
@push('js')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta2/dist/js/bootstrap-select.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){

        var count = 0;

        function add_input_field(count)
        {
            var html = '';
            html += '<tr>';
            html += '<td><input type="text" name="desc[]" id="sub" class="form-control desc" /></td>';
            var remove_button = '';
            if(count > 0)
            {
                remove_button = '<button type="button" name="remove" class="btn btn-danger btn-sm remove"><i class="fas fa-minus"></i></button>';
            }
            html += '<td>'+remove_button+'</td></tr>';
            return html;
        }
        $('#description').append(add_input_field(0));
        $(document).on('click', '.add', function(){
            count++;
            $('#description').append(add_input_field(count));
        });
        $(document).on('click', '.remove', function(){
        $(this).closest('tr').remove();
        });

        $("#insert_form").submit(function(e){
            e.preventDefault();
            var error = '';
            count = 1;
           
            $(".desc").each(function(){
                if($(this).val() == '')
                {
                    error += "<li>Include subscription description at "+count+" row</li>";
                }
                count = count + 1
            });
            var form_data = $(this).serialize();
            if(error == '')
                {
                $.ajax({
                    url:"{{route('save.subscription')}}",
                    method:"POST",
                    data:form_data,
                    beforeSend:function()
                    {
                        $('#submit_button').attr('disabled', 'disabled');
                    },
                    success:function(data)
                    {
                        if(data == 'ok')
                        {
                            $('#description').find('tr:gt(0)').remove();
                            $('#error').html('<div class="alert alert-success">Saved Successfully</div>');
                            $('#submit_button').attr('disabled', false);
                            document.getElementById("insert_form").reset();
                        }else{
                            $('#error').html('<div class="alert alert-danger">Something went wrong</div>');
                        }
                    }
                })

		    }
            else{
                $('#error').html('<div class="alert alert-danger"><ul>'+error+'</ul></div>');
            }
        });
    });
   
</script>
@endpush