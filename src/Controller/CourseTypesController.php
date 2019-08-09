<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * CourseTypes Controller
 *
 * @property \App\Model\Table\CourseTypesTable $CourseTypes
 *
 * @method \App\Model\Entity\CourseType[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CourseTypesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index() {
        $this->CourseTypes->evaluateQuery($this->request->getQuery());
        
        $course_types = $this->CourseTypes->getCourseTypes();
        
        $this->set('course_types', $course_types);
        $this->set('_serialize', 'course_types');
    }
    
    
    /**
     * View method
     *
     * @param string|null $id CourseType id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null) {
        $course_type = $this->CourseTypes->getCourseType($id);
        
        $this->set('course_type', $course_type);
        $this->set('_serialize', 'course_type');
    }
}
