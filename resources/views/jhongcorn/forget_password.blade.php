<script>
  var forget_email_flag=forget_phone_flag=forget_birthday_flag=new_password_value_flag=re_new_password_value_flag=false;
  $(function(){
    $("#modalRegisterForm").on("hidden.bs.modal",function(){
      $("#modalRegisterForm input").removeClass("border border-danger");
      $("#modalRegisterForm input").removeClass("valid");
      $("#modalRegisterForm input").removeClass("invalid");
      $("#modalRegisterForm input").val("");
      $("#modalRegisterForm label,i").removeClass("active");
    });

    $("#modalLoginAvatar").on("hidden.bs.modal",function(){
      $("#modalLoginAvatar input").removeClass("border border-danger");
      $("#modalLoginAvatar input").removeClass("valid");
      $("#modalLoginAvatar input").removeClass("invalid");
      $("#modalLoginAvatar input").val("");
      $("#modalLoginAvatar label,i").removeClass("active");
    });    
    $("#forget_email").bind("change",function(){
      forget_email_flag=emailbind(this.id,this.value);
    });

    $("#forget_phone").bind("change",function(){
      forget_phone_flag=Phonebind(this.id,this.value);
    });

    $( "#forget_birthday" ).datepicker({
      yearRange:"-100:+0",
      dateFormat: 'yy-mm-dd',
      changeMonth:true,
      changeYear:true,
      maxDate:new Date(),
    });

    $("#forget_birthday").bind("change",function(){
      if(this.value!=""){
        forget_birthday_flag=true;
        $(this).removeClass("border border-danger");
      }else{
        $(this).addClass("border border-danger");
        forget_birthday_flag=false;
      }
    });
    
    $("#new_password_value").bind("change",function(){
      new_password_value_flag=regpassword(this.id,this.value);
    });

    $("#re_new_password_value").bind("change",function(){
      re_new_password_value_flag=repassword(this.id);
    });
  });

  function forget(){         
            
    if(forget_email_flag && forget_phone_flag && forget_birthday_flag){
     
      $.ajax({
        url: '/user/forget_password',
        type: 'POST',
        dataType: 'text',
        data:{forget_email:$("#forget_email").val(),forget_phone:$("#forget_phone").val(),forget_birthday:$("#forget_birthday").val(),_token:'{{ csrf_token() }}' },
        success:function(data){
          if(data){
            $("#modalLoginAvatar").modal("show");
            $("#forget_close").trigger("click");
            console.log(data[0]['picture']);
            if(data[0]['picture']){    
               $("#modalLoginAvatar .modal-header").html('<img src="'+data[0]['picture']+'" id="new_password_photo"  class="rounded-circle img-responsive">');
              console.log('aaa');
             }else{
                $("#modalLoginAvatar .modal-header").append('<div  class="border rounded-circle bg-info modal_up_img pt-4" id="#modal-header"><i class="fas fa-user-edit"></i></div>');
                $("#modalLoginAvatar .modal-header").addClass('mb-5 p-5');
             }
                $("#new_password_name").text(data[0]['Name']);
                 $("#new_password_name").attr('data-Name',data[0]['name']);
                $("#new_password_name").attr("customer_id",data[0]['id']);
                $("#new_password_name").attr("oauth_id",data[0]['provider_id']);
          
          }else{
            $('#modalConfirmDelete').modal('show');
            $('#modalConfirmDelete span').html('請重新輸入');
          }
          
        },
        error:function(data){
          console.log(data);
          alert("請重新輸入")},
      });
    }else{
      $('#modalConfirmDelete').modal("show");
      $('#modalConfirmDelete span').html('未輸入完全');
      if($("#forget_birthday").val()==""){
        $("#forget_birthday").addClass("border border-danger");
      }else{
        $("#forget_birthday").removeClass("border border-danger");
      }

      if($("#forget_email").val()==""){
        $("#forget_email").addClass("border border-danger");
      }else{
        $("#forget_email").removeClass("border border-danger");
      }

      if($("#forget_phone").val()==""){
        $("#forget_phone").addClass("border border-danger");
      }else{
        $("#forget_phone").removeClass("border border-danger");
      }      
    }
  }

  function new_password_submit(){
    if(new_password_value_flag && re_new_password_value_flag){
      $.ajax({
        url: '/user/new_password',
        type: 'POST',
        dataType: 'json',
        data: {_token:'{{ csrf_token() }}',item:'userinfo_Customer_Password',value:$("#new_password_value").val(),id: $("#new_password_name").attr("customer_id"),OAuth_Id:$("#new_password_name").attr("oauth_id")},
        success:function(data){
          if(data==$("#new_password_name").attr("data-Name")){
            alert("已變更成功,請使用新密碼登入");
            window.location.replace("logout.php");        
          }else{
            $('#modalConfirmDelete').modal('show');
            $('#modalConfirmDelete span').html('請重新輸入');
          }
          
        },
        error:function(data){//alert("請重新輸入");
      console.log(data);
      },
      });
    }else{
      if( $("#new_password_value").val()=="" || $("#re_new_password_value").val()==""){
        $('#modalConfirmDelete').modal('show');
        $('#modalConfirmDelete span').html('未輸入完全');
        if($("#new_password_value").val()==""){
          $("#new_password_value").addClass("border border-danger");
        }else{
          $("#new_password_value").removeClass("border border-danger");
        }


        if($("#re_new_password_value").val()==""){
          $("#re_new_password_value").addClass("border border-danger");
        }else{
          $("#re_new_password_value").removeClass("border border-danger");
        }

      }

    }
  }
</script>
<style>

  .modal_up_img{
        position:absolute;
        font-size: 50px;
        top:-70px;
        left:50%;
        transform: translateX(-50%);

        height:130px;
        width:130px;

  }
</style>
<div class="modal fade" id="modalRegisterForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header text-center purple-gradient">
        <h4 class="modal-title w-100 font-weight-bold">忘記密碼</h4>
        <button type="button" id="forget_close" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body mx-3">
    
        <div class="md-form mb-5">
          <i class="fas fa-envelope prefix "></i>
          <input type="email" id="forget_email" neme="forget_email" placeholder="XXX@gmail.com" class="form-control validate">
        </div>
        <div class="md-form mb-5">
          <i class="fas fa-phone prefix "></i>
          <input type="text" id="forget_phone" neme="forget_phone" placeholder="09XXXXXXXX or 04XXXXXXXX" class="form-control validate">
        </div>
        <div class="md-form mb-4">
          <i class="fas fa-lock prefix "></i>
          <input type="text" id="forget_birthday" neme="forget_birthday" class="form-control " placeholder="出生年月日" readonly>
        </div>          
         


        <div class="modal-footer d-flex justify-content-center">
          <a class="btn purple-gradient" onclick="forget();"><i class="fas fa-user-lock"></i></a>
        </div> 
      </div>

    </div>
  </div>
</div>

<!--Modal: Login with Avatar Form-->
<div class="modal fade" id="modalLoginAvatar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"  aria-hidden="true">
  <div class="modal-dialog cascading-modal modal-avatar modal-sm" role="document">
    <!--Content-->
    <div class="modal-content">

      <!--Header-->
      <div class="modal-header" >
      </div>
      <!--Body-->

      <div class="modal-body">
        
        <h5 class=" text-center" id="new_password_name"></h5>
         
        <div class="md-form ">
          <i class="fas fa-lock-open prefix"></i>
          <input type="password" type="text" id="new_password_value" class="form-control form-control-sm validate ">
          <label  for="new_password_value" >輸入密碼</label>
        </div>
        <div class="md-form">
          <i class="fas fa-lock-open prefix"></i>
          <input type="password" type="text" id="re_new_password_value" class="form-control form-control-sm validate ">
          <label  for="re_new_password_value" >再次輸入密碼</label>
        </div>
        <p class=" pt-1  passwordbtn col-12" style="font-size: 1vw;">需8~12位數，並且至少包含字母、數字、符號各一</p>
        <div class="text-center mt-4">
          <a class="btn btn-cyan" onclick="new_password_submit();"><i class="fas fa-user-lock"></i></a>
          <a  class="btn btn-outline-info "  data-dismiss="modal">CLOSE</a>
        </div>

      </div>

    </div>
    <!--/.Content-->
  </div>
</div>
<!--Modal: Login with Avatar Form-->
