<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PersonType extends Model
{
    protected $table ="person_types";
    protected $fillable = ['name'];


    public function persons()
    {
      return $this-> hasMany ('App\Person');
    }
}
