<?php
namespace App\Controller;

use Cake\Event\EventInterface;
use Cake\Routing\Router;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{

    public function initialize(): void {
        parent::initialize();
        $this->loadComponent('Authentication.Authentication', [
            'logoutRedirect' => '/users/sign-in'  // Default is false
        ]);
        $this->Authentication->allowUnauthenticated(['signIn','register','whichTerms']);
    }

    public function beforeFilter(EventInterface $event) {
        parent::beforeFilter($event);
        if(!in_array($this->request->getParam('action'), [
            'signIn','register','resetpassword','setpassword']))
            $this->viewBuilder()->setLayout('contributors');
    }

    public function beforeRender(EventInterface $event) {
        parent::beforeRender($event);
    }


    public function signIn()
    {
        if(!empty($_SERVER['HTTP_EPPN'])) {
            var_dump($_SERVER);
            exit;
        }


        // get the shibboleth return parameter
        $here = 'https://dev-dhcr.clarin-dariah.eu/users/sign-in';
        $get = 'https://dhcr.clarin-dariah.eu/Shibboleth.sso/Login?target='.urlencode($here);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $get);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:54.0) Gecko/20100101 Firefox/54.0');
        curl_exec($ch);
        $url = curl_getinfo($ch, CURLINFO_REDIRECT_URL);
        curl_close($ch);
        $idpTarget = false;
        if($url) {
            $query = explode('&', explode('?', $url)[1]);
            foreach ($query as $para) {
                $p = explode('=', $para);
                if($p[0] == 'return') {
                    $returnParameter = urldecode($p[1]);
                    // The return parameter contains the idpSelector form action,
                    // which is hardcoded in class IdpSelector.js
                    // Only the target parameter within the return parameter is required
                    if(strpos($returnParameter, '?') !== false) {
                        $q = explode('&', explode('?', $returnParameter)[1]);
                        foreach($q as $a) {
                            $b = explode('=', $a);
                            if($b[0] == 'target')
                                $idpTarget = urldecode($b[1]);
                        }
                    }
                    break;
                }
            }
        }

        $this->set(compact('idpTarget'));

        $result = $this->Authentication->getResult();

        // If the user is logged in send them away.
        if ($result->isValid()) {
            $authentication = $this->Authentication->getAuthenticationService();
            if ($authentication->identifiers()->get('Password')->needsPasswordRehash()) {
                $user = $this->Users->get($this->Authentication->getIdentityData('id'));
                $user->password = $this->request->getData('password');
                $this->Users->save($user);  // Rehash happens on save.
            }
            $target = $this->Authentication->getLoginRedirect() ?? '/users/dashboard';
            return $this->redirect($target);
        }
        if ($this->request->is('post') && !$result->isValid()) {
            $this->Flash->error('Invalid username or password');
        }
    }



    public function logout()
    {
        $this->Authentication->logout();
        return $this->redirect(['controller' => 'Users','action' => 'signIn']);
    }



    public function dashboard() {

        $this->set('title_for_layout', 'Data Curation UI');
    }



    public function register() {
        $user = $this->Users->newEmptyEntity();
        if ($this->request->is('post')) {
            if(!$this->_checkCaptcha()) {
                $this->Flash->set('The CAPTCHA test failed, please try again.');
                $this->redirect(['controller' => 'users', 'action' => 'register']);
            }

            // patching the entity, validation and other stuff
            $user = $this->Users->register($this->request->getData());

            if($user AND !$user->hasErrors(false)) {
                $this->_newUserAdminNotification($user);
                $result = $this->_sendUserManagementMail([
                    'template' => 'email_verification',
                    'subject' => 'Email Verification',
                    'email' => $user['new_email'],
                    'data' => $user
                ]);
                $this->Session->write('Users.verification', $user['email_token']);
                if($result) {
                    $this->redirect([
                        'controller' => 'users',
                        'action' => 'registration_success'
                    ]);
                }else{
                    $this->Flash->set('User created, but verification mail could not be sent.
                    Try resending the verification mail or contact the admin team to get you started.');
                    $this->redirect([
                        'controller' => 'users',
                        'action' => 'request_email_verification'
                    ]);
                }
            }elseif(!$user) {
                $this->Flash->set('The record could not be saved.
                Please try again and contact the administration team, if the problem persists.');
            }elseif($user->hasErrors(false)) {
                $this->Flash->set('We\'re having errors! Please check the form and amend the indicated fields');
            }
        }
        // render form
        $this->_setOptions();
        $this->set('user', $user);
    }



    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['UserRoles', 'Countries', 'Institutions'],
        ];
        $users = $this->paginate($this->Users);

        $this->set(compact('users'));
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => ['UserRoles', 'Countries', 'Institutions'],
        ]);

        $this->set('user', $user);
    }



    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->_setOptions();
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }




    protected function _setOptions() {
        $institutions = $this->Users->Institutions->find('list', [
            'fields' => ['Institutions.id', 'Institutions.name', 'Countries.name'], // restrict selected fields
            'keyField' => 'id',
            'valueField' => 'name',
            'groupField' => 'country.name'  // the resulting data array path, not very intuitive compared to other field naming conventions in this context
        ])->contain(['Countries'])->toArray();
        // restore alphabetical country order, sort option on finder does not have effect
        ksort($institutions);
        foreach($institutions as $country => &$country_list)
            asort($country_list);
        $countries = $this->Users->Countries->find('list', [
            'order' => 'Countries.name ASC'])->toArray();
        $userRoles = $this->Users->UserRoles->find('list')->toArray();

        $this->set(compact('institutions','countries','userRoles'));
    }

    public function whichTerms() {
        if(!str_ends_with($_SERVER['REQUEST_URI'], '?'))
            $this->redirect('/users/which-terms?');
    }
}
