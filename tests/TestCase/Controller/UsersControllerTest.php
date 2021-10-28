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

    public function testGetRegister()
    {
        $this->get('/users/register');
        $this->assertResponseOk();
    }

    public function testGetSignIn() {
        $this->get('/users/sign-in');
        $this->assertResponseOk();
    }

    public function testGetSignInDisabled() {
        $this->enableRetainFlashMessages();
        $this->enableCsrfToken();
        $this->post('/users/sign-in', [
            'email' => 'banned',
            'password' => '*****'
        ]); // user 2
        $this->assertNoRedirect();
        $this->assertFlashMessage('Invalid username or password.');
    }

    public function testGetSignInLoggedIn() {
        $this->_login(1);
        $this->get('/users/sign-in');
        $this->assertRedirect('/users/dashboard');
        $this->_logout();
    }

    public function testGetSignInExternalIdentity() {
        $this->_setExternalIdentity();
        $this->get('/users/sign-in');
        $this->assertRedirect('/users/unknown_identity');
    }

    public function testGetDashboardLoggedOut() {
        $this->get('/users/dashboard');
        $this->assertHeaderContains('location', '/users/sign-in?redirect=%2Fusers%2Fdashboard');
    }

    public function testGetDashboard() {
        $this->_login(1);
        $this->get('/users/dashboard');
        $this->assertResponseOk();
    }

    public function testGetSignInNotMailVerified() {
        $user = $this->_login(3);   // not email verified
        $this->get('/users/dashboard');
        $this->assertRedirect('/users/registration_success');
    }

    public function testGetSignInNotApproved() {
        $user = $this->_login(4);   // not approved
        $this->get('/users/dashboard');
        $this->assertRedirect('/users/registration_success');
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
