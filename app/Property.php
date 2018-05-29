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
        return $this->hasMany('App\Payments');
    }

    public function  scopeSearchByPersonId($query,$person_id)
    {
        $query =  $query->Where('id','=',"%%");
        return $query;
    }

}
