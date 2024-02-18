<?php

namespace Database;

interface SeederDao
{
    public function seed(int $num): bool;
}