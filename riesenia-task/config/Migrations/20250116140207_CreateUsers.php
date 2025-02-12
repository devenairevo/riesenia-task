<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class CreateUsers extends BaseMigration
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
        $table = $this->table('users');

        // For the username, we remove 'autoIncrement' since it's not applicable for string columns
        $table->addColumn('username', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ])->addIndex(['username'], ['unique' => true]);

        $table->addColumn('password', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);

        $table->addColumn('created', 'datetime', [
            'default' => null,
            'null' => false,
        ]);

        // Remove the manual addition of the 'id' column
        // CakePHP will automatically add an 'id' column as the primary key

        $table->create();
    }
}
