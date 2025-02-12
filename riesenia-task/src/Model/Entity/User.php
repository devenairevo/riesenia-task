<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Authentication\PasswordHasher\DefaultPasswordHasher;
use Cake\ORM\Entity;

class User extends Entity
{
    protected array $_accessible = [
        'id' => true,
        'username' => true,
        'password' => true,
        'password_confirmation' => true
    ];

    protected array $_hidden = [
        'password'
    ];

    protected function _setPassword(string $password): ?string
    {
        if (\strlen($password) > 0) {
            $hasher = new DefaultPasswordHasher();

            return $hasher->hash($password);
        }

        return null;
    }
}
