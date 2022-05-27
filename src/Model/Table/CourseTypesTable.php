<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class CourseTypesTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('course_types');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsTo('CourseParentTypes', [
            'foreignKey' => 'course_parent_type_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('Courses', [
            'foreignKey' => 'course_type_id',
        ]);
        $this->belongsToMany('Subscriptions', [
            'foreignKey' => 'course_type_id',
            'targetForeignKey' => 'subscription_id',
            'joinTable' => 'course_types_subscriptions',
        ]);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('name')
            ->maxLength('name', 100)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        return $validator;
    }

    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['course_parent_type_id'], 'CourseParentTypes'), ['errorField' => 'course_parent_type_id']);

        return $rules;
    }
}
