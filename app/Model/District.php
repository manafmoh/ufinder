<?php

namespace App\Model;

use App\Model\Ad;
use App\Model\Place;
use App\Model\State;
use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\Builder;

class District extends Model
{
    protected $guarded = [];
    protected static function boot() {

        parent::boot();

        static::creating(function ($district){
            $district->slug = $district->setSlug($district->name);
        });
        /*static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('name', 'asc');
        });*/
    }
    public function state() {
        return $this->belongsTo(State::class);
    }

    public function place() {
        return $this->hasMany(Place::class)->orderBy('name', 'asc');
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
    public function getFrontplacepathAttribute() {
        //return asset("api/ad/$this->slug");
        return "/place/".$this->state->slug."/".$this->slug;
    }
    public function getPlacepathAttribute() {
        //return asset("api/ad/$this->slug");
        ///state/{state}/{district}/place
        return "/api/state/".$this->state->slug."/".$this->slug."/place";
    }
}
