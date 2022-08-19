<?php

use Cake\I18n\FrozenTime;
?>
<div class="statistics content">
    <p></p>
    <h2><span class="glyphicon glyphicon-scale"></span>&nbsp;&nbsp;&nbsp;Summary Statistics</h2>
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
    <table width="100%">
        <tr>
            <td colspan="3">
                <hr><br>
            </td>
        </tr>
        <tr>
            <td style="vertical-align:top" width="33%">
                <h3><span class="glyphicon glyphicon-education"></span>&nbsp;&nbsp;&nbsp;Courses</h3>
                <p></p>
                <ul>
                    <li>Total: <?= $coursesTotal ?></li>
                    <li>Total, published, not deleted: <?= $coursesAvailable ?></li>
                    <ul>
                        <li>(Archived until 30 months: <?= $coursesShortArchived ?>)</li>
                        <li>Shown in backend: <?= $coursesInBackend ?></li>
                        <li>Shown in public registry: <?= $coursesPublic ?></li>
                    </ul>
                </ul>
            </td>
            <td style="vertical-align:top" width="33%">
                <h3><span class="glyphicon glyphicon-user"></span>&nbsp;&nbsp;&nbsp;Users</h3>
                <p></p>
                <ul>
                    <li>Total: <?= $usersTotal ?></li>
                    <li>Total with conditions*: <?= $usersAvailable ?></li>
                    <ul>
                        <li>Logged in, in the last</li>
                        <ul>
                            <li>2 years: <?= $users2Years ?></li>
                            <li>1 year: <?= $users1Year ?></li>
                            <li>6 months: <?= $users6Months ?></li>
                            <li>2 months: <?= $users2Months ?></li>
                            <li>1 month: <?= $users1Month ?></li>
                        </ul>
                    </ul>
                </ul>
            </td>
            <td style="vertical-align:top" width="33%">
                <h3><span class="glyphicon glyphicon-book"></span>&nbsp;&nbsp;&nbsp;Institutions</h3>
                <p></p>
                <p>
                    Total: <?= $institutionsTotal ?><br>
                    With courses in backend: ?<br>
                    With courses in registry: ?<br>
                </p>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <hr><br>
            </td>
        </tr>
        <td style="vertical-align:top">
            <h3><span class="glyphicon glyphicon-flag"></span>&nbsp;&nbsp;&nbsp;Countries</h3>
            <p></p>
            <p>
                With courses in backend: ?<br>
                With courses in registry: ?<br>
            </p>
        </td>
        <td style="vertical-align:top">
            <h3><span class="glyphicon glyphicon-text-color"></span>&nbsp;&nbsp;&nbsp;Translations</h3>
            <p></p>
            <p>
                Total: <?= $inviteTranslationsTotal ?><br>
                Published: <?= $inviteTranslationsActive ?><br>
            </p>
        </td>
        <td style="vertical-align:top">
            <!-- <h3><span class="glyphicon glyphicon-question-sign"></span>&nbsp;&nbsp;&nbsp;FAQ Questions</h3>
            <p>
                Total: ?<br>
                Published: ?<br>
                Public: ?<br>
                Contibutor: ?<br>
                Moderator: ?<br>
            </p> -->
        </td>
        <tr>
            <td colspan="3">
                <hr><br>
            </td>
        </tr>
    </table>
    <p>*Conditions for Users: email verified, password set, approved by moderator, account not disabled.</p>
    <p><i>Note: These statistics can change at any time. For example when a user makes changes to a course or when a certain
            expiration period has exceeded.</i></p>
</div>