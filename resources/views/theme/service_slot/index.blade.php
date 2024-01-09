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
          
          <div class="float-left">
            <input type="hidden" name="page_number" id="page_number" class="page_number" value="">
            <div class="input-group mb-3 pr-2">
              <input type="text" class="form-control search" name="search" id="search" placeholder="Search by Name">
            </div>
          </div>
          <button class="btn btn-primary pl-2 search_data">Search</button>
    
          <div class="float-right">
            <div class="input-group mb-3">
              
              <a class="btn btn-primary ml-2" href="{{route('admin.service_slot.create')}}">Add New</a>
            </div>
          </div>
        </div>
        <div class="card-body p-0">
          @if(isset($data) && count($data)>0)
          
          <table class="table table-hover">
            <thead>
              <tr>
                <th>S.R</th>
                <th>Service Name</th>
                <th>Service Date</th>
                <th>Total Slot</th>
                <th>Date Created</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              @foreach($data as $key=>$v)
              <tr class="row_{{ $v->id }}">
                <td>{{ ++$key }}</td>
                <td>{{ $v->service->service_name }}</td>
                <td>{{ Date('d M, Y',strtotime($v->service_date)) }}</td>
                <td>{{ $v->slot }}</td>
                <td>{{ Date('d M, Y',strtotime($v->created_at)) }}</td>
                <td>
                  <a href="{{route('admin.service_slot.edit',[$v->id])}}" class="btn btn-primary btn-sm">Edit</a>
                  <a href="#" data-id="{{ $v->id }}" class="btn btn-danger btn-sm trash_btn delete{{ $v->id }}">Trash</a>
                  
                </td>
              </tr>
              <?php //$page_number++ ?>

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