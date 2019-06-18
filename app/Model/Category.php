<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'slug'];
    protected static function boot() {

        parent::boot();

        static::creating(function ($category){
            $category->slug = $category->setSlug($category->name);
        });
    }
    public function getRouteKeyName()
    {
        return 'slug';
    }
    /*public function subCategories() {
        return $this->hasMany(Category::class);
    }*/
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
    public function getPathAttribute() {
        //return asset("api/ad/$this->slug");
        return "category/$this->slug";
    }
}
