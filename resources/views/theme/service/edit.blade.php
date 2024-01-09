<form id="editServiceForm" enctype="multipart/form-data">
    <input type="hidden" name="id" value="{{$getData->id}}">
    <div class="modal-body">
       <div class="form-row">
          <div class="form-group col-md-12">
             <label for="service_name">Service Name <b class="text-danger">*</b></label>
             <input type="text" class="form-control" id="service_name_edit" name="service_name" maxlength="70" value="{{$getData->service_name}}">
             <span id="service_name_editError" class="msgError"></span>
          </div>
       </div>
       <div class="form-row">
           <div class="form-group col-md-12">
              <label for="service_price">Service Price <b class="text-danger">*</b></label>
              <input type="text" class="form-control" id="service_price_edit" name="service_price" maxlength="50"  value="{{$getData->price}}">
              <span id="service_price_editError" class="msgError"></span>
           </div>
        </div>
    </div>
    <div class="modal-footer">
       <button type="button" class="btn btn-secondary btn-round" data-bs-dismiss="modal">Close</button>
       <div class="saveBtnLoader">
          <button type="button" class="btn btn-info btn-round editServiceBtn">Save Changes</button>
       </div>
    </div>
 </form>