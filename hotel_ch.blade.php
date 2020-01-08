@extends('jhongcorn.layout.jhongcorn')
@section('content')
<script>
  $(function() {
    $( "#fromdate" ).datepicker({
        minDate:+1,
        maxDate:'+3M',
        dateFormat: 'yy-mm-dd',  
        changeMonth: true,
        onClose: function( selectedDate ) {
            var nextDay = new Date(selectedDate);
                nextDay.setDate(nextDay.getDate() + 1);
            if( $( "#todate" ).val()==""){
                $( "#todate" ).datepicker("setDate", nextDay);
                $("label[for=todate]").addClass('active');
            }

            if( $( "#todate" ).val()!=""){
                $( "#todate" ).datepicker("option","minDate", nextDay);
            }

            if($( this ).val()==""){
                $(this).datepicker("setDate", new Date());
            }
            datedayshow("");
        }
    });
    $( "#todate" ).datepicker({
        minDate:+2, 
        maxDate:'+3M', 
        dateFormat: 'yy-mm-dd',
        changeMonth: true,
        onClose: function( selectedDate ) {
            if( $( "#fromdate" ).val()==""){
                var backDay = new Date(selectedDate);
                backDay.setDate(backDay.getDate()-1);
                $( "#fromdate" ).datepicker("setDate", backDay);
                $("label[for=fromdate]").addClass('active');
            } 

            if($( this ).val()==""){
                $(this).datepicker("setDate", new Date());
            }
            datedayshow("");
        }
    });
 });
</script>
<script>
    var id7="map_city";
    var id8="map_region";
    var id9="map_street";
    var id_str3="Customer_";
    var booking_nameflag=booking_phoneflag=booking_emailflag=booking_passwordflag=rebooking_passwordflag=booking_birthdayflag=booking_numflag=false;
    var booking_laneflag=booking_alleyflag=true;
    
    $(function(){
        $("#form3 input[type='checkbox']").attr("id","booking_Customer_title");
        $("#form3 input[type='checkbox']").attr("name","Customer_title");
        $("#form3 .onoffswitch3-label").attr("for","booking_Customer_title");
        $( "#form3 #Customer_birthday" ).attr("id","booking_Customer_birthday");
        $( "#form3 #booking_Customer_birthday" ).attr("name","Customer_birthday");
        $( "#form3 label[for='Customer_birthday']" ).attr("for","booking_Customer_birthday");

        map("form3 #"+id7);
        $("#form3 #"+id7).change(function(){
            map_city($("#form3 #"+id7).find(':selected').data('id'),"form3 #"+id8,"form3 #"+id9);
        });
        $("#form3 #"+id8).change(function(){
            map_region($("#form3 #"+id8).find(':selected').data('id'),"form3 #"+id7,"form3 #"+id8,"form3 #"+id9);
        });
        
        $( "#form3 #booking_Customer_birthday" ).datepicker({
            yearRange:"-100:+0",
             dateFormat: 'yy-mm-dd',
            changeMonth:true,
            changeYear:true,
            maxDate:new Date(),
        });
            
      
        $($("#form3 #"+id_str3+"First_Name")).bind("change",function(){
          
            booking_nameapi("form3 #"+this.id);
        });             
        $("#form3 #"+id_str3+"Last_Name").bind("change",function(){
                
            booking_nameapi("form3 #"+this.id);
        });             
        $("#form3 #"+id_str3+"phone").bind("change",function(){
                
            booking_phoneapi("form3 #"+this.id);
        }); 

        
        $("#form3 #"+id_str3+"email").bind("change",function(){
                
            booking_emailapi("form3 #"+this.id);
        }); 
        $("#form3 #"+id_str3+"password").bind("change",function(){
            
            booking_passwordapi("form3 #"+this.id);
        }); 
        $("#form3 #re_"+id_str3+"password").bind("change",function(){   
            
            booking_repasswordapi("form3 #"+this.id);
        }); 
        $("#form3 #re_"+id_str3+"password").bind("click",function(){    
            if($("#form3 #"+id_str3+"password").val()==""){
                $("#form3 .md-form #"+id_str3+"password").addClass('border border-danger');
                $('#modalConfirmDelete').modal('show');
                $('#modalConfirmDelete span').html('密碼未輸入');
            }

        });     

        $("#form3 #"+id7).bind("change",function(){
            
            booking_citybind();
        }); 
        $("#form3 #"+id8).bind("change",function(){
            
            booking_citybind();
        });
        $("#form3 #"+id9).bind("change",function(){
                
            booking_citybind();
        });

        $("#form3 #"+id_str3+"Addr_lane").bind("input propertychange",function(){   
            booking_laneapi("form3 #"+this.id);
            booking_citybind();
        });
        $("#form3 #"+id_str3+"Addr_alley").bind("input propertychange",function(){  
            booking_alleyapi("form3 #"+this.id);
            booking_citybind();
        });
        $("#form3 #"+id_str3+"Addr_num").bind("input propertychange",function(){
            $(this).prop("required", true); 
            booking_numapi("form3 #"+this.id);
            booking_citybind();
        });
        $("#form3 #booking_"+id_str3+"birthday").bind("change",function(){
            
            booking_birthdayapi("form3 #"+this.id);
        });                     
    });

    function booking_citybind(){
        var booking_city=$("#form3 #"+id7);
        var booking_region=$("#form3 #"+id8);
        var booking_street=$("#form3 #"+id9);
        if(booking_city.val()=="" && booking_region.val()=="" && booking_street.val()==""){
            $('#modalConfirmDelete').modal('show');
            $('#modalConfirmDelete span').html('地址資料沒選擇');
            booking_laneflag=false;
            booking_alleyflag=false;
            booking_numflag=false;          
        }else{
            if(booking_city.val()=="" || booking_region.val()=="" || booking_street.val()==""){
                booking_city.addClass('border border-danger');
                booking_region.addClass('border border-danger');
                booking_street.addClass('border border-danger');
            }
        }

        if(booking_city.val()==""){
            booking_city.addClass('border border-danger');
        }else{
            booking_city.removeClass('border border-danger');
        }
        if(booking_region.val()==""){
            booking_region.addClass('border border-danger');
        }else{
            booking_region.removeClass('border border-danger');
        }
        if(booking_street.val()==""){
            booking_street.addClass('border border-danger');
        }else{
            booking_street.removeClass('border border-danger');
        }
    }

    function booking_laneapi(id){
        booking_laneflag=regAddr(id,$("#"+id).val());
    }

    function booking_alleyapi(id){
        booking_alleyflag=regAddr(id,$("#"+id).val());
    }

    function booking_numapi(id){
        booking_numflag=regAddr(id,$("#"+id).val());
    }

    function booking_nameapi(id){
        if(namebind(id,$("#"+id).val())){
            booking_nameflag=true;
        }else{
            booking_nameflag=false;
        }
    }

    function booking_phoneapi(id){
        if(Phonebind(id,$("#"+id).val())){
            booking_phoneflag=true;
        }else{
            booking_phoneflag=false;
        }       
    }

    function booking_emailapi(id){
        if(emailbind(id,$("#"+id).val())){
            $.ajax({
                url: '{{url("/user/email")}}',
                type: 'POST',
                dataType: 'text',
                data: {email:$("#form3 #"+id_str3+"email").val(),_token:'{{ csrf_token() }}'},
                success:function(data){
                    if(data){
                        $("#form3 #"+id_str3+"email_span").html("可以使用");
                        $("#form3 #"+id_str3+"email_span").css("color","#0f0");
                        booking_emailflag=true;
                    }else{
                        $("#form3 #"+id_str3+"email_span").html("已被使用");
                        $("#form3 #"+id_str3+"email_span").css("color","#f00");
                        booking_emailflag=false;
                    }
                },
                error:function(){alert("error")},
            });
        
        }else{
            booking_emailflag=false;
        }   
    }

    function booking_passwordapi(id){
        if(regpassword(id,$("#"+id).val())){
            booking_passwordflag=true;
        }else{
            booking_passwordflag=false;
        }   
    }

    function booking_repasswordapi(id){
        if(regpassword(id,$("#"+id).val())){
            if(repassword(id)){
                rebooking_passwordflag=true;
            }else{
                rebooking_passwordflag=false;
            }
        }else{
            rebooking_passwordflag=false;
        }
    }

    function booking_birthdayapi(id){
        if($("#"+id).val()!=""){
            booking_birthdayflag=true;
        }else{
            booking_birthdayflag=false;
        }
    }
</script>
<script>
    function datedayshow(id){
        if($( "#"+id+"todate" ).val()!="" && $( "#fromdate" ).val()!=""){
            d1=$("#"+id+"fromdate" ).datepicker("getDate");
            d2=$("#"+id+"todate" ).datepicker("getDate");
          
            daynum=parseInt(d2 - d1)/ 1000 / 60/60/24;
           
            
            $("#"+id+"datedayshow").html("共選了"+daynum+"晚");
            $("#"+id+"datedayshow").attr("day-num",daynum);
            return daynum;
        }
    }

    function show(id){
    
       if($(window).width()<=540){
            $(".textnone" ).hide(500);
            $(".fa-chevron-circle-down").show(500);
            if ($("#"+id+" .textnone" ).css("display")=='none') {
              $("#"+id+" .textnone" ).show(500);
              $("#"+id+" i" ).hide(500);  
            }
            
        }
    }


    function booking(){
        if($( "#todate" ).val()!="" && $( "#fromdate" ).val() !=""){

        <?php if(session('loginName')){
            ?>

             $("#booking_room_modal").modal();
            $("#hotel_modal .close").trigger('click');
            booking_room();
        <?php 
        }else{
         ?> 
            $("#hotel_modal").modal();
         <?php  
        }
        ?>
        }else{
            $( "#fromdate" ).datepicker('show');
        } 
    }

    function login_booking_room(OAuth_Id){
        var user_id=OAuth_Id;
        var hotel_id=$("#hotel_Name").attr("hotel-id");
        var Checkin_date=$("#booking_room_fromdate").val();
        var Checkout_date=$("#booking_room_todate").val();
        var adult=$("#hotel_adult").val();
        var child=$("#hotel_child").val();
        var nights=$("#booking_room_datedayshow").attr("day-num");
        var room=$("#hotel_room").val();
        $.ajax({
            url: '{{asset("/user/booking/")}}',
            type: 'POST',
            dataType: 'text',
            data: {user_id:user_id,hotel_id:hotel_id,Checkin_date:Checkin_date,Checkout_date:Checkout_date,adult:adult,child:child,nights:nights,room:room,_token:'{{ csrf_token() }}'},
            success:function(data){
                if(data){
                    alert('訂房成功');
                    //location.reload();
			console.log(data);
                }else{
                    alert('訂房失敗');
                }
                
            },
            error:function(data){alert("error");
          
        },
        });
    }

    function booking_room_submit(){

    <?php

        if(session('loginName')){
    ?>
        login_booking_room("<?php echo session('OAuth_Id');?>");
    <?php
        }else{
    ?>  
        $.ajax({
            url: '{{url("/user/register")}}',
            type: 'POST',
            dataType: 'text',
            data: $("#form3").serialize(),
            success:function(data){
                if(data){
                   login_booking_room(data);
                }else{
                    alert('訂房失敗');
                }
                
            },
            error:function(){alert("error")},
        });
    <?php
        }
    ?>

    }

    function booking_room(){
       $("#booking_room_fromdate").val($("#fromdate").val());
        $("#booking_room_todate").val($("#todate").val());
        $("#booking_room_datedayshow").html($("#datedayshow").text());
        $("#booking_room_datedayshow").attr("day-num",$("#datedayshow").attr("day-num"));
        $( "#booking_room_fromdate" ).datepicker({
            minDate:+1,  
            maxDate:'+3M', 
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            onClose: function( selectedDate ) {
                var nextDay = new Date(selectedDate);
                    nextDay.setDate(nextDay.getDate() + 1);
                if( $( "#booking_room_todate" ).val()==""){
                    $( "#booking_room_todate" ).datepicker("setDate", nextDay);
                    $("label[for=booking_room_todate]").addClass('active');
                }

                if( $( "#booking_room_todate" ).val()!=""){
                    $( "#booking_room_todate" ).datepicker("option","minDate", nextDay);
                }

                if($( this ).val()==""){
                    $(this).datepicker("setDate", new Date());
                }
                datedayshow("booking_room_");
            }
        });


        $( "#booking_room_todate" ).datepicker({
            minDate:+2,  
            maxDate:'+3M', 
            changeMonth: true,
            dateFormat: 'yy-mm-dd',
            onClose: function( selectedDate ) {
                if( $( "#booking_room_fromdate" ).val()==""){
                    var backDay = new Date(selectedDate);
                    backDay.setDate(backDay.getDate()-1);
                    $( "#booking_room_fromdate" ).datepicker("setDate", backDay);
                    $("label[for=booking_room_fromdate]").addClass('active');
                } 

                if($( this ).val()==""){
                    $(this).datepicker("setDate", new Date());
                }

                if(datedayshow("booking_room_")<=0){
                    $("#booking_room_fromdate").datepicker("setDate", new Date());
                }
                datedayshow("booking_room_");
            }
        });                    
    }

    function nextbooking(){
            
                
        if(booking_nameflag && booking_phoneflag && booking_emailflag && booking_passwordflag && rebooking_passwordflag && booking_birthdayflag &&booking_laneflag && booking_alleyflag&& booking_numflag){

            var booking_addr=Addrsum("form3 #"+id7,"form3 #"+id8,"form3 #"+id9,"form3 #"+id_str3+"Addr_");
            $("#form3 #addr").val(booking_addr);
            $("#booking_room_modal").modal();
            $("#hotel_modal .close").trigger('click');
            booking_room();
            
        }else{

            $('#modalConfirmDelete').modal('show');
            $('#modalConfirmDelete span').html('未輸入完全');
            booking_numflag?$("#form3 #Customer_Addr_num").removeClass("border border-danger"):$("#form3 #Customer_Addr_num").addClass("border border-danger");

            booking_phoneflag?$("#form3 #Customer_phone").removeClass("border border-danger"):$("#form3 #Customer_phone").addClass("border border-danger");

            booking_emailflag?$("#form3 #Customer_email").removeClass("border border-danger"):$("#form3 #Customer_email").addClass("border border-danger");

            if($("#form3 #Customer_First_Name").val()!=""){
                $("#form3 #Customer_First_Name").removeClass("border border-danger");
            }else{
                $("#form3 #Customer_First_Name").addClass("border border-danger");
            }

            if($("#form3 #Customer_Last_Name").val()!=""){
                $("#form3 #Customer_Last_Name").removeClass("border border-danger");
            }else{
                $("#form3 #Customer_Last_Name").addClass("border border-danger");
            }

            if($("#form3 #"+id7).val()==""){
                $("#form3 #"+id7).addClass("border border-danger");
            }else{
                $("#form3 #"+id7).removeClass("border border-danger");
            }

            if($("#form3 #"+id8).val()==""){
                $("#form3 #"+id8).addClass("border border-danger");
            }else{
                $("#form3 #"+id8).removeClass("border border-danger");
            }   

            if($("#form3 #"+id9).val()==""){
                $("#form3 #"+id9).addClass("border border-danger");
            }else{
                $("#form3 #"+id9).removeClass("border border-danger");
            }                   
            booking_passwordflag?$("#form3 #Customer_password").removeClass("border border-danger"):$("#form3 #Customer_password").addClass("border border-danger");
            rebooking_passwordflag?$("#form3 #re_Customer_password").removeClass("border border-danger"):$("#form3 #re_Customer_password").addClass("border border-danger");
            booking_birthdayflag?$("#form3 #Customer_birthday").removeClass("border border-danger"):$("#form3 #Customer_birthday").addClass("border border-danger");
        }
    }
</script>
<script>
  $(function(){
    $("#booking_room_modal").on('show.bs.modal', function() {
        var zIndex = 1060;
        $(this).css('z-index', zIndex);
    });
    $("#booking_room_modal").on("hidden.bs.modal", function () {

        $(this).removeData("bs.modal");

        $(document.body).addClass("modal-open");  

    });
  });

  function backmodal(){
    <?php if(session('loginName')){?>
    $("#booking_room_modal .close").trigger('click');  
   <?php }else{?>
    $("#hotel_modal").modal('show');
    $("#booking_room_modal .close").trigger('click');  
   <?php }?>


  }
</script>
<style>
    .fa-chevron-circle-down{
        display: none;
    }



@media (max-width: 540px){

    .textnone{
        display: none;
    }
    .fa-chevron-circle-down{
        display:block;
    }

}


</style>


<?php
   

	

	$hotel_ch= $tourism ;

	foreach ($hotel_ch as $row) {
        foreach($cityName as $key=>$val){
            if( strpos($row['Region'],$val)!==false){
                $Addrval=$key;
            }
        }

?>

<div class="modal fade" id="booking_room_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-sm modal-notify modal-warning" role="document">
    <!--Content-->
    <div class="modal-content">
      <!--Header-->
      <div class="modal-header text-center">
        <h4 class="modal-title white-text w-100 font-weight-bold py-2">訂房資訊</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="white-text">&times;</span>
        </button>
      </div>

      <!--Body-->
        <div class="modal-body"> 
            <h4 id="hotel_Name" hotel-id="<?php echo $row['hotel_Id'];?>">
                 <?php
                 echo $row['Name'];
                 ?>
            </h4>
            <p>入住日期</p>
            <div class="md-form ">
                
                <i class="fas fa-calendar-alt prefix"></i>
                <input type="text" id="booking_room_fromdate" name="booking_room_fromdate"  readonly class="form-control datepicker">
            </div>  
            <p>退房日期</p>
            <div class="md-form ">
                
                <i class="fas fa-calendar-alt prefix"></i>
                <input type="text" id="booking_room_todate" name="booking_room_todate"  readonly class="form-control datepicker">
            </div> 
            <p>總共入住：</p>
             <p id="booking_room_datedayshow" ></p>                   
        </div>
      <!--Footer-->
      <div class="modal-footer justify-content-center">
        <a type="button" class="btn btn-outline-warning waves-effect" onclick="backmodal();">back <i class="fas fa-paper-plane-o ml-1"></i></a>
        <a type="button" class="btn btn-outline-warning waves-effect" onclick="booking_room_submit();">Send <i class="fas fa-paper-plane-o ml-1"></i></a>
      </div>
    </div>
    <!--/.Content-->
  </div>
</div>

<div class="modal fade " id="hotel_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header text-center">
        <h4 class="modal-title w-100 font-weight-bold">基本資料</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form  method="post" id="form3" name="form3">
        <input type="hidden" name="registered">
     
      @include("jhongcorn.registered") 
      
      </form>
        
      <div class="modal-footer d-flex justify-content-center">
        <button class="btn btn-deep-orange" onclick="nextbooking();">下一步</button>
      </div>
    </div>
  </div>
</div>


<div class="card  text-center">
        
    <?php if(isset($Addrval)){?>
                        
    <img class="card-img up-img-body" src="/laravel/resources/views/jhongcorn/img/<?php echo $cityimg[$Addrval];?>" >
                

    <?php }?>    
    <div class=" up-img card-img-overlay">
       
        <img class="avatar rounded-circle gradient-card-header purple-gradient img-thumbnail"  src="<?php echo $row['Picture1']!=""?$row['Picture1']:'/laravel/resources/views/jhongcorn/img/bg.png';?>" onerror="this.src='/laravel/resources/views/jhongcorn/img/bg.png'">
    </div>

    

    <div  class="card-header d-flex justify-content-center align-items-center">
        <p class="text-primary justify-content-center align-items-center" style="font-size: 1vw;">
            <?php 
            if(session('OAuth_Id')){
                echo $booking_hotel?"有訂過此旅館":"";
            }
            
            ?>
        </p>
        <div class="ml-auto">
            <h4 id="hotel_Name" hotel-id="<?php echo $row['hotel_Id'];?>">
                 <?php
                 echo $row['Name'];
                for($i=1;$i<=(int)$row['Grade'];$i++){ ?>
                 <i class="fas fa-star text-warning" style="font-size: 0.1vh;"></i>
            <?php }?> 
            </h4>           
        </div>
        <div class="ml-auto">
            <button class=" btn btn-outline-light btn-sm aqua-gradient rounded-pill" onclick="booking();">預訂</button>  
        </div>
        
    </div>
    <div class="card-body">
        <div class="row bg-white m-2 p-2">
            <div class="md-form col-md-6 text-left">
                <i class="fas fa-calendar-alt prefix"></i>
                <input type="text" id="fromdate" name="fromdate"  readonly class="form-control datepicker ">
                <label for="fromdate" class="pl-3">入住日期</label>
            </div>
            <div class="md-form col-md-6 text-left">
                <i class="fas fa-calendar-alt prefix"></i>
                <label for="todate" class="pl-3">退房日期</label>
                <input type="text" id="todate" name="todate"  readonly class="form-control datepicker">
            </div>  
            <p id="datedayshow" class="col-md-12 text-left "></p>
            <div class="md-form  text-left  mr-auto">
                <i class="fas fa-user-friends prefix "></i>
                <select class="ml-5  custom-select  md-select w-auto" id="hotel_adult">
                    <?php for($i=1;$i<=30;$i++){?>
                    <option value="<?php echo $i?>" <?php echo $i==2?"selected":""?>><?php echo $i."位成人"?></option>
                     <?php }?>
                </select>
            </div>
            <div class="md-form  text-left mr-auto">
                <i class="fas fa-users prefix"></i>
                <select class="ml-5 custom-select  md-select w-auto"  id="hotel_child">
                    <?php for($i=0;$i<=15;$i++){?>
                    <option value="<?php echo $i?>" <?php echo $i==0?"selected":""?>><?php echo $i==0?"無子女隨行":$i."位子女"?></option>
                <?php }?>
                </select>                
            </div>
  
            <div class="md-form  text-left mr-auto">
                <i class="fas fa-home prefix"></i>
                <select class="ml-5 custom-select  md-select w-auto" id="hotel_room">
                    <?php for($i=1;$i<=30;$i++){?>
                    <option value="<?php echo $i?>" <?php echo $i==1?"selected":""?>><?php echo $i."間客房"?></option>
                    <?php }?>
                </select>    
            </div>
          
        </div>

        
        <!-- Quotation -->
        <div class="card-text text-left">
            <ul class="list-group list-group-flush">
                <li class="list-group-item"> <p><a href="https://www.google.com.tw/maps/place/<?php echo $row['Py'].",".$row['Px'];?>/" class="card-link " style="position: relative;" target="new"><i class="fas fa-map-marker-alt"></i><span class="card-text ml-2"><?php echo $row['Addr'];?></span></a></p></li>
             <?php if($row['Tel']){?>
                <li class="list-group-item " id="<?php echo $row['hotel_Id'];?>_Description" onclick="show(this.id)">
                    <div class="d-flex">
                        <a href="tel:<?php echo $row['Tel'];?>" >
                            <i class="fas fa-phone"></i> 
                            <span class="ml-3 textnone "><?php echo $row['Tel'];?></span>
                        </a> 
                       
                    </div>
                    
                </li>
                <?php }?>                    

                <?php if($row['Description']){?>
                <li class="list-group-item " id="<?php echo $row['hotel_Id'];?>_Description" onclick="show(this.id)">
                    <div class="d-flex"> 
                       <span class="ml-3 mr-auto">描述</span>
                       <i class="fas fa-chevron-circle-down"></i> 
                    </div>
                    <p class="ml-3 textnone "><?php echo $row['Description'];?></p>
                </li>
                <?php }
                    if($row['Spec']){
                ?>
                <li class="list-group-item" id="<?php echo $row['hotel_Id'];?>_Spec" onclick="show(this.id)">
                    <div class="d-flex"> 
                       <span class="ml-3 mr-auto">規格</span>
                       <i class="fas fa-chevron-circle-down"></i> 
                    </div>
                    <p class="ml-3 textnone"><?php echo $row['Spec'];?></p>
                </li>
                <?php }
                    if($row['Serviceinfo']){
                ?>
                <li class="list-group-item" id="<?php echo $row['hotel_Id'];?>_Serviceinfo" onclick="show(this.id)">
                    <div class="d-flex"> 
                       <span class="ml-3 mr-auto">服務信息</span>
                       <i class="fas fa-chevron-circle-down"></i> 
                    </div>
                    <p class="ml-3 textnone"><?php echo $row['Serviceinfo'];?></p>
                </li>
                <?php }
                    if($row['Parkinginfo']){
                ?>
                <li class="list-group-item" id="<?php echo $row['hotel_Id'];?>_Parkinginfo" onclick="show(this.id)">
                    <div class="d-flex"> 
                       <span class="ml-3 mr-auto">停車信息</span>
                       <i class="fas fa-chevron-circle-down"></i> 
                    </div>
                    <p class="ml-3 textnone"><?php echo $row['Parkinginfo'];?></p> 
                </li>
                <?php }?>
            </ul>           
                    
        </div>
    </div>

</div>
@include('jhongcorn.map')
<?php
  $maprestaurant_map=false;
?>
<div class="card mt-3" id="<?php echo $row['hotel_Id'];?>_restaurant" onclick="show(this.id)" >
    <div class="card-header d-flex">
        <h5 class="mb-2 h5 mr-auto">附近店家</h5>
        <h5><i class="fas fa-chevron-circle-down "></i><h5>
    </div>
    <div class="card-body textnone">
        <div class="row">
            
        
        <?php
            foreach ($restaurant as $row1) {
                $maprestaurant=getdistance($row['Py'],$row['Px'],$row1['Py'],$row1['Px']);
                if($maprestaurant<=3000){
                    $maprestaurant_map=true;
                   
                   
        ?>
            <div class=" card-text   col-md-6 col-sm-12">
        
                <a href="https://www.google.com.tw/maps/place/<?php echo $row1['Py'].",".$row1['Px'];?>/" class="card-link " style="position: relative;" target="new">
                    <i class="fas fa-map-marker-alt"></i>
                    <span class="card-text ml-2">
                    <?php  echo $row1['Name'];?></span>
                    <span class="ml-3"><?php echo round($maprestaurant/1000,1)."km";?></span>
                </a>
                <hr>
            </div> 
        
        <?php }         
        } 

        if(!$maprestaurant_map){
            echo "<style>#".$row['hotel_Id']."_restaurant{display:none;}</style>";
        }
        ?>
        </div>
    </div>
</div>



<?php


    $mapscenic_spot_map=false;
?>

<div class="card mt-3" id="<?php echo $row['hotel_Id'];?>_scenic_spot" onclick="show(this.id)">
    <div class="card-header d-flex">
        <h5 class="mb-2 h5 mr-auto">附近景點</h5>
        <h5><i class="fas fa-chevron-circle-down "></i><h5>
    </div>
    <div class="card-body textnone">
        <div class="row">
            
        
        <?php
            foreach ($scenic_spot as $row2) {
                $mapscenic_spot=getdistance($row['Py'],$row['Px'],$row2['Py'],$row2['Px']);
                if($mapscenic_spot<=3000){
                  $mapscenic_spot_map=true;
        ?>
        <div class=" card-text   col-md-6 col-sm-12">
        
                 <a href="https://www.google.com.tw/maps/place/<?php echo $row2['Py'].",".$row2['Px'];?>/" class="card-link " style="position: relative;" target="new"><i class="fas fa-map-marker-alt"></i><span class="card-text ml-2">
                <?php  echo $row2['Name'];?><span class="ml-3"><?php echo round($mapscenic_spot/1000,1)."km";?></span></a>
                <hr>
            </div> 
        
        <?php }
       

    }
        if(!$mapscenic_spot_map){
            echo "<style>#".$row['hotel_Id']."_scenic_spot{display:none;}</style>";
        }
    ?>
        </div>
    </div>
</div>

    
    
    <?php	
	}


?>
@endsection