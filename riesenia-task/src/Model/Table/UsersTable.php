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
    //TODO: validation check why it's giving an error during the registration
    //    public function validationDefault(Validator $validator): Validator
    //    {
    //        $validator
    //            ->maxLength('username', 255)
    //            ->requirePresence('username', 'create')
    //            ->notEmptyString('username')
    //            ->add('username', 'unique', [
    //                'rule' => 'validateUnique',
    //                'provider' => 'table',
    //                'message' => 'This username is already taken.'
    //            ]);
    //
    //        $validator
    //            ->notEmptyString('password', 'A password is required.')
    //            ->minLength('password', 8, 'Password must be at least 8 characters long.')
    //            ->add('password', 'custom', [
    //                'rule' => function ($value, $context) {
    //                    return \preg_match('/^(?=.*[A-Z])(?=.*\d)/', $value);
    //                },
    //                'message' => 'Password must contain at least one uppercase letter and one number.'
    //            ]);
    //
    //        $validator
    //            ->notEmptyString('password_confirmation', 'Password confirmation is required.')
    //            ->sameAs('password_confirmation', 'password', 'Passwords do not match.');
    //
    //        return $validator;
    //    }
}
