<div class="title">
    <?php
    if ($isNew) {
        echo '<h2>Complete your Course Alert</h2>';
        echo '<p>Please complete your course alert and submit the form below to set up filters. Stay informed about 
        new DH courses of your interest.';
        echo '<ul><li>Setting no filters will keep your informed about all new courses. You still have to submit the form.</li>';
        echo '<li>You can manage your course alert at any time by accessing this page again.</li></ul></p>';
    } else {
        echo '<h2>Edit your Course Alert.</h2>';
        echo '<p>Update your course alert settings to stay informed about new DH courses of your interest.</p>';
    }
    ?>
    <p>
        To completely revoke your course alert, please click here: 
        <?= $this->Html->link(
            'Delete my course alert',
            '/subscriptions/delete/' . $subscription->confirmation_key,
            ['confirm' => 'Are you sure to delete your course alert?']
        ) ?>
    </p><p>&nbsp;</p>
</div>
<div class="subscriptions-form">
    <?= $this->Form->create($subscription) ?>
    <fieldset class="invisible">
        <?php
        echo $this->Form->control('email', ['readonly' => true]);
        echo $this->Form->control('country_id', [
            'empty' => '- Where are you from? (optional) -'
        ]);
        ?>
    </fieldset>
    <fieldset class="invisible">
        <?php
        echo '<div class="input radio">';
        echo '<label>Presence</label>';
        echo '<div class="radio-inline">';
        $options = [];
        if (!isset($subscription->online_course)) $options = ['value' => 'NULL'];
        echo $this->Form->radio('online_course', [
            '0' => 'campus',
            '1' => 'online',
            'NULL' => 'both'
        ], $options);
        echo '</div></div>';
        echo $this->element('dropdown_checkbox', ['fieldname' => 'course_types._ids']);
        echo $this->element('dropdown_checkbox', ['fieldname' => 'languages._ids']);
        echo $this->element('dropdown_checkbox', ['fieldname' => 'countries._ids']);
        echo $this->element('dropdown_checkbox', ['fieldname' => 'disciplines._ids']);
        echo $this->element('dropdown_checkbox', ['fieldname' => 'tadirah_objects._ids', 'label' => 'Objects']);
        echo $this->element('dropdown_checkbox', ['fieldname' => 'tadirah_techniques._ids', 'label' => 'Techniques']);
        ?>
    </fieldset>
    <p>
    <?= $this->Form->submit('Submit Preferences', array(
        'class' => 'small blue button',
    )) ?>
    <?= $this->Form->end() ?>
</div>