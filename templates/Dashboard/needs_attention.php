<p></p>
<h2><span class="glyphicon glyphicon-flag"></span>&nbsp;&nbsp;&nbsp;Needs attention</h2>

<div id="dashboard">
    <?php
    if( in_array($user->user_role_id, [1, 2] )) {
        echo $this->Html->link(
            '<p></p><span class="glyphicon glyphicon-user"></span><br>
            Account Approval<br>' . $pendingAccountRequests . '<p></p>',
            [
                'controller' => 'users',
                'action' => 'accountApproval'
            ],
            [
                'class' => 'blue button',
                'title' => 'Account Approval',
                'escape' => false
        ]);
    }    
    echo $this->Html->link(
        '<p></p><span class="glyphicon glyphicon-bell"></span><br>
        Course Expiry<br>' . $expiredCourses . '<p></p>',
        [
            'controller' => 'courses',
            'action' => 'expired'
        ],
        [
            'class' => 'blue button',
            'title' => 'Course Expiry',
            'escape' => false
        ]);
    if( in_array($user->user_role_id, [1, 2] )) {
        echo $this->Html->link(
            '<p></p><span class="glyphicon glyphicon-education"></span><br>
            Course Approval<br>' . $pendingCourseRequests . '<p></p>',
            [
                'controller' => 'courses',
                'action' => 'courseApproval'
            ],
            [
                'class' => 'blue button',
                'title' => 'Course Approval',
                'escape' => false
        ]);    
    }
    ?>
</div>