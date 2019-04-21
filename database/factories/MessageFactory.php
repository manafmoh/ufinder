<?php

use App\User;
use App\Model\Ad;
use Faker\Generator as Faker;


$factory->define(App\Model\Message::class, function (Faker $faker) {
    return [
        'body' => $faker->text,
        'ad_id' => function() {
            return Ad::all()->random();
        },
        'user_id' => function() {
            return User::all()->random();
        },
    ];
});
