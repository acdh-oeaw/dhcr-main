<?php

namespace App\Model\Table;

use Cake\Core\Configure;
use Cake\Core\Exception\Exception;
use Cake\Mailer\MailerAwareTrait;
use Cake\ORM\Entity;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use phpDocumentor\Reflection\Types\Boolean;

class UsersTable extends Table
{
    use MailerAwareTrait;

    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('users');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->addBehavior('Token');

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

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('shib_eppn')
            ->maxLength('shib_eppn', 255, 'Your Identifier is too long. Please turn to the admin team for support or use the classic login.')
            ->allowEmptyString('shib_eppn')
            ->add('shib_eppn', 'unique', [
                'rule' => 'validateUnique', 'provider' => 'table',
                'message' => 'Your identity is already used by an other account. Please turn to our admin team '
            ]);

        $validator
            ->scalar('password')
            ->maxLength('password', 255, 'Your password is too long.')
            ->minLength('password', 6, 'Your password is to short, it should be at least 6 characters.')
            ->allowEmptyString('password', 'Please provide a password.', function ($context) {
                return $context['providers']['table']->invitationMode;
            });

        $validator
            ->setStopOnFailure(true)
            ->email('email', false, 'Email address looks strange.')
            ->add('email', 'unique', [
                'rule' => 'validateUnique', 'provider' => 'table',
                'message' => 'Email address is already in use.'
            ])
            ->email('email', true, 'Email MX check failed.', function ($context) {
                return $context['providers']['table']->invitationMode;
            });

        $validator
            ->email('new_email', false, 'Please provide a valid email address.')
            ->maxLength('new_email', 255)
            ->allowEmptyString('new_email')
            ->notEmptyString('new_email', 'Please provide your email address.')
            ->add('new_email', 'unique', [
                'rule' => function ($value, $context) {
                    return !(bool) $context['providers']['table']->find()->where(['email' => $value])->count();
                },
                'message' => 'Your email address is not unique in our database.'
            ]);

        $validator
            ->scalar('last_name')
            ->maxLength('last_name', 255, 'Your last name is too long.')
            ->notEmptyString('last_name', 'Please provide your last name.');

        $validator
            ->scalar('first_name')
            ->maxLength('first_name', 255, 'Your first name is too long.')
            ->notEmptyString('first_name', 'Please provide your first name.');

        $validator
            ->scalar('academic_title')
            ->maxLength('academic_title', 255, 'Your academic title is too long (> 255 characters). We beg your pardon, that our database cannot take on all your wisdom.')
            ->allowEmptyString('academic_title');

        return $validator;
    }

    // disable email MX check during invitation evaluation
    public $invitationMode = false;

    public function validationCreate(Validator $validator): Validator
    {
        $validator
            ->requirePresence('institution_id', true)
            ->add('institution_id', 'allowEmptyIf', [
                'rule' => function ($value, $context) {
                    if (empty($value) and empty($context['data']['university']))
                        return 'When you do not find your affiliation in the list,
                        you must provide the country, city and name of your institution in the field below.';
                    if (!empty($value) and !empty($context['data']['university']))
                        return 'Leave this field empty, when you want us to add a new organisation
                        as indicated in the field below';
                    return true;
                }
            ]);

        $validator
            ->scalar('about')
            ->notEmptyString('about', 'For verification of your eligibility, please provide reproducible information of your academical teaching involvement.', 'create');

        $validator
            ->requirePresence('consent', 'create')
            ->allowEmptyString('consent', 'You must agree to the terms.')
            ->equals('consent', 1, 'You must agree to the terms.');

        return $this->validationDefault($validator);
    }

    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['user_role_id'], 'UserRoles'));
        $rules->add($rules->existsIn(['country_id'], 'Countries'));
        $rules->add($rules->existsIn(['institution_id'], 'Institutions'));
        return $rules;
    }

    public function getModerators(int $country_id = null, bool $user_admin = true): array
    {
        $admins = [];
        // try fetching the moderator in charge of the user's country,
        if ($country_id) {
            $admins = $this->find()
                ->distinct()->where([
                    'Users.country_id' => $country_id,
                    'Users.user_role_id' => 2,    // moderators
                    'Users.active' => 1
                ])->toArray();
        }
        // then user_admin
        if (empty($admins) and $user_admin) {
            $admins = $this->find()
                ->distinct()->where([
                    'Users.user_admin' => 1,
                    'Users.active' => 1
                ])->toArray();
        }
        // then admin
        if (empty($admins)) {
            $admins = $this->find()
                ->distinct()->where([
                    'Users.is_admin' => 1,
                    'Users.active' => 1
                ])->toArray();
        }
        return $admins;
    }

    public function notifyAdmins($user)
    {
        // TODO: route this to a single team account
        $admins = $this->getModerators(null, true);
        try {
            foreach ($admins as $admin)
                $this->getMailer('User')->send('notifyAdmin', [$user, $admin->email]);
        } catch (Exception $exception) {
        }
    }

    public function register($data = [])
    {
        $data['new_email'] = $data['email'];
        $data['email_token'] = $this->generateToken('email_token');
        $data['approval_token'] = $this->generateToken('approval_token');
        $data['approval_token_expires'] = $this->getLongTokenExpiry();

        $user = $this->newEntity($data);
        if ($user->hasErrors()) {
            return $user;
        }
        if (!$this->save($user)) {
            return false;
        }
        return $user;
    }

    public function getShortTokenExpiry()
    {
        return date('Y-m-d H:i:s', time() + 60 * 60 * 1);
    }

    public function getLongTokenExpiry()
    {
        return date('Y-m-d H:i:s', time() + 60 * 60 * 24 * 7);
    }
}
