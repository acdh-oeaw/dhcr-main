<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Disciplines Model
 *
 * @property \App\Model\Table\CoursesTable|\Cake\ORM\Association\BelongsToMany $Courses
 *
 * @method \App\Model\Entity\Discipline get($primaryKey, $options = [])
 * @method \App\Model\Entity\Discipline newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Discipline[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Discipline|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Discipline saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Discipline patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Discipline[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Discipline findOrCreate($search, callable $callback = null, $options = [])
 */
class DisciplinesTable extends Table
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
        
        $this->setTable('disciplines');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsToMany('Courses', [
            'foreignKey' => 'discipline_id',
            'targetForeignKey' => 'course_id',
            'joinTable' => 'courses_disciplines'
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
    
    
    public function getDiscipline($id = null) {
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
    public function getDisciplines() {
        $records = $this->find()
            ->select(['id','name'])
            ->contain([])
            ->order(['Disciplines.name' => 'ASC'])
            ->toArray();
        
        if(!empty($this->query['course_count']) OR !empty($this->query['sort_count']))
            foreach($records as &$record) $record->setVirtual(['course_count']);
        // sort by course_count descending, using CounterSortBehavior
        if(!empty($this->query['sort_count']))
            $records = $this->sortByCourseCount($records);
        
        return $records;
    }
    
}
