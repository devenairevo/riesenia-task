<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class ProductsCategoriesTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('products_categories');
        $this->addBehavior('Timestamp');

        $this->belongsTo('Products');
        $this->belongsTo('Categories');
    }
}
