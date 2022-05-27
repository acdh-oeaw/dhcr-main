<?php

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         3.3.4
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

namespace App\Controller;

use Cake\Event\Event;
use Cake\Core\Configure;

/**
 * Error Handling Controller
 *
 * Controller used by ExceptionRenderer to render error responses.
 */
class ErrorController extends AppController
{
    /**
     * Initialization hook method.
     *
     * @return void
     */
    public function initialize(): void
    {
        $this->loadComponent('RequestHandler', [
            'enableBeforeRedirect' => false,
        ]);
    }

    /**
     * beforeFilter callback.
     *
     * @param \Cake\Event\Event $event Event.
     * @return \Cake\Http\Response|null|void
     */
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
    }

    /**
     * beforeRender callback.
     *
     * @param \Cake\Event\Event $event Event.
     * @return \Cake\Http\Response|null|void
     */
    public function beforeRender(\Cake\Event\EventInterface $event)
    {
        parent::beforeRender($event);

        $this->viewBuilder()->setTemplatePath('Error');

        if (!Configure::read('debug')) {
            // override _serialize key as we don't want the error message to reveal application code structure (file, line)
            $message = $url = $code = null;
            $this->set('_serialize', ['message', 'url', 'code']);
        }
    }

    /**
     * afterFilter callback.
     *
     * @param \Cake\Event\Event $event Event.
     * @return \Cake\Http\Response|null|void
     */
    public function afterFilter(\Cake\Event\EventInterface $event)
    {
    }
}
