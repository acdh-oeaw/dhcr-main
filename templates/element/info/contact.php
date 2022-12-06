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
<h3>Administrators</h3>
<p>For technical questions or yet not moderated countries, please seek contact to the administration board.</p>
<p>Before you contact us, please check the
    <?= $this->Html->link('FAQ page', ['controller' => 'faqQuestions', 'action' => 'faqList', 'public']) ?>
    to see if your enquiry has already been answered.</p>
<?php /*
<?php
/*
foreach ($adminProfiles as $adminProfile) {
    $displayEmail = $adminProfile->email;
    $displayEmail = str_replace('@', '(at)', $displayEmail);
?>
    <div class="container">
        <div class="profile card">
            <div class="profile-body">
                <div class="profile-bio">
                    <h3><?= $adminProfile->country->name ?></h3>
                    <div class="row">
                        <div class="col-md-5 text-center">
                            <table>
                                <tr>
                                    <td style="padding: 15px" width="150px">
                                        <?php
                                        if ($adminProfile->photo_url != NULL) {
                                            echo $this->Html->Image('/uploads/user_photos/' . $adminProfile->photo_url, array('height' => '170', 'width' => '132'));
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <h2><?= $adminProfile->first_name, ' ', $adminProfile->last_name ?></h2>
                                        <p></p>
                                        <p><strong><?= $adminProfile->institution->name ?></strong><br>
                                            <strong><?= $displayEmail ?></strong>
                                        </p>
                                    </td>
                                </tr>
                            </table>
                            <?= $this->Text->autoParagraph(h($adminProfile->about)) ?>
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
*/ ?>
<div class="css-columns admins">
    <p>
        <?php
        foreach ($userAdmins as $i => $mod) {
            echo $this->Html->link(
                $mod['first_name'] . ' ' . $mod['last_name'],
                'mailto:' . $mod['email']
            );
            echo '<br>';
        }
        ?>
    </p>
</div>

<h3>Bug Report</h3>
<p>
    In case you find a bug, please file a report here:
</p>
<a class="small blue button right" href="https://github.com/hashmich/DHCR-Frontend/issues" target="_blank">Bug Report</a>