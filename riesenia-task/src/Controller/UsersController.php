<?php

namespace App\Controller;

use App\Controller\Helpers\DataFormat;
use Cake\Event\EventInterface;
use Cake\Http\Response;

class UsersController extends AppController
{
    public function index(): void
    {
        $users = $this->paginate($this->Users);
        $this->set(\compact('users'));
    }

    public function add(): ?Response
    {
        $user = $this->Users->newEmptyEntity();

        if ($this->request->is('post')) {
            $data = $this->request->getData();

            $trimmedData = DataFormat::trimData($data);

            $user = $this->Users->patchEntity($user, $trimmedData);

            if ($this->Users->save($user)) {
                $this->Flash->success(__('User added successful'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Creating new user failed. Please try again.'));
        }
        $this->set(\compact('user'));

        return null;
    }

    public function edit(int $id): ?Response
    {
        $user = $this->Users->get($id);

        if ($this->request->is('post')) {
            $data = $this->request->getData();

            if (empty($data['password'])) {
                unset($data['password']);
            }

            $trimmedData = DataFormat::trimData($data);

            $user = $this->Users->patchEntity($user, $trimmedData);

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
        if ($this->request->is('post')) {
            $result = $this->Authentication->getResult();

            if ($result->isValid()) {
                $target = $this->Authentication->getLoginRedirect() ?? '/users';

                return $this->redirect($target);
            }
            $this->Flash->error('Invalid username or password');
        }

        return null;
    }

    public function logout(string $userId): ?Response
    {
        $session = $this->request->getSession();
        $currentUser = $this->Users->get($userId);

        if ($currentUser) {
            $cartKey = 'Cart_' . $currentUser['id'];
            $session->delete($cartKey);
            $session->delete($cartKey . '_Summary');
        }

        $this->Authentication->logout();

        return $this->redirect(['controller' => 'Users', 'action' => 'login']);
    }

    public function beforeFilter(EventInterface $event): void
    {
        parent::beforeFilter($event);
        $this->Authentication->allowUnauthenticated(['login', 'register']);
    }
}
