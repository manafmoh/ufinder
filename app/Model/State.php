<?php

namespace App\Model;

use App\Model\Ad;
use App\Model\Place;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class State extends Model
{
    protected $fillable = ['name', 'slug'];
    protected static function boot() {

        parent::boot();

        static::creating(function ($state){
            $state->slug = $state->setSlug($state->name);
        });
        // Order by name ASC
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('name', 'asc');
        });
    }
    public function getRouteKeyName()
    {
        return 'slug';
    }
    public function ads() {
        return $this->hasMany(Ad::class);
    }

    public function district() {
        return $this->hasMany(District::class)->orderBy('name', 'asc');
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
    public function getPathAttribute() {
        return "state/$this->slug";
    }
    public function getDistrictpathAttribute() {
        return "/state/$this->slug/district";
    }
    public function getStatepathAttribute() {
        //return asset("api/ad/$this->slug");
        return "/state/$this->slug";
    }
}
