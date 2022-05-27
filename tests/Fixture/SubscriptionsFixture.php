<?php

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * SubscriptionsFixture
 */
class SubscriptionsFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'email' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'online_course' => ['type' => 'boolean', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'confirmed' => ['type' => 'boolean', 'length' => null, 'null' => false, 'default' => '0', 'comment' => '', 'precision' => null],
        'confirmation_key' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'deletion_key' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'updated' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        '_indexes' => [
            'confirmation_key' => ['type' => 'index', 'columns' => ['confirmation_key'], 'length' => []],
            'deletion_key' => ['type' => 'index', 'columns' => ['deletion_key'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'email' => ['type' => 'unique', 'columns' => ['email'], 'length' => []],
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
                'id' => 1,  // has notification on course 1
                'email' => 'test@example.com',
                'online_course' => 1,
                'confirmed' => 1,
                'confirmation_key' => 'Loremipsumdolorsitamet',
                'deletion_key' => 'Loremipsumdolorsitamet',
                'created' => '2020-11-23 19:17:24',
                'updated' => '2020-11-23 19:17:24',
            ],
            [
                'id' => 2,
                'email' => 'test2@example.com',
                'online_course' => 0,
                'confirmed' => 0,
                'confirmation_key' => 'Lorem ipsum dolor sit amet',
                'deletion_key' => 'Lorem ipsum dolor sit amet',
                'created' => '2020-11-23 19:17:24',
                'updated' => '2020-11-23 19:17:24',
            ],
            [
                'id' => 3,  // has notification on course 1
                'email' => 'bominuskaya',
                'online_course' => 0,
                'confirmed' => 1,
                'confirmation_key' => 'Lorem ipsum dolor sit amet',
                'deletion_key' => 'Lorem ipsum dolor sit amet',
                'created' => '2020-11-23 19:17:24',
                'updated' => '2020-11-23 19:17:24',
            ],
            [
                'id' => 4,
                'email' => 'Aelomen',
                'online_course' => null,
                'confirmed' => 1,
                'confirmation_key' => 'Lorem ipsum dolor sit amet',
                'deletion_key' => 'Lorem ipsum dolor sit amet',
                'created' => '2020-11-23 19:17:24',
                'updated' => '2020-11-23 19:17:24',
            ],
            [
                'id' => 5,
                'email' => 'dolor',
                'online_course' => 0,
                'confirmed' => 1,
                'confirmation_key' => 'Lorem ipsum dolor sit amet',
                'deletion_key' => 'Lorem ipsum dolor sit amet',
                'created' => '2020-11-23 19:17:24',
                'updated' => '2020-11-23 19:17:24',
            ],
        ];
        parent::init();
    }
}
