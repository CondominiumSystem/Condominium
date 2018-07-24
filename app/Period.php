<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Period extends Model
{
    protected $table ="periods";
    protected $fillable = ['year','month_id','month_name'];


    public function payments()
    {
      return $this-> hasMany ('App\Payment');
    }
}
