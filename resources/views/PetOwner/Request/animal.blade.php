@extends("mainpetowner")
@section("header")
Animals to be Adopted
@endsection
@push("css")
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.2/css/jquery.dataTables.min.css">   
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
                <table id="datatable" class="table table-light table-hover">
                    <thead>
                        <tr>
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
<script src="https://cdn.datatables.net/1.11.2/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript">
       $(document).ready(function() {
    let myTable = $('#datatable').DataTable({
        columnDefs: [{
            orderable: false,
            className: 'select-checkbox',
            targets: 0,
        }],
        select: {
            style: 'os', // 'single', 'multi', 'os', 'multi+shift'
            selector: 'td:first-child',
        },
        order: [
            [1, 'asc'],
        ],
    });

       myTable.on('select deselect draw', function () {
        var all = myTable.rows({ search: 'applied' }).count(); // get total count of rows
        var selectedRows = myTable.rows({ selected: true, search: 'applied' }).count(); // get total count of selected rows

        if (selectedRows < all) {
            $('#datatable i').attr('class', 'fa fa-square-o');
        } else {
            $('#MyTableCheckAllButton i').attr('class', 'fa fa-check-square-o');
        }

    });

    $('#MyTableCheckAllButton').click(function () {
        var all = myTable.rows({ search: 'applied' }).count(); // get total count of rows
        var selectedRows = myTable.rows({ selected: true, search: 'applied' }).count(); // get total count of selected rows


        if (selectedRows < all) {
            //Added search applied in case user wants the search items will be selected
            myTable.rows({ search: 'applied' }).deselect();
            myTable.rows({ search: 'applied' }).select();
        } else {
            myTable.rows({ search: 'applied' }).deselect();
        }
    });
});
    </script>
@endpush