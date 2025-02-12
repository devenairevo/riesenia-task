<?php
declare(strict_types=1);

use Migrations\BaseSeed;

/**
 * Users seed.
 */
class UsersSeed extends BaseSeed
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
            [
                'username' => 'elondusk',
                'password' => 'ElonMuskSon1',
                'created' => date('Y-m-d H:i:s'),
            ],
            [
                'username' => 'oleq',
                'password' => 'HelloWorld1',
                'created' => date('Y-m-d H:i:s'),
            ],
            [
                'username' => 'johnproduction',
                'password' => 'john1RRR',
                'created' => date('Y-m-d H:i:s'),
            ],
            [
                'username' => 'eldar',
                'password' => 'qwertyu1RR',
                'created' => date('Y-m-d H:i:s'),
            ]
        ];

        $table = $this->table('users');
        $validUsers = [];

        foreach ($data as $user) {
            if (preg_match('/^(?=.*[A-Z])(?=.*\d)/', $user['password'])) {
                $user['password'] = password_hash($user['password'], PASSWORD_DEFAULT);
                $validUsers[] = $user;
            } else {
                echo "User {$user['username']} password skipped.\n";
            }
        }

        if (!empty($validUsers)) {
            $table->insert($validUsers)->save();
        } else {
            echo "No valid users to insert.\n";
        }
    }
}
