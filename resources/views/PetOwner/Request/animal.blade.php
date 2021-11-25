@extends("mainpetowner")
@section("header")
Animals to be Adopted
@endsection
@push("css")
<link type="text/css" href="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.12/css/dataTables.checkboxes.css" rel="stylesheet" />
@endpush
@section("content")
<div class="row">
    <div class="col-sm">
        <div class="card shadow mb-4">
            <div class="card-header">
                <form id="myForm" action="POST">
                <button style="border: none; background: transparent; font-size: 14px;" id="MyTableCheckAllButton">
                <i class="far fa-square"></i>  
                </button>                
                </form>
            </div>
            <div class="card-body">
                <table id="example" class="display select" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th><input type="checkbox" name="select_all" value="1" id="example-select-all">
                            <th>ID</th>
                            <th>Animal Photo</th>
                            <th>Name</th>
                            <th>Breed</th>
                            <th>Age</th>
                            <th>Life Stage</th>
                            <th style="text-align:center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($animals as $animal)
                        <tr>
                            <td>{{$animal->id}}</td>
                            <td>
                                <img src="{{asset('uploads/animals/'.$animal->animal_image)}}" width="70px" height="70px" alt="">
                            </td>
                            <td>{{$animal->name}}</td>
                            <td>{{$animal->breed}}</td>
                            <td>{{$animal->age}}</td>
                            <td>{{$animal->pet_stage}}</td>
                            <td>
                                <a href=""><button type="button" class="btn btn-success">Select</button></a>       
                            </td>
                        </tr> 
                    @endforeach
                    @if(empty($animal))   
                        <h6 class="alert alert-danger">No animals being posted for adoption</h6>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script type="text/javascript" src="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.12/js/dataTables.checkboxes.min.js"></script>
    <script type="text/javascript">
     $(document).ready(function (){
        var table = $('#example').DataTable({
            'ajax': '/lab/jquery-datatables-checkboxes/ids-arrays.txt',
            'columnDefs': [
                {
                    'targets': 0,
                    'checkboxes': {
                    'selectRow': true
                    }
                }
            ],
            'select': {
                'style': 'multi'
            },
            'order': [[1, 'asc']]
        });

        // Handle form submission event
        $('#frm-example').on('submit', function(e){
            var form = this;

            var rows_selected = table.column(0).checkboxes.selected();

            // Iterate over all selected checkboxes
            $.each(rows_selected, function(index, rowId){
                // Create a hidden element
                $(form).append(
                    $('<input>')
                        .attr('type', 'hidden')
                        .attr('name', 'id[]')
                        .val(rowId)
                );
            });
        });
    });
    </script>
@endpush