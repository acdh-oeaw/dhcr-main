<?php
$this->set('bodyClasses', 'registration');

$name = '';
if(!empty($identity['first_name']) OR !empty('sn')) $name = '<dt>Name:</dt><dd>';
if(!empty($identity['first_name'])) $name .= $identity['first_name'].' ';
if(!empty($identity['last_name'])) $name .= $identity['last_name'];
$name = trim($name).'</dd>';

$mail = '';
if(!empty($identity['email'])) $mail = '<dt>Email:</dt><dd>'.$identity['email'].'</dd>';
if(empty($mail) AND preg_match("/^[^@]+@[^@]+\.[a-z]{2,6}$/i", $identity['shib_eppn']))
    $mail = '<dt>Email:</dt><dd>'.$identity['shib_eppn'].'</dd>';
?>

<h2>Are you new to the DHCR?</h2>

<p>
    You have been succesfully identified by an external identity provider,
    but that identity is not linked to any of our local accounts.
</p>
<p>
    Please decide, how to continue.
</p>

<?php if(!empty($name) OR !empty($mail)): ?>
<div class="notice">
    <p>We receive the following data from your provider:</p>
    <dl>
        <?= ($name) ?? '' ?>
        <?= ($mail) ?? '' ?>
    </dl>
</div>
<?php endif; ?>

<div class="grid-columns">
    <div class="grid-item">
        <p>
            Have you been using the DHCR before?
        </p>
        <p>
            To access your existing courses or moderation dashboard,
            please click here.
        </p>
        <?= $this->Html->link('Existing account', '/users/connect_identity', [
            'class' => 'blue button']) ?>
    </div>
    <div class="grid-item">
        <p>
            You are new to the DHRC.
        </p>
        <p>
            Continue with the completion of your account data.
        </p>
        <?= $this->Html->link('New account', '/users/register_identity', [
            'class' => 'button']) ?>
    </div>
</div>



