<?php

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CoursesTadirahObjectsFixture
 */
class CoursesTadirahObjectsFixture extends TestFixture
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
        'tadirah_object_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'tadirah_object_id' => ['type' => 'index', 'columns' => ['tadirah_object_id'], 'length' => []],
            'FK__courses' => ['type' => 'index', 'columns' => ['course_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'FK__courses' => ['type' => 'foreign', 'columns' => ['course_id'], 'references' => ['courses', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
            'FK__tadirah_objects' => ['type' => 'foreign', 'columns' => ['tadirah_object_id'], 'references' => ['tadirah_objects', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'utf8_unicode_ci'
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
                'course_id' => 1,
                'tadirah_object_id' => 1,
            ],
        ];
        parent::init();
    }
}
