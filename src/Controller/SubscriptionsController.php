<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Mailer\Email;

/**
 * Subscriptions Controller
 *
 * @property \App\Model\Table\SubscriptionsTable $Subscriptions
 *
 * @method \App\Model\Entity\Subscription[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SubscriptionsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    /* TODO: implement as an admin method
    public function index() {
        $subscriptions = $this->paginate($this->Subscriptions);
        $this->set(compact('subscriptions'));
    }
    */

    /**
     * View method
     *
     * @param string|null $id Subscription id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    /*
    public function view($key = null)
    {
        $subscription = $this->Subscriptions->findByConfirmationKey($key);
        $this->set('subscription', $subscription);
    }
    */

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->viewBuilder()->setLayout('static_page');
        $subscription = $this->Subscriptions->newEntity();
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $_subscription = $this->Subscriptions->find('all',  [
                    'conditions' => ['Subscriptions.email' => $data['email']],
                    'contain' => $this->Subscriptions::$containments
            ])->first();
            if(!empty($_subscription)) {
                $this->Flash->success(__('You already subscribed using this e-mail address. Please check your inbox.'));
                $Email = new Email('default');
                $Email->setFrom(Configure::read('AppMail.defaultFrom'))
                    ->setTo($data['email'])
                    ->setSubject(Configure::read('AppMail.subjectPrefix').' Subscription Confirmation')
                    ->setEmailFormat('text')
                    ->setViewVars(['subscription' => $_subscription])
                    ->viewBuilder()->setTemplate('subscriptions/subscription_access');
                $Email->send();
                return $this->redirect('/');
            }else{
                $data['confirmation_key'] = $this->Subscriptions->generateToken();
                $subscription = $this->Subscriptions->patchEntity($subscription, $data);
                if ($this->Subscriptions->save($subscription)) {
                    $this->Flash->success(__('Your subscription has been saved, please check your inbox.'));
                    $Email = new Email('default');
                    $Email->setFrom(Configure::read('AppMail.defaultFrom'))
                        ->setTo($data['email'])
                        ->setSubject(Configure::read('AppMail.subjectPrefix').' Subscription Confirmation')
                        ->setEmailFormat('text')
                        ->setViewVars(['subscription' => $subscription])
                        ->viewBuilder()->setTemplate('subscriptions/subscription_confirmation');
                    $Email->send();
                    return $this->redirect('/');
                }
            }


            $this->Flash->error(__('Your subscription could not be saved. Please, try again.'));
        }
        $countries = $this->Subscriptions->Countries->find('list');
        $this->set(compact('subscription','countries'));
    }

    /**
     * Edit method
     *
     * @param string|null $key Subscription id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($key = null)
    {
        $this->viewBuilder()->setLayout('static_page');

        $subscription = $this->Subscriptions->find('all', [
            'conditions' => ['Subscriptions.confirmation_key' => $key],
            'contain' => $this->Subscriptions::$containments
        ])->first();

        $isNew = false;
        if(!$subscription['confirmed']) $isNew = true;

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            unset($data['confirmation_key']);
            unset($data['email']);
            $data['confirmed'] = 1;
            if($data['online_course'] == 'NULL') $data['online_course'] = null;
            $subscription = $this->Subscriptions->patchEntity($subscription, $data, [
                'associated' => [
                    'CourseTypes' => ['onlyIds' => true],
                    'Languages' => ['onlyIds' => true],
                    'Countries' => ['onlyIds' => true],
                    'Disciplines' => ['onlyIds' => true],
                    'TadirahTechniques' => ['onlyIds' => true],
                    'TadirahObjects' => ['onlyIds' => true]
            ]]);
            if ($this->Subscriptions->save($subscription)) {
                if(!$subscription['confirmed'])
                    $this->Flash->success(__('Your is now complete and confirmed.
                    You will receieve an e-mail notification, as soon new courses match your filters.'));
                else $this->Flash->success(__('Your subscription has been saved.'));

                return $this->redirect('/');
            }
            $this->Flash->error(__('Your subscription could not be saved. Please, try again.'));
        }
        $disciplines = $this->Subscriptions->Disciplines->find('list', ['limit' => 200]);
        $languages = $this->Subscriptions->Languages->find('list', ['limit' => 200]);
        $courseTypes = $this->Subscriptions->CourseTypes->find('list', ['limit' => 200]);
        $countries = $this->Subscriptions->Countries->find('list', ['limit' => 200]);
        $tadirahObjects = $this->Subscriptions->TadirahObjects->find('list', ['limit' => 200]);
        $tadirahTechniques = $this->Subscriptions->TadirahTechniques->find('list', ['limit' => 200]);
        $this->set(compact('subscription',
            'isNew',
            'disciplines',
            'languages',
            'courseTypes',
            'countries',
            'tadirahObjects',
            'tadirahTechniques'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Subscription id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($key = null)
    {
        $subscription = $this->Subscriptions->findByConfirmationKey($key);

        if($subscription AND $this->Subscriptions->delete($subscription)) {
            $this->Subscriptions->delete($subscription);
            $this->Flash->success(__('Your subscription has been deleted.'));
        }elseif(!$subscription) {
            $this->Flash->error(__('Your subscription could not be found on the database any more'));
        }else{
            $this->Flash->error(__('Your subscription could not be deleted. Please, try again.'));
        }

        return $this->redirect('/');
    }
}
