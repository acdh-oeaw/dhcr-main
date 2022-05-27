<div class="users index content">
    <p></p>
    <h2><span class="glyphicon glyphicon-<?= $users_icon ?>"></span>&nbsp;&nbsp;&nbsp;<?= $users_view_type ?></h2>
    <div class="table-responsive">
        <?php
        if ($usersCount == 0) {
            if ($users_view_type == 'Account Approval') {
                echo '<p>No pending account requests.</p>';
                echo '<p>You are up to date!</p>';
            } else {
                echo '<p>No users found.</p>';
            }
        }
        ?>
        <table>
            <thead>
                <?php if ($usersCount > 0) { ?>
                    <tr>
                        <th class="actions" align="center" style="padding: 5px">Actions</th>
                        <th align="left" style="padding: 5px"><?= $this->Paginator->sort('last_name') ?></th>
                        <th align="left" style="padding: 5px"><?= $this->Paginator->sort('first_name') ?></th>
                        <th align="left" style="padding: 5px"><?= $this->Paginator->sort('email') ?></th>
                        <?php
                        if ($user->is_admin) {
                            echo '<th align="left" style="padding: 5px">' . $this->Paginator->sort('active') . '</th>';
                        } ?>
                        <th align="left" style="padding: 5px">Institution</th>
                        <th align="left" style="padding: 5px">Other Organisation</th>
                        <th align="left" style="padding: 5px">About</th>
                        <?php if ($users_view_type == 'Account Approval') { ?>
                            <th align="left" style="padding: 5px">Request Date</th>
                        <?php } ?>
                    </tr>
                <?php } ?>
            </thead>
            <tbody>
                <?php foreach ($users as $listedUser) : ?>
                    <tr>
                        <td style="padding: 5px" align="center">
                            <?php
                            if ($users_view_type == 'Account Approval') {
                                echo $this->Html->link(__('Approve'), ['action' => 'approve', $listedUser->id]) . '<br>';
                            }
                            echo $this->Html->link(__('View'), ['action' => 'view', $listedUser->id]) . '<br>';
                            echo $this->Html->link(__('Edit'), ['action' => 'edit', $listedUser->id]) . '<br>';
                            ?>
                        <td style="padding: 5px"><?= ucfirst($listedUser->last_name) ?></td>
                        <td style="padding: 5px"><?= ucfirst($listedUser->first_name) ?></td>
                        <td style="padding: 5px"><?= h($listedUser->email) ?></td>
                        <?php
                        if ($user->is_admin) {
                            echo '<th align="left" style="padding: 5px">';
                            if ($listedUser->active) {
                                echo '<font color="green">Yes</font>';
                            } else {
                                echo '<font color="red">No</font>';
                            }
                            echo '</th>';
                        }
                        ?>
                        <td style="padding: 5px"><?= ($listedUser->institution_id != null) ? h($listedUser->institution->name) : '' ?></td>
                        <td style="padding: 5px"><?= h($listedUser->university) ?></td>
                        <?php
                        if (strlen($listedUser->about) >= 150) {
                            $about = substr($listedUser->about, 0, 145) . '.....';
                        } else {
                            $about = $listedUser->about;
                        }
                        ?>
                        <td style="padding: 5px"><?= h($about) ?></td>
                        <?php if ($users_view_type == 'Account Approval') { ?>
                            <td style="padding: 5px"><?= $listedUser->created->timeAgoInWords(['format' => 'MMM d, YYY', 'end' => '+1 year']) ?></td>
                        <?php } ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <?= $this->Paginator->first('<< ' . __('first')) ?>
        <?= $this->Paginator->prev('< ' . __('previous')) ?>
        <?= $this->Paginator->numbers() ?>
        <?= $this->Paginator->next(__('next') . ' >') ?>
        <?= $this->Paginator->last(__('last') . ' >>') ?>
        <p>&nbsp;</p>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>