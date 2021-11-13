<?php
$user = $this->Identity->get();
?>

<h2>Dashboard</h2>

<div id="dashboard">

    <div id="user-info">
        <p>
            Logged in as<br>
            <?= trim($user->academic_title.' '.$user->first_name.' '.$user->last_name) ?>
        </p>
        <p>
            <?= (!empty($user)) ? $user->user_role->name : '' ?>
            <?= ($user->user_role_id == 2) ? 'of<br>' . $user->country->name : null ?>
        </p>
        <?= ($user->is_admin) ? '<p>Admin: Yes</p>' : null ?>
        <?= ($user->user_admin) ? '<p>User-Admin: Yes</p>' : null ?>
    </div>

    <?= $this->Html->link(
        '<span class="glyphicon glyphicon-user">Profile Settings</span>',
        '/users/profile', [
        'class' => 'blue button',
        'title' => 'Profile Settings',
        'escape' => false
    ]) ?>
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
        '<span class="glyphicon glyphicon-flag">Dashboard</span>',
        '/users/dashboard', [
        'class' => 'blue button',
        'title' => 'Dashboard',
        'escape' => false
    ]) ?>

</div>
