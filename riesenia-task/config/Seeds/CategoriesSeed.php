<?php
declare(strict_types=1);

use Migrations\BaseSeed;

/**
 * Categories seed.
 */
class CategoriesSeed extends BaseSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeds is available here:
     * https://book.cakephp.org/migrations/4/en/seeding.html
     *
     * @return void
     */
    public function run(): void
    {
        $data = [
            ['name' => 'PC Parts', 'created' => date('Y-m-d H:i:s')],
            ['name' => 'Phone Accessories', 'created' => date('Y-m-d H:i:s')],
            ['name' => 'Speakers', 'created' => date('Y-m-d H:i:s')],
        ];

        $table = $this->table('categories');
        $table->insert($data)->save();
    }
}
