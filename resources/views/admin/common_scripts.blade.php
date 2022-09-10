<script type="text/javascript">

  function set_js_flashdata(url){
    $.ajax({
      url: url,
      success: function(){}
    });
  }

  function togglePriceFields(elem) {
    if($("#"+elem).is(':checked')){
      $('.paid-course-stuffs').slideUp();
    }else
      $('.paid-course-stuffs').slideDown();
    }
</script>
