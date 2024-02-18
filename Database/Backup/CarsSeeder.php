<?php

namespace Database\Seeds;

use Carbon\Carbon;
use Faker\Factory;

use Database\AbstractSeeder;

class CarsSeeder extends AbstractSeeder {

    protected ?string $tableName = 'Car';

    protected array $tableColumns = [
        [
            'data_type' => 'string',
            'column_name' => 'make'
        ],
        [
            'data_type' => 'string',
            'column_name' => 'model'
        ],
        [
            'data_type' => 'int',
            'column_name' => 'year'
        ],
        [
            'data_type' => 'string',
            'column_name' => 'color'
        ],
        [
            'data_type' => 'float',
            'column_name' => 'price'
        ],
        [
            'data_type' => 'float',
            'column_name' => 'mileage'
        ],
        [
            'data_type' => 'string',
            'column_name' => 'transmission'
        ],
        [
            'data_type' => 'string',
            'column_name' => 'engine'
        ],
        [
            'data_type' => 'string',
            'column_name' => 'status'
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
        $faker->addProvider(new \Faker\Provider\Fakecar($faker));
        $fake_rowdata_arr = [];

        for($i = 0;$i < 1000;$i++){
            $now = Carbon::now();
            $randomDays = rand(0, 30);
            $randomDate = $now->copy()->addDays($randomDays);
            
            $fake_rowdata_arr[$i] = [
                $faker->randomElement(['Toyota', 'Isuzu', 'Suzuki', 'Subaru', 'Daihatu']),
                $faker->vehicleModel,
                (int)$faker->year(),
                $faker->colorName(),
                (float)$faker->randomNumber(5, true),
                (float)$faker->randomNumber(4, true),
                $faker->vehicleGearBoxType,
                $faker->vehicleFuelType,
                $faker->randomElement(['Available', 'Enabled']),
                Carbon::now()->format('Y-m-d H:i:s'),
                $randomDate->format('Y-m-d H:i:s')
            ];
        }
        return $fake_rowdata_arr;
    }
}