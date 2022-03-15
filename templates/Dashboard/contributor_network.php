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
        ]);
    if( $user->is_admin ) {
        echo $this->Html->link(
            '<p></p><span class="glyphicon glyphicon-user"></span><br>
            Administrate Users<br>
            <font color="#60a845">(&nbsp;' . $totalUsers . '&nbsp;)</font><p></p>',
            [
                'controller' => 'users',
                'action' => 'index'
            ],
            [
                'class' => 'blue button',
                'title' => 'Administrate Users',
                'escape' => false
        ]); 
    }
    ?>
</div>