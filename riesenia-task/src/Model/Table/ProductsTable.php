<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class ProductsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('products');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('ProductImages', [
            'foreignKey' => 'product_id',
            'dependent' => true,
            'cascadeCallbacks' => true,
            'saveStrategy' => 'replace'
        ]);

        $this->belongsToMany('Categories', [
            'foreignKey' => 'product_id',
            'targetForeignKey' => 'category_id',
            'joinTable' => 'products_categories',
            'saveStrategy' => 'replace',
            'dependent' => true,
            'cascadeCallbacks' => true
        ]);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->maxLength('name', 255)
            ->notEmptyString('name');

        $validator
            ->maxLength('description', 1000)
            ->allowEmptyString('description');

        $validator
            ->decimal('price', 2)
            ->greaterThanOrEqual('price', 0)
            ->notEmptyString('price');

        $validator
            ->decimal('vat_rate', 2)
            ->greaterThanOrEqual('vat_rate', 0)
            ->lessThanOrEqual('vat_rate', 100)
            ->notEmptyString('vat_rate');

        return $validator;
    }
}
