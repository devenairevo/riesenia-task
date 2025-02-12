<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * @property mixed $product_images
 */
class Product extends Entity
{
    protected array $_accessible = [
        'name' => true,
        'description' => true,
        'price' => true,
        'vat_rate' => true,
        'product_images' => true,
        'categories' => true,
        'categories._ids' => true
    ];
}
