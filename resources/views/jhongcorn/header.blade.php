<script>

  $(function(){

     $(window).resize(function() {
      if($(window).width()>540){
         
         
         $('.navbar').css('z-index','1');
         $('footer').css('z-index','1');
         $('.navbar-collapse').removeClass('show');
         if($(".modal").hasClass('show')){
         
        }else{
          $('body').removeClass("modal-open");
          $('.modal-backdrop').remove();
        }
      }
 
    });

   
        
    $("#searchform_menu").on("hidden.bs.modal", function () {
       $("#Search_text").val("");
    });

    $("#Search_text").on('change',function(){
      $("#searchform_btn").trigger('click');
    });
    $("#searchform_btn").click(function(){
        if($("#Search_text").val()!=""){
          $.ajax({
            url: '{{ url("/Search/Keywords") }}',
            type: 'POST',
            dataType: 'json',
            data: {Search_text:$("#Search_text").val(),_token:'{{ csrf_token() }}'},
            success:function(data){
              var searchhtml="";
              if( data[0].length>0){
                searchhtml+='<div class="card-header font-weight-bold col-12">店面:<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
                for (var i = 0; i < data[0].length; i++) {
                  console.log(data[0][i]);
                  searchhtml+='<a class="dropdown-item col-md-6 col-sm-4 searchtext"'+'href="/tourism/restaurant/restaurant_Id/'+data[0][i]["restaurant_Id"]+'" target="_blank">'+data[0][i]["Name"].substring(0,20)+'</a>';
                }  
                     
              }

              if(data[1].length>0){
                searchhtml+='<div class="card-header font-weight-bold col-12">旅館:<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
                for (var j = 0; j < data[1].length; j++) {
                  searchhtml+='<a class="dropdown-item col-md-6 col-sm-4 searchtext"'+'href="/tourism/hotel_ch/hotel_Id/'+data[1][i]["hotel_Id"]+'" target="_blank">'+data[1][j]["Name"].substring(0,20)+'</a>';
                }                
              }
              if(data[2].length>0){
                searchhtml+='<div class="card-header font-weight-bold col-12">景點:<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
                for (var z = 0; z < data[2].length; z++) {
                  searchhtml+='<a class="dropdown-item col-md-6 col-sm-4 searchtext"'+'href="/tourism/scenic_spot/scenic_Id/'+data[1][i]["scenic_Id"]+'" target="_blank">'+data[2][z]["Name"].substring(0,20)+'</a>';
                }                
              }

              if(data[0].length>0 ||data[1].length>0 ||data[2].length>0){
                if(data[0].length==1 ||data[1].length==1||data[2].length==1){
                  $('#searchform_menu .modal-dialog').removeClass('modal-lg');
                }else{
                  $('#searchform_menu .modal-dialog').addClass('modal-lg');
                }
                $('#searchform_menu .modal-body').html(searchhtml);
                $('#searchform_menu').modal('show');    
              }



            },
            error:function(){
              alert("error")},
          });
        }
    });
  });

  function navbarbody(){
    
    if($('#navbarNav').css('display')=='none'){
      $('body').addClass('modal-open');
      $('body').append('<div class="modal-backdrop fade show"></div>');
      $('.navbar').css('z-index','1050');
      $('footer').css('z-index','1050');
    }else{
         $('.modal-backdrop').remove();
        $('body').removeClass("modal-open");
        $('.navbar').css('z-index','1');
       $('footer').css('z-index','1');
    }
  }
</script>
<style>

  .head-img{
    width:30px;
  }
  .head-block{
    display:none;
  }

  @media (max-width: 540px){
    .head-none{
      display:none;
    }
    .head-block{
      display:block;
    }
  } 
</style>

<nav class="navbar navbar-expand-lg navbar-light bg-ligh sticky-top d-flex border border-info bg-info">

  <a class="navbar-brand  zoom " href="/"><img src="/resources/views/jhongcorn/img/logo.jpg" class='rounded-circle d-inline-block align-top' width="40" height="40"><span class="h6">JhongCorn</span></a>
    <?php 
    if(session('loginName')){
      if(session('picture')){ ?>
        <a href="/user/info" class="ml-auto head-block "><img class="head-img img-thumbnail rounded-circle " src="<?php echo session('picture');?>"></a>
  <?php }else{
        echo '<a href="/user/info"  class="ml-auto head-block"><i class="fas fa-user img-thumbnail rounded-circle "></i></a>';
       }
    }else{
      echo '<a  class="ml-auto head-block" data-toggle="modal" data-target="#modalLRForm"><i class="fas fa-user img-thumbnail rounded-circle "></i></a>';
    } ?> 
  <button class="navbar-toggler" type="button" onclick="navbarbody()" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon border rounded-pill border-dark"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">

    <ul class="navbar-nav ">
      <li class="nav-item <?php echo session('hreflink')=='hotel_ch'?'active bg-primary':'';?>">
        <a class="nav-link d-flex " href="/hotel_ch">旅館<i class="fas fa-home ml-auto head-block"></i></a>
      </li>
      <li class="nav-item  <?php echo session('hreflink')=='scenic_spot'?'active bg-primary':'';?>">
        <a class="nav-link d-flex" href="/scenic_spot">景點<i class="fas fa-home ml-auto head-block"></i></a>
      </li>
      <li class="nav-item <?php echo session('hreflink')=='restaurant'?'active bg-primary':'';?>">
        <a class="nav-link d-flex" href="/restaurant">店家<i class="fas fa-home ml-auto head-block"></i></a>
      </li>
    </ul> 
    <ul class="navbar-nav ml-auto">

      <li class=" nav-item ">

        <?php 
        if(session('loginName')){
        ?>
        <div class="head-block ">
            <a  href="/user/info" class="nav-link d-flex <?php echo session('hreflink')=='info'?'active bg-primary':'';?>" ><?php echo session('loginName');?><i class="fas fa-user-circle ml-auto"></i></a>
            <?php {?>
            <a class="nav-link d-flex <?php echo session('hreflink')=='Order'?'active bg-primary':'';?>" href="/user/Order">訂房資訊<i class="fas fa-hotel ml-auto"></i></a><?php }?>
            <a href="{{ url('user/logout') }}" class="nav-link d-flex">登出<i class="fas fa-sign-out-alt ml-auto"></i></a>
        </div>
        <div class="btn-group head-none" role="group">
          <button id="btnGroupDrop1" type="button" class="btn btn-default  btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo session('loginName');?></button>
          <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
            <a class="dropdown-item <?php echo isset($_GET['userinfo'])?'active bg-primary':'';?>" href="/user/info">會員資料</a>
            <?php 
              
             {
            ?>
            <a class="dropdown-item <?php echo session('hreflink')=='Order'?'active bg-primary':'';?>" href="/user/Order">訂房資訊</a>
          <?php }?>
            <a href="{{ url('user/logout') }}" class="dropdown-item" >登出</a>
          </div>
         </div>
        <?php }
          
        else{ ?>
          <div class="head-none"><a  class="btn btn-sm btn-default " data-toggle="modal" data-target="#modalLRForm" >登入/註冊</a></div>
          <div class="head-block"><a  class="nav-link d-flex" data-toggle="modal" data-target="#modalLRForm" >登入/註冊<i class="fas fa-sign-in-alt ml-auto"></i></a></div>
        
        <?php }?>
      </li>
      <li class="nav-item"><div id="google_translate_element" class="nav-link mt-n2" ></div></li>
    </ul> 
  </div> 
</nav>

<div class="input-group md-form form-sm form-2 pl-0">
  <div class="input-group-append" >
    <a class="input-group-text blue lighten-3" id="searchform_btn" ><i class="fas fa-search text-grey"></i></a>
  </div>
  <input class="form-control my-0 py-1 border-info" id="Search_text" type="text" placeholder="關鍵字" aria-label="Search">
</div>


<div class="modal fade" id="searchform_menu" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header text-center">
        <h4 class="modal-title w-100 font-weight-bold">搜尋結果</h4>
      </div>
      <div class="modal-body row">
      </div>
      <div class="card-footer text-center">
        <button type="button" class="btn btn-outline-info  waves-effect " data-dismiss="modal">Close</button>        
      </div>

    </div>
  </div>
</div>







<style>

  #google_translate_element .goog-te-gadget-simple{
    background: #2BBBAD;
    border: 0;

  }

</style>
<script type="text/javascript">

  function googleTranslateElementInit() {

    new google.translate.TranslateElement({pageLanguage: 'zh-TW', includedLanguages: 'en,ja,zh-TW,zh-CN', layout: google.translate.TranslateElement.InlineLayout.SIMPLE}, 'google_translate_element');
   
    $('#google_translate_element .goog-te-gadget-simple').html('<i class="pt-1 fas fa-globe-americas" style="font-size:30px"></i>');
    $('#google_translate_element .goog-te-gadget-simple img').remove();
  }
</script>
<script type="text/javascript" src="/resources/views/jhongcorn/js/translate.js"></script>
@if(!session('loginName'))
@include('jhongcorn.usermodal')
@endif
