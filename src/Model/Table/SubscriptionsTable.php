<?php

namespace App\Model\Table;

use App\Model\Entity\Subscription;
use Cake\Core\Configure;
use Cake\Mailer\Email;
use Cake\Mailer\MailerAwareTrait;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;
use ArrayObject;

class SubscriptionsTable extends Table
{
    use MailerAwareTrait;

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

    public function buildRules(RulesChecker $rules): \Cake\ORM\RulesChecker
    {
        $rules->add($rules->isUnique(['email']));
        return $rules;
    }

    public function beforeMarshal(Event $event, ArrayObject $data, ArrayObject $options)
    {
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
    public function processSubscriptions()
    {
        $subscriptions = $this->getSubscriptions();
        $courses = 0;
        foreach ($subscriptions as $subscription) {
            if ($this->processSubscription($subscription))
                $courses++;
        }
        return [
            'subscriptions' => count($subscriptions),
            'courses' => $courses
        ];
    }

    public function getSubscriptions()
    {
        return $this->find('all', [
            'contain' => self::$containments
        ])->where([
            'Subscriptions.confirmed' => true
        ])->toArray();
    }

    public function processSubscription(Subscription $subscription)
    {
        $result = false;
        if ($subscription->confirmed) {
            $CoursesTable = TableRegistry::getTableLocator()->get('Courses');
            // get only courses that the subscriber did not receive a notification about before
            $courses = $CoursesTable->getSubscriptionCourses($subscription);
            if ($courses) {
                $this->getMailer('Subscription')->send('notification', [
                    $subscription, $courses
                ]);
                // prevent double notifications, to be filtered by above method CoursesTable::getSubscriptoinCourses()
                $this->Notifications->saveSent($subscription->id, $courses);
            }
            $result = count($courses);
        }
        return $result;
    }
}
