<?php

namespace App\Model;

use App\Model\Ad;
use App\Model\Place;
use App\Model\State;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $guarded = [];
    protected static function boot() {

        parent::boot();

        static::creating(function ($district){
            $district->slug = $district->setSlug($district->name);
        });
    }
    public function state() {
        return $this->belongsTo(State::class);
    }

    public function place() {
        return $this->hasMany(Place::class);
    }
    public function ads() {
        return $this->hasMany(Ad::class);
    }
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function setSlug($value) {
        if (static::whereSlug($slug = str_slug($value))->exists()) {
            $slug = $this->incrementSlug($slug);
        }
        return $slug;
    }
    public function incrementSlug($slug) {
        $original = $slug;
        $count = 2;
        while (static::whereSlug($slug)->exists()) {
            $slug = "{$original}-" . $count++;
        }
        return $slug;
    }
    public function getDistrictpathAttribute() {
        //return asset("api/ad/$this->slug");
        return "/district/".$this->state->slug."_".$this->slug;
    }
    public function getPlacepathAttribute() {
        //return asset("api/ad/$this->slug");
        return "/area/".$this->state->slug."/".$this->slug;
    }
}
