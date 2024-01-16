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
              <div class="col-md-4" style="background-color: darkgray;">
                  <ul class="list-group" >
                    @foreach ($service as $key=>$val)
                        <li class="list-group-item" style="background-color: <?php echo $select == $val['id'] ? '#d2d2a3' :  'beige';?>" >
                            <a href="{{route('admin.slot.index',[$val['id']])}}" class=""> {{$val['service_title']}}</a>
                        </li>
                    @endforeach
                  </ul>
              </div>
              <div class="col-md-8">
                <div id='calendar'></div>  
                {{-- <div id='full_calendar_events'>dd</div> --}}
              </div>
            </div>
          </div>
        </div>
        </form>
      </div>
    </div>
  </div>
  <!-- Basic Modal -->
<div class="modal fade" id="updateServiceSlot" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" style="max-width: 40%;" role="document">
     <div class="modal-content">
        <div class="modal-header">
           <h5 class="modal-title" id="exampleModalLabel">Update Service Slot</h5>
           <button type="button" class="close" data-dismiss="modal" aria-label="Close">
           <span aria-hidden="true">&times;</span>
           </button>
        </div>
        
        <form id="updateServiceSlotForm" enctype="multipart/form-data">
           <div class="modal-body">
            <span class="text-danger" id="errorMsg"></span>
            <div class="form-row">
              <div class="form-group col-md-12">
                 <label for="service_price">Services <b class="text-danger">*</b></label>
                 @foreach ($service as $key=>$val)
                  <div class="form-radio">
                    <input class="form-radio-input" type="radio" value="{{$val['id']}}" name="service" id="service_id{{$val['id']}}" <?php echo $select == $val['id'] ? 'checked' :  '';?>>
                    <label class="form-radio-label" for="service_id{{$val['id']}}">{{$val['service_title']}}</label>
                  </div>
                  @endforeach
              </div>
            </div>
            
              <div class="form-row">
                 <div class="form-group col-md-12">
                    <label for="service_name">Date Rang <b class="text-danger">*</b></label>
                    <input type="text" name="daterange" value="" id="daterange" class="form-control" />
                    <span id="service_nameError" class="msgError"></span>
                 </div>
              </div>
              <div class="form-row">
                  <div class="form-group col-md-12">
                     <label for="update_max_slot">Update Max Slot <b class="text-danger">*</b></label>
                     <input type="text" class="form-control" id="update_max_slot" name="update_max_slot" value="0" maxlength="5">
                     <span id="update_max_slotError" class="msgError"></span>
                  </div>
               </div>

               

           </div>
           <div class="modal-footer">
              <button type="button" class="btn btn-secondary btn-round" data-dismiss="modal">Close</button>
              <div class="saveBtnLoader">
                 <button type="button" class="btn btn-info btn-round updateServiceSlotBtn">Save Changes</button>
              </div>
           </div>
        </form>
     </div>
  </div>
</div>
  @push("scripts")
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>  

{{-- <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script> --}}
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endpush
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<script>
  $(function() {
    $('input[name="daterange"]').daterangepicker({
      opens: 'left'
    }, function(start, end, label) {
      console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
    });
  });
</script>
<script>  
  
  $(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var slots = @json($events);
    var calendar = $('#calendar').fullCalendar({  
        editable: true,
        header: {  
        left: 'prev,next today',  
        center: 'title',  
        right: ''  //month,agendaWeek,agendaDay
        },  
        events:slots,
        selectable:true,
        selectHelper: true,
        select: function(start, end, allDays){
          var selectDate = moment(start).format('YYYY-MM-DD');
          var slectedService = "{{$select}}";
          var startDate = moment(start).format('YYYY-MM-DD');
          var endDate = moment(start).format('YYYY-MM-DD');
          var totalDate = startDate+' - '+endDate;
          $('#daterange').val(totalDate);
          $('#updateServiceSlot').modal('show');
        }
    }); 
    
    //For Change Service
    $(".updateServiceSlotBtn").click(function() {
        var form = $('#updateServiceSlotForm')[0];
        var data = new FormData(form);
        $('#errorMsg').html('');
        if (data) {
            var token = '{{ csrf_token() }}';
            var url = "{{route('admin.slot.update_slot')}}";
            $.ajax({
              type: 'POST',
              url: url,
              data: data,
              processData: false,
              contentType: false,
              cache: false,
              success: function(response) {
                
                if(response.status == 'true'){
                  $('#updateServiceSlot').modal('hide');
                  $("#updateServiceSlotForm")[0].reset();
                  alert(response.msg);
                  window.location.replace("{{route('admin.slot.index',[$select])}}");
                }else{
                  $('#errorMsg').html(response.msg);
                }
              },
            });
          }
      });
     
  });  
   
 </script> 