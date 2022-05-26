<p>National moderators, lecturers or programme directors who add or curate course metadata 
    are invited to join our contributor mailing list to stay informed about the latest developments. 
    If you do not have an account yet, please register first.</p>
<div class="buttons">
    <?= $this->Html->link(
        'Sign up to the Mailing List',
        ['controller' => 'Users', 'action' => 'newsletter'],
        ['class' => 'button', 'id' => 'login-button']
    ) ?>
    <?= $this->Html->link(
        'Register',
        ['controller' => 'Users', 'action' => 'register'],
        ['class' => 'blue button', 'id' => 'register-button']
    ) ?>
</div>