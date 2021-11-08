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


    public function setUp(): void {
        parent::setUp();
        $this->controller = new UsersController();
    }


    protected function _login($userId) {
        $users = TableRegistry::getTableLocator()->get('Users');
        $user = $users->get($userId);
        $this->session(['Auth' => $user]);
        return $user;
    }

    protected function _logout() {
        $this->session(['Auth' => null]);
        $this->get('/users/logout');
    }

    protected function _setExternalIdentity() {
        $this->configRequest([
            'environment' => [
                'HTTP_EPPN' => 'shib_eppn',
                'HTTP_GIVENNAME' => 'first_name',
                'HTTP_SN' => 'last_name',
                'HTTP_EMAIL' => 'email'
            ]
        ]);
    }

    public function testRegister() {
        $this->get('/users/register');
        $this->assertResponseOk();
    }

    public function testVerifyMail() {

    }

    public function testConfirmMail() {
        $user = $this->Users->get(3);
        $this->get('/users/confirm_mail/'.$user->email_token);
        $user = $this->Users->get(3);
        $this->assertTrue($user->email_verified);
    }

    public function testRequestPasswordReset() {

    }

    public function testResetPassword() {

    }

    public function testSignIn() {
        $this->get('/users/sign-in');
        $this->assertResponseOk();
    }

    public function testSignInDisabled() {
        $this->enableRetainFlashMessages();
        $this->enableCsrfToken();
        $this->post('/users/sign-in', [
            'email' => 'banned@example.com',
            'password' => '*****'
        ]); // user 2
        $this->assertNoRedirect();
        $this->assertFlashMessage('Invalid username or password.');
    }

    public function testSignInForm() {
        $this->enableCsrfToken();
        $this->post('/users/sign-in', [
            'email' => 'test@example.com',
            'password' => '*****'
        ]); // user 1
        $this->assertRedirect('/users/dashboard');
    }

    public function testSignInLoggedIn() {
        $this->_login(1);
        $this->get('/users/sign-in');
        $this->assertRedirect('/users/dashboard');
        $this->_logout();
    }

    public function testSignInExternalIdentity() {
        $this->_setExternalIdentity();
        $this->get('/users/sign-in');
        $this->assertRedirect('/users/unknown_identity');
    }

    public function testUnknownIdentity() {
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

    public function testConnectIdentity() {
        $this->get('/users/connect_identity');
        $this->assertRedirect('/users/sign-in');

        $this->_setExternalIdentity();
        $this->get('/users/connect_identity');
        $this->assertResponseContains('Connect your locally existing account');

        $this->_login(1);
        $this->_setExternalIdentity();
        $this->get('/users/connect_identity');
        $user = $this->getSession()->read('Auth');
        $this->assertEquals('shib_eppn', $user['shib_eppn']);
        $this->assertRedirect('/users/dashboard');
    }

    public function testRegisterIdentity() {
        $this->get('/users/register_identity');
        $this->assertRedirect('/users/sign-in');

        $this->_setExternalIdentity();
        $this->get('/users/register_identity');
        $this->assertResponseContains('Account completion');

        $this->_login(1);
        $this->enableRetainFlashMessages();
        $this->get('/users/register_identity');
        $this->assertRedirect('/users/dashboard');
        $this->assertFlashMessage('Please log out before registering a new identity.');
        $this->_logout();


    }

    public function testDashboardLoggedOut() {
        $this->get('/users/dashboard');
        $this->assertHeaderContains('location', '/users/sign-in?redirect=%2Fusers%2Fdashboard');
    }

    public function testDashboard() {
        $this->_login(1);
        $this->get('/users/dashboard');
        $this->assertResponseOk();
    }

    public function testSignInNotMailVerified() {
        $this->_login(3);   // not email verified
        $this->get('/users/dashboard');
        $this->assertRedirect('/users/registration_success');
        $this->get('/users/registration_success');
        $this->assertResponseContains('Please check your inbox');
    }

    public function testSignInNotApproved() {
        $user = $this->_login(4);   // not approved, email verified
        $this->get('/users/dashboard');
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
