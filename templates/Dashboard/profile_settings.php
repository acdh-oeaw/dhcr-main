<p></p>
<h2><span class="glyphicon glyphicon-cog"></span>&nbsp;&nbsp;&nbsp;Profile Settings</h2>
<div id="dashboard">
    <?= $this->Html->link(
        '<p></p><span class="glyphicon glyphicon-envelope"></span><br>
        Change Email Address<p></p>',
        [
            'controller' => 'users',
            'action' => 'changeEmail'
        ],
        [
            'class' => 'blue button',
            'title' => 'Change Email Address',
            'escape' => false
        ]
    ) ?>
    <?= $this->Html->link(
        '<p></p><span class="glyphicon glyphicon-pencil"></span><br>
        Sign up to the Mailing List<p></p>',
        [
            'controller' => 'users',
            'action' => 'newsletter'
        ],
        [
            'class' => 'blue button',
            'title' => 'Sign up to the Mailing List',
            'escape' => false
        ]
    ) ?>
    <?= $this->Html->link(
        '<p></p><span class="glyphicon glyphicon-eye-open"></span><br>
        Change Password<p></p>',
        [
            'controller' => 'users',
            'action' => 'changePassword'
        ],
        [
            'class' => 'blue button',
            'title' => 'Change Password',
            'escape' => false
        ]
    ) ?>
    <?= $this->Html->link(
        '<p></p><span class="glyphicon glyphicon-cog"></span><br>
        Edit Profile<p></p>',
        [
            'controller' => 'users',
            'action' => 'profile'
        ],
        [
            'class' => 'blue button',
            'title' => 'Edit Profile',
            'escape' => false
        ]
    ) ?>
</div>