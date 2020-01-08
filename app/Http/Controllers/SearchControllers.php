<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Model\City;
use App\Http\Model\Jhongcorn;
use Session;
class SearchControllers extends Controller
{
    //
    public function search(Request $request){
        $Search_text=mb_ereg_replace("台","臺", $request->input('Search_text'));
        $resault_hotel_ch=self::sqltable('hotel_ch',$Search_text);
        $resault_restaurant=self::sqltable('restaurant',$Search_text);
        $resault_scenic_spot=self::sqltable('scenic_spot',$Search_text);
        $json_restaurant=array();
		$json_hotel_ch=array();
        $json_scenic_spot=array();

        if(count($resault_restaurant)>0){
			foreach ($resault_restaurant as  $key => $value) {
				$json_restaurant[]=$value;
			}
		}

		if(count($resault_hotel_ch)>0){
			foreach ($resault_hotel_ch as $key => $value) {
				$json_hotel_ch[]=$value;
			}
		}

		if(count($resault_scenic_spot)>0){
			foreach ($resault_scenic_spot as  $key => $value) {
				$json_scenic_spot[]=$value;
			}
		}
		$json=array($json_restaurant,$json_hotel_ch,$json_scenic_spot);
		echo json_encode($json);
        

    }
    function sqltable($table,$search){
        $search_sql=new Jhongcorn();
        $search_sql->citylink($table);
      
        if (!empty($search)) {
            $searchs_sql = $search_sql->where(function ($query) use ($search) {
                $query->where('Name','like','%'.$search.'%')->orwhere('Description','like','%'.$search.'%')->orwhere('Town','like','%'.$search.'%');
            });
        }
        return $searchs_sql->get();
	}
}
