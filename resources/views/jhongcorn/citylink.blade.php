@extends('jhongcorn.layout.jhongcorn')
@section('content')
<style>
    .collapse_Name{
    top:115px;
    }
    .collapse_Name h3{
    font-size: 30px;
    }
    
    @media (max-width: 540px){
      .collapse_Name h3{
        font-size: 20px;
      }
        }
</style>
      <h4 >
        <?php echo $citylink.":"."共".count($Region).$pagetext;?>
      </h4>
      <hr>
      <div align="center" class="row" id="accordion">
        @foreach ($citylink_dbtable as $items)
               <div class="col-md-4 my-3" id="<?php echo $items[$table_Id];?>">
          <div class="card  border border-info rounded-pill ">          
              <a data-toggle="collapse" data-target="#collapse<?php echo $items[$table_Id];?>" aria-expanded="false" aria-controls="collapse<?php echo $items[$table_Id];?>">
                <img class=" card-img  rounded-pill cityimg"  src="<?php echo $items['Picture1']!=""?$items['Picture1']:'/resources/views/jhongcorn/img/'.$errorimg;?>" onerror="this.src='/resources/views/jhongcorn/img/<?php echo $errorimg;?>'">
                <div class="card-img-overlay collapse_Name ">
                  <h3  class="card-title  h3 text-white" style="text-shadow:2px 2px 2px #000000,-2px -2px 2px #000000;"><?php echo $items['Name'];?></h3>
                </div>
              </a>
            <div id="collapse<?php echo $items[$table_Id];?>" class="collapse" aria-labelledby="heading<?php echo $items[$table_Id];?>" data-parent="#accordion">
              <div class="card-body text-left "   >
                <hr>
                <p class="h4 card-title font-weight-bold text-center">
                  <?php if($items['Website']){?>
                  <a href="<?php echo $items['Website'];?>" class="card-link h5 " style="position: relative;" target="new"><i class="fab fa-staylinked"></i></a> <br><?php }?>
                 
    
                  <?php  if(!empty($items['Grade'])){
                    for($i=1;$i<=(int)$items['Grade'];$i++){ ?>
                  <i class="fas fa-star text-warning" style="font-size: 0.1vh;"></i>
                <?php }}?>
                </p>
                <p class="card-text m-4 p-3"><?php echo $items['Description']?mb_substr($items['Description'],0,30,'utf-8')."...":'';?></p>
                <?php if($items['Addr']){?>
                <p class=" m-4"><a href="https://www.google.com.tw/maps/place/<?php echo $items['Py'].",".$items['Px'];?>/" class="card-link " style="position: relative;" target="new"><i class="fas fa-map-marker-alt"></i><span class="card-text ml-2"><?php echo $items['Addr'];?></span></a></p><?php }?>
                <?php if($items['Tel']){?>
                 <p class=" m-4"><a href="tel:<?php echo $items['Tel'];?>" class="card-link " style="position: relative;" target="new"><i class="fas fa-phone"></i><span class="card-text ml-2"><?php echo $items['Tel'];?></span></a></p>
                <?php }?>
                <p class="m-4 text-center"><a  href="/tourism/{{ $dbtable }}/{{ $table_Id }}/{{ $items[$table_Id] }}"  class="btn  btn-sm blue-gradient rounded-pill" style="position: relative;" target="_blank"><?php echo "查看詳細內容";?></a></p>
              </div>
            </div>
          </div>
    
    
        </div>     
        @endforeach
        
     

        
      </div> 
    
      <hr>
      <nav  aria-label="Page navigation example" class="d-flex">
        <ul class="mr-auto ml-auto pagination">
          <?php if ($pageNum > 0) { ?>
          <li class="page-item">
              <a href="{{ url('/citylink/'. $citylink.'/') }}" class="page-link"><i class=" fas fa-angle-double-left text-info"></i></a></li>
          <li class="page-item"><a href="{{ url('/citylink/'. $citylink.'/'.($pageNum-1)) }}"class="page-link"><i class="fas fa-angle-left text-info"></i></a></li><?php }?>
          <li class="page-item"><span><?php echo "第".' '.($pageNum+1).' '.'頁';?></span></li>
          <li class="page-item"><span><?php echo "/共".' '.($totalPages+1).' '."頁";?></span></li>
          <?php if ($pageNum < $totalPages) {?>
          <li class="page-item">
            <a href="{{ url('/citylink/'. $citylink .'/'. ($pageNum+1)) }} "class="page-link"><i class="fas fa-angle-right text-info"></i></a>
          </li>
          <li class="page-item"><a href="{{ url('/citylink/'. $citylink .'/'. $totalPages) }} "class="page-link"><i class="fas fa-angle-double-right text-info"></i></a></li><?php }?>
        </ul>
      </nav>

    @endsection
