@extends('theme.layouts.app')
@section('content')
<?php
$page_number = 1;
?>
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-12">
      @if ($errors->any())
      <div class="alert alert-danger">
        <ul>
          @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
      @endif
      @if(session('success'))
      <div class="alert alert-success">
        {{session('success')}}
      </div>
      @endif
    </div>
    <div class="col-md-12">
      
      <div class="card">
        <div class="card-header">
          
          <div class="float-left">
            <input type="hidden" name="page_number" id="page_number" class="page_number" value="">
            <div class="input-group mb-3 pr-2">
              <input type="text" class="form-control search" name="search" id="search" placeholder="Search by Name">
            </div>
          </div>
          <button class="btn btn-primary pl-2 search_data">Search</button>
    
        </div>
        <div class="card-body p-0">
          
          {{-- <div class="load_data"></div> --}}
          {{-- ---------- --}}
          @if(isset($data) && count($data)>0)
          
          <table class="table table-hover">
            <thead>
              <tr>
                <th>S.R</th>
                <th>BookingId</th>
                <th>Service</th>
                <th>Booking Date</th>
                <th>Total Slot</th>
                <th>Total Cost(&#8377;)</th>
                <th>Name</th>
                <th>Email</th>
              </tr>
            </thead>
            <tbody>
              @foreach($data as $key=>$v)
              <tr class="row_{{ $v->id }}">
                <td>{{ ++$key }}</td>
                <td>{{ $v->booking_id }}</td>
                <td>{{ $v->service_name }}</td>
                <td>{{ Date('d M, Y',strtotime($v->booking_service_date)) }}</td>
                <td>{{ $v->booking_qty }}</td>
                <td>{{ $v->total_cost }}</td>
                <td>{{ $v->full_name }}</td>
                <td>{{ $v->email }}</td>
              </tr>
              <?php //$page_number++ ?>

              @endforeach
            <tbody>
          </table>
          <div class="text-muted p-2">Total Count : {{ $data->count() }}</div>
          @else
          <div class="alert alert-warning" align="center">
            Opps, seems like records not available.
          </div>
          @endif
          
          {{-- ---------- --}}
        </div>
      </div>
    </div>
  </div>
</div>
@push("scripts")
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script type="text/javascript">
  function load_data() {
    // $(".load_data").html('');
    // $(".ajax_loader").show();
  }
//   $(document).ready(function() {
//     $(".bulk_select_btn").hide();
//     load_data();
//     $(".change_row_limit").change(function() {
//       load_data();
//     });
//     $(".search_data").click(function(e) {
//       e.preventDefault();
//       load_data();
//     });
//     $(".reset_data").click(function(e) {
//       e.preventDefault();
//       $(".search").val('');
//       load_data();
//     });
//     $(".all_trashed").click(function(e) {
//       $(".bulk_select_btn").hide();
//       e.preventDefault();
//       temp = $(this).attr('data-val');
//       $(".all_trashed").removeClass('active');
//       $(this).addClass('active');
//       $(".all_trashed_input").val(temp);
//       if (temp == "all") {
//         $(".action_selected").val('trash');
//       } else {
//         $(".action_selected").val('restore');
//       }
//       load_data();
//     });
//   });
</script>
@endpush
@endsection