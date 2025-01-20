<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class CreateProductsCategories extends BaseMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/migrations/4/en/migrations.html#the-change-method
     * @return void
     */
    public function change(): void
    {
        $table = $this->table('products_categories', [
            'id' => false,
            'primary_key' => ['product_id', 'category_id']
        ]);
        $table
            ->addColumn('product_id', 'integer', [
                'null' => false,
            ])
            ->addColumn('category_id', 'integer', [
                'null' => false,
            ])
            ->addForeignKey('product_id', 'products', 'id', [
                'delete' => 'CASCADE',
                'update' => 'CASCADE',
            ])
            ->addForeignKey('category_id', 'categories', 'id', [
                'delete' => 'CASCADE',
                'update' => 'CASCADE',
            ]);

        $table->create();
    }
}
