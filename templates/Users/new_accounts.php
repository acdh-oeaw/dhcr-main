<div class="institutions index content">
    <p>&nbsp;</p>
    <h3><span class="glyphicon glyphicon-user">&nbsp;</span><?= __('New Account Requests') ?></h3>
    <p>&nbsp;</p>
    <?= $this->Html->link(__('Back to Need attention'), ['action' => 'attention'], ['class' => 'side-nav-item']) ?>
    <p>&nbsp;</p>
    <div class="table-responsive">
        <table <thead>
            <tr>
                <th class="actions" align="left" style="padding: 5px"><?= __('Actions') ?></th>
                <th align="left" style="padding: 5px">Name</th>
                <th align="left" style="padding: 5px">Institution</th>
                <th align="left" style="padding: 5px">New institution?</th>
                <th align="left" style="padding: 5px">About</th>
                <th align="left" style="padding: 5px">Email</th>
                <th align="left" style="padding: 5px">Request Date</th>
            </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $key => $user) : ?>
                    <tr>
                        <td style="padding: 5px"><?= 'Edit Approve Delete' //$this->Html->link(__($institution->name), ['action' => 'view', $institution->id]) 
                                                    ?>
                        <td style="padding: 5px"><?= h($user->academic_title . ' ' . $user->first_name . ' ' . $user->last_name) ?></td>
                        <td style="padding: 5px"><?= ($user->institution_id != null) ? h($user->institution->name) : '' ?></td>
                        <td style="padding: 5px"><?= h($user->university) ?></td>
                        <td style="padding: 5px"><?= h($user->about) ?></td>
                        <td style="padding: 5px"><?= h($user->email) ?></td>
                        <td style="padding: 5px"><?= $user->created->timeAgoInWords(['format' => 'MMM d, YYY', 'end' => '+1 year']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>