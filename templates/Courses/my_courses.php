<div class="courses index content">
    <p></p>
    <h2><span class="glyphicon glyphicon-th-large"></span>&nbsp;&nbsp;&nbsp;My Courses</h2>
    <div class="table-responsive">
    <p>
    <b>Course Status</b><br>
    <font color="green">Green:</font> Actively maintained.<br>
    <font color="orange">Orange:</font> Reminder sent, course needs to be updated.<br>
    <font color="red">Red:</font> Outdated, not shown in public registry.
    </p>
        <table>
            <thead>
                <tr>
                    <th align="left" style="padding: 5px">Actions</th>
                    <th align="left" style="padding: 5px">Updated</th>
                    <th align="left" style="padding: 5px">Course Name</th>
                    <th align="left" style="padding: 5px">Education type</th>
                    <th align="left" style="padding: 5px">Institution</th>
                    <th align="left" style="padding: 5px">Department</th>
                    <th align="left" style="padding: 5px">Source URL</th>
                    
                </tr>
            </thead>
            <tbody>
                <?php foreach ($myCourses as $myCourse) : ?>
                    <tr>
                        <td style="padding: 5px">
                            <?= $this->Html->link(__('Share'), ['action' => 'view', $myCourse->id]) ?>
                            <?= $this->Html->link(__('Edit'), ['action' => 'edit', $myCourse->id]) ?>
                        </td>
                        <td style="padding: 5px" bgcolor="
                        <?php
                        if($myCourse->updated->wasWithinLast('10 Months')) {
                            echo 'green';
                        } elseif ($myCourse->updated->wasWithinLast('18 Months')) {
                            echo 'orange';
                        } else {
                            echo 'red';
                        }
                        ?>
                        "><font color="black"><?= $myCourse->updated->timeAgoInWords(['format' => 'MMM d, YYY', 'end' => '+1 year']) ?></font></td>
                        <td style="padding: 5px"><?= $this->Html->link(__($myCourse->name), ['action' => 'view', $myCourse->id]) ?>
                        <td style="padding: 5px"><?= $myCourse->course_type->name ?></td>
                        <td style="padding: 5px"><?= $myCourse->institution->name ?></td>
                        <td style="padding: 5px"><?= $myCourse->department ?></td>
                        <td style="padding: 5px"><?= $this->Html->link('Link', $myCourse->info_url) ?>
                        
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>