<?php

namespace Models\ORM;

use Database\DataAccess\ORM;

class Head extends ORM
{
    public function profile(): string
    {
        return sprintf(
            "Eye: %s\nNose: %s\nChin: %s\nHair: %s\nEyebrows: %s\Hair_color: %s\n",
            $this->eye,
            $this->nose,
            $this->chin,
            $this->hair,
            $this->eyebrows,
            $this->hair_color
        );
    }
}

