<?php

namespace Database\Seeds;

use Database\Seeder;
use Faker\Factory as Faker;
use Models\ORM\Character;
use Models\ORM\Head;

// 2. 各キャラクターにヘッドを作成する HeadSeeder を作成します。
class HeadSeeder implements Seeder{

    protected static ?int $characterId = null;
    
    public function setId(int $id)
    {      
        self::$characterId = $id;
    }

    public function getId()
    {
        return self::$characterId;
    }

    public function seed(): void
    {
        //  HeadSeeder はすべてのキャラクターを取得します
        $allCharacter = Character::getAll();
        $classname = "heads";
        $id = 'id';
        $rows = [];

        for($i = 0; $i < count($allCharacter); $i++){
            // それぞれにヘッドがあるかどうかをチェックします。
            if($allCharacter[$i]->hasOne($classname) === null){
                $this->setId($allCharacter[$i]->id);
                //  キャラクターにヘッドがない場合、シーダーはそのキャラクターのためにヘッドを作成します。
                $rows[$i] = $this->createRowData();
            }
        }
        
        foreach ($rows as $data){
            Head::create($data);
        }
    }

    public function createRowData(): array
    {
        $faker = Faker::create();

        return [
            'character_id'=> $this->getId(),
            'eye'         => $faker->numberBetween(1, 30),
            'nose'        => $faker->numberBetween(1, 30),
            'chin'        => $faker->numberBetween(1, 30),
            'hair'        => $faker->numberBetween(1, 30),
            'eyebrows'    => $faker->numberBetween(1, 30),
            'hair_color'  => $faker->numberBetween(1, 30)
        ];
    }
}