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