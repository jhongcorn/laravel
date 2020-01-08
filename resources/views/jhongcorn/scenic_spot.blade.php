@extends('jhongcorn.layout.jhongcorn')
@section('content')
<script>

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
    <?php if(isset($_SESSION['loginName'])){?>
    $("#booking_room_modal .close").trigger('click');  
   <?php }else{?>
    $("#scenic_spot_modal").modal('show');
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

$scenic_spot= $tourism ;
  foreach ($scenic_spot as $row) {
        foreach($cityName as $key=>$val){
            if( strpos($row['Region'],$val)!==false){
                $Addrval=$key;
            }
        }

?>

<div class="card  text-center">
  <div>

    <?php if(isset($Addrval)){?>
                        
    <img class="card-img up-img-body" src="/resources/views/jhongcorn/img/<?php echo $cityimg[$Addrval];?>" >

    <?php }?>    
    <div class=" up-img card-img-overlay">    
        <img class="avatar rounded-circle gradient-card-header purple-gradient img-thumbnail"  src="<?php echo $row['Picture1']!=""?$row['Picture1']:'/resources/views/jhongcorn/img/bg1.png';?>" onerror="this.src='/resources/views/jhongcorn/img/bg1.png'">
    </div>
  </div> 
    <div  class="card-header d-flex justify-content-center align-items-center">
        <p class="text-primary justify-content-center align-items-center" style="font-size: 1vw;">
        </p>
        <div class="text-center">
            <h4 id="scenic_spot_Name" scenic_spot-id="<?php echo $row['scenic_Id'];?>">
                 <?php
                 echo $row['Name'];
                ?>
                 
            </h4>           
        </div>
    </div>
    <?php if($row['Picture1'] && $row['Picture2']){?>
    <div class="bd-example p-3">
        <div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
          <ol class="carousel-indicators">
             <?php 
             if($row['Picture1']){
               echo' <li data-target="#carouselExampleCaptions" data-slide-to="0" class="active"></li>';
              }
              if($row['Picture2']){
                echo '<li data-target="#carouselExampleCaptions" data-slide-to="1"></li>';
              }
              if($row['Picture3']){
                echo '<li data-target="#carouselExampleCaptions" data-slide-to="2"></li>';
              }
             ?>
            
            
            
          </ol>
          <div class="carousel-inner">
              <?php 
             if($row['Picture1']){
               echo'<div class="carousel-item active"><img src="'.$row['Picture1'].'"  class="d-block w-100" style="height:30vw"><div class="carousel-caption d-none d-md-block" onerror="this.src='.'/resources/views/jhongcorn/img/bg1.png'.'"><h5>'.$row['Picdescribe1'].'</h5></div></div>';
              }
              if($row['Picture2']){
                echo'<div class="carousel-item "><img src="'.$row['Picture2'].'"  class="d-block w-100" style="height:30vw"><div class="carousel-caption d-none d-md-block" onerror="this.src='.'/resources/views/jhongcorn/img/bg1.png'.'"><h5>'.$row['Picdescribe2'].'</h5></div></div>';
              }
              if($row['Picture3']){
                echo'<div class="carousel-item "><img src="'.$row['Picture3'].'"  class="d-block w-100" style="height:30vw"><div class="carousel-caption d-none d-md-block" onerror="this.src='.'/resources/views/jhongcorn/img/bg1.png'.'"><h5>'.$row['Picdescribe3'].'</h5></div></div>';
              }
             ?>

          </div>
          <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
          </a>
          <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
          </a>
        </div>
      </div> <?php }?> 
    <div class="card-body"> 
        <!-- Quotation -->
      <div class="card-text text-left">
          <ul class="list-group list-group-flush">
            <?php if($row['Addr']){?>
              <li class="list-group-item"> <p><a href="https://www.google.com.tw/maps/place/<?php echo $row['Py'].",".$row['Px'];?>/" class="card-link " style="position: relative;" target="new"><i class="fas fa-map-marker-alt"></i><span class="card-text ml-2"><?php echo $row['Addr'];?></span></a></p></li><?php }?>
             
              <?php if($row['Tel']){?>
              <li class="list-group-item " >
                  <div class="d-flex">
                      <a href="tel:<?php echo $row['Tel'];?>" >
                          <i class="fas fa-phone"></i> 
                          <span class="ml-3  "><?php echo $row['Tel'];?></span>
                      </a> 
                     
                  </div>
                  
              </li>
              <?php }?> 
               <?php if($row['Opentime']){?>
              <li class="list-group-item ">
                  
                <p class="ml-3 mr-auto">開放時間</p>
                <span class="ml-3 "><?php echo $row['Opentime'];?></span>

                  
              </li>
              <?php }?> 
              <?php if($row['Toldescribe']){?>
              <li class="list-group-item " id="<?php echo $row['scenic_Id'];?>_Toldescribe" onclick="show(this.id)">
                  <div class="d-flex"> 
                     <span class="ml-3 mr-auto">詳細介紹</span>
                      <i class="fas fa-chevron-circle-down"></i> 
                  </div>
                  <p class="ml-3 textnone "><?php echo $row['Toldescribe'];?></p>
              </li>
              <?php }
              ?>
              <?php if($row['Description']){
                if($row['Description']!=$row['Toldescribe']){?>
              <li class="list-group-item " id="<?php echo $row['scenic_Id'];?>_Description" onclick="show(this.id)">
                  <div class="d-flex"> 
                     <span class="ml-3 mr-auto">簡介</span>
                     <i class="fas fa-chevron-circle-down"></i> 
                  </div>
                  <p class="ml-3 textnone "><?php echo $row['Description'];?></p>
              </li>
              <?php }}
              ?>
              <?php 
                  if($row['Travellinginfo']){
              ?>
              <li class="list-group-item" id="<?php echo $row['scenic_Id'];?>_Serviceinfo" onclick="show(this.id)">
                  <div class="d-flex"> 
                     <span class="ml-3 mr-auto">旅遊信息</span>
                      <i class="fas fa-chevron-circle-down"></i> 
                  </div>
                  <p class="ml-3 textnone"><?php echo $row['Travellinginfo'];?></p>
              </li>
              <?php }
              ?>

              <?php 
                  if($row['Ticketinfo']){
              ?>
              <li class="list-group-item" id="<?php echo $row['scenic_Id'];?>_Ticketinfo" onclick="show(this.id)">
                  <div class="d-flex"> 
                     <span class="ml-3 mr-auto">票務信息</span>
                      <i class="fas fa-chevron-circle-down"></i> 
                  </div>
                  <p class="ml-3 textnone"><?php echo $row['Ticketinfo'];?></p>
              </li>
              <?php }
              ?>
              <li class="list-group-item" id="<?php echo $row['scenic_Id'];?>_Parkinginfo" onclick="show(this.id)">
                  <div class="d-flex"> 
                     <span class="ml-3 mr-auto">停車信息</span>
                     <i class="fas fa-chevron-circle-down"></i> 
                     <a href="https://www.google.com.tw/maps/place/<?php echo $row['Parkinginfo_Py'].",".$row['Parkinginfo_Px'];?>/" class="card-link " style="position: relative;" target="new">
                      
                  </div>
                  <?php if($row['Parkinginfo']){?>
                  <p class="ml-3 textnone"><?php echo $row['Parkinginfo'];?></p> 
                <?php }else{
                  echo '<p class="ml-3 textnone">內有停車場</p>';
                }?>
                </a> 
              </li>
             
              <?php 
                  if($row['Remarks']){
              ?>
              <li class="list-group-item" id="<?php echo $row['scenic_Id'];?>_Remarks" onclick="show(this.id)">
                  <div class="d-flex"> 
                     <span class="ml-3 mr-auto">票務信息</span>
                      <i class="fas fa-chevron-circle-down"></i> 
                  </div>
                  <p class="ml-3 textnone"><?php echo $row['Remarks'];?></p>
              </li>
              <?php }
              ?>

               <?php 
                  if($row['Keyword']){
              ?>
              <li class="list-group-item" id="<?php echo $row['scenic_Id'];?>_Keyword" onclick="show(this.id)">
                  <div class="d-flex"> 
                     <span class="ml-3 mr-auto">搜尋關鍵詞</span>
                      <i class="fas fa-chevron-circle-down"></i> 
                  </div>
                  <p class="ml-3 textnone"><?php echo $row['Keyword'];?></p>
              </li>
              <?php }
              ?>
          </ul>           
                  
      </div>
    </div>

</div>
@include('jhongcorn.map')
<?php
  $maprestaurant_map=false;
?>
<div class="card mt-3" id="<?php echo $row['scenic_Id'];?>_restaurant" onclick="show(this.id)" >
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
                <a href="https://www.google.com.tw/maps/place/<?php echo $row1['Py'].",".$row1['Px'];?>/" class="card-link " style="position: relative;" target="new"><i class="fas fa-map-marker-alt"></i>
                  <span class="card-text ml-2"><?php  echo $row1['Name'];?></span>
                  <span class="ml-3"><?php echo round($maprestaurant/1000,1)."km";?></span>
              </a>
              <hr>
            </div> 
        
        <?php }         
        } 

        if(!$maprestaurant_map){
            echo "<style>#".$row['scenic_Id']."_restaurant{display:none;}</style>";
        }
        ?>
        </div>
    </div>
</div>



<?php
    $maphotel_ch_map=false;
?>

<div class="card mt-3" id="<?php echo $row['scenic_Id'];?>_hotel_ch" onclick="show(this.id)">
    <div class="card-header d-flex">
        <h5 class="mb-2 h5 mr-auto">附近旅館</h5>
        <h5><i class="fas fa-chevron-circle-down "></i><h5>
    </div>
    <div class="card-body textnone">
        <div class="row">
            
        
        <?php
            foreach ($hotel_ch as $row2) {
                $maphotel_ch=getdistance($row['Py'],$row['Px'],$row2['Py'],$row2['Px']);
                if($maphotel_ch<=5000){
                  $maphotel_ch_map=true;
        ?>
        <div class=" card-text   col-md-6 col-sm-12">
        
          <a href="https://www.google.com.tw/maps/place/<?php echo $row2['Py'].",".$row2['Px'];?>/" class="card-link " style="position: relative;" target="new">
              <i class="fas fa-map-marker-alt"></i>
              <span class="card-text ml-2">
            <?php  echo $row2['Name'];?></span>
            <span class="ml-3"><?php echo round($maphotel_ch/1000,1)."km";?></span>
          </a>
          <hr>
        </div> 
        
        <?php }
       

    }
        if(!$maphotel_ch_map){
            echo "<style>#".$row['scenic_Id']."_hotel_ch{display:none;}</style>";
        }
    ?>
        </div>
    </div>
</div>

    
    
    <?php 
  }


?>
@endsection