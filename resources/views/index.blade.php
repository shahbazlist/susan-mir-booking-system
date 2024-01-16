<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Booking</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
</head>
<body>
    <div class="container mt-5" >{{-- style="max-width: 700px" --}}
        <h2 class="h2 text-center mb-5 border-bottom pb-3">Booking System</h2>
        <div class="row">
          <div class="col-sm-6">  
            <div id='full_calendar_events'></div>
          </div>
          <div class="col-sm-6">  
            <div class="form-group">
              <div class="view_response">
                
              </div>
              
            </div>
          </div>
        </div>
        
    </div>

    <!-- Start popup dialog box -->
<div class="modal fade" id="event_entry_modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modalLabel">Booking</h5>
              <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
			</div>
			<div class="modal-body">
        <form id="bookingSlotForm">
          <div class="img-container">
            <div class="row">
              <h5>Booking date : <b class="showBookingDate"></b>, Slot: <b class="totalSlot"></b></h5><br>
              <input type="hidden" id="selectedBookingId" name="selectedBookingId">
              <input type="hidden" id="selectedBookingDate" name="selectedBookingDate">
              <div class="col-sm-12">  
                <div class="form-group">
                  <label for="full_name">Full Name <span class="text-danger">*</span></label>
                  <input type="text" name="full_name" id="full_name" class="form-control" placeholder="Enter your full name">
                  <span id="full_nameError" class="msgError"></span>
                </div>
              </div>
              <div class="col-sm-12">  
                <div class="form-group">
                  <label for="email">Email <span class="text-danger">*</span></label>
                  <input type="text" name="email" id="email" class="form-control" placeholder="Enter your email">
                  <span id="emailError" class="msgError"></span>
                </div>
              </div>
              {{-- style="display: none" --}}
              <div class="col-sm-12 timeline_dev" style="display: none">  
                <div class="form-group">
                  <label for="email">TimeLine <span class="text-danger">*</span></label>
                  <select class="form-control" name="time_line" id="time_line">
                    
                  </select>
                  <span id="emailError" class="msgError"></span>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-6">  
                <div class="form-group">
                  <label for="slot_qty">Slot Qty <span class="text-danger">*</span></label>
                  <input type="text" name="slot_qty" id="slot_qty" class="form-control slotPriceCal" placeholder="Ex 5">
                  <span id="slot_qtyError" class="msgError"></span>
                </div>
              </div>
              <div class="col-sm-6">  
                <div class="form-group">
                  <label for="actual_cost">Actual cost(&#8377;)</label>
                  <input type="text" name="actual_cost" id="actual_cost" class="form-control" value="0" readonly placeholder="Actual costs">
                </div>
              </div>
            </div>
            <span id="actual_costError" class="msgError"></span>
          </div>
        </form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary bookingSlotBtn" id="bookingSlotBtn">Book Now</button>
			</div>
		</div>
	</div>
</div>
<!-- End popup dialog box -->
    {{-- Scripts --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    
    <script>
      $(document).on('input', '#slot_qty', function() {
          $(this).val($(this).val().replace(/\D/g, ''))
      });
        $(document).ready(function () {
            var SITEURL = "{{ url('/') }}";
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var calendar = $('#full_calendar_events').fullCalendar({
                editable: true,
                editable: true,
                displayEventTime: true,
                selectable: true,
                selectHelper: true,
                select: function (event_start, event_end, allDay) {
                    var nowDate = moment(new Date()).format('YYYY-MM-DD');
                    var selectDate = moment(event_start).format('YYYY-MM-DD');
                    if(new Date(nowDate) > new Date(selectDate))
                    {
                      return false;
                    }
                    var event_start = $.fullCalendar.formatDate(event_start, "Y-MM-DD HH:mm:ss");
                    var event_end = $.fullCalendar.formatDate(event_end, "Y-MM-DD HH:mm:ss");
                    $('.view_response').html('');
                    $.ajax({
                        url: "{{route('home.booking.booking_ability')}}",
                        data: {
                            selectDate: selectDate,
                        },
                        type: "POST",
                        success: function (response) {
                          if(response.status == 'true'){
                            $('.view_response').html(response.data);
                          }else{
                            $('.view_response').html(response.data);
                          }
                        }
                    });
                },
            });
        });
        function choseBook(id){
          $(".msgError").html("");
          $("#bookingSlotForm")[0].reset();
          if (id) {
            $.ajax({
                type: "POST",
                url: "{{route('home.booking.chosebook')}}",
                data: {
                    id: id,
                },
                success: function (response) {
                  if(response.status == 'true'){
                    $('#selectedBookingId').val(response.data.selectedDateId);
                    $('#selectedBookingDate').val(response.data.selectedDate);
                    $('.totalSlot').html(response.data.slot);
                    $('.showBookingDate').html(response.data.selectedDate);
                    
                    if(response.data.time_line != ''){
                      $('.timeline_dev').show();
                      // $(".timeline_dev").removeAttr("style").hide();
                      $('#time_line').html(response.data.time_line);
                    }else{
                      $('.timeline_dev').hide();
                    }
                    $('#event_entry_modal').modal('show');
                  }
                }
            });
          }else{
            alert('Something went wrong!');
          }
        }
        
        $('.slotPriceCal').on('input',function(e){
          $(".bookingSlotBtn").removeAttr("disabled");
         var slotQty = this.value;
         if(slotQty == ""){
          $('#actual_cost').val(0);
         }
         var bookId = $('#selectedBookingId').val();
         if(slotQty != "" && bookId != "" && $.isNumeric(slotQty)){
          $('#actual_cost').val(0);
             $.ajax({
        				url: "{{route('home.booking.price_cal')}}",
        				type: 'POST',
        				data:{ 'slotQty': slotQty, 'bookId': bookId},
        				success:function(response) {
                  if(response.status == 'true'){
                    $('#actual_cost').val(response.data);
                  }else if(response.status == 'false'){
                    $(".bookingSlotBtn").attr("disabled", true);
                    alert(response.msg);
                  }else{
                    // $("#register_btn").attr("disabled", true);
                    // $("#bookingSlotBtn").removeAttr("disabled");
                    alert('Something went wrong!');
                  }
        				},
        		});
         }
    });

        $("#bookingSlotBtn").click(function (event) {
                event.preventDefault();
                
                $(".msgError").html("");
                var validationCount = 1;
                if($("#full_name").val().trim() == ""){
                    $("#full_nameError").html("<span class='text-danger'>Please enter full name.</span>");
                    var validationCount= 0;     
                }
                if($("#email").val().trim() == ""){
                    $("#emailError").html("<span class='text-danger'>Please enter email.</span>");
                    var validationCount= 0;     
                }
                if($("#slot_qty").val().trim() == ""){
                    $("#slot_qtyError").html("<span class='text-danger'>Please enter slot qty.</span>");
                    var validationCount= 0;     
                }
                if($("#actual_cost").val().trim() == ""){
                    $("#actual_costError").html("<span class='text-danger'>Something went wrong!</span>");
                    var validationCount= 0;     
                }
                
                if(validationCount == 1){
                    var form = $('#bookingSlotForm')[0];
                    var data = new FormData(form);
                    $("#bookingSlotBtn").prop("disabled", true);
                    $.ajax({
                        type: "POST",
                        enctype: 'multipart/form-data',
                        url: "{{route('home.booking.booking')}}",
                        data: data,
                        processData: false,
                        contentType: false,
                        cache: false,
                        timeout: 800000,
                        success: function (response) {
                          if(response.status == false){
                            $(".bookingSlotBtn").removeAttr("disabled");
                              $.each( response.msg, function( key, value ) {
                                  $('#'+key+'Error').html('<span class="text-danger">'+value+'</span>');
                              });
                          }

                          if(response.status == 'true'){
                            $("#bookingSlotForm")[0].reset();
                            alert(response.msg);
                            location.reload();
                          }

                        },
                        error: function (e) {
                          $(".bookingSlotBtn").removeAttr("disabled");
                          alert('something went wrong');
                        }
                      });
                  }

                });

        
    </script>
</body>
</html>