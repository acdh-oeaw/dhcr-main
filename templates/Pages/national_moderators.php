<style>
    .card {
        -moz-border-radius: 2%;
        -webkit-border-radius: 2%;
        border-radius: 2%;
        box-shadow: 5px 5px 0 rgba(0, 0, 0, 0.08);
    }

    .profile .profile-body {
        padding: 20px;
        background: #f7f7f7;
    }

    .profile .profile-bio {
        background: #fff;
        position: relative;
        padding: 15px 10px 5px 15px;
    }

    .profile .profile-bio a {
        left: 50%;
        bottom: 20px;
        margin: -62px;
        text-align: center;
        position: absolute;
    }

    .profile .profile-bio h2 {
        margin-top: 0;
        font-weight: 200;
    }
</style>
<h1>National Moderators</h1>
<p></p>
<p>
    The course entries in the DH registry are moderated by a group of national moderators who review and approve
    newly entered courses, provide assistance with registration issues and disseminate the DHCR activities among
    the institutions of their countries.
</p>
<p>
    In case there is no moderator listed for your country, please contact one of
    <?= $this->Html->link('the administrators', ['controller' => 'Pages', 'action' => 'info', '#' => 'contact']) ?>
    if you have any questions.
</p>

<?php
foreach ($moderatorProfiles as $moderatorProfile) {
    $displayEmail = $moderatorProfile->email;
    $displayEmail = str_replace('@', '(at)', $displayEmail);
?>
    <div class="container">
        <div class="profile card">
            <div class="profile-body">
                <div class="profile-bio">
                    <h3><?= $moderatorProfile->country->name ?></h3>
                    <p></p>
                    <div class="row">
                        <div class="col-md-5 text-center">
                            <table>
                                <tr>
                                    <td style="padding: 15px" width="150px">
                                        <?php
                                        if ($moderatorProfile->photo_url != NULL) {
                                            echo $this->Html->Image('/uploads/user_photos/' . $moderatorProfile->photo_url, array('height' => '170', 'width' => '132'));
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <h2><?= $moderatorProfile->first_name, ' ', $moderatorProfile->last_name ?></h2>
                                        <p></p>
                                        <p><strong><?= $moderatorProfile->institution->name ?></strong><br>
                                            <strong><?= $displayEmail ?></strong>
                                        </p>
                                    </td>
                                </tr>
                            </table>
                            <?= $this->Text->autoParagraph(h($moderatorProfile->about)) ?>
                        </div>
                        <div class="col-md-7">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <p>&nbsp;</p>
<?php
}
?>