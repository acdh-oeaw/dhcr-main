<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Utility\Inflector;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;

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
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('subscriptions');
        $this->setDisplayField('email');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

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
    public function validationDefault(Validator $validator)
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
            ->scalar('deletion_key')
            ->maxLength('deletion_key', 255)
            ->allowEmptyString('deletion_key');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->isUnique(['email']));

        return $rules;
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


    public function getSubscriptions() {
        $subscriptions = $this->find('all', [
            'contain' => self::$containments
        ])->where([
            'Subscriptions.confirmed' => true
        ])->toArray();
        return $subscriptions;
    }



    public function processSubscriptions() {
        $subscriptions = $this->getSubscriptions();
        $CoursesTable = TableRegistry::getTableLocator()->get('Courses');

        foreach($subscriptions as $subscription) {
            $courses = $CoursesTable->getSubscriptionCourses($subscription);
            if($courses) $subscription['courses'] = $courses;

            //TODO...
        }
    }
}
