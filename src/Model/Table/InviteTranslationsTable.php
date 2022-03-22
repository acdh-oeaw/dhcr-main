<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class InviteTranslationsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('invite_translations');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->integer('sortOrder')
            ->requirePresence('sortOrder', 'create')
            ->notEmptyString('sortOrder');

        $validator
            ->scalar('name')
            ->maxLength('name', 40)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->scalar('subject')
            ->maxLength('subject', 150)
            ->requirePresence('subject', 'create')
            ->notEmptyString('subject');

        $validator
            ->scalar('messageBody')
            ->requirePresence('messageBody', 'create')
            ->notEmptyString('messageBody');

        $validator
            ->boolean('active')
            ->requirePresence('active', 'create')
            ->notEmptyString('active');

        return $validator;
    }
}