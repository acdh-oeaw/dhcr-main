<p></p>
<h2><span class="glyphicon glyphicon-user"></span>&nbsp;&nbsp;&nbsp;Contributor Network</h2>
<div id="dashboard">
    <?php
    echo $this->Html->link(
        '<p></p><span class="glyphicon glyphicon-plus"></span><br>
        Invite User<p></p>',
        [
            'controller' => 'users',
            'action' => 'invite'
        ],
        [
            'class' => 'blue button',
            'title' => 'Invite User',
            'escape' => false
        ]
    );
    if ($user->user_role_id == 2) {
        echo $this->Html->link(
            '<p></p><span class="glyphicon glyphicon-user"></span><br>
            Moderated Users<br>
            <font color="#81d41a">(&nbsp;' . $moderatedUsersCount . '&nbsp;)</font><p></p>',
            [
                'controller' => 'users',
                'action' => 'moderated'
            ],
            [
                'class' => 'blue button',
                'title' => 'Moderated Users',
                'escape' => false
            ]
        );
    }
    if ($user->is_admin) {
        echo $this->Html->link(
            '<p></p><span class="glyphicon glyphicon-user"></span><br>
            All Users<br>
            <font color="#81d41a">(&nbsp;' . $allUsersCount . '&nbsp;)</font><p></p>',
            [
                'controller' => 'users',
                'action' => 'all'
            ],
            [
                'class' => 'blue button',
                'title' => 'All Users',
                'escape' => false
            ]
        );
    }
    ?>
</div>