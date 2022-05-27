<?php

declare(strict_types=1);

namespace App\Test\TestCase\Mailer;

use App\Mailer\SubscriptionMailer;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Mailer\SubscriptionMailer Test Case
 */
class SubscriptionMailerTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Mailer\SubscriptionMailer
     */
    protected $SubscriptionMailer;

    public $fixtures = [
        'app.Subscriptions',
        'app.Courses',
        'app.Disciplines',
        'app.TadirahObjects',
        'app.TadirahTechniques',
        'app.Languages',
        'app.Countries',
        'app.Cities',
        'app.Institutions',
        'app.CourseTypes',
        'app.Notifications',
        'app.DisciplinesSubscriptions',
        'app.SubscriptionsTadirahObjects',
        'app.SubscriptionsTadirahTechniques',
        'app.LanguagesSubscriptions',
        'app.CountriesSubscriptions',
        'app.CourseTypesSubscriptions',
        'app.CoursesDisciplines'
    ];

    public function setUp(): void
    {
        parent::setUp();
        $this->SubscriptionMailer = new SubscriptionMailer();
    }

    protected function _getSubscription($id)
    {
        $table = TableRegistry::getTableLocator()->get('Subscriptions');
        $options = ['contain' => $table::$containments];
        $subscription = $table->get($id, $options);
        // this method draws in the DEBUG_MAIL_TO variable, if present
        $subscription->email = $this->SubscriptionMailer->preventMailbombing($subscription->email);
        return $subscription;
    }

    protected function _getCourses($subscription)
    {
        if (!$subscription->confirmed) return [];
        $table = TableRegistry::getTableLocator()->get('Courses');
        return $table->getSubscriptionCourses($subscription);
    }



    /**
     * Test access method
     *
     * @return void
     * @uses \App\Mailer\SubscriptionMailer::access()
     */
    public function testAccess(): void
    {
        $subscription = $this->_getSubscription(1);
        $this->SubscriptionMailer->send('access', [$subscription]);
        $this->expectNotToPerformAssertions();
    }

    /**
     * Test confirm method
     *
     * @return void
     * @uses \App\Mailer\SubscriptionMailer::confirm()
     */
    public function testConfirm(): void
    {
        $subscription = $this->_getSubscription(2);
        $this->SubscriptionMailer->send('confirm', [$subscription]);
        $this->expectNotToPerformAssertions();
    }

    /**
     * Test notification method
     *
     * @return void
     * @uses \App\Mailer\SubscriptionMailer::notification()
     */
    public function testNotification(): void
    {
        $subscription = $this->_getSubscription(3);
        $courses = $this->_getCourses($subscription);
        $this->SubscriptionMailer->send('notification', [$subscription, $courses]);
        $this->expectNotToPerformAssertions();
    }
}
