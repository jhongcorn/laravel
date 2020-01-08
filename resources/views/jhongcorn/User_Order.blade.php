@extends('jhongcorn.layout.jhongcorn')
@section('content')		
 <?php
 if(session('loginName')){?>

	<script>
		function Change_Order(id){
			var card_id=id.replace("_btn","");
			$("#Change_Order img").attr("src",$("#"+card_id+" img").attr('src'));
			$("#Change_Order h5").text($("#"+card_id+" h5").text());
			$("#Change_Order").attr("order-id",$('#'+card_id).attr('order-id'));
			$("#Change_Order").attr("hotel-id",$('#'+card_id).attr('hotel-id'));
			$("#Change_Order").attr("oauth-id",$('#'+card_id).attr('oauth-id'));
			$("#Change_Order").attr("customer-id",$('#'+card_id).attr('customer-id'));

			$('#hotel_adult option:selected').removeAttr('selected');
			$('#hotel_child option:selected').removeAttr('selected');
			$('#hotel_room option:selected').removeAttr('selected');

			$("#hotel_adult option[value="+$('#'+card_id).attr('adult')+"]").attr('selected', 'selected');
			$("#hotel_child option[value="+$('#'+card_id).attr('child')+"]").attr('selected', 'selected');
			$("#hotel_room option[value="+$('#'+card_id).attr('room')+"]").attr('selected', 'selected');
		}
		function change_order_submit(){
			$.ajax({
                url: '/user/Change_Order',
                type: 'POST',
                dataType: 'text',
                data: {_token:'{{ csrf_token() }}',adult:$("#hotel_adult").val(),child:$("#hotel_child").val(),room:$("#hotel_room").val(),order_id:$("#Change_Order").attr("order-id"),hotel_id:$("#Change_Order").attr("hotel-id"),oauth_id:$("#Change_Order").attr("oauth-id"),customer_id:$("#Change_Order").attr("customer-id"),Change_Order:"<?php echo base64_encode('Change_Order');?>"},
                success:function(data){
 					if(data){
 						alert("變更成功");
 						location.reload();
 					}else{
 						alert("變更失敗");
 					}
                },
                error:function(){alert("error")},
            });
		}

		function del_Order(id){
			var card_id=id.replace("_del","");
			$('#'+card_id).attr('order-id');
			$('#'+card_id).attr('hotel-id');
			$('#'+card_id).attr('oauth-id');
			$('#'+card_id).attr('customer-id');
			$.ajax({
                url: '/user/Change_Order',
                type: 'POST',
                dataType: 'text',
                data: {_token:'{{ csrf_token() }}',order_id:$('#'+card_id).attr("order-id"),hotel_id:$('#'+card_id).attr("hotel-id"),oauth_id:$('#'+card_id).attr("oauth-id"),customer_id:$('#'+card_id).attr("customer-id"),del_Order:"<?php echo base64_encode('del_Order');?>"},
                success:function(data){
 					if(data){
 						location.reload();
 					}else{
 						alert("變更失敗");
 					}
                },
                error:function(){alert("error")},
            });
		}
	</script>

		<!--Modal: Login with Avatar Form-->
		<div class="modal fade" id="Change_Order" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
		  aria-hidden="true">
		  <div class="modal-dialog cascading-modal modal-avatar modal-sm" role="document">
		    <!--Content-->
		    <div class="modal-content">

		      <!--Header-->
		      <div class="modal-header">
		        <img class="rounded-circle img-responsive" style="height: 150px;width:150px">
		      </div>
		      <!--Body-->
		      <div class="modal-body text-center mb-1">

		        <h5 class="mt-1 mb-2"></h5>

	 			<div class="md-form  text-left  mr-auto">
	                <i class="fas fa-user-friends prefix "></i>
	                <select class="ml-5  custom-select  md-select w-auto" id="hotel_adult">
	                    <?php for($i=1;$i<=30;$i++){?>
	                    <option value="<?php echo $i?>" ><?php echo $i."位成人"?></option>
	                     <?php }?>
	                </select>
	            </div>
	            <div class="md-form  text-left mr-auto">
	                <i class="fas fa-users prefix"></i>
	                <select class="ml-5 custom-select  md-select w-auto"  id="hotel_child">
	                    <?php for($i=0;$i<=15;$i++){?>
	                    <option value="<?php echo $i?>" ><?php echo $i==0?"無子女隨行":$i."位子女"?></option>
	                <?php }?>
	                </select>                
	            </div>
	  
	            <div class="md-form  text-left mr-auto">
	                <i class="fas fa-home prefix"></i>
	                <select class="ml-5 custom-select  md-select w-auto" id="hotel_room">
	                    <?php for($i=1;$i<=30;$i++){?>
	                    <option value="<?php echo $i?>"><?php echo $i."間客房"?></option>
	                    <?php }?>
	                </select>    
	            </div>

		        <div class="text-center mt-4">
		          <button class="btn btn-cyan mt-1" onclick="change_order_submit();">變更 <i class="fas fa-sign-in ml-1"></i></button>
		          <button type="button" class="btn btn-outline-info waves-effect ml-auto" data-dismiss="modal">Close</button>
		        </div>
		      </div>

		    </div>
		    <!--/.Content-->
		  </div>
		</div>
		<!--Modal: Login with Avatar Form-->		
	  	<div class="container border border-info">
	  		  
			<h4 class="card-header text-center ">訂房資訊</h4>
	  		 <div class="row">
			<?php
				
				if(count($bookingorder)>0){
					
					foreach($bookingorder as $row){
						
						foreach ($hotelorder as  $value) {
						
							if($value['hotel_Id']==$row['hotel_Id']){
			?>	

	
				
				<div class="col-md-6 col-sm-12 my-3">
					<div class="card" id="order<?php echo $value['hotel_Id'].$row['Order_Id'];?>" adult="<?php echo $row['adult'];?>" child="<?php echo $row['child'];?>" room="<?php echo $row['room'];?>" order-id="<?php echo $row['Order_Id']?>" hotel-id="<?php echo $value['hotel_Id']?>" oauth-id="<?php echo $row['OAuth_Id']?>" customer-id="<?php echo $row['customer_Id']?>">

						<div class="row text-center no-gutters">
							<div class="col-md-6 col-sm-12 "><img class="img-thumbnail card-img" style="height: 300px;width:300px" src="<?php echo $value['Picture1']!=""?$value['Picture1']:'/resources/views/jhongcorn/img/bg.png';?>" onerror="this.src='/resources/views/jhongcorn/img/bg.png'"></div>

							<div class="card-body col-md-6 col-sm-12 text-left p-5">
								<h5 class="card-title"><?php echo $value['Name']?></h5>
								<p class="card-text"><?php echo $row['Checkin_date']."<i class='fas fa-long-arrow-alt-right'></i>".$row['Checkout_date'];?></p>
								<p class="card-text"><small class="text-muted"><?php echo $value['Region'].$value['Town']?></small></p>
							</div>
							<div class="card-footer col-12">
								<?php if(prDates($row['Checkin_date'], $row['Checkout_date'])>1 ){
									echo '<a  class="card-link" id="order'.$value['hotel_Id'].$row['Order_Id'].'_del" onclick="del_Order(this.id);">移除訂單</a>';
									echo '<a href="/tourism/hotel_ch/hotel_Id/'.$value['hotel_Id'].'" class="card-link">再次預定</a>';
								}else if(prDates($row['Checkin_date'], $row['Checkout_date'])<-7) {
									echo '<a  class="card-link" id="order'.$value['hotel_Id'].$row['Order_Id'].'_del" onclick="del_Order(this.id);">取消訂單</a>';
									echo '<a  class="card-link" data-toggle="modal" data-target="#Change_Order" id="order'.$value['hotel_Id'].$row['Order_Id'].'_btn" onclick="Change_Order(this.id);">修改訂單</a>';
								}else if(prDates($row['Checkin_date'], $row['Checkout_date'])<=0 && prDates($row['Checkin_date'], $row['Checkout_date'])>=-7){
									echo '等待您的光臨';
								} 

								?>
								
							</div>
					  	</div>
					</div>
				</div>


			<?php }}}?>

			  <?php
		}else{
			echo "<div class='m-auto m-5 p-5  h1' style='height:700px'>沒有資料</div>";
			}

			?>
			</div>
			@if($pageNum>0 )
			<nav  aria-label="Page navigation example" class="d-flex">
				<ul class="mr-auto ml-auto pagination">
				  <?php if ($pageNum > 0) { ?>
				  <li class="page-item">
					  <a href="/user/Order/0" class="page-link"><i class=" fas fa-angle-double-left text-info"></i></a></li>
				  <li class="page-item"><a href="/user/Order/{{ $pageNum-1 }}"class="page-link"><i class="fas fa-angle-left text-info"></i></a></li><?php }?>
				  <li class="page-item"><span><?php echo "第".' '.($pageNum+1).' '.'頁';?></span></li>
				  <li class="page-item"><span><?php echo "/共".' '.($totalPages+1).' '."頁";?></span></li>
				  <?php if ($pageNum < $totalPages) {?>
				  <li class="page-item">
					<a href="/user/Order/{{ $pageNum+1 }} "class="page-link"><i class="fas fa-angle-right text-info"></i></a>
				  </li>
				  <li class="page-item"><a href="/user/Order/{{ $totalPages }} "class="page-link"><i class="fas fa-angle-double-right text-info"></i></a></li><?php }?>
				</ul>
			  </nav>
			@endif			
		</div>
		@endsection
<?php 

	}
	//判斷天數相差幾天
	function prDates($start, $end) { 
		$dt_bind=strtotime(date('Y-M-D'));
		$dt_start = strtotime($start);
		$dt_end   = strtotime($end);
		$day=($dt_bind-$dt_end)/3600/24;
		return $day;


	}	

?>