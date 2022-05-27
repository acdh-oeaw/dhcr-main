<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class PostsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('posts');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('title')
            ->maxLength('title', 255)
            ->allowEmptyString('title');

        $validator
            ->scalar('external_link')
            ->maxLength('external_link', 255)
            ->allowEmptyString('external_link');

        $validator
            ->scalar('body')
            ->allowEmptyString('body');

        $validator
            ->dateTime('publication_date')
            ->allowEmptyDateTime('publication_date');

        $validator
            ->dateTime('expiry_date')
            ->allowEmptyDateTime('expiry_date');

        $validator
            ->boolean('publish')
            ->notEmptyString('publish');

        return $validator;
    }
}
