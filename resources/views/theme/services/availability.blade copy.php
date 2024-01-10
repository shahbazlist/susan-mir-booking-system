@extends('theme.layouts.app')
@section('content')
  <div class="container-fluid px-5">
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
        @if(session('error'))
          <div class="alert alert-danger">
          {{session('error')}}
          </div>
        @endif
      </div>

      <div class="col-md-12 form_page">
        <form action="" class="" method="post">
        @csrf
        
        <div class="card">
          <div class="card-body">
            <div class="row form_sec">
              <div class="col-12"><h5>Basic Details</h5></div>
            </div>
            <div class="row">
              <div class="col-md-3" style="background-color: darkgray;">
                <ul class="list-group" >
                    <li class="list-group-item" style="background-color: beige;">Cras justo odio</li>
                    <li class="list-group-item" style="background-color: beige;">Dapibus ac facilisis in</li>
                    <li class="list-group-item" style="background-color: beige;">Morbi leo risus</li>
                    <li class="list-group-item" style="background-color: beige;">Porta ac consectetur ac</li>
                    <li class="list-group-item" style="background-color: beige;">Vestibulum at eros</li>
                  </ul>
              </div>
              <div class="col-md-6">
                <div id='full_calendar_events'></div>
              </div>
            </div>
          </div>
        </div>
        <br />

        {{-- <div class="card">
          <div class="card-body">
            <div class="row form_sec">
              <div class="col-12"><h5>Set Password</h5></div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="new_password">New Password</label>
                  <input type="password" name="password" class="form-control" id="new_password" aria-describedby="new_passwordHelp">
                  <small id="new_passwordHelp" class="form-text text-muted"></small>
                </div>
              </div>
            </div>
          </div>
        </div> --}}
        <br />
        <br />
        <div class="row">
          <div class="col-md-12">
            <button type="submit" class="btn btn-primary add_site">
                Update Changes
            </button>
          </div>
        </div>
        </form>
      </div>
    </div>
  </div>
@endsection
