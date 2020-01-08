
<div class="modal-body ">
	          	
	<div class="row">
		<div class="col">
		  <div class="md-form mt-0">
		  	<i class="fas fa-address-card prefix"></i>
		    <input type="text" id="Customer_First_Name" name="Customer_First_Name" class="form-control validate" placeholder="名子" >
		  </div>
		</div>

	    <div class="col">
	      <div class="md-form mt-0">
	      	<i class="fas fa-address-card prefix"></i>
	        <input type="text" class="form-control validate" name="Customer_Last_Name" id="Customer_Last_Name" placeholder="姓氏" >
	      </div>
	    </div>
	</div>

	<div class="d-flex">
		<i class="fas fa-venus-mars " style="font-size: 30px;"></i>
		<div  class="onoffswitch3 mx-1 ">
		    <input type="checkbox" name="Customer_title" class="onoffswitch3-checkbox" id="Customer_title">
		    <label class="onoffswitch3-label" for="Customer_title">    	
		        <span class="onoffswitch3-inner">
		            <span class="onoffswitch3-active"><span class="onoffswitch3-switch"><i class="fas fa-mars"></i></span></span>
		            <span class="onoffswitch3-inactive"><span class="onoffswitch3-switch"><i class="fas fa-venus"></i></span></span>
		        </span>
		    </label>
		</div>
	</div>

	<div class="md-form">
		<i class="fas fa-phone prefix"></i>
		<input type="tel" id="Customer_phone" name="Customer_phone" class="form-control validate" placeholder="09XXXXXXXX 或 04XXXXXXXX" >	
	</div>	

	<div class="md-form">
		<i class="fas fa-envelope prefix"></i>
		<input type="email" id="Customer_email" name="Customer_email" class="form-control validate" placeholder="XXX@gmail.com"  >
		<span id="Customer_email_span"></span>	
	</div>	
	<div class="md-form form-sm mb-4">
		<p class="pl-5 pt-1  passwordbtn col-12" style="font-size: 1vw;">需8~12位數，並且至少包含字母、數字、符號各一</p>
        <i class="fas fa-lock prefix"></i>
        <input type="password" id="Customer_password" name="Customer_password" class="form-control form-control-sm validate" placeholder="你的密碼" >
       
     </div>

	<div class="md-form form-sm mb-4">
        <i class="fas fa-lock prefix"></i>
        <input type="password" id="re_Customer_password" class="form-control form-control-sm validate" placeholder="確認密碼" >
        
     </div>

	<div class="md-form">
	    <i class=" fas fa-map-marked-alt prefix"></i>
	    <div class="row pl-5">
	    	
	        <select class="mx-2 col-md-3 col-sm-12  custom-select  md-select updatabtn" name="map_city" id="map_city" >
	        	<option value="">縣市</option>
	        </select>
	        <select class="mx-2 col-md-3 col-sm-12  custom-select  md-select updatabtn" name="map_region" id="map_region" >
	        	<option value="">區域</option>
	        </select>  
	        <select class="mx-2 col-md-3 col-sm-12  custom-select  md-select updatabtn" name="map_street" id="map_street" >
	        	<option value="">路(街)名或鄉里名稱</option>
	        </select>  
	        <div class="d-flex row">
		        <div class="md-form updatabtn col-2">
		        	<label class="pl-3"for="Customer_Addr_lane">巷</label>
					<input type="text" id="Customer_Addr_lane" name="Customer_Addr_lane" class=" form-control validate"  >
				
		        </div>
		        <div class="md-form updatabtn col-2">
		        	<label class="pl-3" for="Customer_Addr_alley">弄</label>
					<input type="text" id="Customer_Addr_alley" name="Customer_Addr_alley" class=" form-control validate" >
					
				</div>
		        <div class="md-form updatabtn col-2">
		        	<label class="pl-3" for="Customer_Addr_num">號</label>
					<input type="text" id="Customer_Addr_num" name="Customer_Addr_num" class="form-control validate" >
				</div>
		        <div class="md-form updatabtn col-2">
		        	<label class="pl-3" for="Customer_Addr_f1">樓</label>
					<input type="text" id="Customer_Addr_f1" name="Customer_Addr_f1" class="form-control validate">
					
				</div>
		        <div class=" md-form updatabtn col-2">
		        	<label class="pl-3" for="Customer_Addr_suite">室</label>
					<input type="text" id="Customer_Addr_suite" name="Customer_Addr_suite" class="form-control validate">

				</div>	
				<input type="hidden" name="addr" id="addr">			        	
	        </div>		      
	    </div>        
	</div>
	<div class="md-form">
		<i class="fas fa-calendar-alt prefix"></i>
	    <input type="text" id="Customer_birthday" name="Customer_birthday"  readonly class="form-control datepicker " >
	    <label for="Customer_birthday" class="pl-3">出生年月日</label>
	</div>


</div>