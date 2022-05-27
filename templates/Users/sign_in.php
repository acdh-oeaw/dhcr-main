<?php

use Cake\Routing\Router;

$this->set('bodyClasses', 'login');
?>
<div id="classicLogin" style="display:none" class="loginAlternative">
    <h2>Login</h2>
    <ul>
        <li>Use your e-mail address and DHCR password to log in.</li>
        <li>Reset your password if you forgot it or never set one.</li>
        <li>If you do not have a DHCR account<?php // and were not able to log in using the federated login ?>, 
        please use the <?= $this->Html->link('registration form', '/users/register') ?> to create one.</li>
    </ul>
    <p class="notice">You need to login to the DHCR if you are a lecturer or other academic institution member and 
        want to add or curate course metadata. All other audience may use the publicly available content and functionality 
        freely. Watch this <a href="https://www.youtube.com/embed/s-YsnpKCaUE">video tutorial</a> to learn how to browse or 
        filter the courses in the registry.</p>
    <div class="users form">
        <?= $this->Form->create() ?>
        <?= $this->Form->control('email') ?>
        <?= $this->Form->control('password') ?>
        <?= $this->Form->button(__('Login'), ['class' => 'right']); ?>
        <?= $this->Form->end() ?>
    </div>
    <div class="login-alternatives">
        <?= $this->Html->link('Reset Password', '/users/reset_password', ['class' => 'button small']) ?>
        <?= $this->Html->link('Federated Login', '/users/sign-in/#idpSelect', [
            'class' => 'blue button small',
            'id' => 'federatedLogin'
        ]) ?>
    </div>
</div>
<?php
if ($idpTarget) {
    echo '<div id="idpSelect" class="loginAlternative"></div>';
    $this->Html->script([
        'idp_select/IdpSelector.js',
        'idp_select/TypeAhead.js',
        'js_cookie'
    ], ['block' => true]);
    $this->Html->scriptStart(['block' => true]); ?>
    $('#federatedLogin').click(function(e) {
    e.preventDefault()
    $('.loginAlternative').toggle()
    }.bind(this))
    let IdpSelectorClass = new IdpSelector('#idpSelect',
    '<?= $idpTarget ?>',
    '<?= Router::url("/js/idp_select/DiscoFeed.json") ?>');
<?php $this->Html->scriptEnd();
} else {
    $this->Html->scriptStart(['block' => true]); ?>
    $('#classicLogin').css({display:'block'})
    $('#federatedLogin').css({display:'none'})
<?php $this->Html->scriptEnd();
}
?>