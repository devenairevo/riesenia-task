<?php

namespace App\Controller;

use Cake\Event\EventInterface;
use Cake\Http\Response;
use Cake\ORM\TableRegistry;

class UsersController extends AppController
{
    private mixed $Users;

    public function initialize(): void
    {
        parent::initialize();
        $this->Users = TableRegistry::getTableLocator()->get('Users');
    }

    public function index(): void
    {
        $users = $this->paginate($this->Users);
        $this->set(\compact('users'));
    }

    public function register(): ?Response
    {
        $user = $this->Users->newEmptyEntity();
        $result = $this->Authentication->getResult();

        if ($result->isValid()) {
            return $this->redirect(['action' => 'index']);
        }

        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());

            if ($this->Users->save($user)) {
                $this->Flash->success(__('Registration successful. Please login.'));

                return $this->redirect(['action' => 'login']);
            }
            $this->Flash->error(__('Registration failed. Please try again.'));
        }
        $this->set(\compact('user'));

        return null;
    }

    public function login(): ?Response
    {
        $result = $this->Authentication->getResult();

        if ($result->isValid()) {
            $target = $this->Authentication->getLoginRedirect() ?? '/users';

            return $this->redirect($target);
        }
        $this->Flash->error('Invalid username or password');

        return null;
    }

    public function logout(): ?Response
    {
        $this->Authentication->logout();

        return $this->redirect(['controller' => 'Users', 'action' => 'login']);
    }

    public function edit(int $id): ?Response
    {
        $user = $this->Users->get($id);

        if ($this->request->is('post')) {
            $data = $this->request->getData();

            if (empty($data['password'])) {
                unset($data['password']);
            }

            $user = $this->Users->patchEntity($user, $data);

            if ($this->Users->save($user)) {
                $this->Flash->success(__('User updated successfully'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('User could not be updated. Please, try again.'));
            $this->set(\compact('user'));
        }
        $this->set(\compact('user'));

        return null;
    }

    public function delete(int $id): ?Response
    {
        $identity = $this->request->getAttribute('identity');
        $currentUserId = null;

        if ($identity) {
            $currentUserId = $identity->getOriginalData()->id;
        }

        if ($currentUserId == $id) {
            $this->Flash->error(__('You cannot delete your own account.'));

            return $this->redirect(['action' => 'index']);
        }

        $user = $this->Users->get($id);

        if ($this->Users->delete($user)) {
            $this->Flash->success(__('User removed successfully'));

            return $this->redirect(['action' => 'index']);
        }
        $this->Flash->error(__('User could not be deleted. Please, try again.'));

        return $this->redirect(['action' => 'index']);
    }

    public function beforeFilter(EventInterface $event): void
    {
        parent::beforeFilter($event);
        $this->Authentication->allowUnauthenticated(['login', 'register']);
    }
}
