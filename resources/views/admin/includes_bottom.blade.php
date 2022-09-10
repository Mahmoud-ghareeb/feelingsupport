<!-- bundle -->
<script src="{{ asset('assets/backend/js/app.min.js'); }}"></script>
<!-- third party js -->
<script src="{{ asset('assets/backend/js/vendor/Chart.bundle.min.js'); }}"></script>
<script src="{{ asset('assets/backend/js/vendor/jquery-jvectormap-1.2.2.min.js'); }}"></script>
<script src="{{ asset('assets/backend/js/vendor/jquery-jvectormap-world-mill-en.js'); }}"></script>
<script src="{{ asset('assets/backend/js/vendor/jquery.dataTables.min.js'); }}"></script>
<script src="{{ asset('assets/backend/js/vendor/dataTables.bootstrap4.js'); }}"></script>
<script src="{{ asset('assets/backend/js/vendor/dataTables.responsive.min.js'); }}"></script>
<script src="{{ asset('assets/backend/js/vendor/responsive.bootstrap4.min.js'); }}"></script>
<script src="{{ asset('assets/backend/js/vendor/dataTables.buttons.min.js'); }}"></script>
<script src="{{ asset('assets/backend/js/vendor/buttons.bootstrap4.min.js'); }}"></script>
<script src="{{ asset('assets/backend/js/vendor/buttons.html5.min.js'); }}"></script>
<script src="{{ asset('assets/backend/js/vendor/buttons.flash.min.js'); }}"></script>
<script src="{{ asset('assets/backend/js/vendor/buttons.print.min.js'); }}"></script>
<script src="{{ asset('assets/backend/js/vendor/dataTables.keyTable.min.js'); }}"></script>
<script src="{{ asset('assets/backend/js/vendor/dataTables.select.min.js'); }}"></script>
<script src="{{ asset('assets/backend/js/vendor/summernote-bs4.min.js'); }}"></script>
<script src="{{ asset('assets/backend/js/vendor/fullcalendar.min.js'); }}"></script>
<script src="{{ asset('assets/backend/js/pages/demo.summernote.js'); }}"></script>
<script src="{{ asset('assets/backend/js/vendor/dropzone.js'); }}"></script>
<script src="{{ asset('assets/backend/js/pages/datatable-initializer.js'); }}"></script>
<script src="{{ asset('assets/backend/js/font-awesome-icon-picker/fontawesome-iconpicker.min.js'); }}" charset="utf-8"></script>
<script src="{{ asset('assets/backend/js/vendor/bootstrap-tagsinput.min.js');}}" charset="utf-8"></script>
<script src="{{ asset('assets/backend/js/bootstrap-tagsinput.min.js'); }}"></script>
<script src="{{ asset('assets/backend/js/vendor/dropzone.min.js');}}" charset="utf-8"></script>
<script src="{{ asset('assets/backend/js/ui/component.fileupload.js');}}" charset="utf-8"></script>
<script src="{{ asset('assets/backend/js/pages/demo.form-wizard.js'); }}"></script>
<!-- dragula js-->
<script src="{{ asset('assets/backend/js/vendor/dragula.min.js'); }}"></script>
<!-- component js -->
<script src="{{ asset('assets/backend/js/ui/component.dragula.js'); }}"></script>

<!-- Jquery form -->
<script src="{{ asset('assets/global/jquery-form/jquery.form.min.js'); }}"></script>

<script src="{{ asset('assets/backend/js/custom.js');}}"></script>

<script type="text/javascript">
  $(document).ready(function() {
    $(function() {
       $('.icon-picker').iconpicker();
     });
  });
</script>

<!-- Toastr and alert notifications scripts -->
<script type="text/javascript">
function notify(message) {
  $.NotificationApp.send("heads up!", message ,"top-right","rgba(0,0,0,0.2)","info");
}

function success_notify(message) {
  $.NotificationApp.send("congratulations!", message ,"top-right","rgba(0,0,0,0.2)","success");
}

function error_notify(message) {
  $.NotificationApp.send("oh snap!", message ,"top-right","rgba(0,0,0,0.2)","error");
}

function error_required_field() {
  $.NotificationApp.send("oh snap!", "please fill all the required fields" ,"top-right","rgba(0,0,0,0.2)","error");
}
</script>
@if (Session::has('info_message'))
    <script>
        $(document).ready(function(){
          $.NotificationApp.send("success!", '{{ Session::get("info_message") }}' ,"top-right","rgba(0,0,0,0.2)","info");
        });
        
    </script>
@endif
@if (Session::has('error_message'))
    <script>
        $(document).ready(function(){
          $.NotificationApp.send("oh snap!", '{{ Session::get("error_message") }}' ,"top-right","rgba(0,0,0,0.2)","info");
        });
        
    </script>
@endif
@if (Session::has('flash_message'))
    <script>
        $(document).ready(function(){
          $.NotificationApp.send("congratulations!", '{{ Session::get("flash_message") }}' ,"top-right","rgba(0,0,0,0.2)","info");
        });
        
    </script>
@endif
