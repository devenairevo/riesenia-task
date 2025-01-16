<?php

namespace App\Controller;

use Cake\Event\EventInterface;
use Cake\Http\Response;
use function compact;

class UsersController extends AppController
{
    public function index()
    {
        $users = $this->paginate($this->Users);
        $this->set(compact('users'));
    }

    public function register()
    {
        $user = $this->Users->newEmptyEntity();

        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());

            if ($this->Users->save($user)) {
                $this->Flash->success(__('Registration successful. Please login.'));

                return $this->redirect(['action' => 'login']);
            }
            $this->Flash->error(__('Registration failed. Please try again.'));
        }
        $this->set(compact('user'));
    }

    public function login()
    {
        $result = $this->Authentication->getResult();

        // If the user is logged in send them away.
        if ($result->isValid()) {
            $target = $this->Authentication->getLoginRedirect() ?? '/';

            return $this->redirect($target);
        }

        if ($this->request->is('post') && !$result->isValid()) {
            $this->Flash->error('Invalid username or password');
        }
    }

    public function logout(): ?Response
    {
        $this->Authentication->logout();

        return $this->redirect(['controller' => 'Users', 'action' => 'login']);
    }

    public function view($id)
    {
        $user = $this->Users->get($id);
        $this->set(compact('user'));
    }

    public function delete($id): ?Response
    {
        $identity = $this->request->getAttribute('identity');
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
        } else {
            $this->Flash->error(__('User could not be deleted. Please, try again.'));
            return $this->redirect(['action' => 'index']);
        }
    }

    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);
        $this->Authentication->allowUnauthenticated(['login', 'register']);
    }
}
