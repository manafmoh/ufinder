<?php

namespace App\Model;

use App\User;
use App\Model\Message;
use App\Model\Category;
use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    public function getRouteKeyName()
    {
        return 'slug';
    }
    //protected $fillable = [];
    protected $guarded = [];
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function message() {
        return $this->hasMany(Message::class);
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function getPathAttribute() {
        return asset("api/ad/$this->slug");
    }
}

