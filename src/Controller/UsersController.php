<?php
namespace App\Controller;

use App\Authenticator\AppResult;
use Cake\Core\Exception\Exception;
use Cake\Event\EventInterface;
use Cake\Mailer\MailerAwareTrait;
use phpDocumentor\Reflection\Types\Mixed_;

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
        'register',
        'confirmMail',
        'unknownIdentity',
        'connectIdentity',
        'registerIdentity',
        'whichTerms'
    ];

    public const SKIP_AUTHORIZATION = [
        'signIn',
        'logout',
        'register',
        'unknownIdentity',
        'connectIdentity',
        'registerIdentity',
        'whichTerms'
    ];

    public const DEFAULT_LAYOUT = [
        'signIn',
        'register',
        'registrationSuccess',
        'resetpassword',
        'setpassword',
        'unknownIdentity',
        'connectIdentity',
        'registerIdentity',
        'whichTerms'
    ];

    public function initialize(): void {
        parent::initialize();
        $this->Authentication->allowUnauthenticated(self::ALLOW_UNAUTHENTICATED);

        if(in_array($this->request->getParam('action'), self::SKIP_AUTHORIZATION)) {
            $this->Authorization->skipAuthorization();
        }
    }

    public function beforeFilter(EventInterface $event) {
        parent::beforeFilter($event);

        $result = $this->Authentication->getResult();
        if($result->isValid() AND !$this->_checkExternalIdentity()) {
            // renew Auth session on pageload due to possible status or profile changes
            $user = $this->Authentication->getIdentity();
            $user = $this->Users->get($user->id);
            // Set the authorization service to the identity object:
            // this is configured on Application::middleware (identityDecorator),
            // but needs to be done again as we re-set the identity.
            $user->setAuthorization($this->request->getAttribute('authorization'));
            $this->Authentication->setIdentity($user);

            // send newly registered users to the approval status page
            $action = $this->request->getParam('action');
            if((!$user->email_verified OR !$user->approved)
            AND $action != 'registrationSuccess')
                return $this->redirect('/users/registration_success');

            // set the contributor layout for logged in users and certain actions only
            if(!in_array($this->request->getParam('action'), self::DEFAULT_LAYOUT))
                $this->viewBuilder()->setLayout('contributors');
        }
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
    public function signIn()
    {
        if($this->_checkExternalIdentity()) {
            return $this->redirect('/users/unknown_identity');
        }
        // the user is logged in by session, idp or form
        $result = $this->Authentication->getResult();
        if($result->isValid()) {
            $user = $this->Authentication->getIdentity()->getOriginalData();
            if(!$user->approved || !$user->email_verified) {
                return $this->redirect('/users/registration_success');
            }

            $authentication = $this->Authentication->getAuthenticationService();
            if ($authentication->identifiers()->get('Password')->needsPasswordRehash()) {
                $user->password = $this->request->getData('password');
            }
            $user->last_login = date('Y-m-d H:i:s');
            $this->Users->save($user);  // Rehash happens on save.

            $target = $this->Authentication->getLoginRedirect() ?? '/users/dashboard';
            return $this->redirect($target);
        }

        if($this->request->is('post') && !$result->isValid()) {
            $this->Flash->error('Invalid username or password');
        }

        // render the login form, providing federated authentication
        $this->_setIdentityProviderTarget();
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
            return [];
        }
    }



    public function unknownIdentity()
    {
        $identity = $this->_checkExternalIdentity();
        if(empty($identity))
            return $this->redirect('/users/sign-in');

        $this->set(compact('identity'));
    }



    public function connectIdentity()
    {
        $identity = $this->_checkExternalIdentity();
        if(empty($identity))
            return $this->redirect('/users/sign-in');

        // connect account with identity
        $identity = $result->getData();
        $this->set('identity', $identity);
    }



    public function registerIdentity()
    {
        $identity = $this->_checkExternalIdentity();
        if(empty($identity))
            return $this->redirect('/users/sign-in');

        $identity = $result->getData();

        $this->set('identity', $identity);
    }



    public function dashboard()
    {
        $user = $this->getRequest()->getAttribute('identity');

        $this->Authorization->authorize($user, 'accessDashboard');

        $this->set('title_for_layout', 'DHCR Dashboard');
        $this->set(compact('user'));
    }



    public function register()
    {
        $user = $this->Users->newEmptyEntity();
        if ($this->request->is('post')) {
            if(!$this->_checkCaptcha()) {
                $this->Flash->set('The CAPTCHA test failed, please try again.');
                $this->redirect(['controller' => 'users', 'action' => 'register']);
            }

            // patching the entity, validation and other stuff
            $user = $this->Users->register($this->request->getData());

            if($user AND !$user->hasErrors(false)) {
                try {
                    $this->getMailer('User')->send('emailConfirmation', [$user]);
                }catch(Exception $exception) {

                }

                $session = $this->request->getSession();
                $session->write('Auth', $user);

                return $this->redirect([
                    'controller' => 'users',
                    'action' => 'registration_success'
                ]);
            }
            elseif(!$user) {
                $this->Flash->set('The record could not be saved.
                Please try again and contact the administration team, if the problem persists.');
            }
            elseif($user->hasErrors(false)) {
                $this->Flash->set('We have errors! Please check the form and amend the indicated fields');
            }
        }
        // render form
        $this->_setOptions();
        $this->set('user', $user);
    }


    public function registrationSuccess() {
        $user = $this->Authentication->getIdentity();
        //if($user->email_verified && $user->approved)
        if($this->Authorization->can('accessDashboard'))
            return $this->redirect('/users/dashboard');

        $user = $this->Authentication->getIdentity();
        $this->set('user', $user);
    }


    public function sendConfirmationMail() {
        $user = $this->Authentication->getIdentity();
        if(!empty($user->new_email)) {
            $user->email_token_expires = $this->Users->getShortTokenExpiry();
            $this->Users->save($user);
            try {
                $this->getMailer('User')->send('emailConfirmation', [$user]);
            }catch(Exception $exception) {}
            $this->Flash->set('Confirmation mail has been sent.');
        }
        $this->redirect('/users/dashboard');
    }


    public function confirmMail(string $token = null) {
        if($token) {
            $user = $this->Users->find()->where(['email_token' => $token])->contain([])->first();
            if($user) {
                if(!$user->email_verified) {
                    $user->approval_token_expires = $this->Users->getLongTokenExpiry();
                    // TODO: route this to a single team account
                    $admins = $this->Users->getModerators(null, true);
                    try {
                        foreach($admins as $admin)
                            $this->getMailer('User')->send('notifyAdmin', [$user, $admin->email]);
                    }catch(Exception $exception) {}
                }

                $user->email = $user->new_email;
                $user->email_token = null;
                $user->email_verified = true;
                $this->Users->save($user);

                $this->Authentication->setIdentity($user);

                $this->Flash->set('Your email address has been verified');
                return $this->redirect('/users/dashboard');
            }
        }
        $this->redirect('/');
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
