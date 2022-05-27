<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Http\Response;
use Cake\Mailer\Mailer;
use Cake\Mailer\MailerAwareTrait;

/**
 * Subscriptions Controller
 *
 * @property \App\Model\Table\SubscriptionsTable $Subscriptions
 *
 * @method \App\Model\Entity\Subscription[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SubscriptionsController extends AppController
{

    use MailerAwareTrait;


    public function initialize(): void
    {
        parent::initialize();
        $this->Authentication->allowUnauthenticated(['*']);
        $this->Authorization->skipAuthorization();
    }

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
    public function add(): Response
    {
        $subscription = $this->Subscriptions->newEmptyEntity();
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $subscription = $this->Subscriptions->find('all',  [
                'conditions' => ['Subscriptions.email' => $data['email']],
                'contain' => $this->Subscriptions::$containments
            ])->first();
            if (!empty($subscription)) {
                $this->Flash->success(__('You already subscribed using this e-mail address. Please check your inbox to access your settings.'));
                $this->getMailer('Subscription')
                    ->send('access', ['subscription' => $subscription, 'isNew' => false]);
                return $this->redirect('/');
            } else {
                $data['confirmation_key'] = $this->Subscriptions->generateToken();
                $subscription = $this->Subscriptions->newEntity($data);
                if ($this->Subscriptions->save($subscription)) {
                    $this->Flash->success(__('Your subscription has been saved, please check your inbox to confirm your subscription.'));
                    $this->getMailer('Subscription')
                        ->send('confirm', ['subscription' => $subscription]);
                    return $this->redirect('/');
                }
            }

            $this->Flash->error(__('Your subscription could not be saved. Please, try again.'));
        }
        $countries = $this->Subscriptions->Countries->find('list', [
            'order' => ['Countries.name' => 'ASC']
        ]);
        $this->set(compact('subscription', 'countries'));
    }

    /**
     * Edit method
     *
     * @param string|null $key Subscription id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit(string $key = null): Response
    {
        $subscription = $this->Subscriptions->find('all', [
            'conditions' => ['Subscriptions.confirmation_key' => $key],
            'contain' => $this->Subscriptions::$containments
        ])->first();

        if (!$subscription) {
            $this->Flash->set('Your subscription could not be found, please add one!');
            return $this->redirect('/subscriptions/add');
        }

        $isNew = false;
        if (!$subscription['confirmed']) $isNew = true;

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            unset($data['confirmation_key']);
            unset($data['email']);
            $data['confirmed'] = 1;
            if ($data['online_course'] == 'NULL') $data['online_course'] = null;
            $subscription = $this->Subscriptions->patchEntity($subscription, $data, [
                'associated' => [
                    'CourseTypes' => ['onlyIds' => true],
                    'Languages' => ['onlyIds' => true],
                    'Countries' => ['onlyIds' => true],
                    'Disciplines' => ['onlyIds' => true],
                    'TadirahTechniques' => ['onlyIds' => true],
                    'TadirahObjects' => ['onlyIds' => true]
                ]
            ]);
            if ($this->Subscriptions->save($subscription)) {
                if ($isNew)
                    $this->Flash->success(__('Your subscription is now complete and confirmed.'
                        . 'You will receieve e-mail notifications, as soon new courses match your filters.'));
                else $this->Flash->success(__('Your subscription settings have been updated.'));
                $this->getMailer('Subscription')
                    ->send('access', ['subscription' => $subscription, 'isNew' => $isNew]);
                return $this->redirect('/');
            }
            $this->Flash->error(__('Your subscription could not be saved. Please, try again.'));
        }
        $disciplines = $this->Subscriptions->Disciplines->find('list', ['order' => ['Disciplines.name' => 'ASC']]);
        $languages = $this->Subscriptions->Languages->find('list', ['order' => ['Languages.name' => 'ASC']]);
        $courseTypes = $this->Subscriptions->CourseTypes->find('list', ['order' => ['CourseTypes.name' => 'ASC']]);
        $countries = $this->Subscriptions->Countries->find('list', ['order' => ['Countries.name' => 'ASC']]);
        $tadirahObjects = $this->Subscriptions->TadirahObjects->find('list', ['order' => ['TadirahObjects.name' => 'ASC']]);
        $tadirahTechniques = $this->Subscriptions->TadirahTechniques->find('list', ['order' => ['TadirahTechniques.name' => 'ASC']]);
        $this->set(compact(
            'subscription',
            'isNew',
            'disciplines',
            'languages',
            'courseTypes',
            'countries',
            'tadirahObjects',
            'tadirahTechniques'
        ));
    }

    /**
     * Delete method
     *
     * @param string|null $id Subscription id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete(string $key = null): void
    {
        $subscription = $this->Subscriptions->findByConfirmationKey($key)->first();

        if ($subscription and $this->Subscriptions->delete($subscription)) {
            $this->Subscriptions->delete($subscription);
            $this->Flash->success(__('Your subscription has been deleted.'));
        } elseif (!$subscription) {
            $this->Flash->error(__('Your subscription could not be found on the database any more'));
        } else {
            $this->Flash->error(__('Your subscription could not be deleted. Please, try again.'));
        }

        $this->redirect('/');
    }
}
