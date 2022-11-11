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
<p>The DHCR maintains a system of national moderators, who review newly entered courses, help with registration issues and are encouraged
    to disseminate the DHCR initiative among institutions of their countries.</p>

<?php
foreach ($moderatorProfiles as $moderatorProfile) {
    $displayEmail = $moderatorProfile->email;
    $displayEmail = str_replace('@', ' (at) ', $displayEmail);
    $displayEmail = str_replace('.', ' dot ', $displayEmail);
?>
    <div class="container">
        <div class="profile card">
            <div class="profile-body">
                <div class="profile-bio">
                    <h3><?= $moderatorProfile->country->name ?></h3>
                    <div class="row">
                        <div class="col-md-5 text-center">
                            <table>
                                <tr>
                                    <td style="padding: 15px" width="150px">
                                        <?php
                                        if ($moderatorProfile->photo_url != NULL) {
                                            echo $this->Html->Image($moderatorProfile->photo_url, array('height' => '170', 'width' => '132'));
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