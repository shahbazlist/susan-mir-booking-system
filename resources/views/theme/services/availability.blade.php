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
                  <input type="text" class="form-control search" name="search" id="search" placeholder="Search by Name">
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
              <tr>
                <td>{{ $row }}</td>
                <td>{{ Str::limit($v->service->service_title,50,'...')}}</td>
                <td>{{ Date('d M, Y',strtotime($v->from_date)) }}</td>
                <td>{{ $v->booked_slot }}</td>
                <td>
                  <label class="switch">
                    <input type="checkbox" name="two_factor_enable" @php echo $v->status == 1 ? 'checked' : '' @endphp class="two_factor_enable status_btn"  data-id="{{ $v->id }}" id="two_factor_enable">
                    <span class="slider"></span>
                  </label>
                </td>
                <td>
                  <a href="{{route('admin.services.aval.edit',[$v->id])}}" class="btn btn-primary btn-sm">Edit</a>
                  {{-- <a href="#" data-id="{{ $v->id }}" class="btn btn-danger btn-sm trash_btn delete{{ $v->id }}">Trash</a> --}}
                  
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
      });
</script>