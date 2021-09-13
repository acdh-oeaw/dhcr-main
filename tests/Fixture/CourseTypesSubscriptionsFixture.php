<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CourseTypesSubscriptionsFixture
 */
class CourseTypesSubscriptionsFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'subscription_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'course_type_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'FK_course_types_subscriptions_subscriptions' => ['type' => 'index', 'columns' => ['subscription_id'], 'length' => []],
            'FK_course_types_subscriptions_course_types' => ['type' => 'index', 'columns' => ['course_type_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'FK_course_types_subscriptions_course_types' => ['type' => 'foreign', 'columns' => ['course_type_id'], 'references' => ['course_types', 'id'], 'update' => 'noAction', 'delete' => 'cascade', 'length' => []],
            'FK_course_types_subscriptions_subscriptions' => ['type' => 'foreign', 'columns' => ['subscription_id'], 'references' => ['subscriptions', 'id'], 'update' => 'noAction', 'delete' => 'cascade', 'length' => []],
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
                'subscription_id' => 1,
                'course_type_id' => 1,
            ],
        ];
        parent::init();
    }
}
