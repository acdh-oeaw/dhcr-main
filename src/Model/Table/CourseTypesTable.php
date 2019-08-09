<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CourseTypes Model
 *
 * @property \App\Model\Table\CourseParentTypesTable|\Cake\ORM\Association\BelongsTo $CourseParentTypes
 * @property \App\Model\Table\CoursesTable|\Cake\ORM\Association\HasMany $Courses
 *
 * @method \App\Model\Entity\CourseType get($primaryKey, $options = [])
 * @method \App\Model\Entity\CourseType newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\CourseType[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CourseType|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CourseType saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CourseType patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CourseType[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\CourseType findOrCreate($search, callable $callback = null, $options = [])
 */
class CourseTypesTable extends Table
{
	
	public $query = array();
	
	public $allowedParameters = [
		'course_count',
		'sort_count',
		'course_parent_type_id'
	];
	
	
	
	/**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);
    
        $this->addBehavior('CounterSort');
    
        $this->setTable('course_types');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsTo('CourseParentTypes', [
            'foreignKey' => 'course_parent_type_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('Courses', [
            'foreignKey' => 'course_type_id'
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
            ->maxLength('name', 100)
            ->requirePresence('name', 'create')
            ->allowEmptyString('name', false);

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['course_parent_type_id'], 'CourseParentTypes'));

        return $rules;
    }
	
	
	// entry point for querystring evaluation
	public function evaluateQuery($requestQuery = array()) {
		$this->getCleanQuery($requestQuery);
		$this->getFilter();
	}
	
	
	public function getCleanQuery($query = array()) {
		foreach($query as $key => $value) {
			if(!in_array($key, $this->allowedParameters)) {
				unset($query[$key]);
				continue;
			}
		}
		return $this->query = $query;
	}
	
	
	public function getFilter() {
		foreach($this->query as $key => $value) {
			switch($key) {
				case 'sort_count':
				case 'course_count':
					if($value == true || $value === '')
						$this->query[$key] = true;
					if($key == 'sort_count' AND $this->query[$key])
						$this->query['course_count'] = true;
					break;
				case 'course_parent_type_id':
					if(ctype_digit($value)) {
						$this->query['course_parent_type_id'] = $value;
					}else{
						unset($this->query['course_parent_type_id']);
					}
			}
		}
		return $this->query;
	}
	
	
	public function getCourseType($id = null) {
		$record = $this->get($id, [
			'contain' => ['CourseParentTypes'],
			'fields' => ['id','name','course_parent_type_id','CourseParentTypes.id','CourseParentTypes.name']
		]);
		$record->setVirtual(['course_count','full_name']);
		return $record;
	}
	
	/*
	 * Due to iterative post-processing, method returns either array of entities or array of arrays!
	 */
	public function getCourseTypes() {
		$records = $this->find()
			->select(['id','name','course_parent_type_id','CourseParentTypes.id','CourseParentTypes.name'])
			->contain(['CourseParentTypes'])
			->toArray();
		
        foreach($records as &$record) {
            $record->setVirtual(['full_name']);
            if(!empty($this->query['course_count']) OR !empty($this->query['sort_count']))
                $record->setVirtual(['course_count','full_name']);
        }
        // sort by course_count descending, using CounterSortBehavior
        if(!empty($this->query['sort_count']))
            $records = $this->sortByCourseCount($records);
		
		return $records;
	}
 
}
