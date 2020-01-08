<script>
	var login_Email_flag=login_password_flag=false;

	$(function(){
		$("#modalLRForm").on("hidden.bs.modal",function(){
			$("#modalLRForm input").removeClass("border border-danger");
			$("#modalLRForm input").removeClass("valid");
			$("#modalLRForm input").val("");
			$("#modalLRForm #form1 select").removeClass("border border-danger");
			$("modalLRForm #form1 #map_city option[value='']").attr('selected','selected');
			$("#modalLRForm label").removeClass("active");
			$("#modalLRForm i").removeClass("active");
		});
		$("#login_Email").bind("change",function(){
			login_Email_flag=emailbind(this.id,this.value);
		});
		$("#login_password").bind("change",function(){
			login_password_flag=regpassword(this.id,this.value);
		});
		$("#btnpanel8").bind("click",function(){
			$("#login_Email").val("");
			$("label[for=login_Email]").removeClass("active");
			$("#login_password").val("");
			$("label[for=login_password]").removeClass("active");
			$("#form2 i").removeClass("active");
		});

		$("#btnpanel7").bind("click",function(){
			$("#form1 input").removeClass("valid");
			$("#form1 input").removeClass("border border-danger");
			$("#form1 select").removeClass("border border-danger");
			$("#form1 #map_city option[value='']").attr('selected','selected');
			$("#form1 input").val("");
			$("#form1 label").removeClass("active");
			$("#form1 i").removeClass("active");
		});			
	});

	
	function panelpanel7(){
	
		$("#btnpanel7").trigger('click');
	}
	function panelpanel8(){

		$("#btnpanel8").trigger('click');
	}

	function signin(){

		if(login_password_flag && login_Email_flag){
			$.ajax({
				url: '/user/login',
				type: 'POST',
				dataType: 'text',
				data: $("#form2").serialize(),
				success:function(data){
					if(data){
						location.reload();
					}else{
						$('#modalConfirmDelete').modal('show');
						$('#modalConfirmDelete span').html('登入失敗');
					}
					
				},
				error:function(){alert("error")},
			});
		}else{
			if($("#login_Email").val()!="" && $("#login_password").val()!=""){

				$('#modalConfirmDelete').modal('show');
				$('#modalConfirmDelete span').html('格式不正確');
			}else{
				$('#modalConfirmDelete').modal('show');
				$('#modalConfirmDelete span').html('請輸入帳號密碼');
			}

		}		
	}

	function signup(){
		
		if(nameflag && phoneflag && emailflag && passwordflag && repasswordflag && birthdayflag &&laneflag && alleyflag&& numflag){
			var addr=Addrsum(id1,id2,id3,id_str+"Addr_");
			$("#addr").val(addr);
			$.ajax({
				url: '/user/register',
				type: 'POST',
				dataType: 'text',
				data: $("#form1").serialize(),
				success:function(data){
					console.log(data);
					if(data){
						alert('註冊成功');
						location.reload();
					}else{
						alert('註冊失敗');
					}
					
				},
				error:function(){alert("error")},
			});
		}else{

			$('#modalConfirmDelete').modal('show');
			$('#modalConfirmDelete span').html('未輸入完全');
			numflag?$("#Customer_Addr_num").removeClass("border border-danger"):$("#Customer_Addr_num").addClass("border border-danger");

			phoneflag?$("#Customer_phone").removeClass("border border-danger"):$("#Customer_phone").addClass("border border-danger");

			emailflag?$("#Customer_email").removeClass("border border-danger"):$("#Customer_email").addClass("border border-danger");

			if($("#Customer_First_Name").val()!=""){
				$("#Customer_First_Name").removeClass("border border-danger");
			}else{
				$("#Customer_First_Name").addClass("border border-danger");
			}

			if($("#Customer_Last_Name").val()!=""){
				$("#Customer_Last_Name").removeClass("border border-danger");
			}else{
				$("#Customer_Last_Name").addClass("border border-danger");
			}

			if($("#"+id1).val()==""){
				$("#"+id1).addClass("border border-danger");
			}else{
				$("#"+id1).removeClass("border border-danger");
			}

			if($("#"+id2).val()==""){
				$("#"+id2).addClass("border border-danger");
			}else{
				$("#"+id2).removeClass("border border-danger");
			}	

			if($("#"+id3).val()==""){
				$("#"+id3).addClass("border border-danger");
			}else{
				$("#"+id3).removeClass("border border-danger");
			}					
			passwordflag?$("#Customer_password").removeClass("border border-danger"):$("#Customer_password").addClass("border border-danger");
			repasswordflag?$("#re_Customer_password").removeClass("border border-danger"):$("#re_Customer_password").addClass("border border-danger");
			birthdayflag?$("#Customer_birthday").removeClass("border border-danger"):$("#Customer_birthday").addClass("border border-danger");
		}

	
	}

	function forget_password(){

		$("#modalRegisterForm").modal();
		$("#login_close").trigger('click');
	
	}
</script>
<script>
	var id1="map_city";
	var id2="map_region";
	var id3="map_street";
	var id_str="Customer_";
	var nameflag=phoneflag=emailflag=passwordflag=repasswordflag=birthdayflag=numflag=false;
	var laneflag=alleyflag=true;
	
	$(function(){

		map(id1);
		$("#"+id1).change(function(){
			map_city($("#"+id1).find(':selected').data('id'),id2,id3);
		});
		$("#"+id2).change(function(){
			map_region($("#"+id2).find(':selected').data('id'),id1,id2,id3);
		});
		
		$( "#Customer_birthday" ).datepicker({
			yearRange:"-100:+0",
			 dateFormat: 'yy-mm-dd',
			changeMonth:true,
			changeYear:true,
 			maxDate:new Date(),
		});
			
	  
		$("#"+id_str+"First_Name").bind("change",function(){
			
			reg_nameapi(this.id);
		});				
		$("#"+id_str+"Last_Name").bind("change",function(){
				
			reg_nameapi(this.id);
		});				
		$("#"+id_str+"phone").bind("change",function(){
				
			reg_phoneapi(this.id);
		});	

		
		$("#"+id_str+"email").bind("change",function(){
				
			reg_emailapi(this.id);
		});	
		$("#"+id_str+"password").bind("change",function(){
			
			reg_passwordapi(this.id);
		});	
		$("#re_"+id_str+"password").bind("change",function(){	
			
			reg_repasswordapi(this.id);
		});	
		$("#re_"+id_str+"password").bind("change",function(){	
			if($("#"+id_str+"password").val()==""){
				$(".md-form #"+id_str+"password").addClass('border border-danger');
				$('#modalConfirmDelete').modal('show');
				$('#modalConfirmDelete span').html('密碼未輸入');
			}

		});		

		$("#"+id1).bind("change",function(){
			
			citybind();
		});	
		$("#"+id2).bind("change",function(){
			
			citybind();
		});
		$("#"+id3).bind("change",function(){
				
			citybind();
		});

		$("#"+id_str+"Addr_lane").bind("input propertychange",function(){	
			laneapi(this.id);
			citybind();
		});
		$("#"+id_str+"Addr_alley").bind("input propertychange",function(){	
			alleyapi(this.id);
			citybind();
		});
		$("#"+id_str+"Addr_num").bind("input propertychange",function(){
			$(this).prop("required", true);	
			numapi(this.id);
			citybind();
		});
		$("#"+id_str+"birthday").bind("change",function(){
			
			reg_birthdayapi(this.id);
		});						
	});

	function citybind(){
		var city=$("#"+id1);
		var region=$("#"+id2);
		var street=$("#"+id3);
		if(city.val()=="" && region.val()=="" &&street.val()==""){
			$('#modalConfirmDelete').modal('show');
			$('#modalConfirmDelete span').html('地址資料沒選擇');
			laneflag=false;
			alleyflag=false;
			numflag=false;			
		}else{
			if(city.val()=="" || region.val()=="" || street.val()==""){
				city.addClass('border border-danger');
				region.addClass('border border-danger');
				street.addClass('border border-danger');
			}
		}

		if(city.val()==""){
			city.addClass('border border-danger');
		}else{
			city.removeClass('border border-danger');
		}
		if(region.val()==""){
			region.addClass('border border-danger');
		}else{
			region.removeClass('border border-danger');
		}
		if(street.val()==""){
			street.addClass('border border-danger');
		}else{
			street.removeClass('border border-danger');
		}
	}

	function laneapi(id){
		laneflag=regAddr(id,$("#"+id).val());
	}

	function alleyapi(id){
		alleyflag=regAddr(id,$("#"+id).val());
	}

	function numapi(id){
		numflag=regAddr(id,$("#"+id).val());
	}

	function reg_nameapi(id){
		if(namebind(id,$("#"+id).val())){
			nameflag=true;
		}else{
			nameflag=false;
		}
	}

	function reg_phoneapi(id){
		if(Phonebind(id,$("#"+id).val())){
			phoneflag=true;
		}else{
			phoneflag=false;
		}		
	}

	function reg_emailapi(id){
		if(emailbind(id,$("#"+id).val())){
			

			$.ajax({
				url: '/user/email',
				type: 'POST',
				dataType: 'text',
				data: {email:$("#"+id_str+"email").val(),_token:'{{ csrf_token() }}'},
				success:function(data){
					if(data){
						$("#"+id_str+"email_span").html("可以使用");
						$("#"+id_str+"email_span").css("color","#0f0");
						emailflag=true;
					}else{
						$("#"+id_str+"email_span").html("已被使用");
						$("#"+id_str+"email_span").css("color","#f00");
						emailflag=false;
					}
				},
				error:function(){alert("error")},
			});
		
		}else{
			emailflag=false;
		}	
	}

	function reg_passwordapi(id){
		if(regpassword(id,$("#"+id).val())){
			passwordflag=true;
		}else{
			passwordflag=false;
		}	
	}

	function reg_repasswordapi(id){
		if(regpassword(id,$("#"+id).val())){
			if(repassword(id)){
				repasswordflag=true;
			}else{
				repasswordflag=false;
			}
		}else{
			repasswordflag=false;
		}
	}

	function reg_birthdayapi(id){
		if($("#"+id).val()!=""){
			birthdayflag=true;
		}else{
			birthdayflag=false;
		}
	}
</script>
<style>
    @media (max-width: 540px){
        .OAuth_span{
        	display: none;
        }

    }
</style>

@include('jhongcorn.modal_error')
@include('jhongcorn.forget_password')


<!--Modal: Login / Register Form-->
<div class="modal fade" id="modalLRForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog  modal-lg cascading-modal" role="document">
    <!--Content-->
		<div class="modal-content">

		  <!--Modal cascading tabs-->
			<div class="modal-c-tabs">
				
			    <!-- Nav tabs -->
			    <ul class="nav nav-tabs md-tabs tabs-2 light-blue darken-3" role="tablist">
			      <li class="nav-item">
			        <a class="nav-link active" data-toggle="tab" href="#panel7" id="btnpanel7" role="tab" ><i class="fas fa-user mr-1" ></i>
			          登入</a>
			      </li>
			      <li class="nav-item ">
			        <a class="nav-link" data-toggle="tab" href="#panel8" id="btnpanel8" role="tab" ><i class="fas fa-user-plus mr-1"></i>
			          註冊</a>
			      </li>
			    </ul>
		
				<div class="tab-content">
			      <!--Panel 7-->
			    	<div class="tab-pane fade in show active" id="panel7" role="tabpanel">
						
				        <div class="modal-body mb-1">
				        	<form  method="post" id="form2" name="form2">
								@csrf
								<div class="md-form form-sm mb-5">
									<i class="fas fa-envelope prefix"></i>
									<input type="email" id="login_Email" name="login_Email" class="form-control form-control-sm ">
									<label  for="login_Email">你的信箱</label>
								</div>

								<div class="md-form form-sm mb-4">
									<i class="fas fa-lock prefix"></i>
									<input type="password" id="login_password" name="login_password" class="form-control form-control-sm ">
									<label  for="login_password">你的密碼</label>
								</div>
								<div class="text-center mt-2">
									<input type="hidden" name="login">
									<a class="btn btn-outline-info" onclick="signin();">登入<i class="fas fa-sign-in ml-1"></i></a>
								</div>
							</form>
							<div class="d-flex align-items-center justify-content-center">
								<a class="btn btn-outline-info" ><i class="fab fa-facebook-f fa-2x"></i><span class="OAuth_span">以Facebook帳號登入</span></a>
								<a class="btn btn-outline-info" href="/auth/google"><i class="fab fa-google fa-2x"></i><span class="OAuth_span">以Google帳號登入</span></a>
							</div>
				        </div>
				        <!--Footer-->
				        <div class="modal-footer">
				          <div class="options text-center text-md-right mt-1 ">
				            <p class="h6">非會員? <a href="#panel8" class="blue-text" data-toggle="tab" onclick="panelpanel8();" role="tab"><i class="fas fa-user-plus"></i></a></p>
				            <p class="h6">忘記 <a  class="blue-text" onclick="forget_password();" ><i class="fas fa-unlock-alt"></i>?</a></p>
				          </div>
				          <a  class="btn btn-outline-info waves-effect ml-auto" id="login_close" data-dismiss="modal">Close</a>
				        </div>						
						
				        <!--Body-->
			      	</div>
			      <!--/.Panel 7-->
					
						<!--Panel 8-->
						<div class="tab-pane fade " id="panel8" role="tabpanel">
							<form  method="post" id="form1" name="form1">
							<!--Body-->
								@csrf
								@include('jhongcorn.registered')
								<input type="hidden" name="registered">
								<div class="text-center form-sm mt-2">
									<a onclick="signup();"   class="btn btn-info"><i class="fas fa-user-plus"></i><i class="fas fa-sign-in ml-1"></i></a>
								</div>
							</form>
							<!--Footer-->
							<div class="modal-footer">
							  <div class="options text-right ">
							    <p class="pt-1 h6">已有會員? <a href="#panel7" data-toggle="tab" role="tab" onclick="panelpanel7();" class="blue-text"><i class="fas fa-sign-in-alt"></i></a></p>
							  </div>
							  <a  class="btn btn-outline-info waves-effect ml-auto" data-dismiss="modal">CLOSE</a>
							</div>
						</div>
				    
			      <!--/.Panel 8-->
			    </div>	
				
			    <!-- Tab panels -->

			</div>
		</div>
    <!--/.Content-->
	</div>
</div>
<!--Modal: Login / Register Form-->

