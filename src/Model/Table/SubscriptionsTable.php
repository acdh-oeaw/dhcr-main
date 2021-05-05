<?php
namespace App\Model\Table;

use Cake\Core\Configure;
use Cake\Mailer\Email;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;
use ArrayObject;

/**
 * Subscriptions Model
 *
 * @property \App\Model\Table\NotificationsTable&\Cake\ORM\Association\HasMany $Notifications
 *
 * @method \App\Model\Entity\Subscription get($primaryKey, $options = [])
 * @method \App\Model\Entity\Subscription newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Subscription[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Subscription|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Subscription saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Subscription patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Subscription[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Subscription findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class SubscriptionsTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('subscriptions');
        $this->setDisplayField('email');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('Token', [
            'fieldname' => 'confirmation_key'
        ]);

        $this->hasMany('Notifications', [
            'foreignKey' => 'subscription_id',
        ]);

        $this->belongsToMany('Disciplines', [
            'joinTable' => 'disciplines_subscriptions',
            'foreignKey' => 'subscription_id',
            'targetForeignKey' => 'discipline_id'
        ]);

        $this->belongsToMany('Languages', [
            'joinTable' => 'languages_subscriptions',
            'foreignKey' => 'subscription_id',
            'targetForeignKey' => 'language_id'
        ]);

        $this->belongsToMany('CourseTypes', [
            'joinTable' => 'course_types_subscriptions',
            'foreignKey' => 'subscription_id',
            'targetForeignKey' => 'course_type_id'
        ]);

        $this->belongsToMany('Countries', [
            'joinTable' => 'countries_subscriptions',
            'foreignKey' => 'subscription_id',
            'targetForeignKey' => 'country_id'
        ]);

        $this->belongsToMany('TadirahObjects', [
            'joinTable' => 'subscriptions_tadirah_objects',
            'foreignKey' => 'subscription_id',
            'targetForeignKey' => 'tadirah_object_id'
        ]);

        $this->belongsToMany('TadirahTechniques', [
            'joinTable' => 'subscriptions_tadirah_techniques',
            'foreignKey' => 'subscription_id',
            'targetForeignKey' => 'tadirah_technique_id'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): \Cake\Validation\Validator
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmptyString('email')
            ->add('email', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->boolean('online_course')
            ->allowEmptyString('online_course');

        $validator
            ->boolean('confirmed')
            ->notEmptyString('confirmed');

        $validator
            ->scalar('confirmation_key')
            ->maxLength('confirmation_key', 255)
            ->requirePresence('confirmation_key', 'create')
            ->notEmptyString('confirmation_key');

        $validator
            ->boolean('consent')
            ->notEmptyString('consent')
            ->equals('consent', 1, 'You must agree to the terms.')
            ->requirePresence('consent', 'create');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): \Cake\ORM\RulesChecker
    {
        $rules->add($rules->isUnique(['email']));

        return $rules;
    }


    public function beforeMarshal(Event $event, ArrayObject $data, ArrayObject $options) {
        foreach ($data as $key => $value) {
            if (is_string($value)) {
                $data[$key] = trim($value);
            }
        }
    }


    public static $containments = [
        'Disciplines',
        'TadirahObjects',
        'TadirahTechniques',
        'Languages',
        'Countries',
        'CourseTypes',
        'Notifications' // courses will be filtered over notifications already being sent
    ];


    // called by cron using console command
    public function processSubscriptions() {
        $subscriptions = $this->getSubscriptions();
        $courses = 0;
        foreach($subscriptions as $subscription) {
            if($this->processSubscription($subscription))
                $courses++;
        }
        return [
            'subscriptions' => count($subscriptions),
            'courses' => $courses
        ];
    }



    public function getSubscriptions() {
        $subscriptions = $this->find('all', [
            'contain' => self::$containments
        ])->where([
            'Subscriptions.confirmed' => true
        ])->toArray();
        return $subscriptions;
    }



    public function processSubscription($subscription = []) {
        $result = false;
        if($subscription->confirmed) {
            $CoursesTable = TableRegistry::getTableLocator()->get('Courses');
            $courses = $CoursesTable->getSubscriptionCourses($subscription);
            if($courses) {
                $this->sendNotification($subscription, $courses);
                $this->Notifications->saveSent($subscription->id, $courses);
            }
            $result = count($courses);
        }
        return $result;
    }



    private function sendNotification($subscription, $courses = []) {
        $recipient = $subscription->email;
        if(Configure::read('debug')) $recipient = Configure::read('AppMail.debugMailTo');
        $Email = new Email('default');
        $Email->setFrom(Configure::read('AppMail.defaultFrom'))
            ->setTo($recipient)
            ->setSubject(Configure::read('AppMail.subjectPrefix').' New Course Notification')
            ->setEmailFormat('text')
            ->setViewVars([
                'subscription' => $subscription,
                'courses' => $courses])
            ->viewBuilder()->setTemplate('subscriptions/subscription_notification');
            $Email->send();
    }



}
