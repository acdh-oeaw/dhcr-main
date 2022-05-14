<p></p>
<h2><span class="glyphicon glyphicon-question-sign"></span>&nbsp;&nbsp;&nbsp;Help</h2>
<div id="dashboard">
    <?php
    echo $this->Html->link(
        '<p></p><span class="glyphicon glyphicon-tag"></span><br>
        Contributor FAQ<p>&nbsp;</p>',
        [
            'controller' => 'help',
            'action' => 'contributorFaq'
        ],
        [
            'class' => 'blue button',
            'title' => 'Contributor FAQ',
            'escape' => false
        ]
    );
    if ($user->user_role_id == 2 || $user->is_admin) {
        echo $this->Html->link(
            '<p></p><span class="glyphicon glyphicon-tags"></span><br>
            Moderator FAQ<p>&nbsp;</p>',
            [
                'controller' => 'help',
                'action' => 'moderatorFaq'
            ],
            [
                'class' => 'blue button',
                'title' => 'Moderator FAQ',
                'escape' => false
            ]
        );
    }
    ?>
</div>