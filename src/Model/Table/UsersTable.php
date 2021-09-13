<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Users Model
 *
 * @property \App\Model\Table\UserRolesTable&\Cake\ORM\Association\BelongsTo $UserRoles
 * @property \App\Model\Table\CountriesTable&\Cake\ORM\Association\BelongsTo $Countries
 * @property \App\Model\Table\InstitutionsTable&\Cake\ORM\Association\BelongsTo $Institutions
 * @property \App\Model\Table\CoursesTable&\Cake\ORM\Association\HasMany $Courses
 *
 * @method \App\Model\Entity\User get($primaryKey, $options = [])
 * @method \App\Model\Entity\User newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\User[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\User|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\User[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\User findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class UsersTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config) : void
    {
        parent::initialize($config);

        $this->setTable('users');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('UserRoles', [
            'foreignKey' => 'user_role_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Countries', [
            'foreignKey' => 'country_id',
        ]);
        $this->belongsTo('Institutions', [
            'foreignKey' => 'institution_id',
        ]);
        $this->hasMany('Courses', [
            'foreignKey' => 'user_id',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator) : Validator
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('university')
            ->maxLength('university', 255)
            ->allowEmptyString('university');

        $validator
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmptyString('email')
            ->add('email', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('shib_eppn')
            ->maxLength('shib_eppn', 255)
            ->allowEmptyString('shib_eppn')
            ->add('shib_eppn', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('password')
            ->maxLength('password', 255)
            ->allowEmptyString('password');

        $validator
            ->boolean('email_verified')
            ->notEmptyString('email_verified');

        $validator
            ->boolean('active')
            ->notEmptyString('active');

        $validator
            ->boolean('approved')
            ->notEmptyString('approved');

        $validator
            ->boolean('is_admin')
            ->notEmptyString('is_admin');

        $validator
            ->boolean('user_admin')
            ->notEmptyString('user_admin');

        $validator
            ->dateTime('last_login')
            ->allowEmptyDateTime('last_login');

        $validator
            ->scalar('password_token')
            ->maxLength('password_token', 255)
            ->allowEmptyString('password_token');

        $validator
            ->scalar('email_token')
            ->maxLength('email_token', 255)
            ->allowEmptyString('email_token');

        $validator
            ->scalar('approval_token')
            ->maxLength('approval_token', 255)
            ->allowEmptyString('approval_token');

        $validator
            ->scalar('new_email')
            ->maxLength('new_email', 255)
            ->allowEmptyString('new_email');

        $validator
            ->dateTime('password_token_expires')
            ->allowEmptyDateTime('password_token_expires');

        $validator
            ->dateTime('email_token_expires')
            ->allowEmptyDateTime('email_token_expires');

        $validator
            ->dateTime('approval_token_expires')
            ->allowEmptyDateTime('approval_token_expires');

        $validator
            ->scalar('last_name')
            ->maxLength('last_name', 255)
            ->allowEmptyString('last_name');

        $validator
            ->scalar('first_name')
            ->maxLength('first_name', 255)
            ->allowEmptyString('first_name');

        $validator
            ->scalar('academic_title')
            ->maxLength('academic_title', 255)
            ->allowEmptyString('academic_title');

        $validator
            ->scalar('about')
            ->allowEmptyString('about');

        $validator
            ->boolean('mail_list')
            ->notEmptyString('mail_list');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules) : RulesChecker
    {
        $rules->add($rules->isUnique(['email']));
        $rules->add($rules->isUnique(['shib_eppn']));
        $rules->add($rules->existsIn(['user_role_id'], 'UserRoles'));
        $rules->add($rules->existsIn(['country_id'], 'Countries'));
        $rules->add($rules->existsIn(['institution_id'], 'Institutions'));

        return $rules;
    }



    public function getModerators($country_id = null, $user_admin = true) : array
    {
        $admins = [];
        // try fetching the moderator in charge of the user's country,
        if(!empty($country_id)) {
            $admins = $this->find()
                ->distinct()->where([
                    'Users.country_id' => $country_id,
                    'Users.user_role_id' => 2,	// moderators
                    'Users.active' => 1
                ])->toArray();
        }
        // then user_admin
        if(empty($admins) AND $user_admin) {
            $admins = $this->find()
                ->distinct()->where([
                    'Users.user_admin' => 1,
                    'Users.active' => 1
                ])->toArray();
        }
        // then admin
        if(empty($admins)) {
            $admins = $this->find()
                ->distinct()->where([
                    'Users.user_role_id' => 1,	// admins - do not check for the 'is_admin' flag, as it is currently also set for the mods
                    'Users.active' => 1
                ])->toArray();
        }
        return $admins;
    }
}
