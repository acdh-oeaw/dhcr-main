<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Event\Event;
use http\Exception\BadHeaderException;

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
        $this->Courses->evaluateQuery($this->request->getQuery());
        $courses = $this->Courses->getResults();
        $this->set('courses', $courses);
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
