<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Garment extends Model
{
    //
    protected $table = "garments";
    protected $guarded = ['id'];
}
