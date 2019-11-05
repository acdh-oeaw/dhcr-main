<?php
namespace App\Controller;


use Cake\Datasource\Exception\RecordNotFoundException;

/**
 * Courses Controller
 *
 * @property \App\Model\Table\CoursesTable $Courses
 *
 * @method \App\Model\Entity\Course[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CoursesController extends AppController
{
    
    public function index() {
        $query = $this->request->getQuery();
        if(!isset($query['recent']) OR ($query['recent'] !== false AND $query['recent'] != 'false'))
            $query['recent'] = true;
        $this->Courses->evaluateQuery($query);
        $courses = $this->Courses->getResults();
    
        $this->loadModel('Countries');
        $this->loadModel('Cities');
        $this->loadModel('Institutions');
        
        // get filter option lists
        $countriesQuery = ['course_count' => true];
        $this->Countries->evaluateQuery($countriesQuery);
        $countries = $this->Countries->getCountries();
        
        $citiesQuery = ['course_count' => true, 'group' => true];
        if(!empty($query['country_id'])) $citiesQuery['country_id'] = $query['country_id'];
        $this->Cities->evaluateQuery($citiesQuery);
        $cities = $this->Cities->getCities();
        
        $institutionsQuery = ['course_count' => true, 'group' => true];
        if(!empty($query['country_id'])) $institutionsQuery['country_id'] = $query['country_id'];
        $this->Institutions->evaluateQuery($institutionsQuery);
        $institutions = $this->Institutions->getInstitutions();
        
        $this->set(compact('courses','countries','cities','institutions'));
    }
    
    
    public function view($id = null) {
        $course = $this->Courses->get($id, [
            'contain' => $this->Courses->containments,
            'conditions' => [
                'Courses.active' => true
            ]
        ]);
    
        if(empty($course)) {
            throw new RecordNotFoundException();
        }
    
        $this->set('course', $course);
        $this->render('index');
    }

    
}
