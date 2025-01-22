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
        $this->setCartSummary();
    }

    private function setCartSummary(): void
    {
        $session = $this->request->getSession();
        $currentUser = $this->Authentication->getIdentity();

        $summary = [
            'Total Including Vat' => 0,
            'Total Excluding Vat' => 0,
            'Vat Rates' => [],
        ];

        if ($currentUser) {
            $cartKey = 'Cart_' . $currentUser['id'] . '_Summary';
            $summary = $session->read($cartKey) ?? $summary;
        }

        $this->set('cartSummary', $summary);
    }
}
