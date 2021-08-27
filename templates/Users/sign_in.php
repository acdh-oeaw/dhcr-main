<?php use Cake\Routing\Router;

$this->set('bodyClasses', 'login'); ?>




<div id="idpSelect"></div>

<div id="classicLogin">
    <h2>Classic Login</h2>
    <p>
        Use your e-mail address and DHRC password to log in. <br>
        Reset your password if you forgot it or never set one.
    </p>
    <div class="users form">
        <?= $this->Form->create() ?>

        <?= $this->Form->control('email') ?>
        <?= $this->Form->control('password') ?>

        <?= $this->Form->button(__('Login'), ['class' => 'right']); ?>
        <?= $this->Form->end() ?>
    </div>

    <div id="login-alternatives">
        <?= $this->Html->link('Reset Password', '/users/reset_password', ['class' => 'blue button small']) ?>
        <?= $this->Html->link('Registration', '/users/register', ['class' => 'small button']) ?>
        <?= $this->Html->link('Federated Login', '/users/signIn/#idpSelect', ['class' => 'blue button small']) ?>
    </div>
</div>


<?php $this->Html->script(['idp_select/IdpSelector.js','idp_select/TypeAhead.js'], ['block' => true]); ?>
<?php $this->Html->scriptStart(['block' => true]); ?>
let IdpSelectorClass = new IdpSelector('#idpSelect',
    '<?= $idpTarget ?>',
    '<?= Router::url("/js/idp_select/DiscoFeed.json") ?>');
<?php $this->Html->scriptEnd(); ?>


