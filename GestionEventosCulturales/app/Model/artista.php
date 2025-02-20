<?php

namespace App\Model;

class Artista extends Model
{
    function __construct($con)
    {
        parent::__construct($con);
        $this->table = "artista";
    }
}
