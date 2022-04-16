<?php

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class NotificationsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('notifications');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Courses', [
            'foreignKey' => 'course_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Subscriptions', [
            'foreignKey' => 'subscription_id',
            'joinType' => 'INNER',
        ]);
    }

    public function validationDefault(Validator $validator): \Cake\Validation\Validator
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        return $validator;
    }

    public function buildRules(RulesChecker $rules): \Cake\ORM\RulesChecker
    {
        $rules->add($rules->existsIn(['course_id'], 'Courses'));
        $rules->add($rules->existsIn(['subscription_id'], 'Subscriptions'));

        return $rules;
    }

    public function saveSent($id, $courses = [])
    {
        $course_ids = collection($courses)->extract('id')->toList();
        $data = [];
        foreach ($course_ids as $course_id) $data[] = [
            'course_id' => $course_id,
            'subscription_id' => $id
        ];
        $entities = $this->newEntities($data);
        if ($id) $this->saveMany($entities);
    }
}
