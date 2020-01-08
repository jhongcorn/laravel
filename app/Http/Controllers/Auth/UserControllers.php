<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Model\City;
use App\Http\Model\Jhongcorn;
use App\Http\Model\Room_order;
use Session;
class UserControllers extends Controller
{
    
    public function register(Request $request){
        $title=$request->input("Customer_title")?"先生":"小姐";
		$Name= $request->input("Customer_Last_Name").$request->input("Customer_First_Name");
		$Phone=$request->input("Customer_phone");
		
		$Email= $request->input("Customer_email");
		$Password= $request->input("Customer_password");
		$Addr=$request->input('addr');
		$Birthday= $request->input("Customer_birthday");
		$OAuth_Id=date("ymd").rand();

        $user = User::create([
            'name'     => $Name,
            'title'    => $title,
            'first_Name'=>$request->input("Customer_Last_Name"),
            'last_Name'=>$request->input("Customer_First_Name"),
            'phone'    =>$Phone,
            'email'    => $Email,
            'password' =>$Password,
            'addr'     =>$Addr,
            'birthday' =>$Birthday,
            'provider' => 'this',
            'provider_id' =>$OAuth_Id
        ]);
        Session::put('loginName', $Name);
        Session::put('OAuth','this');
        Session::put('OAuth_Id',$OAuth_Id);
        
         return  $OAuth_Id;
    }
    public function email(Request $request){
        $email_sql=new Jhongcorn();
        $email_sql->citylink('users');
        $email=$email_sql->where('email',$request->input('email'))->get();
        if(count($email)>0){
            echo false;
        }else{
            echo true;
        }
    }
    public function login(Request $request){
        $email=$request->input('login_Email');
        $password=$request->input('login_password');
        $login=User::where('provider', 'this')->where('email',$email)->where('password',$password)->get();
        if (count($login)>0)
        {
           foreach($login as $v){
            Session::put('loginName', $v->name);
            Session::put('picture', $v->picture); 
            Session::put('OAuth',$v->provider);
            Session::put('OAuth_Id',$v->provider_id);
           }

            echo true;
        }else{
            echo false;
        }
    }

    public function userinfo(){
        Session::put('hreflink','info');
        $user=User::where("provider_id",session("OAuth_Id"))->where("provider",session("OAuth"))->get();
        $city_background=self::background();
        $cityName=$city_background['cityName'];
        $cityimg=$city_background['cityimg'];
        return view('jhongcorn.userinfo',compact('user','cityName','cityimg'));
    }

    public function update(Request $request){
      
        $item= str_replace("userinfo_Customer_","",$request->input('item'));
        $value= str_replace("userinfo_Customer_","",$request->input('value'));
        $id=$request->input('id');
      
        $OAuth_Id=$request->input('OAuth_Id');
   
        User::where('provider_id', $OAuth_Id)->where('id',$id)->update([$item=> $value]);
        $user=User::where('provider_id', $OAuth_Id)->where('id',$id)->get();
        $name=$user[0]['last_Name'].$user[0]['first_Name'];
        Session::put('loginName', $name);
        return $name;
    }


    public function upload(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'userinfo_Customer_picture' => 'image|mimes:jpeg,bmp,png|max:2000'
        ]);
        if ($validator->fails()) {
            return '上傳錯誤';
        }else{
            $image = $request->file('userinfo_Customer_picture');
            $new_name= session('OAuth_Id'). '.' . $image->getClientOriginalExtension();
            $image->move(base_path().'/resources/views/jhongcorn/photo', $new_name);
            $filepath="/resources/views/jhongcorn/photo/".$new_name;
            
            return $filepath;
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

    public function new_password(Request $request){
        $new=User::where('id',$request->input('id'))->where('provider','this')->where('provider_id',$request->input('OAuth_Id'))->update(['password'=>$request->input('value')]);
        if($new){
            echo true;
        }else{
            echo false;
        }
    }

    public function forget_password(Request $request){
        $Email=$request->input('forget_email');
        $Phone=$request->input('forget_phone');
        $birthday=$request->input('forget_birthday');
        
        $resalut= User::where('email',$Email)->where('phone',$Phone)->where('birthday',$birthday)->where('provider','this')->get();
        
        
        if(count($resalut)>0){
    
          echo  json_encode($resalut);
        }else{
            echo false;
        }
    }

    public function order($pageNum=null){
        Session::put('hreflink','Order');
        $Region=Room_order::where('OAuth_Id',session('OAuth_Id'))->get();

        $maxRows = 10;
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
     
        
        $bookingorder=Room_order::where('OAuth_Id',session('OAuth_Id'))->offset($startRow)->take($maxRows)->get();
        $hotel_sql=new Jhongcorn();
        $hotel_sql->citylink('hotel_ch');
       
        $hotelorder=$hotel_sql->get();

        
        return view('jhongcorn.User_Order',compact('bookingorder','hotelorder','pageNum','totalPages'));
    }
    public function Change_Order(Request $request){
   
        if("Change_Order"==base64_decode(str_replace(" ","+",$request->input('Change_Order')))){
               
            Room_order::where("Order_Id",$request->input('order_id'))->where('hotel_Id',$request->input('hotel_id'))->where('customer_Id',$request->input('customer_id'))->where('OAuth_Id',$request->input('oauth_id'))->update(['adult'=>$request->input('adult'),'child'=>$request->input('child'),'room'=>$request->input('room')]);
            
            echo true;
    
        }elseif("del_Order"==base64_decode(str_replace(" ","+",$request->input('del_Order')))){
                    //刪除訂房資料
        
                    Room_order::where("Order_Id",$request->input('order_id'))->where('hotel_Id',$request->input('hotel_id'))->where('customer_Id',$request->input('customer_id'))->where('OAuth_Id',$request->input('oauth_id'))->delete();
            echo true;
        
        }else{
            echo false;
        }
        
    }

    public function booking_room(Request $request){
        $userresault=User::where('provider_id',$request->input('user_id'))->get();
       
        if(count($userresault)>0){//抓取ID
            foreach($userresault as $row){
                $user_Customer_Id=$row['id'];
                $user_OAuth_Id=$row['provider_id'];
            }
             
            //判斷是否已有訂房紀錄
            $bookingresault=Room_order::where("customer_Id",$user_Customer_Id)->where("OAuth_Id",$user_OAuth_Id)->get();
            $data=array('hotel_Id'=>$request->input('hotel_id'), 'customer_Id'=>$user_Customer_Id, 'OAuth_Id'=>$user_OAuth_Id, 'Checkin_date'=>$request->input('Checkin_date'), 'Checkout_date'=>$request->input('Checkout_date'), 'adult'=>$request->input('adult'), 'child'=>$request->input('child'), 'nights'=>$request->input('nights'), 'room'=>$request->input('room'), 'times'=>date("Y-m-d H:i:s"));
            if(count($bookingresault)>0){
                foreach ($bookingresault as  $value) {
                    $bookingdate=self::prDates($value['Checkin_date'],$value['Checkout_date'],$request->input('Checkin_date'));
                }
                if($bookingdate){
                    Room_order::insert($data);
                    echo true;				
                }else{
                    echo false;
                }
            }else{	
                

                
                Room_order::insert($data);
                echo true;			
            }
            
        }else{
            echo false;
        }
    }

    function prDates($start, $end,$new_start) { 

	    $dt_start = strtotime($start);
	    $dt_end   = strtotime($end);
	    $new_dt_start = strtotime($new_start);

 
 		if($dt_start<=$new_dt_start && $new_dt_start<=$dt_end){
 			return false;
 		}else{
 			return true;
 		}
        
    }	
}
