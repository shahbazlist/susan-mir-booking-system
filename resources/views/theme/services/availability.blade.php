@extends('theme.layouts.app')
@section('content')
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
          <form class="search-form">
              <div class="float-left">
                <div class="input-group mb-3 pr-2">
                  <input type="text" class="form-control search" name="search" id="search" value="{{$search}}" placeholder="Search by Title">
                </div>
              </div>
              <button  class="btn btn-primary pl-2 search_data">Search</button>
          </form>
          <div class="float-right">
            <div class="input-group mb-3">
              
              <a class="btn btn-primary ml-2" href="{{route('admin.services.availAdd')}}">Add New</a>
            </div>
          </div>
        </div>
        <div class="card-body p-0">
          @if(isset($data) && count($data)>0)
          
          <table class="table table-hover">
            <thead>
              <tr>
                <th>S.R</th>
                <th>Service Title</th>
                <th>Service Date</th>
                <th>Booked Slot</th>
                <th> Status </th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @php $row =1 @endphp
              @foreach($data as $key=>$v)
              <?php $totalSlot = $v->updated_max_slot == 0 ? $v->service->slot : $v->updated_max_slot ;?>
              <tr>
                <td>{{ $row }}</td>
                <td>{{ Str::limit($v->service->service_title,50,'...')}}</td>
                <td>{{ Date('d M, Y',strtotime($v->from_date)) }}</td>
                <td>{{ $v->booked_slot }}/{{$totalSlot}}</td>
                <td>
                  <label class="switch">
                    <input type="checkbox" name="two_factor_enable" @php echo $v->status == 1 ? 'checked' : '' @endphp class="two_factor_enable status_btn"  data-id="{{ $v->id }}" id="two_factor_enable">
                    <span class="slider"></span>
                  </label>
                </td>
                <td>
                  <a href="{{route('admin.services.aval.edit',[$v->id])}}" class="btn btn-primary btn-sm">Edit</a>
                  <a href="javascript:void(0);" data-id="{{ $v->id }}" class="btn btn-secondary btn-sm trash_btn bookingView">Booking</a>
                  
                </td>
              </tr>
              <?php $row++ ?>

              @endforeach
            <tbody>
          </table>
          @if(count($data) !== 0)
            <hr>
            @endif
            <div class="page-area">
                {!! $data->links('pagination::bootstrap-4') !!}
            </div>
          @else
          <div class="alert alert-warning" align="center">
            Opps, seems like records not available.
          </div>
          @endif
        </div>
      </div>
    </div>
    <!-- Basic Modal -->
    <div class="modal fade" id="bookingSlot" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" style="max-width: 40%;" role="document">
        <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Booking History</h5>
              <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
            <div id="view_response"></div>
            {{-- Table start --}}
            
            {{-- Table End --}}
        </div>
        </div>
      </div>
    </div>
<!-- Basic Modal End-->
  </div>
</div>
@push("scripts")
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

@endpush
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script>
  //Trash Item
  $(document).ready(function() {
      $(".status_btn").click(function(e) {
    
          e.preventDefault();
          var data_id = $(this).attr('data-id');
          var status_msg = "It will be change status from availability!";
          swal({
              title: "Are you sure?",
              text: status_msg,
              icon: "warning",
              buttons: true,
              dangerMode: true,
            })
            .then((willDelete) => {
              if (willDelete) {
                var token = '{{ csrf_token() }}';
                var url = "{{route('admin.services.aval.status')}}";
                $.ajax({
                  type: 'POST',
                  url: url,
                  data: {
                    _token: token,
                    data_id: data_id,
                  },
                  dataType: 'JSON',
                  success: function(resp) {
                    var res_msg = "Status has chenged successfully.";
                    swal(res_msg, {
                      icon: "success",
                    }).then(function() {
                      window.location.replace("{{route('admin.services.availability')}}")
                    });
                  },

                });
              }
            });
      });

      $(".bookingView").click(function(e) {
        var data_id = $(this).attr('data-id');
        // $('#bookingSlot').modal('show');
        if (data_id) {
            var token = '{{ csrf_token() }}';
            var url = "{{route('admin.services.aval.booking_history')}}";
            $.ajax({
              type: 'POST',
              url: url,
              data: {
                _token: token,
                data_id: data_id,
              },
              dataType: 'JSON',
              success: function(response) {
                if(response.status == 'true'){
                  $('#view_response').html(response.data);
                  $('#bookingSlot').modal('show');
                  return false;
                }
                var res_msg = "Status has chenged successfully.";
                swal(res_msg, {
                  icon: "success",
                }).then(function() {
                  window.location.replace("{{route('admin.services.availability')}}")
                });
              },
            });
          }
      });
      });
</script>