<div class="row">
    <p></p>
    <h2><span class="glyphicon glyphicon-cog"></span>&nbsp;&nbsp;&nbsp;Edit Profile</h2>
    <div class="column-responsive column-80">
        <div class="users form content">
            <?= $this->Form->create($user) ?>
            <fieldset>
                <legend><?= __('Edit Profile') ?></legend>
                <?php
                echo $this->Form->control('academic_title');
                echo $this->Form->control('first_name', ['label' => 'First Name*']);
                echo $this->Form->control('last_name', ['label' => 'Last Name*']);
                echo $this->Form->control('institution_id', ['label' => 'Institution*']);
                echo $this->Form->control('about', ['label' => 'About Me']);
                ?>
            </fieldset>
            <p>&nbsp;</p>
            <?= $this->Form->button(__('Update Profile')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>