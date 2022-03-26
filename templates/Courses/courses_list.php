<div class="courses index content">
    <p></p>
    <h2><span class="glyphicon glyphicon-<?=$course_icon?>"></span>&nbsp;&nbsp;&nbsp;<?=$course_view_type?></h2>
    <div class="table-responsive">
    <?php
    if( in_array($course_view_type, ['Course Expiry', 'My Courses', 'Moderated Courses', 'All Courses']) ) {
    ?>
    <p>
    <strong><u>Course Status</u></strong><br>
    <font color="green">Green:</font> Actively maintained<br>
    <font color="orange">Yellow:</font> Reminder sent, course needs to be updated<br>
    <font color="red">Red:</font> Outdated, not shown in public registry
    </p>
    <?php
    }
    if($coursesCount == 0) {
        echo '<p>No courses in this list.</p>';
        if($course_view_type == 'My Courses') {
            echo '<p>Click ' .$this->Html->link(__('here'), ['action' => 'add']) .' to add one.</p>';
        }
        if($course_view_type == 'Course Approval') {
            echo '<p>You are up to date!</p>';
        }
    } else {
        echo '<p><strong><u>Sorting Order</u></strong><br> ';
        switch($course_view_type) {
            case 'Course Expiry':
                echo 'Most outdated course first';
                break;
            case 'My Courses':
                echo 'Course Name';
                break;
            case 'Moderated Courses':
            case 'All Courses':
                echo 'Institution, Course Name';
                break;
            case 'Course Approval':
                echo 'Most recent added course';
                break;
            }
        echo '</p>';
    }
    ?>
    </p>
        <table>
            <?php if($coursesCount > 0 ) { ?>
            <thead>
                <tr>
                    <th align="center" style="padding: 5px">Actions</th>
                    <th align="left" style="padding: 5px">Updated</th>
                    <th align="left" style="padding: 5px">Active</th>
                    <th align="left" style="padding: 5px">Course Name</th>
                    <th align="left" style="padding: 5px">Education Type</th>
                    <th align="left" style="padding: 5px">Institution</th>
                    <th align="left" style="padding: 5px">Department</th>
                    <th align="left" style="padding: 5px">Source URL</th>
                </tr>
            </thead>
            <?php } ?>
            <tbody>
                <?php foreach ($courses as $course) : ?>
                    <tr>
                        <td style="padding: 5px" align="center">
                            <?php
                            if($course_view_type == 'Course Approval') {
                                echo $this->Html->link(__('Approve'), ['action' => 'approve', $course->id]) .'<br>';
                            }
                            echo $this->Html->link(__('Update/Edit'), ['action' => 'edit', $course->id]) .'<br>';
                            echo $this->Html->link(__('Share'), ['action' => 'view', $course->id]);
                            ?>
                        </td>
                        <td style="padding: 5px" bgcolor="
                        <?php
                        if($course->updated->wasWithinLast('10 Months')) {
                            echo '#81d41a'; //    // 
                        } elseif ($course->updated->wasWithinLast('12 Months')) {
                            echo '#ffbf00';
                        } else {
                            echo '#ff4000';
                        }
                        ?>
                        "><font color="black"><?= $course->updated->timeAgoInWords(['format' => 'MMM d, YYY', 'end' => '+1 year']) ?></font></td>
                        <td style="padding: 5px"><?= ($course->active) ? 'Yes' : 'No' ?></td>
                        <td style="padding: 5px"><?= $this->Html->link(__($course->name), ['action' => 'view', $course->id]) ?>
                        <td style="padding: 5px"><?= $course->course_type->name ?></td>
                        <td style="padding: 5px"><?= $course->institution->name ?></td>
                        <td style="padding: 5px"><?= $course->department ?></td>
                        <td style="padding: 5px"><?= $this->Html->link('Link', $course->info_url) ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>