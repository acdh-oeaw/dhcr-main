<div class="courses index content">
    <p></p>
    <h2><span class="glyphicon glyphicon-<?=$course_icon?>"></span>&nbsp;&nbsp;&nbsp;<?=$course_view_type?></h2>
    <div class="table-responsive">
    <p>
    <?php
    if($course_view_type != 'Course Expiry') { ?>
    <b>Course Status</b><br>
    <font color="green">Green:</font> Actively maintained<br>
    <font color="orange">Orange:</font> Reminder sent, course needs to be updated<br>
    <font color="red">Red:</font> Outdated, not shown in public registry
    <?php } ?>
    </p>
        <table>
            <thead>
                <tr>
                    <th align="center" style="padding: 5px">Actions</th>
                    <th align="left" style="padding: 5px">Updated</th>
                    <th align="left" style="padding: 5px">Course Name</th>
                    <th align="left" style="padding: 5px">Education type</th>
                    <th align="left" style="padding: 5px">Institution</th>
                    <th align="left" style="padding: 5px">Department</th>
                    <th align="left" style="padding: 5px">Source URL</th>
                    
                </tr>
            </thead>
            <tbody>
                <?php foreach ($courses as $course) : ?>
                    <tr>
                        <td style="padding: 5px" align="center">
                            <?= $this->Html->link(__('Share'), ['action' => 'view', $course->id]) ?>
                            <?= $this->Html->link(__('Update/Edit'), ['action' => 'edit', $course->id]) ?>
                        </td>
                        <td style="padding: 5px" bgcolor="
                        <?php
                        if($course->updated->wasWithinLast('10 Months')) {
                            echo 'green';
                        } elseif ($course->updated->wasWithinLast('18 Months')) {
                            echo 'orange';
                        } else {
                            echo 'red';
                        }
                        ?>
                        "><font color="black"><?= $course->updated->timeAgoInWords(['format' => 'MMM d, YYY', 'end' => '+1 year']) ?></font></td>
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