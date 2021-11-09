<?php
namespace App\Controller;

use App\Authenticator\AppResult;
use Cake\Core\Exception\Exception;
use Cake\Event\EventInterface;
use Cake\Mailer\MailerAwareTrait;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 */
class UsersController extends AppController
{
    use MailerAwareTrait;


    public const ALLOW_UNAUTHENTICATED = [
        'signIn',
        'logout',   // avoid redirecting
        'register',
        'confirmMail',
        'requestNewPassword',
        'resetPassword',
        'unknownIdentity',
        'connectIdentity',
        'registerIdentity',
        'whichTerms'
    ];

    public const SKIP_AUTHORIZATION = [
        'signIn',
        'logout',
        'register',
        'verifyMail',
        'confirmMail',
        'requestNewPassword',
        'resetPassword',
        'registrationSuccess',
        'unknownIdentity',
        'connectIdentity',
        'registerIdentity',
        'whichTerms',
        'verifyMail'
    ];

    public const DEFAULT_LAYOUT = [
        'signIn',
        'register',
        'registrationSuccess',
        'requestNewPassword',
        'resetPassword',
        'unknownIdentity',
        'connectIdentity',
        'registerIdentity',
        'whichTerms',
        'verifyMail'
    ];

    public function initialize(): void {
        parent::initialize();
        $this->Authentication->allowUnauthenticated(self::ALLOW_UNAUTHENTICATED);

        if(in_array($this->request->getParam('action'), self::SKIP_AUTHORIZATION)) {
            $this->Authorization->skipAuthorization();
        }
    }

    public function beforeFilter(EventInterface $event) {
        $result = $this->Authentication->getResult();
        if($result->isValid()) {
            // set the contributor layout for logged in users and certain actions only
            if(!in_array($this->request->getParam('action'), self::DEFAULT_LAYOUT))
                $this->viewBuilder()->setLayout('contributors');
        }
        // we must RETURN the Response object here for parent class redirects to take effect
        return parent::beforeFilter($event);
    }

    public function beforeRender(EventInterface $event) {
        parent::beforeRender($event);
    }


    /**
     * @param string|null $mode
     * @return \Cake\Http\Response|void|null
     *
     * Set parameter $mode = 'identity' to bypass redirection loop and connect a present
     * but unknown external identity to an already existing account.
     */
    public function signIn($template = null)
    {
        if($this->_checkExternalIdentity()) {
            return $this->redirect('/users/unknown_identity');
        }

        // the user is logged in by session, idp or form
        $result = $this->Authentication->getResult();
        if($result->isValid()) {
            $user = $this->Authentication->getIdentity()->getOriginalData();

            $authentication = $this->Authentication->getAuthenticationService();
            if($authentication->identifiers()->get('Password')->needsPasswordRehash())
                $user->password = $this->request->getData('password');

            $user->last_login = date('Y-m-d H:i:s');
            $this->Users->save($user);  // Rehash happens on save.

            $target = $this->Authentication->getLoginRedirect() ?? '/users/dashboard';
            return $this->redirect($target);
        }

        if($this->request->is('post') && !$result->isValid()) {
            // evaluate the result here, AppResult might indicate banned user
            $this->Flash->error('Invalid username or password.');
        }
        if($template === 'connect_identity') {
            $this->viewBuilder()->setTemplate($template);
        }else{
            // render the login form, providing federated authentication
            $this->_setIdentityProviderTarget();
        }
    }



    public function logout()
    {
        $this->Authentication->logout();
        return $this->redirect(['controller' => 'Users','action' => 'signIn']);
    }



    protected function _setIdentityProviderTarget() {
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
    }



    protected function _checkExternalIdentity() : array
    {
        $result = $this->Authentication->getResult();
        if($result->getStatus() === AppResult::NEW_EXTERNAL_IDENTITY) {
            // return the external identity
            return $result->getData();
        }else{
            $service = $this->Authentication->getAuthenticationService();
            $authenticator = $service->envAuthenticator;
            if($data = $authenticator->getData($this->getRequest())) {
                return $data;
            }
            return [];
        }
    }



    public function unknownIdentity()
    {
        $identity = $this->_checkExternalIdentity();
        if(empty($identity))
            return $this->redirect('/users/sign-in');

        $session = $this->request->getSession();
        if($session->check('ignoreIdentity'))
            return $this->redirect('/users/dashboard');

        $this->set(compact('identity'));
    }



    public function connectIdentity()
    {
        $identity = $this->_checkExternalIdentity();
        if(empty($identity))
            return $this->redirect('/users/sign-in');
        // connect account with identity
        $result = $this->Authentication->getResult();
        if($result->isValid()) {
            // save the identity shib_eppn to the user
            $user = $this->Authentication->getIdentity();
            $user->shib_eppn = $identity['shib_eppn'];
            $this->Users->save($user);
            $this->_refreshAuthSession();
            $this->Flash->set('Identity connected. Now you can login using your institutional identity provider.');
            return $this->redirect('/users/dashboard');
        }
        // point the form to the regular login action
        // the additional parameter will render the connect_identity view in case of auth errors
        $this->set(compact('identity'));
    }



    public function registerIdentity()
    {
        $identity = $this->_checkExternalIdentity();
        if(empty($identity))
            return $this->redirect('/users/sign-in');
        $result = $this->Authentication->getResult();
        if($result->isValid()) {
            $this->Flash->set('Please log out before registering a new identity.');
            return $this->redirect('/users/dashboard');
        }

        $data['first_name'] = $identity['first_name'] ?? null;
        $data['last_name'] = $identity['last_name'] ?? null;
        $data['email'] = $identity['email'] ?? null;
        if(empty($data['email']) AND preg_match("/^[^@]+@[^@]+\.[a-z]{2,6}$/i", $identity['shib_eppn']))
            $data['email'] = $identity['shib_eppn'];

        // validation is on, show errors!
        $user = $this->Users->newEntity($data, ['validate' => 'create']);
        $user->approved = true;
        $user->email_verified = true;
        $user->shib_eppn = $identity['shib_eppn'];
        if($this->request->is('post')) {
            // patching the entity, validation and other stuff
            $this->Users->patchEntity($user, $this->request->getData());
            if(!$user->hasErrors(false)) {
                if(empty($user->institution_id)) {
                    $user->approved = false;
                    $this->Users->notifyAdmins();
                }else {
                    try {
                        $this->getMailer('User')->send('welcome', [$user]);
                    } catch (Exception $exception) {}
                }

                $this->Users->save($user);

                $session = $this->request->getSession();
                $session->write('Auth', $user);
                return $this->redirect([
                    'controller' => 'users',
                    'action' => 'registration_success'
                ]);
            }else{
                $this->Flash->set('We have errors! Please check the form and amend the indicated fields');
            }
        }

        $this->_setOptions();
        $this->set(compact('identity','user'));
    }


    public function ignoreIdentity() {
        $session = $this->request->getSession();
        $session->write('ignoreIdentity', true);
        $this->redirect('/users/dashboard');
    }


    public function dashboard()
    {
        $user = $this->Authentication->getIdentity();
        $this->Authorization->authorize($user, 'accessDashboard');

        $identity = $this->_checkExternalIdentity();

        $this->set('title_for_layout', 'DHCR Dashboard');
        $this->set(compact('user', 'identity'));
    }



    public function register()
    {
        $user = $this->Users->newEmptyEntity();
        if($this->request->is('post')) {
            if(!$this->_checkCaptcha()) {
                $this->Flash->set('The CAPTCHA test failed, please try again.');
                $this->redirect(['controller' => 'users', 'action' => 'register']);
            }

            // patching the entity, validation and other stuff
            $user = $this->Users->newEntity($this->request->getData(), ['validate' => 'create']);
            $user->email_token = $this->Users->generateToken('email_token');
            $user->new_email = $user->email;
            $user->approval_token = $this->Users->generateToken('approval_token');
            $user->approval_token_expires = $this->Users->getLongTokenExpiry();

            if(!$user->hasErrors(false)) {
                $this->Users->save($user);
                try {
                    $this->getMailer('User')->send('confirmationMail', [$user]);
                }catch(Exception $exception) {}

                $session = $this->request->getSession();
                $session->write('Auth', $user);

                return $this->redirect([
                    'controller' => 'users',
                    'action' => 'registration_success'
                ]);
            }else{
                $this->Flash->set('We have errors! Please check the form and amend the indicated fields');
            }
        }
        // render form
        $this->_setOptions();
        $this->set('user', $user);
    }


    public function registrationSuccess() {
        $user = $this->Authentication->getIdentity();
        if($user->can('accessDashboard', $user))
            return $this->redirect('/users/dashboard');

        $user = $this->Authentication->getIdentity();
        $this->set('user', $user);
    }


    public function verifyMail() {
        $user = $this->Authentication->getIdentity();
        $success = false;
        if($this->request->is('post')) {
            $this->Users->patchEntity($user, $this->request->getData(), [
                'fields' => ['new_email']
            ]);
            if(!$user->getErrors()) {
                $this->Users->save($user);
                $success = true;
            }else{
                $this->set('user', $user);
            }
        }

        if(!empty($user->new_email)) {
            try {
                $this->getMailer('User')->send('confirmationMail', [$user]);
            }catch(Exception $exception) {}
            $success = true;
        }

        if($success) {
            $this->Flash->set('Confirmation mail has been sent, check your inbox to complete verification.');
            $this->redirect('/users/dashboard');
        }
    }


    public function confirmMail(string $token = null) {
        if($token) {
            $user = $this->Users->find()->where(['email_token' => $token])->contain([])->first();
            if($user) {
                // handle new users
                if(!$user->email_verified)
                    $this->Users->notifyAdmins($user);

                $user->email = $user->new_email;
                $user->new_email = null;
                $user->email_token = null;
                $user->email_verified = true;
                $user = $this->Users->save($user);

                $this->Authentication->setIdentity($user);

                $this->Flash->set('Your email address has been verified');
                return $this->redirect('/users/dashboard');
            }
        }
        $this->redirect('/');
    }


    public function requestNewPassword($email = null) {
        $user = $this->Authentication->getIdentity();
        if($user) $email = $user->email;
        if(!empty($this->request->data[$this->modelClass]['email'])) {
            $email = $this->request->data[$this->modelClass]['email'];
        }
        if(!empty($email)) {
            $user = $this->{$this->modelClass}->requestNewPassword($email);
            if($user AND !empty($user[$this->modelClass]['password_token'])) {
                $result = $this->_sendUserManagementMail(array(
                    'template' => 'Users.password_reset',
                    'subject' => 'Password Reset',
                    'email' => $email,
                    'data' => $user
                ));
                if($result) {
                    if(!$this->Auth->user()) $this->Auth->flash('We have sent an email with further instructions to ' . $email . '.');
                    else $this->Flash->set('We have sent an email with further instructions to ' . $email . '.');
                }else{
                    $this->Flash->set('Error while sending the password reset email.');
                }
                if($this->Auth->user()) $this->redirect(array(
                    'plugin' => null,
                    'controller' => 'users',
                    'action' => 'dashboard'
                ));
                $this->redirect(array(
                    'plugin' => null,
                    'controller' => 'users',
                    'action' => 'login'
                ));
            }
        }
    }


    public function resetPassword($token = null) {
        if(!empty($token)) {
            $user = $this->{$this->modelClass}->checkPasswordToken($token);
            if(empty($user)) {
                $this->Auth->flash('Invalid password reset token, try again.');
                $this->redirect(array(
                    'plugin' => null,
                    'controller' => 'users',
                    'action' => 'request_new_password'
                ));
            }
            elseif($user[$this->modelClass]['active'] == 0) {
                $msg = 'Your account has been locked, you cannot reset your password.';
                if(Configure::read('Users.adminConfirmRegistration')) {
                    $msg = 'Your account has not been activated by an administrator, yet.';
                }
                $this->Auth->flash($msg);
                $this->redirect('/');
            }
            $id = (!empty($user[$this->modelClass][$this->{$this->modelClass}->primaryKey]))
                ? $user[$this->modelClass][$this->{$this->modelClass}->primaryKey]
                : null;
            if(!empty($this->request->data[$this->modelClass]) AND !empty($id)) {
                $data = array();
                $data[$this->modelClass][$this->{$this->modelClass}->primaryKey] = $id;
                $data[$this->modelClass]['new_password'] = $this->request->data[$this->modelClass]['new_password'];
                if($this->{$this->modelClass}->resetPassword($data)) {
                    $this->Auth->flash('Password changed, please login with your new password.');
                    $this->Auth->logout();
                    $this->redirect($this->Auth->loginAction);
                }
            }

            $this->set('token', $token);
        }
    }


    public function approve($key = null) {
        if(empty($key)) return $this->redirect('/users/dashboard');

        $redirect = false;
        $admin = $this->Authentication->getIdentity();
        if($admin AND $admin->is_admin AND ctype_digit($key)) {
            // we are accessing the method using the admin dashboard, using user ids as the key
            $user = $this->Users->get($key);
            if(!$user) {
                $this->Flash->set('An account with id '.$key.' could not be found.');
                $redirect = true;
            }
        }else{
            // admins retrieve a link in their notification email to approve directly
            $user = $this->Users->find()->contain([])->where([
                'Users.approval_token' => $key,
                'approved' => 0
            ])->first();
            if(!$user) {
                $this->Flash->set('The requested account has already been accepted.');
                $redirect = true;
            }
        }

        if($user) {
            if($user = $this->Users->approve($key)) {
                $this->getMailer('User')->send('welcome', [$user]);
                $this->Flash->set('The account has been approved successfully.');
                $redirect = true;
            }else{
                // we have missing data or errors - set user to render approval form
                $this->set('user', $user);
                if($admin AND $admin->is_admin)
                    $this->Flash->set('Approval failed, please amend the account.');
                else
                    $this->Flash->set('Approval not possible, please log in to amend the account.');
            }
        }else{
            $redirect = true;
        }

        if($redirect) {
            if($admin) return $this->redirect('/users/dashboard');
            return $this->redirect('/');
        }
        // TODO: create approval view/form/process
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
