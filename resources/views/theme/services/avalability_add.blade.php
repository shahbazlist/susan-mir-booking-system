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
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
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
});


  // Get the elements
  var from_input = $('#startingDate').pickadate(),
    from_picker = from_input.pickadate('picker')
  var to_input = $('#endingDate').pickadate(),
    to_picker = to_input.pickadate('picker')

  // Check if there’s a “from” or “to” date to start with and if so, set their appropriate properties.
  if (from_picker.get('value')) {
    to_picker.set('min', from_picker.get('select'))
  }
  if (to_picker.get('value')) {
    from_picker.set('max', to_picker.get('select'))
  }

  // Apply event listeners in case of setting new “from” / “to” limits to have them update on the other end. If ‘clear’ button is pressed, reset the value.
  from_picker.on('set', function (event) {
    if (event.select) {
      to_picker.set('min', from_picker.get('select'))
    } else if ('clear' in event) {
      to_picker.set('min', false)
    }
  })
  to_picker.on('set', function (event) {
    if (event.select) {
      from_picker.set('max', to_picker.get('select'))
    } else if ('clear' in event) {
      from_picker.set('max', false)
    }
  })
</script>