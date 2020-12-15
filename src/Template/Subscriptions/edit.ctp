<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Subscription $subscription
 */
?>
<?php $this->start('title'); ?>
<div class="title">
    <p>
        <?php
        if($isNew) {
            echo 'Please complete your subscription and submit the form below,
            to set up some filters for only those courses you are interested in.
            Setting no filters will keep your informed about all new courses.';
            echo '<br>';
            echo 'You can later on manage your subscription at any time by accessing this page again.';
        }else{
            echo 'Edit your subscription.';
        }
        ?>
    </p>
    <p>
        To completely revoke your subscription, please click here:<br>
        <?= $this->Html->link('Delete my subscription',
            '/subscriptions/delete/'.$subscription->confirmation_key,
            ['confirm' => 'Are you sure to delete your subscription?']) ?>
    </p>
</div>
<?php $this->end(); ?>

<div class="subscriptions-form">
    <?= $this->Form->create($subscription) ?>
    <fieldset class="invisible">
        <?php
        echo $this->Form->control('email', ['readonly' => true]);
        echo $this->Form->control('country_id', [
            'empty' => '- Where are you from? (optional) -']);
        ?>
    </fieldset>
    <fieldset class="invisible">
        <?php
        echo '<div class="input radio">';
        echo '<label>Presence</label>';
        echo '<div class="radio-inline">';
        echo $this->Form->radio('online_course', [
            '0' => 'campus',
            '1' => 'online',
            'NULL' => 'both'
        ], ['value' => 'NULL']);
        echo '</div></div>';

        echo $this->element('dropdown_checkbox', ['fieldname' => 'course_types._ids']);
        echo $this->element('dropdown_checkbox', ['fieldname' => 'languages._ids']);

        echo $this->element('dropdown_checkbox', ['fieldname' => 'countries._ids']);
        echo $this->element('dropdown_checkbox', ['fieldname' => 'disciplines._ids']);
        echo $this->element('dropdown_checkbox', ['fieldname' => 'tadirah_objects._ids']);
        echo $this->element('dropdown_checkbox', ['fieldname' => 'tadirah_techniques._ids']);
        ?>
    </fieldset>

    <?= $this->Form->submit('Submit', array(
        'class' => 'small blue button right',
    )) ?>
    <?= $this->Form->end() ?>
</div>
