<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CourseParentTypes Model
 *
 * @property \App\Model\Table\CourseParentTypesTable|\Cake\ORM\Association\HasMany $CourseParentTypes
 * @property \App\Model\Table\CoursesTable|\Cake\ORM\Association\HasMany $Courses
 *
 * @method \App\Model\Entity\CourseParentType get($primaryKey, $options = [])
 * @method \App\Model\Entity\CourseParentType newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\CourseParentType[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CourseParentType|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CourseParentType saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CourseParentType patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CourseParentType[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\CourseParentType findOrCreate($search, callable $callback = null, $options = [])
 */
class CourseParentTypesTable extends Table
{
    
    public $allowedParameters = [
        'course_count',
        'sort_count'
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
    
        $this->setTable('course_parent_types');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->hasMany('CourseParentTypes', [
            'foreignKey' => 'course_parent_type_id'
        ]);
        $this->hasMany('Courses', [
            'foreignKey' => 'course_parent_type_id'
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
            }
        }
        return $this->query;
    }
    
    
    public function getCourseParentType($id = null) {
        $record = $this->get($id, [
            'contain' => [],
            'fields' => ['id','name']
        ]);
        $record->setVirtual(['course_count']);
        return $record;
    }
    
    /*
     * Due to iterative post-processing, method returns either array of entities or array of arrays!
     */
    public function getCourseParentTypes() {
        $records = $this->find()
            ->select(['id','name'])
            ->contain([])
            ->toArray();
        
        if(!empty($this->query['course_count']) OR !empty($this->query['sort_count']))
            foreach($records as &$record) $record->setVirtual(['course_count']);
        // sort by course_count descending, using CounterSortBehavior
        if(!empty($this->query['sort_count']))
            $records = $this->sortByCourseCount($records);
        
        return $records;
    }
    
}
