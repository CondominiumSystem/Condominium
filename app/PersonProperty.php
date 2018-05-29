<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;


class PersonProperty extends Pivot
{
    protected $table ="person_property";
    protected $fillable = [
        'person_id',
        'property_id',
        'owner',
        'life_here'
    ];
}
