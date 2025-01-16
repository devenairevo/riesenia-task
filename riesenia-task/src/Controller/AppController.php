<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Controller\Controller;

/**
 * Application Controller.
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @see https://book.cakephp.org/5/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{
    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('FormProtection');`
     */
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('Flash');
        $this->loadComponent('Authentication.Authentication', [
            'logoutRedirect' => '/users/login'
        ]);

        /*
         * Enable the following component for recommended CakePHP form protection settings.
         * see https://book.cakephp.org/5/en/controllers/components/form-protection.html
         */
        // $this->loadComponent('FormProtection');
    }
}
