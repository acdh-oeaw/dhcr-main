<?php $this->Html->css('https://use.fontawesome.com/releases/v5.8.2/css/all.css', ['block' => true]); ?>
<div id="registration_success">
    <h2>You are successfully registered!</h2>
    <p>
        Before you can log into your dashboard,
        the following steps need to be completed to get you going.
    </p>
    <?php if (empty($user->shib_eppn)) : ?>
        <div class="status-container">
            <h3>Email Confirmation</h3>
            <?php if (!$user->email_verified) : ?>
                <span class="glyphicon glyphicon-envelope"></span>
                <p>
                    Please check your inbox!<br>
                    If the confirmation mail did not come through,
                    you may send it again by clicking the button below.
                </p>
                <?= $this->Html->link(
                    'Send confirmation mail',
                    '/users/verify_mail',
                    ['class' => 'small blue button']
                ) ?>
            <?php else : ?>
                <span class="glyphicon glyphicon-ok-circle"></span>
                <p>Your email address has been verified.</p>
            <?php endif; ?>
        </div>
    <?php else : ?>
        <div class="status-container">
            <h3>Eligibility Confirmation</h3>
            <span class="glyphicon glyphicon-ok-circle"></span>
            <p>
                As a member of an academical organisation,
                you are eligible for contributing to the DHRC.
            </p>
        </div>
    <?php endif; ?>
    <div class="status-container">
        <h3>Account Approval</h3>
        <?php if (!$user->email_verified) : ?>
            <span class="glyphicon glyphicon-minus-sign"></span>
            <p>
                After completion of the email confirmation process,
                your account will be approved by an administrator.
            </p>
        <?php else : ?>
            <span class="glyphicon glyphicon-bullhorn"></span>
            <p>
                An admin has been notified!<br>
                Once your account is ready to log in, we will let you know.
            </p>
        <?php endif; ?>
    </div>
</div>