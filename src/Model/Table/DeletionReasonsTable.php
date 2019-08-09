<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * DeletionReasons Model
 *
 * @property \App\Model\Table\CoursesTable|\Cake\ORM\Association\HasMany $Courses
 *
 * @method \App\Model\Entity\DeletionReason get($primaryKey, $options = [])
 * @method \App\Model\Entity\DeletionReason newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\DeletionReason[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\DeletionReason|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DeletionReason saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DeletionReason patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\DeletionReason[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\DeletionReason findOrCreate($search, callable $callback = null, $options = [])
 */
class DeletionReasonsTable extends Table
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

        $this->setTable('deletion_reasons');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->hasMany('Courses', [
            'foreignKey' => 'deletion_reason_id'
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
            ->allowEmptyString('id', 'create');

        $validator
            ->scalar('name')
            ->maxLength('name', 255)
            ->requirePresence('name', 'create')
            ->allowEmptyString('name', false);

        return $validator;
    }
	
	
	public function getDeletionReason($id = null) {
		$record = $this->get($id, [
			'contain' => [],
			'fields' => ['id','name']
		]);
		return $record;
	}
	
	
	public function getDeletionReasons() {
		$records = $this->find()
			->select(['id','name'])
			->contain([])
			->toArray();
		return $records;
	}
 
}
