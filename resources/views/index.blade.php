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
    <div class="container mt-5" style="max-width: 700px">
        <h2 class="h2 text-center mb-5 border-bottom pb-3">Booking System</h2>
        <div id='full_calendar_events'></div>
    </div>

    <!-- Start popup dialog box -->
<div class="modal fade" id="event_entry_modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modalLabel">Booking</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">�</span>
				</button>
			</div>
			<div class="modal-body">
        <form id="bookingSlotForm">
          <div class="img-container">
            <div class="row">
              <h4>Booking date : <b class="showBookingDate"></b></h4><br>
              <input type="hidden" id="selectedBookingId" name="selectedBookingId">
              <input type="hidden" id="selectedBookingDate" name="selectedBookingDate">
              <div class="col-sm-12">  
                <div class="form-group">
                  <label for="full_name">Full Name</label>
                  <input type="text" name="full_name" id="full_name" class="form-control" placeholder="Enter your full name">
                  <span id="full_nameError" class="msgError"></span>
                </div>
              </div>
              <div class="col-sm-12">  
                <div class="form-group">
                  <label for="email">Email</label>
                  <input type="text" name="email" id="email" class="form-control" placeholder="Enter your email">
                  <span id="emailError" class="msgError"></span>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-6">  
                <div class="form-group">
                  <label for="slot_qty">Slot Qty</label>
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

    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    {{-- <script type="text/javascript">
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      </script> --}}
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
                    var selectDate = moment(event_start).format('YYYY-MM-DD');
                    var event_start = $.fullCalendar.formatDate(event_start, "Y-MM-DD HH:mm:ss");
                    var event_end = $.fullCalendar.formatDate(event_end, "Y-MM-DD HH:mm:ss");
                    $.ajax({
                        // url: SITEURL + "/calendar-crud-ajax",
                        url: "{{route('home.booking.booking_ability')}}",
                        data: {
                            selectDate: selectDate,
                            // event_start: event_start,
                            // event_end: event_end,
                        },
                        type: "POST",
                        success: function (response) {
                          if(response.status == 'true'){
                            $('.showBookingDate').html(response.data.selectedDate);
                            $('#selectedBookingId').val(response.data.selectedDateId);
                            $('#selectedBookingDate').val(response.data.selectedDate);
                            $('#event_entry_modal').modal('show');
                          }else{
                            alert('No Service Available!');
                          }
                          return false
                          alert(response.status);return false;
                            displayMessage("Event created.");
                            calendar.fullCalendar('renderEvent', {
                                id: data.id,
                                title: event_name,
                                start: event_start,
                                end: event_end,
                                allDay: allDay
                            }, true);
                            calendar.fullCalendar('unselect');
                        }
                    });
                },
                eventDrop: function (event, delta) {
                    var event_start = $.fullCalendar.formatDate(event.start, "Y-MM-DD");
                    var event_end = $.fullCalendar.formatDate(event.end, "Y-MM-DD");
                    $.ajax({
                        url: SITEURL + '/calendar-crud-ajax',
                        data: {
                            title: event.event_name,
                            start: event_start,
                            end: event_end,
                            id: event.id,
                            type: 'edit'
                        },
                        type: "POST",
                        success: function (response) {
                            displayMessage("Event updated");
                        }
                    });
                },
                eventClick: function (event) {
                    var eventDelete = confirm("Are you sure?");
                    if (eventDelete) {
                        $.ajax({
                            type: "POST",
                            url: SITEURL + '/calendar-crud-ajax',
                            data: {
                                id: event.id,
                                type: 'delete'
                            },
                            success: function (response) {
                                calendar.fullCalendar('removeEvents', event.id);
                                displayMessage("Event removed");
                            }
                        });
                    }
                }
            });
        });
        function displayMessage(message) {
            toastr.success(message, 'Event');            
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
        function save_booking(){
          alert();
        }

        $("#bookingSlotBtn").click(function (event) {
                event.preventDefault();
                
                $(".msgError").html("");
                var validationCount = 1;
                if($("#full_name").val().trim() == ""){
                    $("#full_nameError").html("<span class='text-danger'>Please enter full name.</span>");
                    var validationCount= 0;     
                }
                // if($("#email").val().trim() == ""){
                //     $("#emailError").html("<span class='text-danger'>Please enter email.</span>");
                //     var validationCount= 0;     
                // }
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