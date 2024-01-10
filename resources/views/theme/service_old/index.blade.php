@extends('theme.layouts.app')
@section('content')

<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="message"></div>
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
              <a class="btn btn-primary ml-2" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#addService">Add New</a>
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
                <th>Service Price</th>
                <th>Date Created</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($data as $key=>$v)
              <tr>
                <td>{{ ++$key }}</td>
                <td>{{ $v->service_name }}</td>
                <td>{{ $v->price }}</td>
                <td>{{ Date('d M, Y',strtotime($v->created_at)) }}</td>
                <td>
                  <a href="javascript:void(0);" onclick="editData({{$v->id}})" class="btn btn-primary btn-sm">Edit</a>
                  {{-- <a href="javascript:void(0);" data-id="{{ $v->id }}" class="btn btn-danger btn-sm trash_btn delete{{ $v->id }}">Trash</a> --}}
                  
                </td>
              </tr>

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
<!-- Basic Modal -->
<div class="modal fade" id="addService" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 40%;" role="document">
       <div class="modal-content">
          <div class="modal-header">
             <h5 class="modal-title" id="exampleModalLabel">Add Service</h5>
             <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
             <span aria-hidden="true">&times;</span>
             </button>
          </div>
          <form id="addServiceForm" enctype="multipart/form-data">
             <div class="modal-body">
                <div class="form-row">
                   <div class="form-group col-md-12">
                      <label for="service_name">Service Name <b class="text-danger">*</b></label>
                      <input type="text" class="form-control" id="service_name" name="service_name" maxlength="70">
                      <span id="service_nameError" class="msgError"></span>
                   </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-12">
                       <label for="service_price">Service Price <b class="text-danger">*</b></label>
                       <input type="text" class="form-control" id="service_price" name="service_price" maxlength="50">
                       <span id="service_priceError" class="msgError"></span>
                    </div>
                 </div>
             </div>
             <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-round" data-bs-dismiss="modal">Close</button>
                <div class="saveBtnLoader">
                   <button type="button" class="btn btn-info btn-round addServiceBtn">Save Changes</button>
                </div>
             </div>
          </form>
       </div>
    </div>
 </div>

 {{-- Edit Form --}}
 <div class="modal fade" id="editService" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" style="max-width: 40%;" role="document">
     <div class="modal-content">
        <div class="modal-header">
           <h5 class="modal-title" id="exampleModalLabel">Edit Service</h5>
           <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
           <span aria-hidden="true">&times;</span>
           </button>
        </div>
        <div id="editContent"></div>
     </div>
  </div>
</div>

@push("scripts")
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    </script>
<script type="text/javascript">
    
    $(document).on("click",".addServiceBtn",function() {
            $(".msgError").html("");
            var validationCount = 1;
                if($("#service_name").val().trim() == ""){
                    $("#service_nameError").html("<span class='text-danger'>Please enter service name.</span>");
                    var validationCount= 0;     
                }
            if($("#service_price").val().trim() == ""){
                    $("#service_priceError").html("<span class='text-danger'>Please add the service price.</span>");
                    var validationCount= 0;     
                }
            
            if(validationCount == 1){
                event.preventDefault();
                // var formData=$("#addServiceForm").serializeArray();
                var formData = new FormData($('#addServiceForm')[0]);
                $.ajax({
                    url: "{{route('admin.service.store')}}",
                    type: 'POST',
                        data: formData,
                        mimeType: "multipart/form-data",
                        contentType: false,
                        cache: false,
                        processData: false,
                    beforeSend: function () {
                        $('.saveBtnLoader').html(' <button type="button" class="btn btn-info btn-round" disabled>Save Changes</button>');
                        },
                    success:function(response) {
                        response = JSON.parse(response);
                        $('.saveBtnLoader').html(' <button type="button" class="btn btn-info btn-round addServiceBtn">Save Changes</button>');
                        if(response.status == false){
                            $.each( response.msg, function( key, value ) {
                                $('#'+key+'Error').html('<span class="text-danger">'+value+'</span>');
                            });
                        }
                        if (response.status == 200) {
                            $(".message").html('<div class="alert alert-success">'+response.message+'</div>');
                            $('#addService').modal('hide');
                            $("#addServiceForm")[0].reset();
                            setTimeout(function(){
                              location.reload();
                              }, 5000);
                            
                        }
                    },
                });
            }
   		});
       
       $(document).on("click",".editServiceBtn",function() {
            $(".msgError").html("");
            var validationCount = 1;
              if($("#service_name_edit").val().trim() == ""){
                  $("#service_name_editError").html("<span class='text-danger'>Please enter service name.</span>");
                  var validationCount= 0;     
              }
            if($("#service_price_edit").val().trim() == ""){
                    $("#service_price_editError").html("<span class='text-danger'>Please add the service price.</span>");
                    var validationCount= 0;     
                }
            if(validationCount == 1){
                event.preventDefault();
                var formData = new FormData($('#editServiceForm')[0]);
                $.ajax({
                    url: "{{route('admin.service.update')}}",
                    type: 'POST',
                        data: formData,
                        mimeType: "multipart/form-data",
                        contentType: false,
                        cache: false,
                        processData: false,
                    beforeSend: function () {
                        $('.saveBtnLoader').html(' <button type="button" class="btn btn-info btn-round" disabled>Save Changes</button>');
                        },
                    success:function(response) {
                        response = JSON.parse(response);
                        $('.saveBtnLoader').html(' <button type="button" class="btn btn-info btn-round editServiceBtn">Save Changes</button>');
                        if(response.status == false){
                            $.each( response.msg, function( key, value ) {
                                $('#'+key+'Error').html('<span class="text-danger">'+value+'</span>');
                            });
                        }
                        if (response.status == 200) {
                            $(".message").html('<div class="alert alert-success">'+response.message+'</div>');
                            $('#editService').modal('hide');
                            $("#editServiceForm")[0].reset();
                            setTimeout(function(){
                              location.reload();
                              }, 5000);
                            
                        }
                    },
                });
            }
   		});

      // Edit
   		function editData(id){
        if(id !="") {
            $.ajax({
                url: "{{route('admin.service.edit')}}",
                type: "GET",
                data: {'id':id},
                success: function (response) {
                    if(response.success==true) {
                        $('#editService').modal('show');
                        $('#editContent').html(response.html);
                    } 
                }
            });
        }
      }
</script>
@endpush
@endsection