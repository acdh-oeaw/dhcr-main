<div class="index content">
    <p></p>
    <h2><span class="glyphicon glyphicon-user"></span>&nbsp;&nbsp;&nbsp;Account approval</h2>
    <div class="table-responsive">
        <table>
            <thead>
                <?php
                if($usersCount > 0) {
                    ?>
                <tr>
                    <th class="actions" align="center" style="padding: 5px">Actions</th>
                    <th align="left" style="padding: 5px">Name</th>
                    <th align="left" style="padding: 5px">Institution</th>
                    <th align="left" style="padding: 5px">Other Organisation</th>
                    <th align="left" style="padding: 5px">About</th>
                    <th align="left" style="padding: 5px">Email</th>
                    <th align="left" style="padding: 5px">Request Date</th>
                </tr>
                <?php
                }
                ?>
            </thead>
            <tbody>
                <?php foreach ($users as $key => $user) : ?>
                    <tr>
                        <td style="padding: 5px" align="center">
                            <?php
                            echo $this->Html->link(__('Details'), ['action' => 'view', $user->id]) .'<br>';
                            echo $this->Html->link(__('Approve'), ['action' => 'approve', $user->id]) .'<br>';
                            echo $this->Html->link(__('Edit'), ['action' => 'edit', $user->id]) .'<br>';
                            echo $this->Html->link(__('Delete'), ['action' => 'delete', $user->id]);
                            ?>
                        <td style="padding: 5px"><?= ucfirst($user->academic_title) .' ' .ucfirst($user->first_name) .' ' .ucfirst($user->last_name)?></td>
                        <td style="padding: 5px"><?= ($user->institution_id != null) ? h($user->institution->name) : '' ?></td>
                        <td style="padding: 5px"><?= h($user->university) ?></td>
                        <td style="padding: 5px"><?= h($user->about) ?></td>
                        <td style="padding: 5px"><?= h($user->email) ?></td>
                        <td style="padding: 5px"><?= $user->created->timeAgoInWords(['format' => 'MMM d, YYY', 'end' => '+1 year']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php
        if($usersCount == 0) {
            echo '<p>No pending account requests.</p>';
            echo '<p>You are up to date!</p>';
        }
        ?>
    </div>
</div>