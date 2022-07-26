<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class LogentriesTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('logentries');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('LogentryCodes', [
            'foreignKey' => 'logentry_code_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
        ]);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create')
            ->add('id', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('source_name')
            ->maxLength('source_name', 25)
            ->requirePresence('source_name', 'create')
            ->notEmptyString('source_name');

        $validator
            ->scalar('subject')
            ->maxLength('subject', 25)
            ->requirePresence('subject', 'create')
            ->notEmptyString('subject');

        $validator
            ->scalar('description')
            ->maxLength('description', 150)
            ->requirePresence('description', 'create')
            ->notEmptyString('description');

        $validator
            ->boolean('cleared')
            ->notEmptyString('cleared');

        return $validator;
    }

    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->isUnique(['id']), ['errorField' => 'id']);
        $rules->add($rules->existsIn(['logentry_code_id'], 'LogentryCodes'), ['errorField' => 'logentry_code_id']);
        $rules->add($rules->existsIn(['user_id'], 'Users'), ['errorField' => 'user_id']);

        return $rules;
    }

    public function createLogEntry($logentryCode, $logUserId, $logSource, $logSubject, $logDescription)
    {
        $logentry = $this->newEmptyEntity();
        $logentry->set('logentry_code_id', $logentryCode);
        $logentry->set('user_id', $logUserId);
        $logentry->set('source_name',  substr($logSource, 0, 25));
        $logentry->set('subject', substr($logSubject, 0, 25));
        $logentry->set('description', substr($logDescription, 0, 150));
        if (!$this->save($logentry)) {
            die("ERROR: Could not save log entry. Program aborted.\n");
        }
    }
}
