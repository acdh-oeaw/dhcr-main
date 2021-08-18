
<div class="title">
    <h2>User Registration</h2>
    <p>
        Open an account as a lecturer, programme director or national moderator.<br>
        After registration, you will be able to add your courses to the registry.
    </p>
    <p>
        Only register for an account, if your institution is not present on the federated login page.
    </p>
    <?= $this->Html->link('Federated Login', '/users/signIn/#idpSelect', ['class' => 'blue button small']) ?>
</div>


<div class="users form content">
    <?= $this->Form->create() ?>

    <?= $this->Form->control('email') ?>
    <?= $this->Form->control('password') ?>

    <?= $this->Form->button(__('Register'), ['class' => 'right']); ?>
    <?= $this->Form->end() ?>
</div>
