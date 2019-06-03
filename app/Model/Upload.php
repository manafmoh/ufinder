<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Upload extends Model
{
    protected $fillable = ['filepath'];

    public function getRouteKeyName()
    {
        return 'filepath';
    }
}
