<?php

namespace App\Model;

use App\Model\State;
use App\Model\District;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Place extends Model
{
    protected $guarded = [];
    protected static function boot() {

        parent::boot();

        static::creating(function ($place){
            $place->slug = $place->setSlug($place->name);
        });
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('name', 'asc');
        });
    }

    public function district() {
        return $this->belongsTo(District::class);
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
    public function getPlacepathAttribute() {
        //return asset("api/ad/$this->slug");
        return "/place/".$this->state->slug."/".$this->district->slug."/".$this->slug;
    }
}
