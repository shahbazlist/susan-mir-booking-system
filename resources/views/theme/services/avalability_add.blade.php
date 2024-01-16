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
            <div class="row form_sec">
              <div class="col-12">
                <h5>Add New Service</h5>
              </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                      <label for="service_title">Service Title <span class="text-danger">*</span></label>
                      <select class="form-control" name="service">
                        <option value="">Select Service</option>
                        @foreach($data as $val)
                          <option value="{{$val['id']}}">{{$val['service_title']}}</option>
                        @endforeach
                      </select>
                        @error('service') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                      <label for="price">Date <span class="text-danger">*</span></label>
                      <input type="date" name="date" class="form-control"  value="{{old('date')}}" id="txtDate" placeholder="">
                      @error('date') <div class="text-danger">{{ $message }}</div> @enderror
                      @if(session('errorDate')) <div class="text-danger">{{session('errorDate')}}</div> @endif
                    </div>
                  </div>
                  {{-- <div class="col-md-12">
                    <input type="checkbox" id="selectAll"><label for="selectAll"> &nbsp; Select All</label><br>
                  </div>
                  <br>
                  @foreach($timeLine as $val)
                    <div class="col-md-2">
                        <input type="checkbox" name="start_time[]" class="startTime" value="{{$val['id']}}" id="start_time_{{$val['id']}}"><label for="start_time_{{$val['id']}}"> &nbsp; {{ $val['time']}}</label><br>
                    </div>
                  @endforeach
                  <br> --}}
                  <div class="col-md-2">
                  </div>
                  <hr>
                  <div class="col-md-12">
                    <div class="form-group">
                      <table class="table table-bordered" id="dynamicTable">  
                          <tr>
                              <th>From Time</th>
                              <th>To Tim</th>
                              <th>Action</th>
                          </tr>
                          <tr>  
                              <td><input type="time" name="addmore[0][from]" placeholder="Enter your Name" class="form-control" /></td>  
                              <td><input type="time" name="addmore[0][to]" placeholder="Enter your Qty" class="form-control" /></td>  
                              <td><button type="button" name="add" id="add" class="btn btn-success" onclick="addMore()">Add More</button></td>  
                          </tr>  
                      </table> 
                    </div>
                  </div>
                  {{-- <div class="col-md-6">
                    <div class="form-group">
                      <label for="price">Date <span class="text-danger">*</span></label>
                      <input type="text" name="daterange" value="" id="daterange" class="form-control" />
                      @error('your_datepicker_id') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>
                  </div> --}}
            </div>
            
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <button type="submit" class="btn btn-primary add_site"> Add </button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@push("scripts")
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

@endpush
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<script>
  var i = 0;
  function addMore(){
    ++i;
    if(i <=10){
      $("#dynamicTable").append('<tr><td><input type="time" name="addmore['+i+'][from]" placeholder="Enter your Name" class="form-control" /></td><td><input type="time" name="addmore['+i+'][to]" placeholder="Enter your Qty" class="form-control" /></td><td><button type="button" class="btn btn-danger remove-tr">Remove</button></td></tr>');
    }else{
      return false
    }
  }
  $(document).on('click', '.remove-tr', function(){  
      $(this).parents('tr').remove();
  });
  // $(function() {
  //   $('input[name="daterange"]').daterangepicker({
  //     opens: 'left'
  //   }, function(start, end, label) {
  //     console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
  //   });
  // });
</script>
<script>
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
    $('#daterange').attr('min', minDate);
});
// $(document).ready(function () {
//   $('#selectAll').on('change',function(e){
//     if( $('#selectAll').is(':checked') ){
//       $('.startTime').prop('checked', true);
//     }
//     else{
//       $('.startTime').prop('checked', false);
//     }
//   });
// });
</script>