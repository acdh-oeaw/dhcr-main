<?php

namespace App\Controller;

use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Core\Configure;

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
        $this->loadModel('DhcrCore.Courses');
        $course = $this->Courses->newEmptyEntity();
        $user = $this->Authentication->getIdentity();
        $this->Authorization->authorize($course);
        if ($this->request->is('post')) {
            $course = $this->Courses->patchEntity($course, $this->request->getData());
            $course->set('updated', date("Y-m-d H:i:s"));
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
                $this->Flash->success(__('The course has been added.'));
                return $this->redirect(['controller' => 'Dashboard', 'action' => 'adminCourses']);
            }
            $this->Flash->error(__('The course could not be added. Please, try again.'));
        }
        $this->viewBuilder()->setLayout('contributors');
        // Set breadcrums
        $breadcrumTitles[0] = 'Administrate Courses';
        $breadcrumControllers[0] = 'Dashboard';
        $breadcrumActions[0] = 'adminCourses';
        $breadcrumTitles[1] = 'Add Course';
        $breadcrumControllers[1] = 'Courses';
        $breadcrumActions[1] = 'add';
        $this->set((compact('breadcrumTitles', 'breadcrumControllers', 'breadcrumActions')));
        $userInstitution = $this->Courses->Institutions->find()->where(['id' => $user->institution_id])->first();
        $mapInit = ['lon' => $userInstitution->lon, 'lat' => $userInstitution->lat];
        $languages = $this->Courses->Languages->find('list', ['order' => 'Languages.name asc']);
        $course_types = $this->Courses->CourseTypes->find('list', ['order' => 'id asc']);
        $course_duration_units = $this->Courses->CourseDurationUnits->find('list', ['order' => 'id asc'])->toList();
        $institutions = $this->Courses->Institutions->find('list', ['order' => 'Institutions.name asc']);
        $disciplines = $this->Courses->Disciplines->find('list', ['order' => 'Disciplines.name asc']);
        $selectedDisciplines = [];
        $tadirah_techniques = $this->Courses->TadirahTechniques->find('list', ['order' => 'TadirahTechniques.name asc']);
        $selectedTadirahTechniques = [];
        $tadirah_objects = $this->Courses->TadirahObjects->find('list', ['order' => 'TadirahObjects.name asc']);
        $selectedTadirahObjects = [];
        // required for changing map to location of selected institution
        $institutionsLocations = [];
        foreach ($this->Courses->Institutions->find() as $institution) {
            $institutionsLocations[$institution->id] = ['lon' => $institution->lon, 'lat' => $institution->lat];
        }
        $this->set(compact('user')); // required for contributors menu
        $this->set(compact(
            'mapInit',
            'course',
            'languages',
            'course_types',
            'course_duration_units',
            'institutions',
            'disciplines',
            'selectedDisciplines',
            'tadirah_techniques',
            'selectedTadirahTechniques',
            'tadirah_objects',
            'selectedTadirahObjects',
            'institutionsLocations'
        ));
        // "customize" view
        $this->set('course_icon', 'plus');
        $this->set('course_action', 'Add Course');
        $this->set('course_submit_label', 'Add Course');
        $this->render('add_edit');
    }

    public function edit($id = null)
    {
        $this->loadModel('DhcrCore.Courses');
        $course = $this->Courses->get($id);
        $user = $this->Authentication->getIdentity();
        $this->Authorization->authorize($course);
        if ($this->request->is(['patch', 'post', 'put'])) {

            // debug($this->request);
            
            $course = $this->Courses->patchEntity($course, $this->request->getData());
            // set updated
            $course->set('updated', date("Y-m-d H:i:s"));
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
        $this->viewBuilder()->setLayout('contributors');
        // Set breadcrums
        $breadcrumTitles[0] = 'Administrate Courses';
        $breadcrumControllers[0] = 'Dashboard';
        $breadcrumActions[0] = 'adminCourses';
        $breadcrumTitles[1] = 'Edit Course';
        $breadcrumControllers[1] = 'Courses';
        $breadcrumActions[1] = 'edit';
        $this->set((compact('breadcrumTitles', 'breadcrumControllers', 'breadcrumActions')));
        $mapInit = ['lon' => $course->lon, 'lat' => $course->lat];
        $languages = $this->Courses->Languages->find('list', ['order' => 'Languages.name asc']);
        $course_types = $this->Courses->CourseTypes->find('list', ['order' => 'id asc']);
        $course_duration_units = $this->Courses->CourseDurationUnits->find('list', ['order' => 'id asc']);
        $institutions = $this->Courses->Institutions->find('list', ['order' => 'Institutions.name asc']);
        $disciplines = $this->Courses->Disciplines->find('list', ['order' => 'Disciplines.name asc']);
        $results = $this->Courses->CoursesDisciplines->find('all')->where(['course_id' => $course->id]);
        $selectedDisciplines = [];
        foreach($results as $result) {
            $selectedDisciplines[] = $result->discipline_id;
        }
        $tadirah_techniques = $this->Courses->TadirahTechniques->find('list', ['order' => 'TadirahTechniques.name asc']);
        $results = $this->Courses->CoursesTadirahTechniques->find('all')->where(['course_id' => $course->id]);
        $selectedTadirahTechniques = [];
        foreach($results as $result) {
            $selectedTadirahTechniques[] = $result->tadirah_technique_id;
        }
        $tadirah_objects = $this->Courses->TadirahObjects->find('list', ['order' => 'TadirahObjects.name asc']);
        $results = $this->Courses->CoursesTadirahObjects->find('all')->where(['course_id' => $course->id]);
        $selectedTadirahObjects = [];
        foreach($results as $result) {
            $selectedTadirahObjects[] = $result->tadirah_object_id;
        }
        // required for changing map to location of selected institution
        $institutionsLocations = [];
        foreach ($this->Courses->Institutions->find() as $institution) {
            $institutionsLocations[$institution->id] = ['lon' => $institution->lon, 'lat' => $institution->lat];
        }
        $this->set(compact('user')); // required for contributors menu
        $this->set(compact(
            'mapInit',
            'course',
            'languages',
            'course_types',
            'course_duration_units',
            'institutions',
            'disciplines',
            'selectedDisciplines',
            'tadirah_techniques',
            'selectedTadirahTechniques',
            'tadirah_objects',
            'selectedTadirahObjects',
            'institutionsLocations'
        ));
        // "customize" view
        $this->set('course_icon', 'pencil');
        $this->set('course_action', 'Edit Course');
        $this->set('course_submit_label', 'Update Course');
        $this->render('add_edit');
    }

    public function myCourses()
    {
        $this->loadModel('DhcrCore.Courses');
        $user = $this->Authentication->getIdentity();
        $this->viewBuilder()->setLayout('contributors');
        // Set breadcrums
        $breadcrumTitles[0] = 'Administrate Courses';
        $breadcrumControllers[0] = 'Dashboard';
        $breadcrumActions[0] = 'adminCourses';
        $breadcrumTitles[1] = 'My Courses';
        $breadcrumControllers[1] = 'Courses';
        $breadcrumActions[1] = 'myCourses';
        $this->set((compact('breadcrumTitles', 'breadcrumControllers', 'breadcrumActions')));
        $courses = $this->paginate(
            $this->Courses->find()->where([
                'deleted' => 0,
                'Courses.updated >' => Configure::read('courseArchiveDate'),
                'user_id' => $user->id
            ]),
            [
                'order' => ['Courses.name' => 'asc'],
                'contain' => ['CourseTypes', 'Institutions', 'Users']
            ]
        );
        $coursesCount = $this->Courses->find()->where([
            'deleted' => 0,
            'Courses.updated >' => Configure::read('courseArchiveDate'),
            'user_id' => $user->id
        ])
            ->count();
        $this->set(compact('user')); // required for contributors menu
        $this->set(compact('courses', 'coursesCount'));
        // "customize" view
        $this->set('course_icon', 'education');
        $this->set('course_view_type', 'My Courses');
        $this->render('courses-list');
    }

    public function expired()
    {
        $this->loadModel('DhcrCore.Courses');
        $user = $this->Authentication->getIdentity();
        $this->viewBuilder()->setLayout('contributors');
        // Set breadcrums
        $breadcrumTitles[0] = 'Needs Attention';
        $breadcrumControllers[0] = 'Dashboard';
        $breadcrumActions[0] = 'needsAttention';
        $breadcrumTitles[1] = 'Course Expiry';
        $breadcrumControllers[1] = 'Courses';
        $breadcrumActions[1] = 'myCourses';
        $this->set((compact('breadcrumTitles', 'breadcrumControllers', 'breadcrumActions')));
        if ($user->is_admin) {
            $courses = $this->paginate(
                $this->Courses->find()->where([
                    'Courses.active' => 1,
                    'Courses.deleted' => 0,
                    'Courses.updated <' => Configure::read('courseYellowDate'),
                    'Courses.updated >' => Configure::read('courseArchiveDate')
                ]),
                [
                    'order' => ['Courses.updated' => 'asc'],
                    'contain' => ['CourseTypes', 'Institutions', 'Users']
                ]
            );
            $coursesCount = $this->Courses->find()->where([
                'active' => 1,
                'deleted' => 0,
                'Courses.updated <' => Configure::read('courseYellowDate'),
                'Courses.updated >' => Configure::read('courseArchiveDate')
            ])
                ->count();
        } elseif ($user->user_role_id == 2) {
            $courses = $this->paginate(
                $this->Courses->find()->where([
                    'Courses.active' => 1,
                    'Courses.deleted' => 0,
                    'Courses.updated <' => Configure::read('courseYellowDate'),
                    'Courses.updated >' => Configure::read('courseArchiveDate'),
                    'Courses.country_id' => $user->country_id
                ]),
                [
                    'order' => ['Courses.updated' => 'asc'],
                    'contain' => ['CourseTypes', 'Institutions', 'Users']
                ]
            );
            $coursesCount = $this->Courses->find()->where([
                'active' => 1,
                'deleted' => 0,
                'Courses.updated <' => Configure::read('courseYellowDate'),
                'Courses.updated >' => Configure::read('courseArchiveDate'),
                'Courses.country_id' => $user->country_id
            ])
                ->count();
        } else {
            $courses = $this->paginate(
                $this->Courses->find()->where([
                    'Courses.active' => 1,
                    'Courses.deleted' => 0,
                    'Courses.updated <' => Configure::read('courseYellowDate'),
                    'Courses.updated >' => Configure::read('courseArchiveDate'),
                    'Courses.user_id' => $user->id
                ]),
                [
                    'order' => ['Courses.updated' => 'asc'],
                    'contain' => ['CourseTypes', 'Institutions', 'Users']
                ]
            );
            $coursesCount = $this->Courses->find()->where([
                'active' => 1,
                'deleted' => 0,
                'Courses.updated <' => Configure::read('courseYellowDate'),
                'Courses.updated >' => Configure::read('courseArchiveDate'),
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

    public function moderated()
    {
        $this->loadModel('DhcrCore.Courses');
        $user = $this->Authentication->getIdentity();
        $this->viewBuilder()->setLayout('contributors');
        // Set breadcrums
        $breadcrumTitles[0] = 'Administrate Courses';
        $breadcrumControllers[0] = 'Dashboard';
        $breadcrumActions[0] = 'adminCourses';
        $breadcrumTitles[1] = 'Moderated Courses';
        $breadcrumControllers[1] = 'Courses';
        $breadcrumActions[1] = 'moderatedCourses';
        $this->set((compact('breadcrumTitles', 'breadcrumControllers', 'breadcrumActions')));
        if ($user->user_role_id == 2) {
            $courses = $this->paginate(
                $this->Courses->find()->where([
                    'Courses.approved' => 1,
                    'Courses.active' => 1,
                    'Courses.deleted' => 0,
                    'Courses.updated >' => Configure::read('courseArchiveDate'),
                    'Courses.country_id' => $user->country_id
                ]),
                [
                    'order' => ['Courses.name' => 'asc'],
                    'contain' => ['CourseTypes', 'Institutions', 'Users']
                ]
            );
            $coursesCount = $this->Courses->find()->where([
                'Courses.approved' => 1,
                'Courses.active' => 1,
                'Courses.deleted' => 0,
                'Courses.updated >' => Configure::read('courseArchiveDate'),
                'Courses.country_id' => $user->country_id,
            ])
                ->count();
        } else {
            $this->Flash->error(__('Not authorized to moderated courses'));
            return $this->redirect(['controller' => 'Dashboard', 'action' => 'index']);
        }
        $this->set(compact('user')); // required for contributors menu
        $this->set(compact('courses', 'coursesCount'));
        // "customize" view
        $this->set('course_icon', 'th');
        $this->set('course_view_type', 'Moderated Courses');
        $this->render('courses-list');
    }

    public function all()
    {
        $this->loadModel('DhcrCore.Courses');
        $user = $this->Authentication->getIdentity();
        $this->viewBuilder()->setLayout('contributors');
        // Set breadcrums
        $breadcrumTitles[0] = 'Administrate Courses';
        $breadcrumControllers[0] = 'Dashboard';
        $breadcrumActions[0] = 'adminCourses';
        $breadcrumTitles[1] = 'All Courses';
        $breadcrumControllers[1] = 'Courses';
        $breadcrumActions[1] = 'allCourses';
        $this->set((compact('breadcrumTitles', 'breadcrumControllers', 'breadcrumActions')));
        if ($user->is_admin) {
            $courses = $this->paginate(
                $this->Courses->find()->where([
                    'deleted' => 0,
                    'Courses.updated >' => Configure::read('courseArchiveDate'),
                ]),
                [
                    'order' => ['Courses.name' => 'asc'],
                    'contain' => ['CourseTypes', 'Institutions', 'Users']
                ]
            );
            $coursesCount = $this->Courses->find()->where([
                'deleted' => 0,
                'Courses.updated >' => Configure::read('courseArchiveDate')
            ])
                ->count();
        } else {
            $this->Flash->error(__('Not authorized to all courses'));
            return $this->redirect(['controller' => 'Dashboard', 'action' => 'index']);
        }
        $this->set(compact('user')); // required for contributors menu
        $this->set(compact('courses', 'coursesCount'));
        // "customize" view
        $this->set('course_icon', 'list-alt');
        $this->set('course_view_type', 'All Courses');
        $this->render('courses-list');
    }

    public function approve($id = null)
    {
        $this->loadModel('DhcrCore.Courses');
        $user = $this->Authentication->getIdentity();
        if ($id != null) {
            $course = $this->Courses->get($id);
            $this->Authorization->authorize($course);
            $course->set('approved', 1);
            if ($this->Courses->save($course)) {
                $this->Flash->success(__('The course has been approved.'));
            } else {
                $this->Flash->error(__('Error approving the course.'));
            }
            return $this->redirect(['controller' => 'Courses', 'action' => 'approve']);
        }
        $this->viewBuilder()->setLayout('contributors');
        // Set breadcrums
        $breadcrumTitles[0] = 'Needs Attention';
        $breadcrumControllers[0] = 'Dashboard';
        $breadcrumActions[0] = 'needsAttention';
        $breadcrumTitles[1] = 'Course Approval';
        $breadcrumControllers[1] = 'Courses';
        $breadcrumActions[1] = 'courseApproval';
        $this->set((compact('breadcrumTitles', 'breadcrumControllers', 'breadcrumActions')));
        if ($user->is_admin) {
            $courses = $this->paginate(
                $this->Courses->find()->where([
                    'Courses.approved' => 0,
                    'Courses.active' => 1,
                    'Courses.deleted' => 0,
                    'Courses.updated >' => Configure::read('courseArchiveDate'),
                ]),
                [
                    'order' => ['Courses.created' => 'desc'],
                    'contain' => ['CourseTypes', 'Institutions', 'Users']
                ]
            );
            $coursesCount = $this->Courses->find()->where([
                'approved' => 0,
                'active' => 1,
                'deleted' => 0,
                'Courses.updated >' => Configure::read('courseArchiveDate')
            ])
                ->count();
        } elseif ($user->user_role_id == 2) {
            $courses = $this->paginate(
                $this->Courses->find()->where([
                    'Courses.approved' => 0,
                    'Courses.active' => 1,
                    'Courses.deleted' => 0,
                    'Courses.updated >' => Configure::read('courseArchiveDate'),
                    'Courses.country_id' => $user->country_id
                ]),
                [
                    'order' => ['Courses.created' => 'desc'],
                    'contain' => ['CourseTypes', 'Institutions', 'Users']
                ]
            );
            $coursesCount = $this->Courses->find()->where([
                'approved' => 0,
                'active' => 1,
                'deleted' => 0,
                'Courses.updated >' => Configure::read('courseArchiveDate'),
                'Courses.country_id' => $user->country_id,
            ])
                ->count();
        } else {
            $this->Flash->error(__('Not authorized to course approval'));
            return $this->redirect(['controller' => 'Dashboard', 'action' => 'index']);
        }
        $this->set(compact('user')); // required for contributors menu
        $this->set(compact('courses', 'coursesCount'));
        // "customize" view
        $this->set('course_icon', 'education');
        $this->set('course_view_type', 'Course Approval');
        $this->render('courses-list');
    }
}
