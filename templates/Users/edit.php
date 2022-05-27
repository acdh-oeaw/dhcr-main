<div class="row">
    <p></p>
    <h2><span class="glyphicon glyphicon-pencil"></span>&nbsp;&nbsp;&nbsp;Edit User</h2>
    <div class="column-responsive column-80">
        <p></p>
        <div class="users form content">
            <?= $this->Form->create($editUser) ?>
            <fieldset>
                <legend><?= ucfirst($editUser->academic_title) . ' ' . ucfirst($editUser->first_name) . ' ' . ucfirst($editUser->last_name) ?></legend>
                <p>
                <h3>Account Status</h3>
                </p>
                Email Verified: <font color=" <?= ($editUser->email_verified) ? 'green">Yes' : 'red">No' ?></font><br>
                Password Set: <font color=" <?= ($editUser->password != null) ? 'green">Yes' : 'red">No' ?></font><br>
                    Approved: <font color=" <?= ($editUser->approved) ? 'green">Yes</font>' : 'red">No</font>' ?><br>
                <?php
                if ($user->is_admin) {   // only admin can disable user
                    echo $this->Form->control('active');
                } else {
                    echo '<p></p>';
                }
                echo '<h3>Details</h3><p>';
                echo $this->Form->control('academic_title');
                echo $this->Form->control('first_name');
                echo $this->Form->control('last_name');
                if ($user->is_admin) {   // only admin can change email
                    echo $this->Form->control('email');
                }
                echo $this->Form->control('mail_list', ['label' => 'Contributor Mailing List']);
                echo $this->Form->control('institution_id', ['options' => $institutions]);
                echo $this->Form->control('about');
                if ($user->is_admin) {   // only admin can change user roles
                    echo '<h3>User roles</h3><p>';
                    echo $this->Form->control('user_role_id', ['label' => 'Moderator', 'options' => [1 => 'Old value - please change', 2 => 'Yes', 3 => 'No']]);
                    echo 'Moderated country: ';
                    echo ($editUser->user_role_id == 2) ? h($editUser->country->name) : '-';
                    echo $this->Form->control('is_admin', ['label' => 'Administrator']);
                    echo $this->Form->control('user_admin', ['label' => 'Show as admin on contact page']);
                }
                ?>
            </fieldset>
            <p>&nbsp;</p>
            <?= $this->Form->button(__('Update User')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>