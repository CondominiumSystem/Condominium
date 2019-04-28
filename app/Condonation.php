<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Condonation extends Model
{
  protected $table ="condonations";
  protected $fillable = [
      'user_id',
      'transaction_id',
      'note',
      'vaule'

      ];

}
