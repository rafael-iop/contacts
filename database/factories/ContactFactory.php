<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Contact::class, function (Faker $faker) {
	$faker->addProvider(new \Faker\Provider\pt_BR\Person($faker));

    return [
        'name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => $faker->unique()->safeEmail,
        'phone' => $faker->unique()->phoneNumber
    ];
});
