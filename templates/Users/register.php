
<div class="title">
    <h2>User Registration</h2>
    <p class="notice">
        You only need to register an account with the DHRC, if you are a lecturer or other academic institution member
        and want to add or curate course meta data.
        All other audience may use the publicly available content and functionality freely.
        See this <a href="https://www.youtube.com/embed/s-YsnpKCaUE">tutorial video</a> for advice
        on how to browse or filter our listed courses.
    </p>
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
