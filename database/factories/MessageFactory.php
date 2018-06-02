<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Message::class, function (Faker $faker) {

    return [
    	'contact_id' => function () {
            return factory(App\Models\Contact::class)->create()->id;
        },
    	'description' => $faker->text(rand(5, 2000)),
    ];
});
