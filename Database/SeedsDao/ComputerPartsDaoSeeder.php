<?php

namespace Database\SeedsDao;

use Faker\Factory;
use Database\DataAccess\DAOFactory;
use Database\SeederDao;
use Models\ComputerPart;

class ComputerPartsDaoSeeder implements SeederDao{

    public function seed(int $num): bool {
        $faker = Factory::create();
        $partDao = DAOFactory::getComputerPartDAO();

        for($i = 0; $i < $num; $i++){
            $partData = new ComputerPart(
                $faker->randomElement(['Ryzen 9 5900X', 'GeForce RTX 3080', 'Samsung 970 EVO SSD', 'Corsair Vengeance LPX 16GB']),
                $faker->randomElement(['CPU', 'GPU', 'SSD', 'RAM']),
                $faker->randomElement(['AMD', 'NVIDIA', 'Samsung', 'Corsair']),
                null,
                $faker->bothify('**********'),
                $faker->date(),
                $faker->sentence(),
                $faker->numberBetween(1, 100),
                $faker->randomFloat(null, 50, 1000),
                $faker->randomFloat(null, 0, 1),
                $faker->randomFloat(null, 100, 1000),
                $faker->randomFloat(null, 0, 1),
                $faker->randomFloat(null, 0, 1),
                $faker->randomFloat(null, 0, 1),
                $faker->numberBetween(1, 20)
            );    
            $success = $partDao->create($partData);
            if(!$success){
                return false;
            }
        }
        return true;
    }
}
