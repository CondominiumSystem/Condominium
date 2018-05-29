<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AliquotValue extends Model
{
    protected $table ="aliquot_values";
    protected $fillable = [
        'value',
        'start_date',
        'end_date',
        'property_type_id',
    ];

    public function property_type()
    {
        return $this->hasOne('App\PropertyType');
    }


}
