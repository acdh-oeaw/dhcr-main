

<div>
    <h2>User Registration</h2>

    <p>You successfully created an account!</p>
    <p>
        Please check your inbox to verify your email address before logging in.
        If the mail did not come through,
        you may send it again by clicking the button below.
    </p>
    <?= $this->Html->link('Send verification mail again', [
            'action' => 'send_email_verification',
            'controller' => 'Users'],[
            'title' => 'If you already registered, but have not verified your
                email address, click here.',
            'class' => 'small blue button']) ?>


</div>
