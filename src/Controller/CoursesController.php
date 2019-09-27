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
     	// do nothing particular...
    }
    
    
    public function view($id = null) {
		$this->render('index');
    }

    
}
