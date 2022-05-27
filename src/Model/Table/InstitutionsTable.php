<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class InstitutionsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('institutions');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Cities', [
            'foreignKey' => 'city_id',
        ]);
        $this->belongsTo('Countries', [
            'foreignKey' => 'country_id',
        ]);
        $this->hasMany('Courses', [
            'foreignKey' => 'institution_id',
        ]);
        $this->hasMany('Users', [
            'foreignKey' => 'institution_id',
        ]);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('name')
            ->maxLength('name', 255)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->scalar('description')
            ->allowEmptyString('description');

        $validator
            ->scalar('url')
            ->maxLength('url', 255)
            ->allowEmptyString('url');

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
        $rules->add($rules->existsIn(['city_id'], 'Cities'), ['errorField' => 'city_id']);
        $rules->add($rules->existsIn(['country_id'], 'Countries'), ['errorField' => 'country_id']);

        return $rules;
    }
}
