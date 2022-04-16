<?php

declare(strict_types=1);

namespace App\Test\TestCase\Mailer;

use App\Mailer\UserMailer;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Mailer\UserMailer Test Case
 */
class UserMailerTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Mailer\UserMailer
     */
    protected $UserMailer;

    public $fixtures = [
        'app.Users'
    ];

    public function setUp(): void
    {
        parent::setUp();
        $this->UserMailer = new UserMailer();
    }

    protected function _getUser()
    {
        $users = TableRegistry::getTableLocator()->get('Users');
        $user = $users->get(1);
        // this method draws in the DEBUG_MAIL_TO variable, if present
        $user->email = $this->UserMailer->preventMailbombing($user->email);
        $user->new_email = $this->UserMailer->preventMailbombing($user->new_email);
        // we are not using EmailTrait for these tests, because we want to send actual emails for debugging!
        return $user;
    }

    /**
     * Test welcome method
     *
     * @return void
     * @uses \App\Mailer\UserMailer::welcome()
     */
    public function testWelcome(): void
    {
        $user = $this->_getUser();
        $this->UserMailer->send('welcome', [$user]);
        $this->expectNotToPerformAssertions();
    }

    /**
     * Test emailConfirmation method
     *
     * @return void
     * @uses \App\Mailer\UserMailer::emailConfirmation()
     */
    public function testConfirmationMail(): void
    {
        $user = $this->_getUser();
        $this->UserMailer->send('confirmationMail', [$user]);
        $this->expectNotToPerformAssertions();
    }

    /**
     * Test resetPassword method
     *
     * @return void
     * @uses \App\Mailer\UserMailer::resetPassword()
     */
    public function testResetPassword(): void
    {
        $user = $this->_getUser();
        $this->UserMailer->send('resetPassword', [$user]);
        $this->expectNotToPerformAssertions();
    }

    /**
     * Test notifyAdmin method
     *
     * @return void
     * @uses \App\Mailer\UserMailer::notifyAdmin()
     */
    public function testNotifyAdmin(): void
    {
        $user = $this->_getUser();
        $admin = $this->UserMailer->preventMailbombing('admin@example.com');
        $this->UserMailer->send('notifyAdmin', [$user, $admin]);
        $this->expectNotToPerformAssertions();
    }

    public function testContactForm(): void
    {
        $admin = $this->UserMailer->preventMailbombing('admin@example.com');
        $data = [
            'email' => 'test@example.com',
            'country_id' => 1,
            'message' => 'This is a testmessage',
            'first_name' => '',
            'last_name' => ''
        ];
        $this->UserMailer->send('contactForm', [$data, $admin]);
        $this->expectNotToPerformAssertions();
    }
}
