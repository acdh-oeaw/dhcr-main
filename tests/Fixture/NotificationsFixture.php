<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * NotificationsFixture
 */
class NotificationsFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'course_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'subscription_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'FK_notifications_courses' => ['type' => 'index', 'columns' => ['course_id'], 'length' => []],
            'FK_notifications_subscriptions' => ['type' => 'index', 'columns' => ['subscription_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'FK_notifications_courses' => ['type' => 'foreign', 'columns' => ['course_id'], 'references' => ['courses', 'id'], 'update' => 'noAction', 'delete' => 'cascade', 'length' => []],
            'FK_notifications_subscriptions' => ['type' => 'foreign', 'columns' => ['subscription_id'], 'references' => ['subscriptions', 'id'], 'update' => 'noAction', 'delete' => 'cascade', 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'utf8_general_ci'
        ],
    ];
    // @codingStandardsIgnoreEnd
    /**
     * Init method
     *
     * @return void
     */
    public function init() : void
    {
        $this->records = [
            [
                'id' => 1,
                'course_id' => 1,
                'subscription_id' => 1,
            ],
            [
                'id' => 2,
                'course_id' => 1,
                'subscription_id' => 3,
            ],
        ];
        parent::init();
    }
}
