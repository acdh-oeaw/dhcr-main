<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * CourseParentTypes Controller
 *
 * @property \App\Model\Table\CourseParentTypesTable $CourseParentTypes
 *
 * @method \App\Model\Entity\CourseParentType[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CourseParentTypesController extends AppController
{
    
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index() {
        $this->CourseParentTypes->evaluateQuery($this->request->getQuery());
        
        $course_parent_types = $this->CourseParentTypes->getCourseParentTypes();
        
        $this->set('course_parent_types', $course_parent_types);
        $this->set('_serialize', 'course_parent_types');
    }
    
    
    /**
     * View method
     *
     * @param string|null $id CourseParentType id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null) {
        $course_parent_type = $this->CourseParentTypes->getCourseParentType($id);
        
        $this->set('course_parent_type', $course_parent_type);
        $this->set('_serialize', 'course_parent_type');
    }
}
