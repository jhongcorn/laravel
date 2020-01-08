<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Jhongcorn extends Model
{
    //
   protected  $table;
   
   public function citylink($citylink){
  
    $this->table=$citylink;
    
   }
}
