<div class="row">
    <p></p>
    <h2><span class="glyphicon glyphicon-pencil"></span>&nbsp;&nbsp;&nbsp;Edit User</h2>
    <div class="column-responsive column-80">
        <p></p>
        <div class="users form content">
            <?= $this->Form->create($editUser, ["enctype" => "multipart/form-data"]) ?>
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
                    echo $this->Form->control('active', ['label' => 'User account enabled (uncheck only if the user should not be able to login)']);
                } else {
                    echo '<p></p>';
                }
                echo '<h3>Details</h3><p>';
                echo $this->Form->control('academic_title');
                echo $this->Form->control('first_name');
                echo $this->Form->control('last_name');
                if ($user->is_admin) {   // only admin can change email
                    echo $this->Form->control('email', ['label' => 'Email Address']);
                }
                echo $this->Form->control('mail_list', ['label' => 'Contributor Mailing List Subscription']);
                echo $this->Form->control('institution_id', ['options' => $institutions]);
                echo $this->Form->control('about');
                if ($user->is_admin) {   // only admin can change user roles
                    echo '<p>&nbsp;</p><h3>User roles</h3><p>';
                    echo $this->Form->control('user_role_id', ['label' => 'Moderator', 'options' => [1 => 'Old value - please change', 2 => 'Yes', 3 => 'No']]);
                    echo 'Moderated country: ';
                    echo ($editUser->user_role_id == 2) ? h($editUser->country->name) : '-';
                    echo $this->Form->control('is_admin', ['label' => 'Administrator']);
                    echo $this->Form->control('user_admin', ['label' => 'Show as admin on contact page']);
                }
                if ($user->is_admin && $editUser->user_role_id == 2) {   // only admin can change moderator profile AND only when user is a moderator
                    echo '<p>&nbsp;</p><h3>National Moderator List</h3><p></p>';
                    echo 'Below you can select if a moderator should be shown in the list of National Moderators. You can also upload a picture, 
                    which is optional. As well, the information from the following fields (which can be edited above) are shown in the list of 
                    National Moderators: First Name, Last Name, Email Address, Institution, Country (based on institution), About.<p>';
                    echo $this->Form->control('mod_profile', ['label' => 'Show this user in the National Moderators List']);
                    echo '<h4>Profile photo</h4><p></p>';
                    if (strlen($editUser->photo_url) > 0) {
                        // photo is present. show picture and delete option
                        echo $this->Html->Image('/uploads/user_photos/' . $editUser->photo_url, array('height' => '170', 'width' => '132'));
                        echo '<p></p>';
                        echo $this->Html->Link('Delete photo', ['action' => 'edit', $editUser->id, 'delete_photo']);
                    } else {
                        // photo not present. show add option with file selector
                        echo '<u>Add photo</u><br>';
                        echo '<i>The size should be: height 170 px, width 132 px. <br>Please resize the image on your device, before uploading.</i><p></p>';
                        echo $this->Form->input('photo', ['type' => 'file', 'class' => 'form-control']);
                        echo '<p></p><i>After adding a photo, click on "Update User", to save the photo.</i>';
                    }
                }
                ?>
                <p></p>
            </fieldset>
            <p>&nbsp;</p>
            <?= $this->Form->button(__('Update User')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>