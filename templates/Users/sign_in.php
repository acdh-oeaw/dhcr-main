<?php use Cake\Routing\Router;

$this->set('bodyClasses', 'login'); ?>

<div id="classicLogin" style="display:none" class="loginAlternative">
    <h2>Classic Login</h2>
    <p>
        Use your e-mail address and DHRC password to log in. <br>
        Reset your password if you forgot it or never set one.
    </p>
    <p>
        If you do not have a DHCR account and were not able to log in using the federated login,
        please use our <?= $this->Html->link('registration form', '/users/register') ?>.
    </p>
    <div class="users form">
        <?= $this->Form->create() ?>

        <?= $this->Form->control('email') ?>
        <?= $this->Form->control('password') ?>

        <?= $this->Form->button(__('Login'), ['class' => 'right']); ?>
        <?= $this->Form->end() ?>
    </div>

    <div id="login-alternatives">
        <?= $this->Html->link('Reset Password', '/users/reset_password', ['class' => 'button small']) ?>
        <?= $this->Html->link('Federated Login', '/users/sign-in/#idpSelect', [
            'class' => 'blue button small',
            'id' => 'federatedLogin']) ?>
    </div>
</div>

<?php
if($idpTarget) {
    echo '<div id="idpSelect" class="loginAlternative"></div>';
    $this->Html->script(['idp_select/IdpSelector.js',
        'idp_select/TypeAhead.js',
        'js_cookie'
    ],['block' => true]);
    $this->Html->scriptStart(['block' => true]); ?>
    $('#federatedLogin').click(function(e) {
        e.preventDefault()
        $('.loginAlternative').toggle()
    }.bind(this))
    let IdpSelectorClass = new IdpSelector('#idpSelect',
        '<?= $idpTarget ?>',
        '<?= Router::url("/js/idp_select/DiscoFeed.json") ?>');
    <?php $this->Html->scriptEnd();
}else{
    $this->Html->scriptStart(['block' => true]); ?>
    $('#classicLogin').css({display:'block'})
    $('#federatedLogin').css({display:'none'})
    <?php $this->Html->scriptEnd();
}
?>


