<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Model\City;
use App\Http\Model\Room_order;
use App\Http\Model\Jhongcorn;
use Session;
class IndexControllers extends Controller
{
    //
    public function index($tourism=null){
        if($tourism==null){
            $tourism='hotel_ch';
        }
        switch ($tourism) {
            case 'hotel_ch':
                $indexh4="旅館";
                break;
            case 'restaurant':
                $indexh4="店家";
                break;
            case 'scenic_spot':
                $indexh4="景點";
                break;               
            default:
                $indexh4="旅館";
                break;
        }
        Session::put('tourism', $tourism);
        Session::put('hreflink',$tourism);
        $city=City::get();
        $Jhongcorn=new Jhongcorn();
        $Jhongcorn->citylink($tourism);
        
        $citylink_dbtable=$Jhongcorn->get();
        return view('jhongcorn.city',compact('city', 'citylink_dbtable','indexh4'));
    }
    public function citylink($citylink,$pageNum=null){
        $maxRows = 15;
        $Jhongcorn=new Jhongcorn;
        $Jhongcorn->citylink(session('tourism'));
        $Region=$Jhongcorn->where('Region',$citylink)->get();
        $totalPages=ceil(count($Region)/$maxRows)-1;

        if($pageNum==null){
            $pageNum=0;
        }

        if($pageNum<0){
            $pageNum=0;
        }else if($pageNum>$totalPages){
            $pageNum=$totalPages;
        }  
        $startRow = $pageNum * $maxRows;
        $citylink_dbtable=$Jhongcorn->where('Region',$citylink)->offset($startRow)->take($maxRows)->get();

        switch (session('tourism')) {
            case 'hotel_ch':
                $dbtable='hotel_ch';
                $table_Id='hotel_Id';
                $errorimg="bg.png";
                $pagetext="間民宿";
                break;
            case 'restaurant':
                $dbtable='restaurant';
                $table_Id='restaurant_Id';
                $errorimg="bg2.png";
                $pagetext="間店家";
                break;
            case 'scenic_spot':
                $dbtable='scenic_spot';
                $table_Id='scenic_Id';
                $errorimg="bg1.png";
                $pagetext="個景點";
                break;               
            default:
                $dbtable='hotel_ch';
                $table_Id='hotel_Id';
                $errorimg="bg.png";
                $pagetext="間民宿";
                break;
        }
        return view('jhongcorn.citylink',compact('citylink', 'citylink_dbtable','table_Id','errorimg','pagetext','Region','pageNum','totalPages','dbtable'));
    }

    public function tourism($dbtable,$table_Id,$tourism_Id){
        Session::put('tourism', $dbtable);
        $Jhongcorn_tourism=new Jhongcorn();
        $Jhongcorn_tourism->citylink($dbtable);
        $tourism=$Jhongcorn_tourism->where($table_Id,$tourism_Id)->get();
        $city_background=self::background();
        $cityName=$city_background['cityName'];
        $cityimg=$city_background['cityimg'];
        $booking_hotel=false;



        $restaurant_sql=new Jhongcorn();
        $restaurant_sql->citylink('restaurant');
        $restaurant=$restaurant_sql->get();

        $scenic_spot_sql=new Jhongcorn();
        $scenic_spot_sql->citylink('scenic_spot');
        $scenic_spot=$scenic_spot_sql->get();

        $hotel_ch_sql=new Jhongcorn();
        $hotel_ch_sql->citylink('hotel_ch');
        $hotel_ch=$hotel_ch_sql->get();

        
        if(session('tourism')=='hotel_ch'){
            if(Session::has('OAuth_Id')){
                $bookingresault= Room_order::where($table_Id,$tourism_Id)->where('OAuth_Id',Session::get('OAuth_Id'))->get();  
               
               if(count($bookingresault)>0){
                   $booking_hotel=true;
               }else{
                   $booking_hotel=false;
               }
           }
        }
        switch (session('tourism')) {
            case 'hotel_ch':
                return view('jhongcorn.'.$dbtable,compact('tourism','cityName','cityimg','booking_hotel','restaurant','scenic_spot'));
                break;
            case 'restaurant':
                return view('jhongcorn.'.$dbtable,compact('tourism','cityName','cityimg','hotel_ch','scenic_spot'));
                break;
            case 'scenic_spot':
                return view('jhongcorn.'.$dbtable,compact('tourism','cityName','cityimg','restaurant','hotel_ch'));
                break;               
            default:
                return view('jhongcorn.'.$dbtable,compact('tourism','cityName','cityimg','booking_hotel','restaurant','scenic_spot'));
                break;
        }
        
    }

     function background(){
        $city=City::get();
        $cityName = array();
        $cityimg = array();
        $i=0;
        foreach ($city as $row){
            $cityName[$i]=$row['City_ch'];
            $cityimg[$i]=$row['City_img'];
              $i++;
       }   	
       return compact('cityName','cityimg');
    }
}
