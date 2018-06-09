<?php

use Faker\Generator as Faker;

$factory->define(App\Property::class, function (Faker $faker) {
     return [
        'lot_number' => rand(1,400),
        'note' => $faker->sentence($nbWords = 4, $variableNbWords = true),
        'address' =>  $faker->streetAddress,
        'active' => 1,
        'property_type_id' =>rand(1,3),

        
    ];
});
