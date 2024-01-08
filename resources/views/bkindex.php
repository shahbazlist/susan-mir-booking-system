<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css"
    />

    <style>
      .slotContainer {
        display: none;
      }
      .slotContainer.show {
        display: block;
      }
    </style>
  </head>
  <body>
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <div id="calendar">
            <div class="placeholder"></div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="slotContainer">
            <br>
            <h3 class="input-group">Service Book</h3>
            <p class="input-group">Jan 10, 2024</p>
            <hr>
            <div class="date-selector d-flex clearfix">
                <div class="option">
                    <p class="pickup">Start at 6:30 am</p>
                    <p class="arrival">End at 12:00 pm</p>
                </div>
                <div class="option-selector">
                    <a class="button choose-date primary float-right">Choose</a>
                </div>
            </div>

          </div>
        </div>
      </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
      var flatpickr = $("#calendar .placeholder").flatpickr({
        inline: true,
        minDate: "today",
        disableMobile: "false",
        onChange: function (date, str, inst) {
            var url = '{{url('/')}}/booking';
            var token = '{{ csrf_token() }}';
           
                $.ajax({
                  type: 'POST',
                  url: url,
                  data: {
                    _token: token,
                    date: date,
                  },
                  dataType: 'JSON',
                  success: function(resp) {
                    alert(resp);return false;
                    var res_msg = "Items are trashed successfully.";
                    swal(res_msg, {
                      icon: "success",
                    }).then(function() {
                      location.reload();
                    });
                  },

                });
          $(".slotContainer").addClass("show");
        },
      });
    </script>
  </body>
</html>
