<p></p>
<h2><span class="glyphicon glyphicon-question-sign"></span>&nbsp;&nbsp;&nbsp;Help</h2>
<div id="dashboard">
    <?php
    /*
    echo $this->Html->link(
        '<p></p><span class="glyphicon glyphicon-education"></span><br>
        Contributor FAQ<p>&nbsp;</p>',
        [
            'controller' => 'FaqQuestions',
            'action' => 'faqList', 'contributor'
        ],
        [
            'class' => 'blue button',
            'title' => 'Contributor FAQ',
            'escape' => false
        ]
    );
    if ($user->user_role_id == 2 || $user->is_admin) {
        echo $this->Html->link(
            '<p></p><span class="glyphicon glyphicon-list-alt"></span><br>
            Moderator FAQ<p>&nbsp;</p>',
            [
                'controller' => 'FaqQuestions',
                'action' => 'faqList', 'moderator'
            ],
            [
                'class' => 'blue button',
                'title' => 'Moderator FAQ',
                'escape' => false
            ]
        );
    }
    */
    if ($user->user_role_id == 2 || $user->is_admin) {
        echo $this->Html->link(
            '<p></p><span class="glyphicon glyphicon-wrench"></span><br>
            Users, Access and Workflows<p></p>',
            [
                'controller' => 'FaqQuestions',
                'action' => 'usersAccessWorkflows'
            ],
            [
                'class' => 'blue button',
                'title' => 'Users, Access and Workflows',
                'escape' => false
            ]
        );
    }
    ?>
</div>