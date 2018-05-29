<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    protected $table ="persons";
    protected $fillable = ['name','document_number','phone','cell_phone','address','start_date','user_id'];


    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function properties()
    {
        return $this->belongsToMany('App\Property')->using('App\PersonProperty');
    }

    public function  scopeSearch($query,$name,$document_number)
    {
        if ( $name != ""){
           $query =  $query->Where('name','LIKE',"%$name%");
        }
        else{
           $query = $query->Where('document_number','LIKE',"$document_number%");
        }
        return $query;
    }
}
