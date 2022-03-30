@extends("main")
@section("header")
Archived Policy
@endsection
@push("css")
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.2/css/jquery.dataTables.min.css">   
@endpush
@section("content")
<div class="row">
    <div class="col-md">
            <div class="card shadow mb-4">
                <!-- Policy header -->
                <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <div>
                        <a href="/AdoptionPolicy"><button class="btn btn-secondary" type="button">Back</button></a>
                    </div>
                </div>
    <!-- Policy Content -->
    <div class="card-body">
        <table id="datatable" class="table table-light table-hover">
            <thead>
                <tr>
                    <th> ID</th>
                    <th>Policy Content</th>
                    <th style="text-align:center">Action</th>
                </tr>
            </thead>
            <tbody>
            @foreach($policy as $pol)
                <tr>
                    <td>{{$pol->id}}</td>
                    <td>{{$pol->policy_content}}</td>
                    <td style="text-align:center">
                        <a href="{{route('restore_policy',$pol->id)}}"><button class="btn btn-dark">Restore</button></a>
                    </td>
                </tr> 
            @endforeach($policy as $pol)
            @if(empty($policy))   
                <h6 class="alert alert-danger">No archived policy!</h6>
            @endif
            </tbody>
        </table>
</div>

@endsection

@push("js")
    <script src="https://cdn.datatables.net/1.11.2/js/jquery.dataTables.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function(){
          var table = $('#datatable').DataTable();
        });
    </script>
@endpush