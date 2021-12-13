<p></p>
<h2><span class="glyphicon glyphicon-flag"></span>&nbsp;&nbsp;&nbsp;Needs attention</h2>

<div id="dashboard">

    <?= $this->Html->link(
        '<p></p><span class="glyphicon glyphicon-user"></span><br>
        Account Approval<br>' . $pendingAccountRequests . '<p></p>',
        [
            'controller' => 'users',
            'action' => 'newUsers'
        ],
        [
            'class' => 'blue button',
            'title' => 'Account Approval',
            'escape' => false
        ]
    ) ?>
    <?= $this->Html->link(
        '<p></p><span class="glyphicon glyphicon-list"></span><br>
        Course Expiry<br>' . $expiredCourses . '<p></p>',
        [
            'controller' => 'courses',
            'action' => 'expiredCourses'
        ],
        [
            'class' => 'blue button',
            'title' => 'Course Expiry',
            'escape' => false
        ]
    ) ?>
    <?= $this->Html->link(
        '<p></p><span class="glyphicon glyphicon-education"></span><br>
        Course Approval<br>' . $pendingCourseRequests . '<p></p>',
        [
            'controller' => 'courses',
            'action' => 'newCourses'
        ],
        [
            'class' => 'blue button',
            'title' => 'Course Approval',
            'escape' => false
        ]
    ) ?>
</div>