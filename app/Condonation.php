<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Condonation extends Model
{
<<<<<<< HEAD
  protected $table ="persons";
  protected $fillable = [
    'transaction_id',
    'note'
  ];
=======
  protected $table ="condonations";
  protected $fillable = [
      'transaction_id',
      'note'
      ];

>>>>>>> b666858e636746fbee7e9a679ebb3a99819c72ba
}
