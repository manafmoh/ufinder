<?php

use App\User;
use App\Model\Category;
use Faker\Generator as Faker;

$factory->define(App\Model\Ad::class, function (Faker $faker) {
    $title = $faker->sentence();
    return [
        'title' => $title,
        'slug' => str_slug($title),
        'category_id' => function() {
            return Category::all()->random();
        },
        'body' => $faker->text,
        'user_id' => function() {
            return User::all()->random();
        },
        'featured'=>$faker->numberBetween(0,1),
        'amount'=>$faker->numberBetween(100,1000),
        'image'=>$faker->imageUrl(500,500),
        'post_type' => 'sell',
        'type' => 'new',
        'country' => 'IN',
        'city' => $faker->city,
        'area' => $faker->streetName
    ];
});
