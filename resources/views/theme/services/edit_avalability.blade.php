@extends('theme.layouts.app')
@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-12">
      
      @if(session('success'))
      <div class="alert alert-success">
        {{session('success')}}
      </div>
      @endif
      @if(session('error'))
      <div class="alert alert-danger">
        {{session('error')}}
      </div>
      @endif
    </div>

    <div class="col-md-12 form_page">
      <div class="card">
        <div class="card-body">
          <form action="" class="" method="post">
            @csrf
            <input type="hidden" name="id" value="{{$data->id}}">
            <div class="row form_sec">
              <div class="col-12">
                <h5>Edit Service</h5>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                  <div class="form-group">
                    <label for="service_title">Service Title <span class="text-danger">*</span></label>
                    <select class="form-control" name="service">
                      <option value="">Select Service</option>
                      @foreach($services as $val)
                        <option value="{{$val['id']}}" {{ $data->service_id == $val['id'] ? 'selected' : '' }}>{{$val['service_title']}}</option>
                      @endforeach
                    </select>
                      @error('service') <div class="text-danger">{{ $message }}</div> @enderror
                  </div>
              </div>
              <div class="col-md-6">
                  <div class="form-group">
                    <label for="price">Date <span class="text-danger">*</span></label>
                    <input type="date" name="date" class="form-control"  value="{{ $data->from_date}}" id="txtDate" placeholder="">
                    @error('date') <div class="text-danger">{{ $message }}</div> @enderror
                    @if(session('errorDate')) <div class="text-danger">{{session('errorDate')}}</div> @endif
                  </div>
                </div>
          </div>
          <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                  <label for="service_title">Update Max Slot <span class="text-danger">*</span></label>
                  <input type="text" name="max_slot" class="form-control"  value="{{old('max_slot', $data->updated_max_slot)}}" id="max_slot" placeholder="">
                    @error('max_slot') <div class="text-danger">{{ $message }}</div> @enderror
                </div>
            </div>
          </div>
          
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <button type="submit" class="btn btn-primary add_site"> Update Changes </button>
                  <a href="{{route('admin.services.availability')}}" class="btn btn-secondary add_site"> Back </a>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script>
  $(document).on('input', '#max_slot', function() {
          $(this).val($(this).val().replace(/\D/g, ''))
      });
    $(function(){
    var dtToday = new Date();

    var month = dtToday.getMonth() + 1;
    var day = dtToday.getDate();
    var year = dtToday.getFullYear();
    if(month < 10)
        month = '0' + month.toString();
    if(day < 10)
        day = '0' + day.toString();

    var minDate= year + '-' + month + '-' + day;

    $('#txtDate').attr('min', minDate);
});
</script>