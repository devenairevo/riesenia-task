<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;

class ProductsCategory extends Entity
{
    protected array $_accessible = [
        '*' => true,
        'id' => false,
    ];
}
