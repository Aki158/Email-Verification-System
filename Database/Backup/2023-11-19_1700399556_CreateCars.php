<?php

namespace Database\Migrations;

use Database\SchemaMigration;

class CreateCars implements SchemaMigration
{
    public function up(): array
    {
        return [
            "CREATE TABLE IF NOT EXISTS Car (
                id INT PRIMARY KEY AUTO_INCREMENT,
                make VARCHAR(50),
                model VARCHAR(50),
                year INT,
                color VARCHAR(20),
                price FLOAT,
                mileage FLOAT,
                transmission VARCHAR(20),
                engine VARCHAR(20),
                status VARCHAR(10),
                created_at DATETIME NOT NULL,
                updated_at DATETIME NOT NULL
            )"            
        ];
    }

    public function down(): array
    {
        return [
            "DROP TABLE Car"
        ];
    }
}