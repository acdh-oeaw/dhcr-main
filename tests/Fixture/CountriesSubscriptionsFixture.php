<?php

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CountriesSubscriptionsFixture
 */
class CountriesSubscriptionsFixture extends TestFixture
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
        'country_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'FK_countries_subscriptions_subscriptions' => ['type' => 'index', 'columns' => ['subscription_id'], 'length' => []],
            'FK_countries_subscriptions_countries' => ['type' => 'index', 'columns' => ['country_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'FK_countries_subscriptions_countries' => ['type' => 'foreign', 'columns' => ['country_id'], 'references' => ['countries', 'id'], 'update' => 'noAction', 'delete' => 'cascade', 'length' => []],
            'FK_countries_subscriptions_subscriptions' => ['type' => 'foreign', 'columns' => ['subscription_id'], 'references' => ['subscriptions', 'id'], 'update' => 'noAction', 'delete' => 'cascade', 'length' => []],
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
                'country_id' => 1,
            ],
        ];
        parent::init();
    }
}
