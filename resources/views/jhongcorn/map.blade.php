<?php
function getdistance($lng1,$lat1,$lng2,$lat2){
   //將角度轉為弧度 
   $radLat1=deg2rad($lat1);  
   $radLat2=deg2rad($lat2); 
   $radLng1=deg2rad($lng1); 
   $radLng2=deg2rad($lng2); 
   $tmp1=$radLat1-$radLat2; 
   $tmp2=$radLng1-$radLng2;
   //計算公式 
   $d=2*asin(sqrt(pow(sin($tmp1/2),2)+cos($radLat1)*cos($radLat2)*pow(sin($tmp2/2),2)))*6378.137*1000; 
   //單位公尺
   return intval($d);
 }


?>