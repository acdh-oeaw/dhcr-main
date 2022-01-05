<div class="index content">
    <p>&nbsp;</p>
    <h3><span class="glyphicon glyphicon-user">&nbsp;</span><?= __('New Courses') ?></h3>
    <p>&nbsp;</p>
    <?= $this->Html->link(__('Back to Needs attention'), ['controller' => 'Users', 'action' => 'needsAttention'], ['class' => 'side-nav-item']) ?>
    <p>&nbsp;</p>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th class="actions" align="left" style="padding: 5px"><?= __('Actions') ?></th>
                    <th align="left" style="padding: 5px">Updated</th>
                    <th align="left" style="padding: 5px">Course name</th>
                    <th align="left" style="padding: 5px">Education type</th>
                    <th align="left" style="padding: 5px">Institution</th>
                    <th align="left" style="padding: 5px">Department</th>
                    <th align="left" style="padding: 5px">External link</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($courses as $course) : ?>
                    <tr>
                        <td style="padding: 5px"><?= 'Share Approve Edit Revalidate' //$this->Html->link(__($institution->name), ['action' => 'view', $institution->id]) 
                                                    ?>
                        <td style="padding: 5px"><?= $course->created->timeAgoInWords(['format' => 'MMM d, YYY', 'end' => '+1 year']) ?></td>
                        <td style="padding: 5px"><?= h($course->name) ?></td>
                        <td style="padding: 5px"><?= 'Educ.type' ?></td>
                        <td style="padding: 5px"><?= h($course->institution->name) ?></td>
                        <td style="padding: 5px"><?= h($course->department) ?></td>
                        <td style="padding: 5px"><?= 'url' // $course->info_url ?></td>
                        <td style="padding: 5px"></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>