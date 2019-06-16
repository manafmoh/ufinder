<?php

namespace App\Model;

use App\User;
use App\Model\Message;
use App\Model\Category;
use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    protected $with = ['message'];

    // Boot method for adding slug automaticaly when create AD

    protected static function boot() {

        parent::boot();

        static::creating(function ($ad){
            //$ad->slug = str_slug($ad->title);
            $ad->slug = $ad->setSlug($ad->title);
        });
    }
    //Mutator not wrking
    public function setSlug($value) {
        if (static::whereSlug($slug = str_slug($value))->exists()) {
            $slug = $this->incrementSlug($slug);
        }
        return $slug;
        //$this->attributes['slug'] = $slug;
    }
    public function incrementSlug($slug) {
        $original = $slug;
        $count = 2;
        while (static::whereSlug($slug)->exists()) {
            $slug = "{$original}-" . $count++;
        }
        return $slug;
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
    protected $fillable = ['title','featured','amount','image','body','post_type','type','country','city','area','category_id', 'uploads'];
    //protected $guarded = [];
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function message() {
        return $this->hasMany(Message::class)->latest();
    }

    public function upload() {
        return $this->hasMany(Upload::class);
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function getPathAttribute() {
        //return asset("api/ad/$this->slug");
        return "ad/$this->slug";
    }
}

