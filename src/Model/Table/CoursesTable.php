<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Utility\Hash;

/**
 * Courses Model
 *
 * @property \App\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\DeletionReasonsTable|\Cake\ORM\Association\BelongsTo $DeletionReasons
 * @property \App\Model\Table\CountriesTable|\Cake\ORM\Association\BelongsTo $Countries
 * @property \App\Model\Table\CitiesTable|\Cake\ORM\Association\BelongsTo $Cities
 * @property \App\Model\Table\InstitutionsTable|\Cake\ORM\Association\BelongsTo $Institutions
 * @property \App\Model\Table\CourseParentTypesTable|\Cake\ORM\Association\BelongsTo $CourseParentTypes
 * @property \App\Model\Table\CourseTypesTable|\Cake\ORM\Association\BelongsTo $CourseTypes
 * @property \App\Model\Table\LanguagesTable|\Cake\ORM\Association\BelongsTo $Languages
 * @property \App\Model\Table\CourseDurationUnitsTable|\Cake\ORM\Association\BelongsTo $CourseDurationUnits
 * @property \App\Model\Table\DisciplinesTable|\Cake\ORM\Association\BelongsToMany $Disciplines
 * @property \App\Model\Table\TadirahActivitiesTable|\Cake\ORM\Association\BelongsToMany $TadirahActivities
 * @property \App\Model\Table\TadirahObjectsTable|\Cake\ORM\Association\BelongsToMany $TadirahObjects
 * @property \App\Model\Table\TadirahTechniquesTable|\Cake\ORM\Association\BelongsToMany $TadirahTechniques
 *
 * @method \App\Model\Entity\Course get($primaryKey, $options = [])
 * @method \App\Model\Entity\Course newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Course[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Course|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Course saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Course patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Course[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Course findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class CoursesTable extends Table
{
	
	public $query = array();
	
	public $joins = array();	// filter by associated data
	
	public $filter = array();	// oldschool find conditions
	
	public $sorters = array();		// sort criteria
	
	
	public $allowedFilters = [
		'country_id',
		'city_id',
		'institution_id',
		'language_id',
		'course_type_id',
		'course_parent_type_id',
		'recent',
		'start_date',
		'end_date',
		'sort'
	];
	
	public $allowedTags = [
		'discipline_id',
		'tadirah_object_id',
		'tadirah_technique_id',
	];
	
	public $containments = [
		'DeletionReasons',
		'Countries',
		'Cities',
		'Institutions',
		'CourseParentTypes',
		'CourseTypes',
		'Languages',
		'CourseDurationUnits',
		'Disciplines',
		'TadirahTechniques',
		'TadirahObjects'
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

        $this->setTable('courses');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id'
        ]);
        $this->belongsTo('DeletionReasons', [
            'foreignKey' => 'deletion_reason_id'
        ]);
        $this->belongsTo('Countries', [
            'foreignKey' => 'country_id'
        ]);
        $this->belongsTo('Cities', [
            'foreignKey' => 'city_id'
        ]);
        $this->belongsTo('Institutions', [
            'foreignKey' => 'institution_id'
        ]);
        $this->belongsTo('CourseParentTypes', [
            'foreignKey' => 'course_parent_type_id'
        ]);
        $this->belongsTo('CourseTypes', [
            'foreignKey' => 'course_type_id'
        ]);
        $this->belongsTo('Languages', [
            'foreignKey' => 'language_id'
        ]);
        $this->belongsTo('CourseDurationUnits', [
            'foreignKey' => 'course_duration_unit_id'
        ]);
        $this->hasMany('CoursesDisciplines', [
            'foreignKey' => 'course_id'
        ]);
        $this->hasMany('CoursesTadirahObjects', [
            'foreignKey' => 'course_id'
        ]);
        $this->hasMany('CoursesTadirahTechniques', [
            'foreignKey' => 'course_id'
        ]);
        
        $this->belongsToMany('Disciplines');
        $this->belongsToMany('TadirahTechniques');
        $this->belongsToMany('TadirahObjects');
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
            ->boolean('active')
            ->allowEmptyString('active', false);

        $validator
            ->boolean('deleted')
            ->allowEmptyString('deleted', false);

        $validator
            ->boolean('approved')
            ->allowEmptyString('approved', false);

        $validator
            ->scalar('approval_token')
            ->maxLength('approval_token', 255)
            ->allowEmptyString('approval_token');

        $validator
            ->boolean('mod_mailed')
            ->allowEmptyString('mod_mailed', false);

        $validator
            ->dateTime('last_reminder')
            ->allowEmptyDateTime('last_reminder');

        $validator
            ->scalar('name')
            ->maxLength('name', 255)
            ->allowEmptyString('name');

        $validator
            ->scalar('description')
            ->allowEmptyString('description');

        $validator
            ->scalar('department')
            ->maxLength('department', 255)
            ->allowEmptyString('department');

        $validator
            ->scalar('access_requirements')
            ->allowEmptyString('access_requirements');

        $validator
            ->scalar('start_date')
            ->maxLength('start_date', 100)
            ->allowEmptyString('start_date');

        $validator
            ->integer('duration')
            ->allowEmptyString('duration');

        $validator
            ->boolean('recurring')
            ->allowEmptyString('recurring', false);

        $validator
            ->scalar('info_url')
            ->allowEmptyString('info_url');

        $validator
            ->scalar('guide_url')
            ->allowEmptyString('guide_url');

        $validator
            ->dateTime('skip_info_url')
            ->allowEmptyDateTime('skip_info_url');

        $validator
            ->dateTime('skip_guide_url')
            ->allowEmptyDateTime('skip_guide_url');

        $validator
            ->numeric('ects')
            ->allowEmptyString('ects');

        $validator
            ->scalar('contact_mail')
            ->maxLength('contact_mail', 255)
            ->allowEmptyString('contact_mail');

        $validator
            ->scalar('contact_name')
            ->maxLength('contact_name', 255)
            ->allowEmptyString('contact_name');

        $validator
            ->decimal('lon')
            ->allowEmptyString('lon');

        $validator
            ->decimal('lat')
            ->allowEmptyString('lat');

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
        $rules->add($rules->existsIn(['user_id'], 'Users'));
        $rules->add($rules->existsIn(['deletion_reason_id'], 'DeletionReasons'));
        $rules->add($rules->existsIn(['country_id'], 'Countries'));
        $rules->add($rules->existsIn(['city_id'], 'Cities'));
        $rules->add($rules->existsIn(['institution_id'], 'Institutions'));
        $rules->add($rules->existsIn(['course_parent_type_id'], 'CourseParentTypes'));
        $rules->add($rules->existsIn(['course_type_id'], 'CourseTypes'));
        $rules->add($rules->existsIn(['language_id'], 'Languages'));
        $rules->add($rules->existsIn(['course_duration_unit_id'], 'CourseDurationUnits'));

        return $rules;
    }
	
	
	// entrance point for querystring evaluation
	public function evaluateQuery($requestQuery = array()) {
		$this->getCleanQuery($requestQuery);
		$this->getFilter();
		$this->getJoins();
		$this->getSorters();
	}
	
    
	public function getCleanQuery($query = array()) {
		foreach($query as $key => &$value) {
			if(	!in_array($key, $this->allowedFilters)
			AND !in_array($key, $this->allowedTags)) {
				unset($query[$key]);
				continue;
			}if(is_string($value) AND strpos($value, ',') !== false) {
				$value = array_map('trim', explode(',', $value));
				$value = array_filter($value);    // remove empty elements
				// remove non-digits
				if($key != 'sort')
					$value = array_filter($value, function ($v) {
						return ctype_digit($v) AND $v > 0;
					});
			}
		}
		return $this->query = $query;
	}
    
    
    public function getFilter() {
		$conditions = ['Courses.active' => true];
		foreach($this->query as $key => $value) {
			if(in_array($key, $this->allowedTags)) continue;
			switch($key) {
				case 'recent':
					if($value == true || $value === '') {
						$query['recent'] = true;
						$conditions['Courses.deleted'] = false;
						$conditions['Courses.updated >'] = date('Y-m-d H:i:s', time() - 60*60*24*489);
					}
					break;
				case 'start_date':
					if(is_string($value)) $conditions['Courses.created >='] = $value;
					break;
				case 'end_date':
					if(is_string($value)) $conditions['Courses.updated <='] = $value;
					break;
				case 'sort':
					break;
				default:
					if(!is_array($value))
						$conditions['Courses.'.$key] = $value;
					else
						$conditions['Courses.'.$key.' IN'] = $value;
			}
		}
		
		return $this->filter = $conditions;
	}
	
	
	public function getJoins() {
    	$joins = [];
    	foreach($this->query as $key => $value) {
    		switch($key) {
    			case 'discipline_id':
					$joins[] = [
						'assoc' => 'CoursesDisciplines',
						'conditions' => [
							'CoursesDisciplines.discipline_id IN' => $value
						]
					];
					break;
				case 'tadirah_object_id':
					$joins[] = [
						'assoc' => 'CoursesTadirahObjects',
						'conditions' => [
							'CoursesTadirahObjects.tadirah_object_id IN' => $value
						]
					];
					break;
				case 'tadirah_technique_id':
					$joins[] = [
						'assoc' => 'CoursesTadirahTechniques',
						'conditions' => [
							'CoursesTadirahTechniques.tadirah_techniques_id IN' => $value
						]
					];
			}
		}
    	
    	return $this->joins = $joins;
	}
	
	
	public function getSorters() {
    	if(!empty($this->query['sort'])) {
    		$value = $this->query['sort'];
			if(!is_array($value)) {
				$this->__getValidSorter($this->sorters, $value);
			}else{
				foreach($value as $sort) {
					$this->__getValidSorter($this->sorters, $sort);
				}
			}
		}
    	return $this->sorters;
	}
	
	// do some checking for contained models, existing fields and assume defaults...
	private function __getValidSorter(&$sorters = array(), $value) {
		$direction = 'ASC';
		$sortkey = $value;
    	if(strpos($value, ':') !== false) {
			$expl = array_map('trim', explode(':', $value));
			$expl = array_filter($expl);
			if(!empty($expl[1]) AND preg_match('/^asc$|^desc$/i', $expl[1]))
				$direction = strtoupper($expl[1]);
			$sortkey = $expl[0];
		}
  
		if(strpos($sortkey, '.') === false) $sortkey = 'Courses.'.$sortkey;
		$expl = array_map('trim', explode('.', $sortkey));
		$model = $expl[0];
		$field = $expl[1];
		if(in_array($model, $this->containments) OR $model == 'Courses') {
			if($model == 'Courses') {
				if($this->hasField($field))
					$this->sorters[$sortkey] = $direction;
			}else{
				if($this->{$model}->hasField($field)) {
					$this->sorters[$sortkey] = $direction;
				}
			}
		}
	}
	
	
	public function getResults() {
		$query = $this->find()->distinct()
			->contain($this->containments);
		foreach($this->joins as $join) {
			$query->leftJoinWith($join['assoc']);
			$this->filter[] = $join['conditions'];
		}
		$query->order($this->sorters);
		$query->where($this->filter);
		
		return $query->toArray();
	}
	
	
	public function countResults() {
		$query = $this->find()->distinct();
		foreach($this->joins as $join) {
			$query->leftJoinWith($join['assoc']);
			$this->filter[] = $join['conditions'];
		}
		$query->where($this->filter);
		
		return $query->count();
	}
	
	
	
}
