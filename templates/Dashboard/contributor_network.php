<p></p>
<h2><span class="glyphicon glyphicon-user"></span>&nbsp;&nbsp;&nbsp;Contributor Network</h2>

<div id="dashboard">

    <?= $this->Html->link(
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
    ) ?>
    <?= $this->Html->link(
        '<p></p><span class="glyphicon glyphicon-cog"></span><br>
        Administrate Users<br>' . $totalUsers . '<p></p>',
        [
            'controller' => 'users',
            'action' => 'index'
        ],
        [
            'class' => 'blue button',
            'title' => 'Administrate Users',
            'escape' => false
        ]
    ) ?>
</div>