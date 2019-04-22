<?php

namespace App\Model;

use App\User;
use App\Model\Ad;
use App\Model\Like;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $guarded = [];
    public function ad() {
        return $this->belongsTo(Ad::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function like() {
        return $this->hasMany(Like::class);
    }
}
