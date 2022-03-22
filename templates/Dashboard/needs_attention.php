<p></p>
<h2><span class="glyphicon glyphicon-flag"></span>&nbsp;&nbsp;&nbsp;Needs attention</h2>
<div id="dashboard">
    <?php
    if( $user->user_role_id == 2 || $user->is_admin ) {
        echo $this->Html->link(
            '<p></p><span class="glyphicon glyphicon-user"></span><br>
            Account Approval<br>
            <font color="#60a845">(&nbsp;' . $pendingAccountRequests . '&nbsp;)</font><p></p>',
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
        Course Expiry<br>
        <font color="#60a845">(&nbsp;' . $expiredCourses . '&nbsp;)</font><p></p>',
        [
            'controller' => 'courses',
            'action' => 'expired'
        ],
        [
            'class' => 'blue button',
            'title' => 'Course Expiry',
            'escape' => false
        ]);
    if( $user->user_role_id == 2 || $user->is_admin ) {
        echo $this->Html->link(
            '<p></p><span class="glyphicon glyphicon-education"></span><br>
            Course Approval<br>
            <font color="#60a845">(&nbsp;' . $pendingCourseRequests . '&nbsp;)</font><p></p>',
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