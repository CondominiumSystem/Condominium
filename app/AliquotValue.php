<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AliquotValue extends Model
{
    protected $table ="aliquot_values";
    protected $fillable = ['id',
        'value',
        'start_date',
        'end_date',
        'property_type_id',
    ];

    public function propertyType()
    {
        //return $this->hasOne('App\PropertyType');
        return $this->belongsTo('App\PropertyType');

    }


}
