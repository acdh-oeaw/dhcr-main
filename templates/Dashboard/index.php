<p></p>

<p></p>
<h2><span class="glyphicon glyphicon-star"></span>&nbsp;&nbsp;&nbsp;Dashboard</h2>
<p></p>
<div id="dashboard">
    <?= $this->Html->link(
        '<p></p><span class="glyphicon glyphicon-flag"></span><br>Needs Attention<p></p>',
        [
            'controller' => 'dashboard',
            'action' => 'needsAttention'
        ],
        [
            'class' => 'blue button',
            'title' => 'Needs Attention',
            'escape' => false
        ]
    ) ?>
    <?= $this->Html->link(
        '<p></p><span class="glyphicon glyphicon-list"></span><br>Category Lists<p></p>',
        [
            'controller' => 'Backend',
            'action' => 'categoryLists'
        ],
        [
            'class' => 'blue button',
            'title' => 'Courses',
            'escape' => false
        ]
    ) ?>
    <?= $this->Html->link(
        '<p></p><span class="glyphicon glyphicon-education"></span><br>Courses<p></p>',
        [
            'controller' => 'Courses',
            'action' => 'adminCourses'
        ],
        [
            'class' => 'blue button',
            'title' => 'Contributor Network',
            'escape' => false
        ]
    ) ?>
    <?= $this->Html->link(
        '<p></p><span class="glyphicon glyphicon-cog"></span><br>Profile Settings<p></p>',
        [
            'controller' => 'Users',
            'action' => 'profile'
        ],
        [
            'class' => 'blue button',
            'title' => 'Profile Settings',
            'escape' => false
        ]
    ) ?>
    <?= $this->Html->link(
        '<p></p><span class="glyphicon glyphicon-user"></span><br>Contributor Network<p></p>',
        [
            'controller' => 'Users',
            'action' => 'showOptions'
        ],
        [
            'class' => 'blue button',
            'title' => 'Contributor Network',
            'escape' => false
        ]
    ) ?>

</div>