<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class UsersTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('users');
        $this->addBehavior('Timestamp');
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->maxLength('username', 255)
            ->requirePresence('username', 'create')
            ->notEmptyString('username')
            ->add('username', 'unique', [
                'rule' => 'validateUnique',
                'provider' => 'table',
                'message' => 'This username is already taken.'
            ]);

        $validator
            ->notEmptyString('password', 'A password is required.')
            ->minLength('password', 8, 'Password must be at least 8 characters long.')
            ->add('password', 'validPassword', [
                'rule' => 'isValidPassword',
                'provider' => 'table',
                'message' => 'Password must contain at least one uppercase letter and one number.',
            ])
            ->add('password', 'passwordEmptyForChange', [
                'rule' => function ($value, $context) {
                    if (empty($value) && !$context['newRecord']) {
                        return true;
                    }

                    return !empty($value);
                },
                'message' => 'Please provide a password or leave it blank if you do not want to change it.'
            ]);

        $validator
            ->allowEmptyString('password_confirmation')
            ->add('password_confirmation', 'emptyWhenPasswordEmpty', [
                'rule' => function ($value, $context) {
                    if (empty($context['data']['password'])) {
                        return empty($value);
                    }

                    return !empty($value);
                },
                'message' => 'Password confirmation should be empty if you are not changing the password.'
            ])
            ->sameAs('password_confirmation', 'password', 'Passwords do not match.', function ($context) {
                return !empty($context['data']['password']);
            });

        return $validator;
    }

    public function isValidPassword(string $value): bool
    {
        if (\preg_match('/^(?=.*[A-Z])(?=.*\d)/', $value)) {
            return true;
        }

        return false;
    }
}
