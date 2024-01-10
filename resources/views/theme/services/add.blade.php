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
          <form action="{{route('admin.services.store')}}" class="" method="post">
            @csrf
            <div class="row form_sec">
              <div class="col-12">
                <h5>Add New Service</h5>
              </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                      <label for="service_title">Service Title <span class="text-danger">*</span></label>
                      <input type="text" name="service_title" class="form-control"  value="{{old('service_title')}}" id="service_title" placeholder="Service Title">
                        @error('service_title') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                      <label for="service_desc">Service Description <span class="text-danger">*</span></label>
                      <textarea id="service_desc" name="service_desc"  class="form-control" >  </textarea>
                      @error('service_desc') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="slot">Total Slot <span class="text-danger">*</span></label>
                    <input type="text" name="slot" class="form-control"  value="{{old('slot')}}" id="slot" placeholder="Ex 10">
                    @error('slot') <div class="text-danger">{{ $message }}</div> @enderror
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="price">Price <span class="text-danger">*</span></label>
                    <input type="text" name="price" class="form-control"  value="{{old('price')}}" id="price" placeholder="Ex 10">
                    @error('price') <div class="text-danger">{{ $message }}</div> @enderror
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
</script>