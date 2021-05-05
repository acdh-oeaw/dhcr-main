<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * UsersFixture
 */
class UsersFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'user_role_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => '3', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'country_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => 'moderators belong to country', 'precision' => null, 'autoIncrement' => null],
        'institution_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'university' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'comment' => 'temporary value provided during registration, if the university is not in the list yet', 'precision' => null, 'fixed' => null],
        'email' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'shib_eppn' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'password' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'email_verified' => ['type' => 'boolean', 'length' => null, 'null' => false, 'default' => '0', 'comment' => '', 'precision' => null],
        'active' => ['type' => 'boolean', 'length' => null, 'null' => false, 'default' => '1', 'comment' => '', 'precision' => null],
        'approved' => ['type' => 'boolean', 'length' => null, 'null' => false, 'default' => '0', 'comment' => '', 'precision' => null],
        'is_admin' => ['type' => 'boolean', 'length' => null, 'null' => false, 'default' => '0', 'comment' => '', 'precision' => null],
        'user_admin' => ['type' => 'boolean', 'length' => null, 'null' => false, 'default' => '0', 'comment' => '', 'precision' => null],
        'last_login' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'password_token' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'email_token' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'approval_token' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'new_email' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'password_token_expires' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'email_token_expires' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'approval_token_expires' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'last_name' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'first_name' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'academic_title' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'about' => ['type' => 'text', 'length' => null, 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'comment' => '', 'precision' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'modified' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'mail_list' => ['type' => 'boolean', 'length' => null, 'null' => false, 'default' => '0', 'comment' => '', 'precision' => null],
        '_indexes' => [
            'email' => ['type' => 'index', 'columns' => ['email'], 'length' => []],
            'email_reset_token' => ['type' => 'index', 'columns' => ['email_token'], 'length' => []],
            'password_reset_token' => ['type' => 'index', 'columns' => ['password_token'], 'length' => []],
            'FK_users_institutions' => ['type' => 'index', 'columns' => ['institution_id'], 'length' => []],
            'FK_users_user_roles' => ['type' => 'index', 'columns' => ['user_role_id'], 'length' => []],
            'FK_users_countries' => ['type' => 'index', 'columns' => ['country_id'], 'length' => []],
            'key_shib_eppn' => ['type' => 'index', 'columns' => ['shib_eppn'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'unique_email' => ['type' => 'unique', 'columns' => ['email'], 'length' => []],
            'shib_eppn' => ['type' => 'unique', 'columns' => ['shib_eppn'], 'length' => []],
            'FK_users_countries' => ['type' => 'foreign', 'columns' => ['country_id'], 'references' => ['countries', 'id'], 'update' => 'cascade', 'delete' => 'restrict', 'length' => []],
            'FK_users_institutions' => ['type' => 'foreign', 'columns' => ['institution_id'], 'references' => ['institutions', 'id'], 'update' => 'cascade', 'delete' => 'restrict', 'length' => []],
            'FK_users_user_roles' => ['type' => 'foreign', 'columns' => ['user_role_id'], 'references' => ['user_roles', 'id'], 'update' => 'cascade', 'delete' => 'restrict', 'length' => []],
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
    public function init() : void
    {
        $this->records = [
            [
                'id' => 1,
                'user_role_id' => 1,
                'country_id' => 1,
                'institution_id' => 1,
                'university' => 'Lorem ipsum dolor sit amet',
                'email' => 'Lorem ipsum dolor sit amet',
                'shib_eppn' => 'Lorem ipsum dolor sit amet',
                'password' => 'Lorem ipsum dolor sit amet',
                'email_verified' => 1,
                'active' => 1,
                'approved' => 1,
                'is_admin' => 1,
                'user_admin' => 1,
                'last_login' => '2021-05-04 16:19:43',
                'password_token' => 'Lorem ipsum dolor sit amet',
                'email_token' => 'Lorem ipsum dolor sit amet',
                'approval_token' => 'Lorem ipsum dolor sit amet',
                'new_email' => 'Lorem ipsum dolor sit amet',
                'password_token_expires' => '2021-05-04 16:19:43',
                'email_token_expires' => '2021-05-04 16:19:43',
                'approval_token_expires' => '2021-05-04 16:19:43',
                'last_name' => 'Lorem ipsum dolor sit amet',
                'first_name' => 'Lorem ipsum dolor sit amet',
                'academic_title' => 'Lorem ipsum dolor sit amet',
                'about' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'created' => '2021-05-04 16:19:43',
                'modified' => '2021-05-04 16:19:43',
                'mail_list' => 1,
            ],
        ];
        parent::init();
    }
}
