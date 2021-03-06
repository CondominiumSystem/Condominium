<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    protected $table ="properties";
    protected $fillable = [
        'lot_number',
        'note',
        'address',
        'acive',
        'property_type_id',
        'person_id'];


    public function persons()
    {
        return $this->belongsToMany('App\Person');
    }

    public function property_type()
    {
        return $this->belongsTo('App\PropertyType');
    }


    public function payments()
    {
        return $this->hasMany('App\Payment');
    }

    public function  scopeSearchByLotNumber($query,$lot_number)
    {
        $query =  $query->Where('lot_number','=',$lot_number);
        return $query;
    }

    /*
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
    */
}
