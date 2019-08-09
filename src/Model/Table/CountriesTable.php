<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Countries Model
 *
 * @property \App\Model\Table\CitiesTable|\Cake\ORM\Association\HasMany $Cities
 * @property \App\Model\Table\CoursesTable|\Cake\ORM\Association\HasMany $Courses
 * @property \App\Model\Table\InstitutionsTable|\Cake\ORM\Association\HasMany $Institutions
 *
 * @method \App\Model\Entity\Country get($primaryKey, $options = [])
 * @method \App\Model\Entity\Country newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Country[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Country|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Country saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Country patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Country[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Country findOrCreate($search, callable $callback = null, $options = [])
 */
class CountriesTable extends Table
{
	
	public $query = array();
	
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

        $this->setTable('countries');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->hasMany('Cities', [
            'foreignKey' => 'country_id'
        ]);
        $this->hasMany('Courses', [
            'foreignKey' => 'country_id'
        ]);
        $this->hasMany('Institutions', [
            'foreignKey' => 'country_id'
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

        $validator
            ->scalar('domain_name')
            ->maxLength('domain_name', 255)
            ->allowEmptyString('domain_name');

        $validator
            ->scalar('stop_words')
            ->maxLength('stop_words', 255)
            ->allowEmptyString('stop_words');

        return $validator;
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
					if($value == true || $value === '')
						$this->query[$key] = true;
					if($key == 'sort_count')
						$this->query['course_count'] = true;
			}
		}
		return $this->query;
	}
    
    
    public function getCountry($id = null) {
    	$country = $this->get($id, [
			'contain' => [],
			'fields' => ['id','name']
		]);
    	$country->setVirtual(['course_count']);
    	return $country;
	}
	
	/*
	 * Due to iterative post-processing, method returns either array of entities or array of arrays!
	 */
	public function getCountries() {
    	$countries = $this->find()
			->select(['id','name'])
			->contain([])
			->order(['Countries.name' => 'ASC'])
			->toArray();
        
        if(!empty($this->query['course_count']) OR !empty($this->query['sort_count']))
            foreach($countries as &$country) $country->setVirtual(['course_count']);
        // sort by course_count descending, using CounterSortBehavior
        if(!empty($this->query['sort_count']))
            $countries = $this->sortByCourseCount($countries);

		return $countries;
	}
	
	
	
}
