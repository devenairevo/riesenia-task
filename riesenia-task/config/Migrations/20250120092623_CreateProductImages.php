<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class CreateProductImages extends BaseMigration
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
        $table = $this->table('product_images');
        $table
            ->addColumn('product_id', 'integer', [
                'null' => false
            ])
            ->addColumn('image', 'string', [
               'limit' => 255,
               'null' => false
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'null' => false,
            ])
            ->addForeignKey('product_id', 'products', 'id', [
                'delete' => 'CASCADE',
                'update' => 'CASCADE',
            ]);

        $table->create();
    }
}
