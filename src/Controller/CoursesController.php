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
        if(!isset($query['sort']))
            $query['sort'] = 'Courses.updated:desc';
        else
            $query['sort'] .= ',Courses.updated:desc';
        $this->Courses->evaluateQuery($query);
        $courses = $this->Courses->getResults();
    
        $this->loadModel('Countries');
        $this->loadModel('Cities');
        $this->loadModel('Institutions');
        $this->loadModel('Languages');
        $this->loadModel('CourseTypes');
        $this->loadModel('Disciplines');
        $this->loadModel('TadirahTechniques');
        $this->loadModel('TadirahObjects');
        
        // get filter option lists
        $this->Countries->evaluateQuery(['course_count' => true]);
        $countries = $this->Countries->getCountries();
        
        $citiesQuery = ['course_count' => true, 'group' => true];
        if(!empty($query['country_id'])) $citiesQuery['country_id'] = $query['country_id'];
        $this->Cities->evaluateQuery($citiesQuery);
        $cities = $this->Cities->getCities();
        
        $institutionsQuery = ['course_count' => true, 'group' => true];
        if(!empty($query['country_id'])) $institutionsQuery['country_id'] = $query['country_id'];
        $this->Institutions->evaluateQuery($institutionsQuery);
        $institutions = $this->Institutions->getInstitutions();
    
        $this->CourseTypes->evaluateQuery(['course_count' => true]);
        $types = $this->CourseTypes->getCourseTypes();
    
        $this->Languages->evaluateQuery(['course_count' => true]);
        $languages = $this->Languages->getLanguages();
    
        $this->Disciplines->evaluateQuery(['course_count' => true]);
        $disciplines = $this->Disciplines->getDisciplines();
        
        $this->TadirahTechniques->evaluateQuery(['course_count' => true]);
        $techniques = $this->TadirahTechniques->getTadirahTechniques();
        
        $this->TadirahObjects->evaluateQuery(['course_count' => true]);
        $objects = $this->TadirahObjects->getTadirahObjects();
        
        $this->set(compact('courses',
            'countries','cities','institutions','types',
            'languages','disciplines','techniques','objects'));
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
