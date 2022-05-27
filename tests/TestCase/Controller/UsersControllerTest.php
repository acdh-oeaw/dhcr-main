<?php

namespace App\Test\TestCase\Controller;

use App\Controller\UsersController;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\UsersController Test Case
 *
 * @uses \App\Controller\UsersController
 */
class UsersControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Users',
        'app.UserRoles',
        'app.Countries',
        'app.Institutions',
        'app.Courses',
    ];

    public $controller;

    public $Users;


    public function setUp(): void
    {
        parent::setUp();
        $this->controller = new UsersController();
        $this->Users = TableRegistry::getTableLocator()->get('Users');
    }


    protected function _login($userId)
    {
        $user = $this->Users->get($userId);
        $this->session(['Auth' => $user]);
        return $user;
    }

    protected function _logout()
    {
        $this->session(['Auth' => null]);
        $this->get('/users/logout');
    }

    protected function _setExternalIdentity()
    {
        $this->configRequest([
            'environment' => [
                'HTTP_EPPN' => 'shib_eppn',
                'HTTP_GIVENNAME' => 'first_name',
                'HTTP_SN' => 'last_name',
                'HTTP_EMAIL' => 'email'
            ]
        ]);
    }

    public function testRegister()
    {
        $this->get('/users/register');
        $this->assertResponseOk();
    }

    public function testVerifyMail()
    {
        $this->get('/users/verify_mail');
        $this->assertRedirect('/');

        $this->enableRetainFlashMessages();
        $this->_login(3);   // not verified, new user, hitting the 'send' button
        $this->get('/users/verify_mail');
        $this->assertRedirect('/dashboard/index');
        $this->assertFlashMessage('Confirmation mail has been sent, check your inbox to complete verification.');

        $user = $this->Users->get(3);
        $this->get('/users/verify_mail/' . $user->email_token);
        $user = $this->Users->get(3);
        $this->assertTrue($user->email_verified);
    }

    public function testResetPassword()
    {
        $this->get('/users/reset_password');
        $this->assertResponseContains('Please enter your email address');

        $this->enableCsrfToken();
        $this->enableRetainFlashMessages();
        $this->post('/users/reset_password', [
            'email' => 'banned@example.com'
        ]);
        $this->assertFlashMessage('This account has been disabled.');
        $this->assertRedirect('/users/sign-in');

        //$this->enableCsrfToken();
        $this->post('/users/reset_password', [
            'email' => 'test@example.com'
        ]);
        $this->assertResponseContains('Please check your email inbox');
        $user = $this->_login(1);
        $this->assertNotEquals('bbbbb', $user->password_token);

        $this->get('/users/reset_password/' . $user->password_token);
        $this->assertResponseContains('Now set a new password');

        $this->post('/users/reset_password/' . $user->password_token, [
            'password' => 'aaaaaa'
        ]);
        $this->assertFlashMessage('Password has been set successfully, now log in using your new password.');
        $this->assertRedirect('/users/sign-in');

        $this->post('/users/sign-in', [
            'email' => 'test@example.com',
            'password' => 'aaaaaa'
        ]);
        $this->assertRedirect('/dashboard/index');
    }

    public function testSignIn()
    {
        $this->get('/users/sign-in');
        $this->assertResponseOk();
    }

    public function testSignInDisabled()
    {
        $this->enableRetainFlashMessages();
        $this->enableCsrfToken();
        $this->post('/users/sign-in', [
            'email' => 'banned@example.com',
            'password' => '*****'
        ]); // user 2
        $this->assertNoRedirect();
        $this->assertFlashMessage('Invalid username or password.');
    }

    public function testSignInForm()
    {
        $this->enableCsrfToken();
        $this->post('/users/sign-in', [
            'email' => 'test@example.com',
            'password' => '*****'
            // corresponding hash: $user->password = '$2y$10$W883gRwZgOMrbBeN6nN6qexdgj2obAvP1vy04.ucooJHXO2azvj4m';
        ]); // user 1
        $this->assertRedirect('/dashboard/index');
    }

    public function testSignInLoggedIn()
    {
        $this->_login(1);
        $this->get('/users/sign-in');
        $this->assertRedirect('/dashboard/index');
        $this->_logout();
    }

    public function testSignInExternalIdentity()
    {
        $this->_setExternalIdentity();
        $this->get('/users/sign-in');
        $this->assertRedirect('/users/unknown_identity');
    }

    public function testUnknownIdentity()
    {
        $this->get('/users/unknown_identity');
        $this->assertRedirect('/users/sign-in');

        $this->_login(1);
        $this->get('/users/unknown_identity');
        $this->assertRedirect('/users/sign-in');    // redirection to dashboard follows
        $this->_setExternalIdentity();
        // either logged in or not, or already connected to some other identity
        $this->get('/users/unknown_identity');
        $this->assertResponseOk();
    }

    public function testConnectIdentity()
    {
        $this->get('/users/connect_identity');
        $this->assertRedirect('/users/sign-in');

        $this->_setExternalIdentity();
        $this->get('/users/connect_identity');
        $this->assertResponseContains('Connect your locally existing account');

        $this->_setExternalIdentity();
        $this->enableCsrfToken();
        $this->post('/users/sign-in?redirect=/users/connect_identity', [
            'email' => 'test5@example.com',
            'password' => '*****'
        ]);
        $this->assertRedirect('/users/connect_identity');

        $this->_login(1);
        $this->_setExternalIdentity();
        $this->get('/users/connect_identity');
        $user = $this->getSession()->read('Auth');
        $this->assertEquals('shib_eppn', $user['shib_eppn']);
        $this->assertRedirect('/dashboard/index');
    }

    public function testRegisterIdentity()
    {
        $this->get('/users/register_identity');
        $this->assertRedirect('/users/sign-in');

        $this->_setExternalIdentity();
        $this->get('/users/register_identity');
        $this->assertResponseContains('Account completion');

        $this->_login(1);
        $this->enableRetainFlashMessages();
        $this->get('/users/register_identity');
        $this->assertRedirect('/dashboard/index');
        $this->assertFlashMessage('Please log out before registering a new identity.');
        $this->_logout();
    }

    public function testDashboardLoggedOut()
    {
        $this->get('/dashboard/index');
        $this->assertHeaderContains('location', '/users/sign-in?redirect=%2Fdashboard%2Findex');
    }

    public function testDashboard()
    {
        $this->_login(1);
        $this->get('/dashboard/index');
        $this->assertResponseOk();
    }

    public function testSignInNotMailVerified()
    {
        $this->_login(3);   // not email verified
        $this->get('/dashboard/index');
        $this->assertRedirect('/users/registration_success');
    }

    public function testRegistrationSuccess()
    {
        $this->_login(3);   // not email verified
        $this->get('/users/registration_success');
        $this->assertResponseContains('Please check your inbox');
    }

    public function testSignInNotApproved()
    {
        $user = $this->_login(4);   // not approved, email verified
        $this->get('/dashboard/index');
        $this->assertRedirect('/users/registration_success');
        $this->get('/users/registration_success');
        $this->assertResponseContains('Your email address has been verified');
        $this->assertResponseContains('An admin has been notified');
    }

    /**
     * Test index method
     *
     * @return void
     */
    public function testIndex()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test view method
     *
     * @return void
     */
    public function testView()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test add method
     *
     * @return void
     */
    public function testAdd()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test edit method
     *
     * @return void
     */
    public function testEdit()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test delete method
     *
     * @return void
     */
    public function testDelete()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
