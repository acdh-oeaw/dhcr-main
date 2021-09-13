<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CoursesDisciplinesFixture
 */
class CoursesDisciplinesFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'course_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'discipline_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'FK_courses_disciplines_courses' => ['type' => 'index', 'columns' => ['course_id'], 'length' => []],
            'FK_courses_disciplines_disciplines' => ['type' => 'index', 'columns' => ['discipline_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'FK_courses_disciplines_courses' => ['type' => 'foreign', 'columns' => ['course_id'], 'references' => ['courses', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
            'FK_courses_disciplines_disciplines' => ['type' => 'foreign', 'columns' => ['discipline_id'], 'references' => ['disciplines', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
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
                'discipline_id' => 1,
            ],
            [
                'id' => 2,
                'course_id' => 3,
                'discipline_id' => 1,
            ],
        ];
        parent::init();
    }
}
