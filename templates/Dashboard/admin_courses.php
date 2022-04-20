<p></p>
<h2><span class="glyphicon glyphicon-education"></span>&nbsp;&nbsp;&nbsp;Administrate Courses</h2>
<div id="dashboard">
    <?php
    echo $this->Html->link(
        '<p></p><span class="glyphicon glyphicon-plus"></span><br>
        Add Course<p></p>',
        [
            'controller' => 'courses',
            'action' => 'add'
        ],
        [
            'class' => 'blue button',
            'title' => 'Add Course',
            'escape' => false
        ]
    );
    if ($user->user_role_id == 2) {
        echo $this->Html->link(
            '<p></p><span class="glyphicon glyphicon-th"></span><br>
            Moderated Courses<br>
            <font color="#81d41a">(&nbsp;' . $moderatedCoursesCount . '&nbsp;)</font><p></p>',
            [
                'controller' => 'courses',
                'action' => 'moderated'
            ],
            [
                'class' => 'blue button',
                'title' => 'Moderated Courses',
                'escape' => false
            ]
        );
    }
    echo $this->Html->link(
        '<p></p><span class="glyphicon glyphicon-education"></span><br>
        My Courses<br>
        <font color="#81d41a">(&nbsp;' . $myCoursesCount . '&nbsp;)</font><p></p>',
        [
            'controller' => 'courses',
            'action' => 'myCourses'
        ],
        [
            'class' => 'blue button',
            'title' => 'My Courses',
            'escape' => false
        ]
    );
    if ($user->is_admin) {
        echo $this->Html->link(
            '<p></p><span class="glyphicon glyphicon glyphicon-list-alt"></span><br>
                All Courses<br>
                <font color="#81d41a">(&nbsp;' . $allCoursesCount . '&nbsp;)</font><p></p>',
            [
                'controller' => 'courses',
                'action' => 'all'
            ],
            [
                'class' => 'blue button',
                'title' => 'All Courses',
                'escape' => false
            ]
        );
    }
    ?>
</div>