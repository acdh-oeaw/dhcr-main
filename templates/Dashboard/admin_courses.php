<p></p>
<h2><span class="glyphicon glyphicon-education"></span>&nbsp;&nbsp;&nbsp;Administrate Courses</h2>

<div id="dashboard">

    <?= $this->Html->link(
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
    ) ?>
    <?= $this->Html->link(
        '<p></p><span class="glyphicon glyphicon-th"></span><br>
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
    <?= $this->Html->link(
        '<p></p><span class="glyphicon glyphicon-th-large"></span><br>
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
</div>