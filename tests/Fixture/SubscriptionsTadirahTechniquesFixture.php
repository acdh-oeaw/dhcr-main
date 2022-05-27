<?php

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * SubscriptionsTadirahTechniquesFixture
 */
class SubscriptionsTadirahTechniquesFixture extends TestFixture
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
        'tadirah_technique_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'FK_subscriptions_tadirah_techniques_subscriptions' => ['type' => 'index', 'columns' => ['subscription_id'], 'length' => []],
            'FK_subscriptions_tadirah_techniques_tadirah_techniques' => ['type' => 'index', 'columns' => ['tadirah_technique_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'FK_subscriptions_tadirah_techniques_subscriptions' => ['type' => 'foreign', 'columns' => ['subscription_id'], 'references' => ['subscriptions', 'id'], 'update' => 'noAction', 'delete' => 'cascade', 'length' => []],
            'FK_subscriptions_tadirah_techniques_tadirah_techniques' => ['type' => 'foreign', 'columns' => ['tadirah_technique_id'], 'references' => ['tadirah_techniques', 'id'], 'update' => 'noAction', 'delete' => 'cascade', 'length' => []],
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
                'tadirah_technique_id' => 1,
            ],
        ];
        parent::init();
    }
}
