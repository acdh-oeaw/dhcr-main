<?php

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * SubscriptionsTadirahObjectsFixture
 */
class SubscriptionsTadirahObjectsFixture extends TestFixture
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
        'tadirah_object_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'FK_subscriptions_tadirah_objects_subscriptions' => ['type' => 'index', 'columns' => ['subscription_id'], 'length' => []],
            'FK_subscriptions_tadirah_objects_tadirah_objects' => ['type' => 'index', 'columns' => ['tadirah_object_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'FK_subscriptions_tadirah_objects_subscriptions' => ['type' => 'foreign', 'columns' => ['subscription_id'], 'references' => ['subscriptions', 'id'], 'update' => 'noAction', 'delete' => 'cascade', 'length' => []],
            'FK_subscriptions_tadirah_objects_tadirah_objects' => ['type' => 'foreign', 'columns' => ['tadirah_object_id'], 'references' => ['tadirah_objects', 'id'], 'update' => 'noAction', 'delete' => 'cascade', 'length' => []],
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
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'subscription_id' => 1,
                'tadirah_object_id' => 1,
            ],
        ];
        parent::init();
    }
}
