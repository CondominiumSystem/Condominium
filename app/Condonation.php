<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Condonation extends Model
{
  protected $table ="persons";
  protected $fillable = [
    'transaction_id',
    'note'
  ];
}
