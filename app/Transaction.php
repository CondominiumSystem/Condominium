<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table ="transaction";
    protected $fillable = ['transaction_id','ruc','email','phone','address'];

}
