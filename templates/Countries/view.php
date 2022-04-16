<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Country'), ['action' => 'edit', $country->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Country'), ['action' => 'delete', $country->id], ['confirm' => __('Are you sure you want to delete # {0}?', $country->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Countries'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Country'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="countries view content">
            <h3><?= h($country->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($country->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Domain Name') ?></th>
                    <td><?= h($country->domain_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Alpha 3') ?></th>
                    <td><?= h($country->alpha_3) ?></td>
                </tr>
                <tr>
                    <th><?= __('Stop Words') ?></th>
                    <td><?= h($country->stop_words) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($country->id) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Subscriptions') ?></h4>
                <?php if (!empty($country->subscriptions)) : ?>
                    <div class="table-responsive">
                        <table>
                            <tr>
                                <th><?= __('Id') ?></th>
                                <th><?= __('Email') ?></th>
                                <th><?= __('Online Course') ?></th>
                                <th><?= __('Confirmed') ?></th>
                                <th><?= __('Confirmation Key') ?></th>
                                <th><?= __('Country Id') ?></th>
                                <th><?= __('Created') ?></th>
                                <th><?= __('Updated') ?></th>
                                <th class="actions"><?= __('Actions') ?></th>
                            </tr>
                            <?php foreach ($country->subscriptions as $subscriptions) : ?>
                                <tr>
                                    <td><?= h($subscriptions->id) ?></td>
                                    <td><?= h($subscriptions->email) ?></td>
                                    <td><?= h($subscriptions->online_course) ?></td>
                                    <td><?= h($subscriptions->confirmed) ?></td>
                                    <td><?= h($subscriptions->confirmation_key) ?></td>
                                    <td><?= h($subscriptions->country_id) ?></td>
                                    <td><?= h($subscriptions->created) ?></td>
                                    <td><?= h($subscriptions->updated) ?></td>
                                    <td class="actions">
                                        <?= $this->Html->link(__('View'), ['controller' => 'Subscriptions', 'action' => 'view', $subscriptions->id]) ?>
                                        <?= $this->Html->link(__('Edit'), ['controller' => 'Subscriptions', 'action' => 'edit', $subscriptions->id]) ?>
                                        <?= $this->Form->postLink(__('Delete'), ['controller' => 'Subscriptions', 'action' => 'delete', $subscriptions->id], ['confirm' => __('Are you sure you want to delete # {0}?', $subscriptions->id)]) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Cities') ?></h4>
                <?php if (!empty($country->cities)) : ?>
                    <div class="table-responsive">
                        <table>
                            <tr>
                                <th><?= __('Id') ?></th>
                                <th><?= __('Country Id') ?></th>
                                <th><?= __('Name') ?></th>
                                <th class="actions"><?= __('Actions') ?></th>
                            </tr>
                            <?php foreach ($country->cities as $cities) : ?>
                                <tr>
                                    <td><?= h($cities->id) ?></td>
                                    <td><?= h($cities->country_id) ?></td>
                                    <td><?= h($cities->name) ?></td>
                                    <td class="actions">
                                        <?= $this->Html->link(__('View'), ['controller' => 'Cities', 'action' => 'view', $cities->id]) ?>
                                        <?= $this->Html->link(__('Edit'), ['controller' => 'Cities', 'action' => 'edit', $cities->id]) ?>
                                        <?= $this->Form->postLink(__('Delete'), ['controller' => 'Cities', 'action' => 'delete', $cities->id], ['confirm' => __('Are you sure you want to delete # {0}?', $cities->id)]) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Courses') ?></h4>
                <?php if (!empty($country->courses)) : ?>
                    <div class="table-responsive">
                        <table>
                            <tr>
                                <th><?= __('Id') ?></th>
                                <th><?= __('User Id') ?></th>
                                <th><?= __('Active') ?></th>
                                <th><?= __('Deleted') ?></th>
                                <th><?= __('Deletion Reason Id') ?></th>
                                <th><?= __('Approved') ?></th>
                                <th><?= __('Approval Token') ?></th>
                                <th><?= __('Mod Mailed') ?></th>
                                <th><?= __('Created') ?></th>
                                <th><?= __('Updated') ?></th>
                                <th><?= __('Last Reminder') ?></th>
                                <th><?= __('Name') ?></th>
                                <th><?= __('Description') ?></th>
                                <th><?= __('Country Id') ?></th>
                                <th><?= __('City Id') ?></th>
                                <th><?= __('Institution Id') ?></th>
                                <th><?= __('Department') ?></th>
                                <th><?= __('Course Parent Type Id') ?></th>
                                <th><?= __('Course Type Id') ?></th>
                                <th><?= __('Language Id') ?></th>
                                <th><?= __('Access Requirements') ?></th>
                                <th><?= __('Start Date') ?></th>
                                <th><?= __('Duration') ?></th>
                                <th><?= __('Course Duration Unit Id') ?></th>
                                <th><?= __('Recurring') ?></th>
                                <th><?= __('Online Course') ?></th>
                                <th><?= __('Info Url') ?></th>
                                <th><?= __('Guide Url') ?></th>
                                <th><?= __('Skip Info Url') ?></th>
                                <th><?= __('Skip Guide Url') ?></th>
                                <th><?= __('Ects') ?></th>
                                <th><?= __('Contact Mail') ?></th>
                                <th><?= __('Contact Name') ?></th>
                                <th><?= __('Lon') ?></th>
                                <th><?= __('Lat') ?></th>
                                <th class="actions"><?= __('Actions') ?></th>
                            </tr>
                            <?php foreach ($country->courses as $courses) : ?>
                                <tr>
                                    <td><?= h($courses->id) ?></td>
                                    <td><?= h($courses->user_id) ?></td>
                                    <td><?= h($courses->active) ?></td>
                                    <td><?= h($courses->deleted) ?></td>
                                    <td><?= h($courses->deletion_reason_id) ?></td>
                                    <td><?= h($courses->approved) ?></td>
                                    <td><?= h($courses->approval_token) ?></td>
                                    <td><?= h($courses->mod_mailed) ?></td>
                                    <td><?= h($courses->created) ?></td>
                                    <td><?= h($courses->updated) ?></td>
                                    <td><?= h($courses->last_reminder) ?></td>
                                    <td><?= h($courses->name) ?></td>
                                    <td><?= h($courses->description) ?></td>
                                    <td><?= h($courses->country_id) ?></td>
                                    <td><?= h($courses->city_id) ?></td>
                                    <td><?= h($courses->institution_id) ?></td>
                                    <td><?= h($courses->department) ?></td>
                                    <td><?= h($courses->course_parent_type_id) ?></td>
                                    <td><?= h($courses->course_type_id) ?></td>
                                    <td><?= h($courses->language_id) ?></td>
                                    <td><?= h($courses->access_requirements) ?></td>
                                    <td><?= h($courses->start_date) ?></td>
                                    <td><?= h($courses->duration) ?></td>
                                    <td><?= h($courses->course_duration_unit_id) ?></td>
                                    <td><?= h($courses->recurring) ?></td>
                                    <td><?= h($courses->online_course) ?></td>
                                    <td><?= h($courses->info_url) ?></td>
                                    <td><?= h($courses->guide_url) ?></td>
                                    <td><?= h($courses->skip_info_url) ?></td>
                                    <td><?= h($courses->skip_guide_url) ?></td>
                                    <td><?= h($courses->ects) ?></td>
                                    <td><?= h($courses->contact_mail) ?></td>
                                    <td><?= h($courses->contact_name) ?></td>
                                    <td><?= h($courses->lon) ?></td>
                                    <td><?= h($courses->lat) ?></td>
                                    <td class="actions">
                                        <?= $this->Html->link(__('View'), ['controller' => 'Courses', 'action' => 'view', $courses->id]) ?>
                                        <?= $this->Html->link(__('Edit'), ['controller' => 'Courses', 'action' => 'edit', $courses->id]) ?>
                                        <?= $this->Form->postLink(__('Delete'), ['controller' => 'Courses', 'action' => 'delete', $courses->id], ['confirm' => __('Are you sure you want to delete # {0}?', $courses->id)]) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Emails') ?></h4>
                <?php if (!empty($country->emails)) : ?>
                    <div class="table-responsive">
                        <table>
                            <tr>
                                <th><?= __('Id') ?></th>
                                <th><?= __('Country Id') ?></th>
                                <th><?= __('Email') ?></th>
                                <th><?= __('First Name') ?></th>
                                <th><?= __('Last Name') ?></th>
                                <th><?= __('Telephone') ?></th>
                                <th><?= __('Message') ?></th>
                                <th><?= __('Updated') ?></th>
                                <th><?= __('Created') ?></th>
                                <th class="actions"><?= __('Actions') ?></th>
                            </tr>
                            <?php foreach ($country->emails as $emails) : ?>
                                <tr>
                                    <td><?= h($emails->id) ?></td>
                                    <td><?= h($emails->country_id) ?></td>
                                    <td><?= h($emails->email) ?></td>
                                    <td><?= h($emails->first_name) ?></td>
                                    <td><?= h($emails->last_name) ?></td>
                                    <td><?= h($emails->telephone) ?></td>
                                    <td><?= h($emails->message) ?></td>
                                    <td><?= h($emails->updated) ?></td>
                                    <td><?= h($emails->created) ?></td>
                                    <td class="actions">
                                        <?= $this->Html->link(__('View'), ['controller' => 'Emails', 'action' => 'view', $emails->id]) ?>
                                        <?= $this->Html->link(__('Edit'), ['controller' => 'Emails', 'action' => 'edit', $emails->id]) ?>
                                        <?= $this->Form->postLink(__('Delete'), ['controller' => 'Emails', 'action' => 'delete', $emails->id], ['confirm' => __('Are you sure you want to delete # {0}?', $emails->id)]) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Institutions') ?></h4>
                <?php if (!empty($country->institutions)) : ?>
                    <div class="table-responsive">
                        <table>
                            <tr>
                                <th><?= __('Id') ?></th>
                                <th><?= __('City Id') ?></th>
                                <th><?= __('Country Id') ?></th>
                                <th><?= __('Name') ?></th>
                                <th><?= __('Description') ?></th>
                                <th><?= __('Url') ?></th>
                                <th><?= __('Lon') ?></th>
                                <th><?= __('Lat') ?></th>
                                <th><?= __('Created') ?></th>
                                <th><?= __('Updated') ?></th>
                                <th class="actions"><?= __('Actions') ?></th>
                            </tr>
                            <?php foreach ($country->institutions as $institutions) : ?>
                                <tr>
                                    <td><?= h($institutions->id) ?></td>
                                    <td><?= h($institutions->city_id) ?></td>
                                    <td><?= h($institutions->country_id) ?></td>
                                    <td><?= h($institutions->name) ?></td>
                                    <td><?= h($institutions->description) ?></td>
                                    <td><?= h($institutions->url) ?></td>
                                    <td><?= h($institutions->lon) ?></td>
                                    <td><?= h($institutions->lat) ?></td>
                                    <td><?= h($institutions->created) ?></td>
                                    <td><?= h($institutions->updated) ?></td>
                                    <td class="actions">
                                        <?= $this->Html->link(__('View'), ['controller' => 'Institutions', 'action' => 'view', $institutions->id]) ?>
                                        <?= $this->Html->link(__('Edit'), ['controller' => 'Institutions', 'action' => 'edit', $institutions->id]) ?>
                                        <?= $this->Form->postLink(__('Delete'), ['controller' => 'Institutions', 'action' => 'delete', $institutions->id], ['confirm' => __('Are you sure you want to delete # {0}?', $institutions->id)]) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Users') ?></h4>
                <?php if (!empty($country->users)) : ?>
                    <div class="table-responsive">
                        <table>
                            <tr>
                                <th><?= __('Id') ?></th>
                                <th><?= __('User Role Id') ?></th>
                                <th><?= __('Country Id') ?></th>
                                <th><?= __('Institution Id') ?></th>
                                <th><?= __('University') ?></th>
                                <th><?= __('Email') ?></th>
                                <th><?= __('Shib Eppn') ?></th>
                                <th><?= __('Password') ?></th>
                                <th><?= __('Email Verified') ?></th>
                                <th><?= __('Active') ?></th>
                                <th><?= __('Approved') ?></th>
                                <th><?= __('Is Admin') ?></th>
                                <th><?= __('User Admin') ?></th>
                                <th><?= __('Last Login') ?></th>
                                <th><?= __('Password Token') ?></th>
                                <th><?= __('Email Token') ?></th>
                                <th><?= __('Approval Token') ?></th>
                                <th><?= __('New Email') ?></th>
                                <th><?= __('Password Token Expires') ?></th>
                                <th><?= __('Email Token Expires') ?></th>
                                <th><?= __('Approval Token Expires') ?></th>
                                <th><?= __('Last Name') ?></th>
                                <th><?= __('First Name') ?></th>
                                <th><?= __('Academic Title') ?></th>
                                <th><?= __('About') ?></th>
                                <th><?= __('Created') ?></th>
                                <th><?= __('Modified') ?></th>
                                <th><?= __('Mail List') ?></th>
                                <th class="actions"><?= __('Actions') ?></th>
                            </tr>
                            <?php foreach ($country->users as $users) : ?>
                                <tr>
                                    <td><?= h($users->id) ?></td>
                                    <td><?= h($users->user_role_id) ?></td>
                                    <td><?= h($users->country_id) ?></td>
                                    <td><?= h($users->institution_id) ?></td>
                                    <td><?= h($users->university) ?></td>
                                    <td><?= h($users->email) ?></td>
                                    <td><?= h($users->shib_eppn) ?></td>
                                    <td><?= h($users->password) ?></td>
                                    <td><?= h($users->email_verified) ?></td>
                                    <td><?= h($users->active) ?></td>
                                    <td><?= h($users->approved) ?></td>
                                    <td><?= h($users->is_admin) ?></td>
                                    <td><?= h($users->user_admin) ?></td>
                                    <td><?= h($users->last_login) ?></td>
                                    <td><?= h($users->password_token) ?></td>
                                    <td><?= h($users->email_token) ?></td>
                                    <td><?= h($users->approval_token) ?></td>
                                    <td><?= h($users->new_email) ?></td>
                                    <td><?= h($users->password_token_expires) ?></td>
                                    <td><?= h($users->email_token_expires) ?></td>
                                    <td><?= h($users->approval_token_expires) ?></td>
                                    <td><?= h($users->last_name) ?></td>
                                    <td><?= h($users->first_name) ?></td>
                                    <td><?= h($users->academic_title) ?></td>
                                    <td><?= h($users->about) ?></td>
                                    <td><?= h($users->created) ?></td>
                                    <td><?= h($users->modified) ?></td>
                                    <td><?= h($users->mail_list) ?></td>
                                    <td class="actions">
                                        <?= $this->Html->link(__('View'), ['controller' => 'Users', 'action' => 'view', $users->id]) ?>
                                        <?= $this->Html->link(__('Edit'), ['controller' => 'Users', 'action' => 'edit', $users->id]) ?>
                                        <?= $this->Form->postLink(__('Delete'), ['controller' => 'Users', 'action' => 'delete', $users->id], ['confirm' => __('Are you sure you want to delete # {0}?', $users->id)]) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>