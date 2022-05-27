<div class="row">
    <p></p>
    <h2><span class="glyphicon glyphicon-user"></span>&nbsp;&nbsp;&nbsp;User Details</h2>
    <div class="column-responsive column-80">
        <div class="view content">
            <?= $this->Html->link(__('Edit User'), ['action' => 'edit', $viewedUser->id], ['class' => 'button float-right']) ?>
            <p></p>
            <h3><?= ucfirst($viewedUser->academic_title) . ' ' . ucfirst($viewedUser->first_name) . ' ' . ucfirst($viewedUser->last_name) ?></h3>
            <p></p>
            <strong><u>Account status</u></strong>
            <table>
                <tr>
                    <th align="left" style="padding: 5px">Email Verified:</th>
                    <td style="padding: 5px">
                        <?php
                        if ($viewedUser->email_verified) {
                            echo '<font color="green">Yes</font>';
                        } else {
                            echo '<font color="red">No</font>';
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <th align="left" style="padding: 5px">Password Set:</th>
                    <td style="padding: 5px">
                        <?php
                        if ($viewedUser->password != null) {
                            echo '<font color="green">Yes</font>';
                        } else {
                            echo '<font color="red">No</font>';
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <th align="left" style="padding: 5px">Approved:</th>
                    <td style="padding: 5px">
                        <?php
                        if ($viewedUser->approved) {
                            echo '<font color="green">Yes</font>';
                        } else {
                            echo '<font color="red">No</font>';
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <th align="left" style="padding: 5px">Active:</th>
                    <td style="padding: 5px">
                        <?php
                        if ($viewedUser->active) {
                            echo '<font color="green">Yes</font>';
                        } else {
                            echo '<font color="red">No</font>';
                        }
                        ?>
                    </td>
                </tr>
            </table>
            <p></p>
            <strong><u>Details</u></strong>
            <table>
                <tr>
                    <th align="left" style="padding: 5px">Email Address:</th>
                    <td style="padding: 5px"><?= h($viewedUser->email) ?></td>
                </tr>
                <tr>
                    <th align="left" style="padding: 5px">Contributor Mailing List:</th>
                    <td style="padding: 5px"><?= ($viewedUser->mail_list) ? 'Yes' : 'No'; ?></td>
                </tr>
                <tr>
                    <th align="left" style="padding: 5px">Institution:</th>
                    <td style="padding: 5px"><?= (isset($viewedUser->institution_id)) ? h($viewedUser->institution->name) : '<font color="red">Empty!</font>' ?></td>
                </tr>
                <tr>
                    <th align="left" style="padding: 5px">About:</th>
                    <td style="padding: 5px"><?= $this->Text->autoParagraph(h($viewedUser->about)) ?></td>
                </tr>
            </table>
            <p></p>
            <?php if ($user->is_admin) { // only admin can see user roles 
            ?>
                <strong><u>User roles</u></strong>
                <table>
                    <tr>
                        <th align="left" style="padding: 5px">Moderator:</th>
                        <td style="padding: 5px"><?= ($viewedUser->user_role_id == 2) ? 'Yes' : 'No'; ?></td>
                    </tr>
                    <tr>
                        <th align="left" style="padding: 5px">Moderated country:</th>
                        <td style="padding: 5px"><?= ($viewedUser->user_role_id == 2) ? h($viewedUser->country->name) : '-' ?></td>
                    </tr>
                    <tr>
                        <th align="left" style="padding: 5px">Admin:</th>
                        <td style="padding: 5px"><?= ($viewedUser->is_admin == 2) ? 'Yes' : 'No'; ?></td>
                    </tr>
                    <tr>
                        <th align="left" style="padding: 5px">Show as admin on contact page:</th>
                        <td style="padding: 5px"><?= ($viewedUser->user_admin == 2) ? 'Yes' : 'No'; ?></td>
                    </tr>
                </table>
            <?php } ?>
        </div>
    </div>
</div>