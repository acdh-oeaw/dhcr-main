<?php

use Cake\I18n\FrozenTime;
?>
<div class="statistics content">
    <p></p>
    <h2><span class="glyphicon glyphicon-stats"></span>&nbsp;&nbsp;&nbsp;Summary Statistics</h2>
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
    echo '<p><u>Data updated at: ' . $now->i18nFormat('yyyy-MM-dd HH:mm') . ' UTC</u></p>';
    ?>
    <table width="100%">
        <tr>
            <td colspan="3">
                <hr><br>
            </td>
        </tr>
        <tr>
            <td style="vertical-align:top" width="33%">
                <h3><span class="glyphicon glyphicon-education"></span>&nbsp;&nbsp;&nbsp;
                    <?= $this->Html->link('Courses', ['controller' => 'Statistics', 'action' => 'courseStatistics']) ?>
                </h3>
                <p></p>
                <ul>
                    <li>Total: <?= $coursesTotal ?></li>
                    <li>In backend & published: <?= $coursesBackend ?></li>
                    <li>Public visible: <?= $coursesPublic ?><br></li>
                    <li>Public as part of backend: <?= (int) ($coursesPublic / $coursesBackend * 100) ?>%</li>

                </ul>
            </td>
            <td style="vertical-align:top" width="33%">
                <h3><span class="glyphicon glyphicon-user"></span>&nbsp;&nbsp;&nbsp;
                    <?= $this->Html->link('Users', ['controller' => 'Statistics', 'action' => 'userStatistics']) ?>
                </h3>
                <p></p>
                <ul>
                    <li>Total: <?= $usersTotal ?></li>
                    <li>Total available*: <?= $usersAvailable ?></li>
                    <li>Available & subcribed mailing list: <?= $usersAvailableSubscribed ?></li>
                    <li>Moderators: <?= $moderators ?></li>
                </ul>
            </td>
            <td style="vertical-align:top" width="33%">
                <h3><span class="glyphicon glyphicon-book"></span>&nbsp;&nbsp;&nbsp;Institutions</h3>
                <p></p>
                <ul>
                    <li>Total: <?= $institutionsTotal ?></li>
                    <li>With courses: <?= $institutionsCourses ?></li>
                    <li>With courses in backend: <?= $institutionsBackend ?></li>
                    <li>With courses public visible: <?= $institutionsPublic ?></li>
                </ul>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <hr><br>
            </td>
        </tr>
        <tr>
            <td style="vertical-align:top">
                <h3><span class="glyphicon glyphicon-flag"></span>&nbsp;&nbsp;&nbsp;Countries</h3>
                <p></p>
                <ul>
                    <li>With available users: <?= $countriesUsersAvailable ?></li>
                    <li>With courses: <?= $countriesCourses ?></li>
                    <li>With courses in backend: <?= $countriesCoursesBackend ?></li>
                    <li>With courses in registry: <?= $countriesCoursesPublic ?></li>

                </ul>
            </td>
            <td style="vertical-align:top">
                <h3><span class="glyphicon glyphicon-home"></span>&nbsp;&nbsp;&nbsp;Cities</h3>
                <p></p>
                <ul>
                    <li>Total: <?= $citiesTotal ?></li>
                    <li>With courses: <?= $citiesCourses ?></li>
                    <li>With courses in backend: <?= $citiesCoursesBackend ?></li>
                    <li>With courses in registry: <?= $citiesCoursesPublic ?></li>

                </ul>
            </td>
            <td style="vertical-align:top">
                <h3><span class="glyphicon glyphicon-question-sign"></span>&nbsp;&nbsp;&nbsp;FAQ Questions</h3>
                <p></p>
                <ul>
                    <li>Total: <?= $faqQuestionsTotal ?></li>
                    <li>Published: <?= $faqQuestionsPublished ?></li>
                    <ul>
                        <li>Public: <?= $faqQuestionsPublishedPublic ?></li>
                        <li>Contributor: <?= $faqQuestionsPublishedContributor ?></li>
                        <li>Moderator: <?= $faqQuestionsPublishedModerator ?></li>
                    </ul>
                </ul>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <hr><br>
            </td>
        </tr>
        <tr>
            <td style="vertical-align:top">
                <h3><span class="glyphicon glyphicon-text-color"></span>&nbsp;&nbsp;&nbsp;Translations (invite mail)</h3>
                <p></p>
                <ul>
                    <li>Total: <?= $inviteTranslationsTotal ?></li>
                    <li>Published: <?= $inviteTranslationsPublished ?></li>
                </ul>
            </td>
            <td style="vertical-align:top">
            </td>
            <td style="vertical-align:top">
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <hr><br>
            </td>
        </tr>
    </table>
    *Available users meet the following criteria:
    <ol>
        <li>Email verified</li>
        <li>Password set</li>
        <li>Approved (by moderator)</li>
        <li>Account not disabled</li>
    </ol>
    <p><i>Note: These statistics can change at any time. For example when a user makes changes to a course or when a certain
            expiration period has exceeded.</i></p>
</div>