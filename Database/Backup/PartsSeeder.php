<?php

namespace Database\Seeds;

use Carbon\Carbon;
use Faker\Factory;

use Database\AbstractSeeder;

class PartsSeeder extends AbstractSeeder {

    protected ?string $tableName = 'Part';

    protected array $tableColumns = [
        [
            'data_type' => 'int',
            'column_name' => 'carID'
        ],
        [
            'data_type' => 'string',
            'column_name' => 'name'
        ],
        [
            'data_type' => 'string',
            'column_name' => 'description'
        ],
        [
            'data_type' => 'float',
            'column_name' => 'price'
        ],
        [
            'data_type' => 'int',
            'column_name' => 'quantityInStock'
        ],
        [
            'data_type' => 'string',
            'column_name' => 'created_at'
        ],
        [
            'data_type' => 'string',
            'column_name' => 'updated_at'
        ]
    ];

    public function createRowData(): array
    {
        $faker = Factory::create();
        $fake_rowdata_arr = [];

        for($i = 0;$i < 10000;$i++){
            $now = Carbon::now();
            $randomDays = rand(0, 30);
            $randomDate = $now->copy()->addDays($randomDays);
            
            $fake_rowdata_arr[$i] = [
                $faker->numberBetween(1, 1000),
                $faker->title(),
                $faker->sentence(),
                $faker->randomFloat(null, 10, 100),
                $faker->randomNumber(),
                Carbon::now()->format('Y-m-d H:i:s'),
                $randomDate->format('Y-m-d H:i:s')
            ];
        }
        return $fake_rowdata_arr;
    }
}