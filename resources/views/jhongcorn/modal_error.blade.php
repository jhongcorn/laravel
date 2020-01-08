<script>

$(document).ready(function() {
    $("#modalConfirmDelete").on('show.bs.modal', function() {
        var zIndex = 1070;
        $(this).css('z-index', zIndex);
    });


    $("#modalConfirmDelete").on("hidden.bs.modal", function () {
        $(this).removeData("bs.modal");
        $(document.body).addClass("modal-open");  
    });

});



</script>
<!--Modal: modalConfirmDelete-->
<div class="modal fade error" id="modalConfirmDelete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-notify modal-danger " role="document">
    <!--Content-->
    <div class="modal-content text-center ">
      <!--Header-->
      <div class="modal-header d-flex justify-content-center">
        <p class="heading"><i class="fas fa-times fa-4x animated rotateIn text-white"></i></p>
      </div>

      <!--Body-->
      <div class="modal-body">

        
        <span class="h3"></span>

      </div>

      <!--Footer-->
      <div class="modal-footer flex-center">
        <a  class="btn  btn-danger waves-effect" data-dismiss="modal" >確定</a>
      </div>
    </div>
    <!--/.Content-->
  </div>
</div>
<!--Modal: modalConfirmDelete-->