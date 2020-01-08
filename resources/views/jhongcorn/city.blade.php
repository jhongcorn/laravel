@extends('jhongcorn.layout.jhongcorn')
@section('content')
<style>
  p{
   font-size: 30px; 
  }
  @media (max-width: 540px){
 p{
  font-size: 20px;
 }
  
}
</style>  

<p class="text-center mb-5">您想查詢哪個縣市的{{ $indexh4 }}</p>

  <div align="center" class="row">
@foreach ($city as $item)
  <div class="col-md-4 ">
  
    <a href="/citylink/{{ $item->City_ch }}"  class=" card  rounded-circle">
      
          <div class="view  zoom  rounded-circle">
            <img class="card-img rounded-circle cityimg img-thumbnail"  src="{{ asset('/resources/views/jhongcorn/img/'.$item->City_img) }}" >
            <div class="card-img-overlay" style="top:30%">
              <div class="card-body ">
                <div class=" text-white" >

                  <p style="text-shadow:2px 2px 2px #000000,-2px -2px 2px #000000;">{{ $item->City_ch }}</p>
                   <span class="badge badge-pill badge-info">{{ count($citylink_dbtable->where('Region',$item->City_ch)) }}</span>
                </div>
                
               
              </div>
              
            </div>
          </div>  

    </a>
    <!-- Card -->
    <br>
  </div>    
@endforeach

  

  </div>
@endsection