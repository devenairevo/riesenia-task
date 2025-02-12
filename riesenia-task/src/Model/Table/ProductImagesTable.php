<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class ProductImagesTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('product_images');
        $this->addBehavior('Timestamp');

        $this->belongsTo('Products')
            ->setForeignKey('product_id');
    }
}
