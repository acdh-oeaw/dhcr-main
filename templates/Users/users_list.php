<div class="users index content">
    <p></p>
    <h2><span class="glyphicon glyphicon-<?=$users_icon?>"></span>&nbsp;&nbsp;&nbsp;<?=$users_view_type?></h2>
    <div class="table-responsive">
    <?php
    if($usersCount == 0) {
        if($users_view_type == 'Account Approval') {
            echo '<p>No pending account requests.</p>';
            echo '<p>You are up to date!</p>';
        } else {
            echo '<p>No users found.</p>';
        }
    } else {
        echo '<p><strong><u>Sorting Order</u></strong><br> ';
        switch($users_view_type) {
            case 'Account Approval':
                echo 'Latest created account first';
                break;
            case 'Moderated Users':
            case 'All Users':
                echo 'Institution, User Last Name';
                break;
            }
        echo '</p>';
    }
    ?>
        <table>
            <thead>
                <?php if($usersCount > 0) { ?>
                    <tr>
                        <th class="actions" align="center" style="padding: 5px">Actions</th>
                        <th align="left" style="padding: 5px">Name</th>
                        <th align="left" style="padding: 5px">Email</th>
                        <th align="left" style="padding: 5px">Institution</th>
                        <th align="left" style="padding: 5px">Other Organisation</th>
                        <th align="left" style="padding: 5px">About</th>
                        <?php if($users_view_type == 'Account Approval') { ?>
                            <th align="left" style="padding: 5px">Request Date</th>
                        <?php } ?>
                    </tr>
                <?php } ?>
            </thead>
            <tbody>
                <?php foreach ($users as $key => $user) : ?>
                    <tr>
                        <td style="padding: 5px" align="center">
                            <?php
                            if ($users_view_type == 'Account Approval') {
                                echo $this->Html->link(__('Approve'), ['action' => 'approve', $user->id]) .'<br>';
                            }
                            echo $this->Html->link(__('View'), ['action' => 'view', $user->id]) .'<br>';
                            echo $this->Html->link(__('Edit'), ['action' => 'edit', $user->id]) .'<br>';
                            echo $this->Html->link(__('Disable'), ['action' => 'disable', $user->id]);
                            ?>
                        <td style="padding: 5px"><?= ucfirst($user->academic_title) .' ' .ucfirst($user->first_name) .' ' .ucfirst($user->last_name)?></td>
                        <td style="padding: 5px"><?= h($user->email) ?></td>
                        <td style="padding: 5px"><?= ($user->institution_id != null) ? h($user->institution->name) : '' ?></td>
                        <td style="padding: 5px"><?= h($user->university) ?></td>
                        <?php
                        if(strlen($user->about) >= 150) {
                            $about = substr($user->about, 0, 145) .'.....';
                        } else {
                            $about = $user->about;
                        }
                        ?>
                        <td style="padding: 5px"><?= h($about) ?></td>
                        <?php if($users_view_type == 'Account Approval') { ?>
                            <td style="padding: 5px"><?= $user->created->timeAgoInWords(['format' => 'MMM d, YYY', 'end' => '+1 year']) ?></td>
                        <?php } ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>