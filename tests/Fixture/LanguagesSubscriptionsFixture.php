<?php

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * LanguagesSubscriptionsFixture
 */
class LanguagesSubscriptionsFixture extends TestFixture
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
        'language_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'FK_laguages_subscriptions_subscriptions' => ['type' => 'index', 'columns' => ['subscription_id'], 'length' => []],
            'FK_languages_subscriptions_lanugages' => ['type' => 'index', 'columns' => ['language_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'FK_languages_subscriptions_languages' => ['type' => 'foreign', 'columns' => ['language_id'], 'references' => ['languages', 'id'], 'update' => 'noAction', 'delete' => 'cascade', 'length' => []],
            'FK_languages_subscriptions_subscriptions' => ['type' => 'foreign', 'columns' => ['subscription_id'], 'references' => ['subscriptions', 'id'], 'update' => 'noAction', 'delete' => 'cascade', 'length' => []],
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
                'language_id' => 1,
            ],
            [
                'id' => 2,
                'subscription_id' => 3,
                'language_id' => 1,
            ],
            [
                'id' => 3,
                'subscription_id' => 3,
                'language_id' => 2,
            ],
        ];
        parent::init();
    }
}
