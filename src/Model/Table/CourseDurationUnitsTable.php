<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CourseDurationUnits Model
 *
 * @property \App\Model\Table\CoursesTable|\Cake\ORM\Association\HasMany $Courses
 *
 * @method \App\Model\Entity\CourseDurationUnit get($primaryKey, $options = [])
 * @method \App\Model\Entity\CourseDurationUnit newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\CourseDurationUnit[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CourseDurationUnit|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CourseDurationUnit saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CourseDurationUnit patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CourseDurationUnit[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\CourseDurationUnit findOrCreate($search, callable $callback = null, $options = [])
 */
class CourseDurationUnitsTable extends Table
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

        $this->setTable('course_duration_units');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->hasMany('Courses', [
            'foreignKey' => 'course_duration_unit_id'
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
            ->maxLength('name', 50)
            ->requirePresence('name', 'create')
            ->allowEmptyString('name', false);

        return $validator;
    }
	
	
	
	public function getCourseDurationUnit($id = null) {
		$record = $this->get($id, [
			'contain' => [],
			'fields' => ['id','name']
		]);
		return $record;
	}
	
	
	public function getCourseDurationUnits() {
		$records = $this->find()
			->select(['id','name'])
			->contain([])
			->toArray();
		return $records;
	}
 
 
}
