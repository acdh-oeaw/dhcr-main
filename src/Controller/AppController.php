<?php

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */

namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\Event\EventInterface;
use Cake\ORM\TableRegistry;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{



    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();

        // Set the Cache-Control as private for 3600 seconds
        $this->response = $this->response->withSharable(true, 3600);

        $this->loadComponent('RequestHandler', [
            'enableBeforeRedirect' => false,
        ]);
        $this->loadComponent('Flash');
        $this->loadComponent('Authorization.Authorization');
        $this->loadComponent('Authentication.Authentication', [
            'logoutRedirect' => '/users/sign-in'  // Default is false
        ]);
    }



    public function beforeFilter(EventInterface $event)
    {
        $result = $this->Authentication->getResult();
        if ($result->isValid()) {
            // send newly registered users to the approval status page
            $action = $this->request->getParam('action');
            $user = $this->Authentication->getIdentity();
            if (
                !$user->can('accessDashboard', $user)
                and !in_array($action, ['registrationSuccess', 'verifyMail'])
                and !in_array($action, $this->Authentication->getUnauthenticatedActions())
            ) {
                return $this->redirect('/users/registration_success');
            }
        }
        // we must RETURN the Response object here for the redirect to take effect
        return parent::beforeFilter($event);
    }


    protected function _checkCaptcha(&$errors = array()): bool
    {
        if (Configure::read('debug')) return true;

        $ip = $_SERVER['REMOTE_ADDR'];
        if (!empty($_SERVER['HTTP_CLIENT_IP']))
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];

        $data = [
            'secret' => Configure::read('reCaptchaPrivateKey'),
            'response' => $this->request->getData('g-recaptcha-response'),
            'remoteip' => $ip
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        $result = curl_exec($ch);
        curl_close($ch);

        if (empty($result)) return false;
        $result = json_decode($result, true);
        // if(!empty($result['error-codes'])) $errors = $result['error-codes'];
        if (!empty($result['success'])) return true;
        return false;
    }


    /** Renew Auth session on pageload due to possible status or profile changes.
     * We might configure the Session Authenticator ['identify' => true] in App\Application,
     * but that would create unnecessary db io on each request.
     * Refresh session only in certain situations.
     */
    protected function _refreshAuthSession()
    {
        $result = $this->Authentication->getResult();
        if ($result->isValid()) {
            $Users = TableRegistry::getTableLocator()->get('Users');
            $user = $this->Authentication->getIdentity();
            $user = $Users->get($user->id);
            // Set the authorization service to the identity object:
            // this is configured on Application::middleware (identityDecorator),
            // but needs to be done again as we re-set the identity.
            $user->setAuthorization(
                $this->request->getAttribute('authorization')
            );
            $this->Authentication->setIdentity($user);
            $this->getRequest()->getSession()->write('Auth', $user);
        }
    }
}
