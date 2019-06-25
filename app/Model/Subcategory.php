<?php

namespace App\Model;
use App\Model\Category;
use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{

    protected $guarded = [];
    protected static function boot() {

        parent::boot();

        static::creating(function ($subcategory){
            $subcategory->slug = $subcategory->setSlug($subcategory->name);
        });
    }
    public function category() {
        return $this->belongsTo(Category::class);
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
    public function getSubCategorypathAttribute() {
        //return asset("api/ad/$this->slug");
        return "/sc/$this->slug";
    }
}
