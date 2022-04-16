<?php

namespace App\Model\Table;

use App\Model\Entity\Subscription;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Utility\Inflector;
use Cake\Validation\Validator;

class CoursesTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('courses');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
        ]);
        $this->belongsTo('DeletionReasons', [
            'foreignKey' => 'deletion_reason_id',
        ]);
        $this->belongsTo('Countries', [
            'foreignKey' => 'country_id',
        ]);
        $this->belongsTo('Cities', [
            'foreignKey' => 'city_id',
        ]);
        $this->belongsTo('Institutions', [
            'foreignKey' => 'institution_id',
        ]);
        $this->belongsTo('CourseParentTypes', [
            'foreignKey' => 'course_parent_type_id',
        ]);
        $this->belongsTo('CourseTypes', [
            'foreignKey' => 'course_type_id',
        ]);
        $this->belongsTo('Languages', [
            'foreignKey' => 'language_id',
        ]);
        $this->belongsTo('CourseDurationUnits', [
            'foreignKey' => 'course_duration_unit_id',
        ]);
        $this->hasMany('Notifications', [
            'foreignKey' => 'course_id',
        ]);
        $this->belongsToMany('Disciplines', [
            'foreignKey' => 'course_id',
            'targetForeignKey' => 'discipline_id',
            'joinTable' => 'courses_disciplines',
        ]);
        $this->belongsToMany('TadirahActivities', [
            'foreignKey' => 'course_id',
            'targetForeignKey' => 'tadirah_activity_id',
            'joinTable' => 'courses_tadirah_activities',
        ]);
        $this->belongsToMany('TadirahObjects', [
            'foreignKey' => 'course_id',
            'targetForeignKey' => 'tadirah_object_id',
            'joinTable' => 'courses_tadirah_objects',
        ]);
        $this->belongsToMany('TadirahTechniques', [
            'foreignKey' => 'course_id',
            'targetForeignKey' => 'tadirah_technique_id',
            'joinTable' => 'courses_tadirah_techniques',
        ]);
    }

    public function validationDefault(Validator $validator): \Cake\Validation\Validator
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->boolean('active')
            ->notEmptyString('active');

        $validator
            ->boolean('deleted')
            ->notEmptyString('deleted');

        $validator
            ->boolean('approved')
            ->notEmptyString('approved');

        $validator
            ->scalar('approval_token')
            ->maxLength('approval_token', 255)
            ->allowEmptyString('approval_token');

        $validator
            ->boolean('mod_mailed')
            ->notEmptyString('mod_mailed');

        $validator
            ->dateTime('last_reminder')
            ->allowEmptyDateTime('last_reminder');

        $validator
            ->scalar('name')
            ->maxLength('name', 255)
            ->allowEmptyString('name');

        $validator
            ->scalar('description')
            ->allowEmptyString('description');

        $validator
            ->scalar('department')
            ->maxLength('department', 255)
            ->allowEmptyString('department');

        $validator
            ->scalar('access_requirements')
            ->allowEmptyString('access_requirements');

        $validator
            ->scalar('start_date')
            ->maxLength('start_date', 100)
            ->allowEmptyString('start_date');

        $validator
            ->integer('duration')
            ->allowEmptyString('duration');

        $validator
            ->boolean('recurring')
            ->notEmptyString('recurring');

        $validator
            ->boolean('online_course')
            ->notEmptyString('online_course');

        $validator
            ->scalar('info_url')
            ->allowEmptyString('info_url');

        $validator
            ->scalar('guide_url')
            ->allowEmptyString('guide_url');

        $validator
            ->dateTime('skip_info_url')
            ->allowEmptyDateTime('skip_info_url');

        $validator
            ->dateTime('skip_guide_url')
            ->allowEmptyDateTime('skip_guide_url');

        $validator
            ->numeric('ects')
            ->allowEmptyString('ects');

        $validator
            ->scalar('contact_mail')
            ->maxLength('contact_mail', 255)
            ->allowEmptyString('contact_mail');

        $validator
            ->scalar('contact_name')
            ->maxLength('contact_name', 255)
            ->allowEmptyString('contact_name');

        $validator
            ->decimal('lon')
            ->allowEmptyString('lon');

        $validator
            ->decimal('lat')
            ->allowEmptyString('lat');

        return $validator;
    }

    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['user_id'], 'Users'));
        $rules->add($rules->existsIn(['deletion_reason_id'], 'DeletionReasons'));
        $rules->add($rules->existsIn(['country_id'], 'Countries'));
        $rules->add($rules->existsIn(['city_id'], 'Cities'));
        $rules->add($rules->existsIn(['institution_id'], 'Institutions'));
        $rules->add($rules->existsIn(['course_parent_type_id'], 'CourseParentTypes'));
        $rules->add($rules->existsIn(['course_type_id'], 'CourseTypes'));
        $rules->add($rules->existsIn(['language_id'], 'Languages'));
        $rules->add($rules->existsIn(['course_duration_unit_id'], 'CourseDurationUnits'));
        return $rules;
    }

    public function getSubscriptionCourses(Subscription $subscription): array
    {
        $options = $this->getFilter($subscription);
        $query = $this->find('all', $options);
        $this->__match_association($query, $subscription, 'disciplines');
        $this->__match_association($query, $subscription, 'languages');
        $this->__match_association($query, $subscription, 'countries');
        $this->__match_association($query, $subscription, 'course_types');
        $this->__match_association($query, $subscription, 'tadirah_objects');
        $this->__match_association($query, $subscription, 'tadirah_techniques');
        return $query->distinct()->toArray();
    }

    public function getFilter(Subscription $subscription): array
    {
        $conditions = [
            'Courses.updated >' => $subscription->created,
            'Courses.active' => true,
            'Courses.deleted' => false
        ];
        if ($subscription->online_course !== null)
            $conditions['Courses.online_course'] = $subscription->online_course;

        if ($subscription->notifications) {
            $excludes = collection($subscription->notifications)
                ->extract('course_id')->toList();
            if ($excludes) $conditions['Courses.id NOT IN'] = $excludes;
        }
        return [
            'conditions' => $conditions,
            'contain' => ['Disciplines', 'Countries', 'Cities', 'Institutions']
        ];
    }

    private function __match_association(Query &$query, Subscription $subscription, string $assoc): void
    {
        if ($subscription->{$assoc}) {
            $ids = collection($subscription->{$assoc})->extract('id')->toList();
            $query->matching(Inflector::camelize($assoc), function ($q) use ($ids, $assoc) {
                return $q->where([Inflector::camelize($assoc) . '.id IN' => $ids]);
            });
        }
    }
}
