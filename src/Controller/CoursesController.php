<?php

namespace App\Controller;

use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\I18n\FrozenTime;

class CoursesController extends AppController
{
    public $modelClass = 'DhcrCore.Courses';
    public $Courses = null;
    public const SKIP_AUTHORIZATION = [
        'index',
        'view'
    ];

    public function initialize(): void
    {
        parent::initialize();
        $this->Authentication->allowUnauthenticated(['index', 'view']);
        if (in_array($this->request->getParam('action'), self::SKIP_AUTHORIZATION)) {
            $this->Authorization->skipAuthorization();
        }
    }

    public function index()
    {
        $this->viewBuilder()->setLayout('home');
        $query = $this->request->getQuery();
        if (!isset($query['recent']) or ($query['recent'] !== false and $query['recent'] != 'false'))
            $query['recent'] = true;
        if (!isset($query['sort']))
            $query['sort'] = 'Courses.updated:desc';
        else
            $query['sort'] .= ',Courses.updated:desc';

        // load models from plugin
        $this->loadModel('DhcrCore.Courses');
        $this->loadModel('DhcrCore.Countries');
        $this->loadModel('DhcrCore.Cities');
        $this->loadModel('DhcrCore.Institutions');
        $this->loadModel('DhcrCore.Languages');
        $this->loadModel('DhcrCore.CourseTypes');
        $this->loadModel('DhcrCore.Disciplines');
        $this->loadModel('DhcrCore.TadirahTechniques');
        $this->loadModel('DhcrCore.TadirahObjects');

        $this->Courses->evaluateQuery($query);
        $courses = $this->Courses->getResults();

        // get filter option lists
        $this->Countries->evaluateQuery(['count_recent' => true]);
        $countries = $this->Countries->getCountries();

        $citiesQuery = ['count_recent' => true, 'group' => true];
        if (!empty($query['country_id'])) $citiesQuery['country_id'] = $query['country_id'];
        $this->Cities->evaluateQuery($citiesQuery);
        $cities = $this->Cities->getCities();

        $institutionsQuery = ['count_recent' => true, 'group' => true];
        if (!empty($query['country_id'])) $institutionsQuery['country_id'] = $query['country_id'];
        $this->Institutions->evaluateQuery($institutionsQuery);
        $institutions = $this->Institutions->getInstitutions();

        $this->CourseTypes->evaluateQuery(['count_recent' => true]);
        $types = $this->CourseTypes->getCourseTypes();

        $this->Languages->evaluateQuery(['count_recent' => true]);
        $languages = $this->Languages->getLanguages();

        $this->Disciplines->evaluateQuery(['count_recent' => true]);
        $disciplines = $this->Disciplines->getDisciplines();

        $this->TadirahTechniques->evaluateQuery(['count_recent' => true]);
        $techniques = $this->TadirahTechniques->getTadirahTechniques();

        $this->TadirahObjects->evaluateQuery(['count_recent' => true]);
        $objects = $this->TadirahObjects->getTadirahObjects();

        $this->set(compact(
            'courses',
            'countries',
            'cities',
            'institutions',
            'types',
            'languages',
            'disciplines',
            'techniques',
            'objects'
        ));
    }

    public function view($id = null)
    {
        $this->viewBuilder()->setLayout('home');
        $this->loadModel('DhcrCore.Courses');
        $course = $this->Courses->get($id, [
            'contain' => $this->Courses->containments,
            'conditions' => [
                'Courses.active' => true
            ]
        ]);
        if (empty($course)) {
            throw new RecordNotFoundException();
        }
        $this->set('course', $course);
        $this->render('index');
    }

    public function add()
    {
        $this->viewBuilder()->setLayout('contributors');
        $this->loadModel('DhcrCore.Courses');
        // Set breadcrums
        $breadcrumTitles[0] = 'Administrate Courses';
        $breadcrumControllers[0] = 'Dashboard';
        $breadcrumActions[0] = 'adminCourses';
        $breadcrumTitles[1] = 'Add Course';
        $breadcrumControllers[1] = 'Courses';
        $breadcrumActions[1] = 'add';
        $this->set((compact('breadcrumTitles', 'breadcrumControllers', 'breadcrumActions')));
        $course = $this->Courses->newEmptyEntity();
        $user = $this->Authentication->getIdentity();
        $this->Authorization->authorize($course);
        if ($this->request->is('post')) {
            $course = $this->Courses->patchEntity($course, $this->request->getData());
            // set updated
            $course->set('updated', date("Y-m-d H:i:s") );
            // set user_id
            $course->set('user_id', $this->Authentication->getIdentity()->id);                        
            // set city_id
            $query = $this->Courses->Institutions->find('all')->where(['id' => $course->institution_id]);
            $course->set('city_id', $query->first()->city_id);
            // set country_id
            $course->set('country_id', $query->first()->country_id);
            // set course_parent_type
            $query = $this->Courses->CourseTypes->find('all')->where(['id' => $course->course_type_id]);
            $course->set('course_parent_type_id', $query->first()->course_parent_type->id);
            if ($this->Courses->save($course)) {
                $this->Flash->success(__('The course has been saved.'));
                return $this->redirect(['controller' => 'Dashboard', 'action' => 'adminCourses']);
            }
            $this->Flash->error(__('The course could not be saved. Please, try again.'));
        }
        $languages = $this->Courses->Languages->find('list', ['order' => 'Languages.name asc']);
        $course_types = $this->Courses->CourseTypes->find('list', ['order' => 'id asc']);
        $course_duration_units = $this->Courses->CourseDurationUnits->find('list', ['order' => 'id asc'])->toList();
        $institutions = $this->Courses->Institutions->find('list', ['order' => 'Institutions.name asc']);
        $disciplines = $this->Courses->Disciplines->find('list', ['order' => 'Disciplines.name asc']);
        $tadirah_techniques = $this->Courses->TadirahTechniques->find('list', ['order' => 'TadirahTechniques.name asc']);
        $tadirah_objects = $this->Courses->TadirahObjects->find('list', ['order' => 'TadirahObjects.name asc']);
        $this->set(compact('user')); // required for contributors menu
        $this->set(compact('course', 'languages', 'course_types', 'course_duration_units', 'institutions', 'disciplines', 
                            'tadirah_techniques', 'tadirah_objects'));
    }

    public function edit($id = null)
    {
        $this->viewBuilder()->setLayout('contributors');
        $this->loadModel('DhcrCore.Courses');
        // Set breadcrums
        $breadcrumTitles[0] = 'Administrate Courses';
        $breadcrumControllers[0] = 'Dashboard';
        $breadcrumActions[0] = 'adminCourses';
        $breadcrumTitles[1] = 'Edit Course';
        $breadcrumControllers[1] = 'Courses';
        $breadcrumActions[1] = 'edit';
        $this->set((compact('breadcrumTitles', 'breadcrumControllers', 'breadcrumActions')));
        $user = $this->Authentication->getIdentity();
        $this->Authorization->authorize($user, 'editCourse');
        $course = $this->Courses->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $course = $this->Courses->patchEntity($course, $this->request->getData());
            // set updated
            $course->set('updated', date("Y-m-d H:i:s") );
            // set city_id
            $query = $this->Courses->Institutions->find('all')->where(['id' => $course->institution_id]);
            $course->set('city_id', $query->first()->city_id);
            // set country_id
            $course->set('country_id', $query->first()->country_id);
            // set course_parent_type
            $query = $this->Courses->CourseTypes->find('all')->where(['id' => $course->course_type_id]);
            $course->set('course_parent_type_id', $query->first()->course_parent_type->id);
            if ($this->Courses->save($course)) {
                $this->Flash->success(__('The course has been updated.'));
                return $this->redirect(['controller' => 'Dashboard', 'action' => 'adminCourses']);
            }
            $this->Flash->error(__('The course could not be updated. Please, try again.'));
        }
        $languages = $this->Courses->Languages->find('list', ['order' => 'Languages.name asc']);
        $course_types = $this->Courses->CourseTypes->find('list', ['order' => 'id asc']);
        $course_duration_units = $this->Courses->CourseDurationUnits->find('list', ['order' => 'id asc'])->toList();
        $institutions = $this->Courses->Institutions->find('list', ['order' => 'Institutions.name asc']);
        $disciplines = $this->Courses->Disciplines->find('list', ['order' => 'Disciplines.name asc']);
        $tadirah_techniques = $this->Courses->TadirahTechniques->find('list', ['order' => 'TadirahTechniques.name asc']);
        $tadirah_objects = $this->Courses->TadirahObjects->find('list', ['order' => 'TadirahObjects.name asc']);
        $this->set(compact('user')); // required for contributors menu
        $this->set(compact('user', 'course', 'languages', 'course_types', 'course_duration_units', 'institutions', 'disciplines', 
                            'tadirah_techniques', 'tadirah_objects'));
    }

    public function myCourses()
    {
        $this->viewBuilder()->setLayout('contributors');
        $this->loadModel('DhcrCore.Courses');
        // Set breadcrums
        $breadcrumTitles[0] = 'Administrate Courses';
        $breadcrumControllers[0] = 'Dashboard';
        $breadcrumActions[0] = 'adminCourses';
        $breadcrumTitles[1] = 'My Courses';
        $breadcrumControllers[1] = 'Courses';
        $breadcrumActions[1] = 'myCourses';
        $this->set((compact('breadcrumTitles', 'breadcrumControllers', 'breadcrumActions')));
        $user = $this->Authentication->getIdentity();
        // todo add auth
        $courses = $this->Courses->find('all', ['order' => 'Courses.updated asc', 'contain' => ['CourseTypes', 'Institutions'] ])->where([
                                                        'deleted' => 0,
                                                        'Courses.updated >=' => new FrozenTime('-18 months'),
                                                        'user_id' => $user->id
                                                        ]);
        $coursesCount = $this->Courses->find()->where([
                                                        'deleted' => 0,
                                                        'Courses.updated >=' => new FrozenTime('-18 months'),
                                                        'user_id' => $user->id                                                        
                                                        ])
                                                        ->count();
        $this->set(compact('user')); // required for contributors menu
        $this->set(compact('courses', 'coursesCount'));
        // "customize" view
        $this->set('course_icon', 'th-large');
        $this->set('course_view_type', 'My Courses');
        $this->render('courses-list');
    }

    public function expired()
    {
        $this->viewBuilder()->setLayout('contributors');
        $this->loadModel('DhcrCore.Courses');
        // Set breadcrums
        $breadcrumTitles[0] = 'Needs Attention';
        $breadcrumControllers[0] = 'Dashboard';
        $breadcrumActions[0] = 'needsAttention';
        $breadcrumTitles[1] = 'Course Expiry';
        $breadcrumControllers[1] = 'Courses';
        $breadcrumActions[1] = 'myCourses';
        $this->set((compact('breadcrumTitles', 'breadcrumControllers', 'breadcrumActions')));
        $user = $this->Authentication->getIdentity();
        // todo add auth
        $reminderDate = new FrozenTime('-10 months');
        $hideDate =     new FrozenTime('-18 months');
        if($user->is_admin) {
            $courses = $this->Courses->find('all', ['order' => 'Courses.updated asc', 'contain' => ['CourseTypes', 'Institutions'] ])
                                                ->where([
                                                        'active' => 1,
                                                        'deleted' => 0,
                                                        'Courses.updated <=' => $reminderDate,
                                                        'Courses.updated >=' => $hideDate
                                                        ]);
                        
            $coursesCount = $this->Courses->find()->where([
                                                        'active' => 1,
                                                        'deleted' => 0,
                                                        'Courses.updated <=' => $reminderDate,
                                                        'Courses.updated >=' => $hideDate
                                                        ])
                                                        ->count();
        } elseif($user->user_role_id == 2) {
            $courses = $this->Courses->find('all', ['order' => 'Courses.updated asc', 'contain' => ['CourseTypes', 'Institutions'] ])
                                                ->where([
                                                        'active' => 1,
                                                        'deleted' => 0,
                                                        'Courses.updated <=' => $reminderDate,
                                                        'Courses.updated >=' => $hideDate,
                                                        'Courses.country_id' => $user->country_id
                                                        ]);
                        
            $coursesCount = $this->Courses->find()->where([
                                                        'active' => 1,
                                                        'deleted' => 0,
                                                        'Courses.updated <=' => $reminderDate,
                                                        'Courses.updated >=' => $hideDate,
                                                        'Courses.country_id' => $user->country_id
                                                        ])
                                                        ->count();
        } else {
            $courses = $this->Courses->find('all', ['order' => 'Courses.updated asc', 'contain' => ['CourseTypes', 'Institutions'] ])
                                                ->where([
                                                        'active' => 1,
                                                        'deleted' => 0,
                                                        'Courses.updated <=' => $reminderDate,
                                                        'Courses.updated >=' => $hideDate,
                                                        'user_id' => $user->id
                                                        ]);
                        
            $coursesCount = $this->Courses->find()->where([
                                                        'active' => 1,
                                                        'deleted' => 0,
                                                        'Courses.updated <=' => $reminderDate,
                                                        'Courses.updated >=' => $hideDate,
                                                        'user_id' => $user->id
                                                        ])
                                                        ->count();
        }
        $this->set(compact('user')); // required for contributors menu
        $this->set(compact('courses', 'coursesCount'));
        // "customize" view
        $this->set('course_icon', 'bell');
        $this->set('course_view_type', 'Course Expiry');
        $this->render('courses-list');
    }

    public function moderatedCourses()
    {
        $this->viewBuilder()->setLayout('contributors');
        $this->loadModel('DhcrCore.Courses');
        // Set breadcrums
        $breadcrumTitles[0] = 'Administrate Courses';
        $breadcrumControllers[0] = 'Dashboard';
        $breadcrumActions[0] = 'adminCourses';
        $breadcrumTitles[1] = 'Moderated Courses';
        $breadcrumControllers[1] = 'Courses';
        $breadcrumActions[1] = 'moderatedCourses';
        $this->set((compact('breadcrumTitles', 'breadcrumControllers', 'breadcrumActions')));
        $user = $this->Authentication->getIdentity();
        // todo add auth
        $hideDate = new FrozenTime('-18 months');
        $courses = $this->Courses->find('all', ['order' => 'Courses.updated asc', 'contain' => ['CourseTypes', 'Institutions'] ])
                    ->where([
                            'deleted' => 0,
                            'Courses.updated >=' => $hideDate,
                            'Courses.country_id' => $user->country_id,
                            'approved' => 1
                            ]);
        $coursesCount = $this->Courses->find()->where([
                                                        'deleted' => 0,
                                                        'Courses.updated >=' => $hideDate,
                                                        'Courses.country_id' => $user->country_id,
                                                        'approved' => 1
                                                        ])
                                                        ->count();
        $this->set(compact('user')); // required for contributors menu
        $this->set(compact('courses', 'coursesCount'));
        // "customize" view
        $this->set('course_icon', 'th');
        $this->set('course_view_type', 'Moderated Courses');
        $this->render('courses-list');
    }

    public function courseApproval()
    {
        $this->viewBuilder()->setLayout('contributors');
        $this->loadModel('DhcrCore.Courses');
        // Set breadcrums
        $breadcrumTitles[0] = 'Needs Attention';
        $breadcrumControllers[0] = 'Dashboard';
        $breadcrumActions[0] = 'needsAttention';
        $breadcrumTitles[1] = 'Course Approval';
        $breadcrumControllers[1] = 'Courses';
        $breadcrumActions[1] = 'courseApproval';
        $this->set((compact('breadcrumTitles', 'breadcrumControllers', 'breadcrumActions')));
        $user = $this->Authentication->getIdentity();
        if($user->is_admin) {
            $courses = $this->Courses->find()->order(['Courses.created' => 'desc'])->contain(['Institutions'])
                        ->where([
                                'approved' => 0,
                                'deleted' => 0
                                ]);
        } elseif($user->user_role_id == 2) {
            $courses = $this->Courses->find()->order(['Courses.created' => 'desc'])->contain(['Institutions'])
                        ->where([
                                'approved' => 0,
                                'active' => 1,
                                'Courses.country_id' => $user->country_id
                                ]);
        }
        $this->set(compact('user')); // required for contributors menu
        $this->set(compact('courses'));
    }
}