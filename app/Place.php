<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    // чтобы не использовать временные метки updated_at и created_at
    public $timestamps = false;
}
