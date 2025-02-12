<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class CategoriesTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('categories');
        $this->addBehavior('Timestamp');

        $this->belongsToMany('Products', [
            'joinTable' => 'products_categories',
        ])
            ->setThrough('ProductsCategories')
            ->setForeignKey('category_id')
            ->setTargetForeignKey('product_id')
            ->setThrough('ProductsCategories');
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->maxLength('name', 255)
            ->requirePresence('name', 'create')
            ->notEmptyString('name')
            ->add('name', 'unique', [
                'rule' => 'validateUnique',
                'provider' => 'table',
                'message' => 'This category is already taken.'
            ]);

        return $validator;
    }
}
