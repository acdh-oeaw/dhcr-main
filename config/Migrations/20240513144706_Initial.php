<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class Initial extends AbstractMigration
{
    /**
     * Up Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-up-method
     * @return void
     */
    public function up(): void
    {
        $this->table('cities')
            ->addColumn('country_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 100,
                'null' => false,
            ])
            ->addIndex(
                [
                    'country_id',
                ],
                [
                    'name' => 'FK_cities_countries',
                ]
            )
            ->create();

        $this->table('countries')
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 100,
                'null' => false,
            ])
            ->addColumn('domain_name', 'string', [
                'comment' => 'The domain name country code.',
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('stop_words', 'string', [
                'comment' => 'Provide any word fragment that might indicate, that an institution is located in this country. Consider English language, the country\'s lang and adjective forms.',
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->create();

        $this->table('course_duration_units')
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 50,
                'null' => false,
            ])
            ->create();

        $this->table('course_parent_types')
            ->addColumn('name', 'string', [
                'comment' => 'a short name',
                'default' => null,
                'limit' => 100,
                'null' => false,
            ])
            ->create();

        $this->table('course_types')
            ->addColumn('course_parent_type_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 100,
                'null' => false,
            ])
            ->addIndex(
                [
                    'course_parent_type_id',
                ],
                [
                    'name' => 'FK_course_types_course_parent_types',
                ]
            )
            ->create();

        $this->table('courses')
            ->addColumn('user_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('active', 'boolean', [
                'default' => true,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('deleted', 'boolean', [
                'default' => false,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('deletion_reason_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('approved', 'boolean', [
                'default' => false,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('approval_token', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('mod_mailed', 'boolean', [
                'default' => false,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('updated', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('last_reminder', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('description', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('country_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('city_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('institution_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('department', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('course_parent_type_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('course_type_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('language_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('access_requirements', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('start_date', 'string', [
                'default' => null,
                'limit' => 100,
                'null' => true,
            ])
            ->addColumn('duration', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('course_duration_unit_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('online_course', 'boolean', [
                'default' => false,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('recurring', 'boolean', [
                'default' => true,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('info_url', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('guide_url', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('skip_info_url', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('skip_guide_url', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('ects', 'float', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('contact_mail', 'string', [
                'comment' => 'as opposed to the former \'contact name\' colums, the lecturer properties are supposed to contain only a single contact',
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('contact_name', 'string', [
                'comment' => 'enter a single email address only',
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('lon', 'decimal', [
                'default' => null,
                'null' => true,
                'precision' => 10,
                'scale' => 6,
            ])
            ->addColumn('lat', 'decimal', [
                'default' => null,
                'null' => true,
                'precision' => 10,
                'scale' => 6,
            ])
            ->addIndex(
                [
                    'name',
                    'institution_id',
                    'course_type_id',
                ],
                [
                    'name' => 'course_inst_educ',
                    'unique' => true,
                ]
            )
            ->addIndex(
                [
                    'city_id',
                ],
                [
                    'name' => 'FK_courses_cities',
                ]
            )
            ->addIndex(
                [
                    'country_id',
                ],
                [
                    'name' => 'FK_courses_countries',
                ]
            )
            ->addIndex(
                [
                    'course_duration_unit_id',
                ],
                [
                    'name' => 'FK_courses_course_duration_units',
                ]
            )
            ->addIndex(
                [
                    'course_parent_type_id',
                ],
                [
                    'name' => 'FK_courses_course_parent_types',
                ]
            )
            ->addIndex(
                [
                    'course_type_id',
                ],
                [
                    'name' => 'FK_courses_course_types',
                ]
            )
            ->addIndex(
                [
                    'deletion_reason_id',
                ],
                [
                    'name' => 'FK_courses_deletion_reasons',
                ]
            )
            ->addIndex(
                [
                    'institution_id',
                ],
                [
                    'name' => 'FK_courses_institutions',
                ]
            )
            ->addIndex(
                [
                    'language_id',
                ],
                [
                    'name' => 'FK_courses_languages',
                ]
            )
            ->addIndex(
                [
                    'user_id',
                ],
                [
                    'name' => 'FK_courses_users',
                ]
            )
            ->addIndex(
                [
                    'active',
                ],
                [
                    'name' => 'active',
                ]
            )
            ->addIndex(
                [
                    'lon',
                ],
                [
                    'name' => 'lon',
                ]
            )
            ->addIndex(
                [
                    'lat',
                ],
                [
                    'name' => 'lat',
                ]
            )
            ->create();

        $this->table('courses_disciplines')
            ->addColumn('course_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('discipline_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addIndex(
                [
                    'course_id',
                ],
                [
                    'name' => 'FK_courses_disciplines_courses',
                ]
            )
            ->addIndex(
                [
                    'discipline_id',
                ],
                [
                    'name' => 'FK_courses_disciplines_disciplines',
                ]
            )
            ->create();

        $this->table('courses_tadirah_activities')
            ->addColumn('course_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('tadirah_activity_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addIndex(
                [
                    'course_id',
                ],
                [
                    'name' => 'FK_courses_tadirah_activities_courses',
                ]
            )
            ->addIndex(
                [
                    'tadirah_activity_id',
                ],
                [
                    'name' => 'FK_courses_tadirah_activities_tadirah_activities',
                ]
            )
            ->create();

        $this->table('courses_tadirah_objects')
            ->addColumn('course_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('tadirah_object_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addIndex(
                [
                    'course_id',
                ],
                [
                    'name' => 'FK__courses',
                ]
            )
            ->addIndex(
                [
                    'tadirah_object_id',
                ],
                [
                    'name' => 'FK__tadirah_objects',
                ]
            )
            ->create();

        $this->table('courses_tadirah_techniques')
            ->addColumn('course_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('tadirah_technique_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addIndex(
                [
                    'course_id',
                ],
                [
                    'name' => 'FK_courses_tadirah_techniques_courses',
                ]
            )
            ->addIndex(
                [
                    'tadirah_technique_id',
                ],
                [
                    'name' => 'FK_courses_tadirah_techniques_tadirah_techniques',
                ]
            )
            ->create();

        $this->table('deletion_reasons')
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->create();

        $this->table('disciplines')
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->create();

        $this->table('faq_categories')
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 60,
                'null' => false,
            ])
            ->addIndex(
                [
                    'id',
                ],
                [
                    'name' => 'id',
                ]
            )
            ->create();

        $this->table('faq_questions')
            ->addColumn('faq_category_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('sort_order', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('question', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('answer', 'text', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('link_title', 'string', [
                'default' => null,
                'limit' => 100,
                'null' => true,
            ])
            ->addColumn('link_url', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('published', 'boolean', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addIndex(
                [
                    'faq_category_id',
                ],
                [
                    'name' => 'FK_faq_category',
                ]
            )
            ->addIndex(
                [
                    'id',
                ],
                [
                    'name' => 'id',
                ]
            )
            ->create();

        $this->table('institutions')
            ->addColumn('city_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('country_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('description', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('url', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('lon', 'decimal', [
                'default' => null,
                'null' => true,
                'precision' => 10,
                'scale' => 6,
            ])
            ->addColumn('lat', 'decimal', [
                'default' => null,
                'null' => true,
                'precision' => 10,
                'scale' => 6,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('updated', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addIndex(
                [
                    'city_id',
                ],
                [
                    'name' => 'FK_institutions_cities',
                ]
            )
            ->addIndex(
                [
                    'country_id',
                ],
                [
                    'name' => 'FK_institutions_countries',
                ]
            )
            ->create();

        $this->table('invite_translations')
            ->addColumn('language_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('sortOrder', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('subject', 'string', [
                'default' => null,
                'limit' => 150,
                'null' => false,
            ])
            ->addColumn('messageBody', 'text', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('updated', 'datetime', [
                'default' => '0000-00-00 00:00:00',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('active', 'boolean', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addIndex(
                [
                    'sortOrder',
                ],
                [
                    'name' => 'sortOrder',
                    'unique' => true,
                ]
            )
            ->addIndex(
                [
                    'language_id',
                ],
                [
                    'name' => 'fk_language',
                ]
            )
            ->create();

        $this->table('languages')
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 100,
                'null' => false,
            ])
            ->create();

        $this->table('logentries')
            ->addColumn('logentry_code_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('user_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('source_name', 'string', [
                'default' => null,
                'limit' => 25,
                'null' => false,
            ])
            ->addColumn('subject', 'string', [
                'default' => null,
                'limit' => 25,
                'null' => false,
            ])
            ->addColumn('description', 'string', [
                'default' => null,
                'limit' => 150,
                'null' => false,
            ])
            ->addColumn('cleared', 'boolean', [
                'default' => false,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addIndex(
                [
                    'user_id',
                ],
                [
                    'name' => 'FK_logentries_user',
                ]
            )
            ->addIndex(
                [
                    'logentry_code_id',
                ],
                [
                    'name' => 'FK_logentry_code',
                ]
            )
            ->create();

        $this->table('logentry_codes')
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 60,
                'null' => false,
            ])
            ->create();

        $this->table('tadirah_activities')
            ->addColumn('parent_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('name', 'string', [
                'default' => '0',
                'limit' => 100,
                'null' => false,
            ])
            ->addColumn('description', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addIndex(
                [
                    'parent_id',
                ],
                [
                    'name' => 'FK_tadirah_activities_tadirah_activities',
                ]
            )
            ->create();

        $this->table('tadirah_activities_tadirah_techniques')
            ->addColumn('tadirah_activity_id', 'integer', [
                'default' => '0',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('tadirah_technique_id', 'integer', [
                'default' => '0',
                'limit' => null,
                'null' => false,
            ])
            ->addIndex(
                [
                    'tadirah_activity_id',
                ],
                [
                    'name' => 'FK_tadirah_activities_tadirah_techniques_tadirah_activities',
                ]
            )
            ->addIndex(
                [
                    'tadirah_technique_id',
                ],
                [
                    'name' => 'FK_tadirah_activities_tadirah_techniques_tadirah_techniques',
                ]
            )
            ->create();

        $this->table('tadirah_objects')
            ->addColumn('name', 'string', [
                'default' => '0',
                'limit' => 100,
                'null' => false,
            ])
            ->addColumn('description', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->create();

        $this->table('tadirah_techniques')
            ->addColumn('name', 'string', [
                'default' => '0',
                'limit' => 100,
                'null' => false,
            ])
            ->addColumn('description', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->create();

        $this->table('user_roles')
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->create();

        $this->table('users')
            ->addColumn('user_role_id', 'integer', [
                'default' => '3',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('country_id', 'integer', [
                'comment' => 'moderators belong to country',
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('institution_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('university', 'string', [
                'comment' => 'temporary value provided during registration, if the university is not in the list yet',
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('email', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('mail_list', 'boolean', [
                'default' => false,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('shib_eppn', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('password', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('email_verified', 'boolean', [
                'default' => false,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('active', 'boolean', [
                'default' => true,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('approved', 'boolean', [
                'default' => false,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('is_admin', 'boolean', [
                'default' => false,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('user_admin', 'boolean', [
                'default' => false,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('last_login', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('password_token', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('email_token', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('approval_token', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('new_email', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('password_token_expires', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('email_token_expires', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('approval_token_expires', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('last_name', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('first_name', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('academic_title', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('about', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('mod_profile', 'boolean', [
                'default' => false,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('photo_url', 'string', [
                'default' => null,
                'limit' => 150,
                'null' => true,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addIndex(
                [
                    'email',
                ],
                [
                    'name' => 'unique_email',
                    'unique' => true,
                ]
            )
            ->addIndex(
                [
                    'shib_eppn',
                ],
                [
                    'name' => 'shib_eppn',
                    'unique' => true,
                ]
            )
            ->addIndex(
                [
                    'country_id',
                ],
                [
                    'name' => 'FK_users_countries',
                ]
            )
            ->addIndex(
                [
                    'institution_id',
                ],
                [
                    'name' => 'FK_users_institutions',
                ]
            )
            ->addIndex(
                [
                    'user_role_id',
                ],
                [
                    'name' => 'FK_users_user_roles',
                ]
            )
            ->addIndex(
                [
                    'email',
                ],
                [
                    'name' => 'email',
                ]
            )
            ->addIndex(
                [
                    'email_token',
                ],
                [
                    'name' => 'email_reset_token',
                ]
            )
            ->addIndex(
                [
                    'password_token',
                ],
                [
                    'name' => 'password_reset_token',
                ]
            )
            ->addIndex(
                [
                    'shib_eppn',
                ],
                [
                    'name' => 'key_shib_eppn',
                ]
            )
            ->create();

        $this->table('cities')
            ->addForeignKey(
                'country_id',
                'countries',
                'id',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION',
                    'constraint' => 'FK_cities_countries'
                ]
            )
            ->update();

        $this->table('course_types')
            ->addForeignKey(
                'course_parent_type_id',
                'course_parent_types',
                'id',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION',
                    'constraint' => 'FK_course_types_course_parent_types'
                ]
            )
            ->update();

        $this->table('courses')
            ->addForeignKey(
                'city_id',
                'cities',
                'id',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION',
                    'constraint' => 'FK_courses_cities'
                ]
            )
            ->addForeignKey(
                'country_id',
                'countries',
                'id',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION',
                    'constraint' => 'FK_courses_countries'
                ]
            )
            ->addForeignKey(
                'course_duration_unit_id',
                'course_duration_units',
                'id',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'SET_NULL',
                    'constraint' => 'FK_courses_course_duration_units'
                ]
            )
            ->addForeignKey(
                'course_parent_type_id',
                'course_parent_types',
                'id',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION',
                    'constraint' => 'FK_courses_course_parent_types'
                ]
            )
            ->addForeignKey(
                'course_type_id',
                'course_types',
                'id',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION',
                    'constraint' => 'FK_courses_course_types'
                ]
            )
            ->addForeignKey(
                'deletion_reason_id',
                'deletion_reasons',
                'id',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION',
                    'constraint' => 'FK_courses_deletion_reasons'
                ]
            )
            ->addForeignKey(
                'institution_id',
                'institutions',
                'id',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION',
                    'constraint' => 'FK_courses_institutions'
                ]
            )
            ->addForeignKey(
                'language_id',
                'languages',
                'id',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION',
                    'constraint' => 'FK_courses_languages'
                ]
            )
            ->addForeignKey(
                'user_id',
                'users',
                'id',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'SET_NULL',
                    'constraint' => 'FK_courses_users'
                ]
            )
            ->update();

        $this->table('courses_disciplines')
            ->addForeignKey(
                'course_id',
                'courses',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE',
                    'constraint' => 'FK_courses_disciplines_courses'
                ]
            )
            ->addForeignKey(
                'discipline_id',
                'disciplines',
                'id',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION',
                    'constraint' => 'FK_courses_disciplines_disciplines'
                ]
            )
            ->update();

        $this->table('courses_tadirah_activities')
            ->addForeignKey(
                'course_id',
                'courses',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE',
                    'constraint' => 'FK_courses_tadirah_activities_courses'
                ]
            )
            ->addForeignKey(
                'tadirah_activity_id',
                'tadirah_activities',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE',
                    'constraint' => 'FK_courses_tadirah_activities_tadirah_activities'
                ]
            )
            ->update();

        $this->table('courses_tadirah_objects')
            ->addForeignKey(
                'course_id',
                'courses',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE',
                    'constraint' => 'FK__courses'
                ]
            )
            ->addForeignKey(
                'tadirah_object_id',
                'tadirah_objects',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE',
                    'constraint' => 'FK__tadirah_objects'
                ]
            )
            ->update();

        $this->table('courses_tadirah_techniques')
            ->addForeignKey(
                'course_id',
                'courses',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE',
                    'constraint' => 'FK_courses_tadirah_techniques_courses'
                ]
            )
            ->addForeignKey(
                'tadirah_technique_id',
                'tadirah_techniques',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE',
                    'constraint' => 'FK_courses_tadirah_techniques_tadirah_techniques'
                ]
            )
            ->update();

        $this->table('faq_questions')
            ->addForeignKey(
                'faq_category_id',
                'faq_categories',
                'id',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION',
                    'constraint' => 'FK_faq_category'
                ]
            )
            ->update();

        $this->table('institutions')
            ->addForeignKey(
                'city_id',
                'cities',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'NO_ACTION',
                    'constraint' => 'FK_institutions_cities'
                ]
            )
            ->addForeignKey(
                'country_id',
                'countries',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'NO_ACTION',
                    'constraint' => 'FK_institutions_countries'
                ]
            )
            ->update();

        $this->table('invite_translations')
            ->addForeignKey(
                'language_id',
                'languages',
                'id',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION',
                    'constraint' => 'fk_language'
                ]
            )
            ->update();

        $this->table('logentries')
            ->addForeignKey(
                'user_id',
                'users',
                'id',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION',
                    'constraint' => 'FK_logentries_user'
                ]
            )
            ->addForeignKey(
                'logentry_code_id',
                'logentry_codes',
                'id',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION',
                    'constraint' => 'FK_logentry_code'
                ]
            )
            ->update();

        $this->table('tadirah_activities')
            ->addForeignKey(
                'parent_id',
                'tadirah_activities',
                'id',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION',
                    'constraint' => 'FK_tadirah_activities_tadirah_activities'
                ]
            )
            ->update();

        $this->table('tadirah_activities_tadirah_techniques')
            ->addForeignKey(
                'tadirah_activity_id',
                'tadirah_activities',
                'id',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION',
                    'constraint' => 'FK_tadirah_activities_tadirah_techniques_tadirah_activities'
                ]
            )
            ->addForeignKey(
                'tadirah_technique_id',
                'tadirah_techniques',
                'id',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION',
                    'constraint' => 'FK_tadirah_activities_tadirah_techniques_tadirah_techniques'
                ]
            )
            ->update();

        $this->table('users')
            ->addForeignKey(
                'country_id',
                'countries',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'NO_ACTION',
                    'constraint' => 'FK_users_countries'
                ]
            )
            ->addForeignKey(
                'institution_id',
                'institutions',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'NO_ACTION',
                    'constraint' => 'FK_users_institutions'
                ]
            )
            ->addForeignKey(
                'user_role_id',
                'user_roles',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'NO_ACTION',
                    'constraint' => 'FK_users_user_roles'
                ]
            )
            ->update();
    }

    /**
     * Down Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-down-method
     * @return void
     */
    public function down(): void
    {
        $this->table('cities')
            ->dropForeignKey(
                'country_id'
            )->save();

        $this->table('course_types')
            ->dropForeignKey(
                'course_parent_type_id'
            )->save();

        $this->table('courses')
            ->dropForeignKey(
                'city_id'
            )
            ->dropForeignKey(
                'country_id'
            )
            ->dropForeignKey(
                'course_duration_unit_id'
            )
            ->dropForeignKey(
                'course_parent_type_id'
            )
            ->dropForeignKey(
                'course_type_id'
            )
            ->dropForeignKey(
                'deletion_reason_id'
            )
            ->dropForeignKey(
                'institution_id'
            )
            ->dropForeignKey(
                'language_id'
            )
            ->dropForeignKey(
                'user_id'
            )->save();

        $this->table('courses_disciplines')
            ->dropForeignKey(
                'course_id'
            )
            ->dropForeignKey(
                'discipline_id'
            )->save();

        $this->table('courses_tadirah_activities')
            ->dropForeignKey(
                'course_id'
            )
            ->dropForeignKey(
                'tadirah_activity_id'
            )->save();

        $this->table('courses_tadirah_objects')
            ->dropForeignKey(
                'course_id'
            )
            ->dropForeignKey(
                'tadirah_object_id'
            )->save();

        $this->table('courses_tadirah_techniques')
            ->dropForeignKey(
                'course_id'
            )
            ->dropForeignKey(
                'tadirah_technique_id'
            )->save();

        $this->table('faq_questions')
            ->dropForeignKey(
                'faq_category_id'
            )->save();

        $this->table('institutions')
            ->dropForeignKey(
                'city_id'
            )
            ->dropForeignKey(
                'country_id'
            )->save();

        $this->table('invite_translations')
            ->dropForeignKey(
                'language_id'
            )->save();

        $this->table('logentries')
            ->dropForeignKey(
                'user_id'
            )
            ->dropForeignKey(
                'logentry_code_id'
            )->save();

        $this->table('tadirah_activities')
            ->dropForeignKey(
                'parent_id'
            )->save();

        $this->table('tadirah_activities_tadirah_techniques')
            ->dropForeignKey(
                'tadirah_activity_id'
            )
            ->dropForeignKey(
                'tadirah_technique_id'
            )->save();

        $this->table('users')
            ->dropForeignKey(
                'country_id'
            )
            ->dropForeignKey(
                'institution_id'
            )
            ->dropForeignKey(
                'user_role_id'
            )->save();

        $this->table('cities')->drop()->save();
        $this->table('countries')->drop()->save();
        $this->table('course_duration_units')->drop()->save();
        $this->table('course_parent_types')->drop()->save();
        $this->table('course_types')->drop()->save();
        $this->table('courses')->drop()->save();
        $this->table('courses_disciplines')->drop()->save();
        $this->table('courses_tadirah_activities')->drop()->save();
        $this->table('courses_tadirah_objects')->drop()->save();
        $this->table('courses_tadirah_techniques')->drop()->save();
        $this->table('deletion_reasons')->drop()->save();
        $this->table('disciplines')->drop()->save();
        $this->table('faq_categories')->drop()->save();
        $this->table('faq_questions')->drop()->save();
        $this->table('institutions')->drop()->save();
        $this->table('invite_translations')->drop()->save();
        $this->table('languages')->drop()->save();
        $this->table('logentries')->drop()->save();
        $this->table('logentry_codes')->drop()->save();
        $this->table('tadirah_activities')->drop()->save();
        $this->table('tadirah_activities_tadirah_techniques')->drop()->save();
        $this->table('tadirah_objects')->drop()->save();
        $this->table('tadirah_techniques')->drop()->save();
        $this->table('user_roles')->drop()->save();
        $this->table('users')->drop()->save();
    }
}
