<div id="menu">
    <?= $this->Html->link(
        '<span class="glyphicon glyphicon-list">Everything Else</span>',
        '/subscriptions/add', [
        'class' => 'blue button',
        'title' => 'Everything Else',
        'escape' => false
    ]) ?>
    <?= $this->Html->link(
        '<span class="glyphicon glyphicon-education">Your Courses</span>',
        '/courses/my_courses', [
        'class' => 'blue button',
        'title' => 'Your Courses',
        'escape' => false
    ]) ?>
    <?= $this->Html->link(
        '<span class="glyphicon glyphicon-user">Profile Settings</span>',
        '/users/profile', [
        'class' => 'blue button',
        'title' => 'Profile Settings',
        'escape' => false
    ]) ?>
    <?= $this->Html->link(
        '<span class="glyphicon glyphicon-flag">Dashboard</span>',
        '/users/dashboard', [
        'class' => 'blue button',
        'title' => 'Dashboard',
        'escape' => false
    ]) ?>

</div>
