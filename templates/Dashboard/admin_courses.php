<p></p>
<h2><span class="glyphicon glyphicon-flag"></span>&nbsp;&nbsp;&nbsp;Administrate Courses</h2>

<div id="dashboard">

    <?= $this->Html->link(
        '<p></p><span class="glyphicon glyphicon-user"></span><br>
        My Courses<br>' . $myCoursesNr . '<p></p>',
        [
            'controller' => 'courses',
            'action' => 'myCourses'
        ],
        [
            'class' => 'blue button',
            'title' => 'My Courses',
            'escape' => false
        ]
    ) ?>
    <?= $this->Html->link(
        '<p></p><span class="glyphicon glyphicon-list"></span><br>
        Moderated Courses<br>' . $moderatedCoursesNr . '<p></p>',
        [
            'controller' => 'courses',
            'action' => 'moderatedCourses'
        ],
        [
            'class' => 'blue button',
            'title' => 'Moderated Courses',
            'escape' => false
        ]
    ) ?>
</div>