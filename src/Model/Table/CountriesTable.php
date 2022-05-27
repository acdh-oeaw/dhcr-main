<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class CountriesTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('countries');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->hasMany('Cities', [
            'foreignKey' => 'country_id',
        ]);
        $this->hasMany('Courses', [
            'foreignKey' => 'country_id',
        ]);
        $this->hasMany('Institutions', [
            'foreignKey' => 'country_id',
        ]);
        $this->hasMany('Subscriptions', [
            'foreignKey' => 'country_id',
        ]);
        $this->hasMany('Users', [
            'foreignKey' => 'country_id',
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
}
