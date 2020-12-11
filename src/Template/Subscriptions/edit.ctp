<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Subscription $subscription
 */
?>
<?php $this->start('title'); ?>
<div class="title">
    <p>Subscribe to new courses.</p>
    <p>
        After confirmation of your e-mail address,
        you can set filters to stay informed about courses in
        disciplines, languages or countries you are interested in.
    </p>
    <p>
        In case you already did subscribe,
        you can request the confirmation mail
        here again to edit your existing subscription.
    </p>
</div>
<?php $this->end(); ?>

<div class="subscriptions-form optionals">
    <?= $this->Form->create($subscription) ?>
    <fieldset>
        <?php
        echo $this->Form->control('email', ['readonly' => true]);
        echo $this->Form->control('country_id');
        ?>
    </fieldset>
    <fieldset>
        <?php
        echo $this->Form->control('course_types._ids', ['options' => $courseTypes]);
        echo $this->Form->control('online_course');
        echo $this->Form->control('languages._ids', ['options' => $languages]);
        echo $this->Form->control('countries._ids', ['options' => $countries]);
        echo $this->Form->control('disciplines._ids', ['options' => $disciplines]);
        echo $this->Form->control('tadirah_objects._ids', ['options' => $tadirahObjects]);
        echo $this->Form->control('tadirah_techniques._ids', ['options' => $tadirahTechniques]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
