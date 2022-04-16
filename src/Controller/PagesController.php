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

use Cake\Core\Configure;
use Cake\Http\Exception\ForbiddenException;
use Cake\Http\Exception\NotFoundException;
use Cake\Mailer\MailerAwareTrait;
use Cake\View\Exception\MissingTemplateException;
use Cake\Mailer\Mailer;

/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link https://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class PagesController extends AppController
{

    use MailerAwareTrait;

    public function initialize(): void
    {
        parent::initialize();

        $this->Authentication->allowUnauthenticated(['info', 'follow', 'display']);
        $this->Authorization->skipAuthorization();
    }



    public function follow()
    {
        $this->loadModel('DhcrCore.Countries');
        $this->loadModel('Subscriptions');
        $subscription = $this->Subscriptions->newEmptyEntity();
        $countries = $this->Subscriptions->Countries->find('list', [
            'order' => ['Countries.name' => 'ASC']
        ]);
        $this->set(compact('subscription', 'countries'));
    }



    public function info()
    {
        $this->loadModel('Users');
        $this->loadModel('DhcrCore.Countries');
        $this->loadModel('Emails');

        $data = $this->request->getData();
        if (!empty($data) and $this->_checkCaptcha()) {

            $email = $this->Emails->newEntity($data);   // illegal values (country = admins) are being ignored from entity :)
            if (!$email->getErrors()) {
                //$this->Emails->save($email);
                // try fetching the moderator in charge of the user's country
                $country_id = ($data['country_id'] == 'administrators') ? null : $data['country_id'];
                $admins = $this->Users->getModerators($country_id, $user_admin = true);
                if ($admins) {
                    foreach ($admins as $admin) {
                        $this->getMailer('User')->send('contactForm', [$data, $admin->email]);
                    }
                    $this->Flash->set('Your message has been sent.');
                }
            } else {
                $this->Flash->set('We are missing required data to send email.');
            }
        } elseif (!empty($data) and !$this->_checkCaptcha()) {
            // repopulate the email form
            $data = $this->request->getData();
            $email = $this->Emails->newEntity($data);
            $this->Flash->set('You did not succeed the CAPTCHA test. Please make sure you are human and try again.');
        } else {
            // init email form
            $email = $this->Emails->newEmptyEntity();
        }

        $moderators = $this->Users->find('all', array(
            'contain' => array('Countries'),
            'conditions' => array('Users.user_role_id' => 2),
            'order' => array('Countries.name' => 'asc')
        ))->toList();

        $userAdmins = $this->Users->find('all', array(
            'contain' => array(),
            'conditions' => array('Users.user_admin' => 1)
        ));
        $country_ids = array();
        if ($moderators) foreach ($moderators as $mod) {
            if (!empty($mod['country_id']) and !in_array($mod['country_id'], $country_ids))
                $country_ids[] = $mod['country_id'];
        }
        $countries = $this->Countries->find('list')
            ->order(['Countries.name ASC'])
            ->where(['Countries.id IN' => $country_ids])
            ->toArray();
        $this->set(compact('countries', 'moderators', 'userAdmins', 'email'));
    }


    /**
     * Displays a view
     *
     * @param array ...$path Path segments.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Http\Exception\ForbiddenException When a directory traversal attempt.
     * @throws \Cake\Http\Exception\NotFoundException When the view file could not
     *   be found or \Cake\View\Exception\MissingTemplateException in debug mode.
     */
    public function display(...$path)
    {
        $count = count($path);
        if (!$count) {
            return $this->redirect('/');
        }
        if (in_array('..', $path, true) || in_array('.', $path, true)) {
            throw new ForbiddenException();
        }
        $page = $subpage = null;

        if (!empty($path[0])) {
            $page = $path[0];
        }
        if (!empty($path[1])) {
            $subpage = $path[1];
        }
        $this->set(compact('page', 'subpage'));

        try {
            $this->render(implode('/', $path));
        } catch (MissingTemplateException $exception) {
            if (Configure::read('debug')) {
                throw $exception;
            }
            throw new NotFoundException();
        }
    }
}
