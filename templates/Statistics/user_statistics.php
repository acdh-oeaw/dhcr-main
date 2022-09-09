<?php

use Cake\I18n\FrozenTime;
?>
<div class="statistics content">
    <p></p>
    <h2><span class="glyphicon glyphicon-user"></span>&nbsp;&nbsp;&nbsp;User Statistics</h2>
    <?php
    // guard against providing not accurate data
    if (env('DHCR_BASE_URL') != 'https://dhcr.clarin-dariah.eu/') {
        echo '<font color="red"><strong>';
        echo '**************************************************<br>';
        echo 'WARNING:<br>';
        echo 'You are not using the production version.<br>';
        echo 'This data is not accurate.<br>';
        echo 'Do not use this data!<br>';
        echo '**************************************************<br>';
        echo '</strong></font><br>';
    }
    $now = new FrozenTime('now');
    echo '<p><u>Data updated at: ' . $now->i18nFormat('dd-MM-yyyy HH:mm') . ' UTC</u></p>';
    ?>
    <h3>Key data</h3>
    <p>
        Total: <?= $usersTotal ?><br>
        Subcribed to mailing list: <?= $usersSubscribed ?><br>
        &nbsp;<br>
        Total available*: <?= $usersAvailable ?><br>
        Available & subcribed to mailing list: <?= $usersAvailableSubscribed ?><br>
        Available & subcribed as part of available: <?= (int) ($usersAvailableSubscribed / $usersAvailable * 100) ?>%<br>
        &nbsp;<br>
        Moderators: <?= $moderators ?><br>
        Moderators subscribed to mailing list: <?= $moderatorsSubscribed ?>
    </p>
    <h3>Logged in users within the last x months</h3>
    <p>
        <?php
        foreach ($loggedinUserCounts as $key => $loggedinUserCount) {
            echo '' . $key . ' months ago: ' . $loggedinUserCount . '<br>';
        }
        ?>
    </p>
    <h3>Logged in moderators per months ago</h3>
    <p>
        <?php
        foreach ($loggedinModeratorCounts as $key => $loggedinModeratorCount) {
            echo '' . $key . ' months ago: ' . $loggedinModeratorCount . '<br>';
        }
        ?>
    </p>
    <hr>
    *Available users meet the following criteria:
    <ol>
        <li>Email verified</li>
        <li>Password set</li>
        <li>Approved (by moderator)</li>
        <li>Account not disabled</li>
    </ol>
    <p><i>Note: These statistics can change at any time.</i></p>
</div>