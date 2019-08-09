<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Institutions Model
 *
 * @property \App\Model\Table\InstitutionsTable|\Cake\ORM\Association\BelongsTo $Institutions
 * @property \App\Model\Table\CountriesTable|\Cake\ORM\Association\BelongsTo $Countries
 * @property \App\Model\Table\CoursesTable|\Cake\ORM\Association\HasMany $Courses
 * @property \App\Model\Table\UsersTable|\Cake\ORM\Association\HasMany $Users
 *
 * @method \App\Model\Entity\Institution get($primaryKey, $options = [])
 * @method \App\Model\Entity\Institution newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Institution[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Institution|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Institution saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Institution patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Institution[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Institution findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class InstitutionsTable extends Table
{
	
	public $query = array();
	
	public $allowedParameters = [
		'course_count',
		'sort_count',
		'group',
		'country_id',
		'city_id'
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

        $this->setTable('institutions');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Cities', [
            'foreignKey' => 'city_id'
        ]);
        $this->belongsTo('Countries', [
            'foreignKey' => 'country_id'
        ]);
        $this->hasMany('Courses', [
            'foreignKey' => 'institution_id'
        ]);
        $this->hasMany('Users', [
            'foreignKey' => 'institution_id'
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

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['institution_id'], 'Institutions'));
        $rules->add($rules->existsIn(['country_id'], 'Countries'));

        return $rules;
    }
	
	
	
	// entrance point for querystring evaluation
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
				case 'group':
					if($value == true || $value === '')
						$this->query[$key] = true;
					if($key == 'sort_count' AND $this->query[$key])
						$this->query['course_count'] = true;
					break;
				case 'country_id':
					if(ctype_digit($value)) {
						$this->query['country_id'] = $value;
					}else{
						unset($this->query['country_id']);
					}
					break;
				case 'city_id':
					if(ctype_digit($value)) {
						$this->query['city_id'] = $value;
						unset($this->query['country_id']);
					}else{
						unset($this->query['city_id']);
					}
			}
		}
		
		return $this->query;
	}
	
	
	
	public function getInstitution($id = null) {
		$institution = $this->get($id, [
			'contain' => ['Countries','Cities'],
			'fields' => ['id','name','country_id','city_id','Countries.id','Countries.name','Cities.id','Cities.name']
		]);
		$institution->setVirtual(['course_count']);
		return $institution;
	}
	
	/*
	 * Due to iterative post-processing, method returns either array of entities or array of arrays!
	 */
	public function getInstitutions() {
		$institutions = $this->find()
			->select(['id','name','city_id','country_id','Cities.id','Cities.name'])
			->contain(['Countries','Cities'])
			->order(['Institutions.name' => 'ASC']);
		if(!empty($this->query['country_id']) AND empty($this->query['city_id']))
			$institutions->where(['Institutions.country_id' => $this->query['country_id']]);
		if(!empty($this->query['city_id']) AND empty($this->query['country_id']))
			$institutions->where(['Institutions.city_id' => $this->query['city_id']]);
		
		// calling toArray directly does not change the object by reference - assignment required
		$institutions = $institutions->toArray();
        
        if(!empty($this->query['course_count']) OR !empty($this->query['sort_count']))
            foreach($institutions as &$institution) $institution->setVirtual(['course_count']);
        // sort by course_count descending, using CounterSortBehavior
        if(!empty($this->query['sort_count']))
            $institutions = $this->sortByCourseCount($institutions);
		
		// mapReduce does not work on result array: $institution->mapReduce($mapper, $reducer);
		if(!empty($this->query['group'])) {
			$result = [];
			foreach($institutions as $key => $institution) {
				$result[$institution['country']['name']][] = $institution;
			}
			$institutions = $result;
			ksort($institutions, SORT_STRING);
		}
		
		return $institutions;
	}
	
	
}
