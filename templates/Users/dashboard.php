<p></p>
<?php
// *** Begin Breadcrums
// Home
echo $this->Html->link(__('Home'), ['controller' => 'Courses', 'action' => 'index'], ['class' => 'side-nav-item']);
echo ' / ';
// First depth
echo $this->Html->link(__('Dashboard'), ['controller' => 'Users', 'action' => 'dashboard'], ['class' => 'side-nav-item']);
// *** End Breadcrums
echo '<p></p>';
// Welcome user
echo 'Hello ' . ucfirst(trim($user->academic_title)) . ' ' . ucfirst(trim($user->first_name)) . ' ' . ucfirst(trim($user->last_name))
    . ', thanks for contributing to the DHCR as <strong><font color="black"> ';
switch ($user->user_role_id) {
    case 1:
        echo 'administrator.';
        break;
    case 2:
        echo 'moderator</font></strong> of  <strong><font color="black">' . $user->country->name . '.';
        break;
    case 3:
        echo 'contributor.';
        break;
}
echo '</font></strong>';
?>
<p></p>
<h2><span class="glyphicon glyphicon-star"></span>&nbsp;&nbsp;&nbsp;Dashboard</h2>
<p></p>
<div id="dashboard">
    <?= $this->Html->link(
        '<p></p><span class="glyphicon glyphicon-flag"></span><br>Needs Attention<p></p>',
        [
            'controller' => 'users',
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