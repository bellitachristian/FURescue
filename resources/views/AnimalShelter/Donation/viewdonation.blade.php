@extends("main")
@section("header")
Donation
@endsection
@push("css")
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.2/css/jquery.dataTables.min.css"> 
@endpush
@section("content")
<div class="row">
    <div class="col-md">
            <div class="card shadow mb-4">
                <!-- Vaccine header -->
                <div>
                </div>
    <!-- Vaccine and deworm Content -->
    <div class="card-body">
        <table id="datatable" class="table table-light table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Donor Name</th>
                    <th>Email</th>
                    <th>Donation Method</th>
                    <th>Contact Number</th>
                    <th>Message</th>
                    <th>Amount</th>
                    <th>Proof of donation</th>
                    <th style="text-align:center">Action</th>
                </tr>
            </thead>
            <tbody>
            @foreach($donors as $donor)
                <tr>
                    <td>{{ $donor->donation_id}}</td>
                    <td>{{ $donor->donor_fname}} {{ $donor->donor_lname}}</td>
                    <td>{{ $donor->donor_email}}</td>
                    <td>{{ $donor->donor_paymentMethod}}</td>
                    <td>{{ $donor->donor_phone}}</td>
                    <td style="text-align:center">
                        {{ $donor->donor_message}}
                    </td>
                    <td style="text-align:center">
                        {{ $donor->donor_amount}}
                    </td>
                    <td style="text-align:center">  
                        <img src="{{asset('phpcode/donation/'.$donor->donor_photo)}}" width="70px" height="70px" alt="">
                    </td>
                    <td> 
                        <a href="#"><butston style="margin-bottom:3px" id="approve" class="btn btn-success" type="button">Approve</button></a>
                        <a href="#"><button style="margin-bottom:3px" id="reject" class="btn btn-danger" type="button">Reject</button></a>
                    </td>
                </tr>
                @endforeach
                @if(empty($donor))
                <h6 class="alert alert-danger">No data for donations</h6>
                @endif   
        </tbody>
    </table>
</div>
</div>
@include('AnimalShelter.Donation.Modal.feedbackmessage')
@include('AnimalShelter.Donation.Modal.feedbackmessageerror')
@endsection
@push('js')
<script src="https://cdn.datatables.net/1.11.2/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
          var table = $('#datatable').DataTable();
          table.on('click','#approve', function(){
                $tr =$(this).closest('tr');
                var data = table.row($tr).data();
                if($($tr).hasClass('child')) {
                    $tr=$tr.prev('.parent');
                }
                var data = table.row($tr).data();
                console.log(data);

                $('#feedbackform').attr('action','/Admin/feedbackdonationmessage/'+data[0]);
                $('#feedback').modal('show');
            });
        });
    </script>
    <script>
        $(document).ready(function(){
          var table = $('#datatable').DataTable();
          table.on('click','#reject', function(){
                $tr =$(this).closest('tr');
                var data = table.row($tr).data();
                if($($tr).hasClass('child')) {
                    $tr=$tr.prev('.parent');
                }
                var data = table.row($tr).data();
                console.log(data);

                $('#feedbackformerror').attr('action','/Admin/feedbackdonationmessageerror/'+data[0]);
                $('#feedback1').modal('show');
            });
        });
    </script>
@endpush