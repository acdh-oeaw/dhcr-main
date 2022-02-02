<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * InviteTranslations Model
 *
 * @method \App\Model\Entity\InviteTranslation newEmptyEntity()
 * @method \App\Model\Entity\InviteTranslation newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\InviteTranslation[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\InviteTranslation get($primaryKey, $options = [])
 * @method \App\Model\Entity\InviteTranslation findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\InviteTranslation patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\InviteTranslation[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\InviteTranslation|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\InviteTranslation saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\InviteTranslation[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\InviteTranslation[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\InviteTranslation[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\InviteTranslation[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class InviteTranslationsTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('invite_translations');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
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
            ->scalar('messageSignature')
            ->maxLength('messageSignature', 255)
            ->requirePresence('messageSignature', 'create')
            ->notEmptyString('messageSignature');

        $validator
            ->boolean('active')
            ->requirePresence('active', 'create')
            ->notEmptyString('active');

        return $validator;
    }
}
