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
    echo '<p><u>Data updated at: ' . $now->i18nFormat('yyyy-MM-dd HH:mm') . ' UTC</u></p>';
    ?>
    <h3><span class="glyphicon glyphicon-star"></span>&nbsp;&nbsp;&nbsp;Key data</h3>
    <p>
        Total: <?= $usersTotal ?><br>
        Subcribed to mailing list: <?= $usersSubscribed ?><br>
        &nbsp;<br>
        Total available*: <?= $usersAvailable ?><br>
        Available & subcribed to mailing list: <?= $usersAvailableSubscribed ?><br>
        Available & subcribed as part of available: <?= (int) ($usersAvailableSubscribed / $usersAvailable * 100) ?>%<br>
        &nbsp;<br>
        Moderators: <?= $moderators ?><br>
        Moderators subscribed to mailing list: <?= $moderatorsSubscribed ?><br>
        &nbsp;<br>
        Administrators: <?= $administrators ?><br>
        Administrators shown on contact page: <?= $userAdmins ?>
    </p>
    <h3><span class="glyphicon glyphicon-user"></span>&nbsp;&nbsp;&nbsp;Logged in users until months ago</h3>
    <div id="chart_users"></div>
    <p></p>
    <h3><span class="glyphicon glyphicon-th-list"></span>&nbsp;&nbsp;&nbsp;Logged in moderators until months ago</h3>
    <div id="chart_moderators"></div>
    <p></p>
    <h3><span class="glyphicon glyphicon-equalizer"></span>&nbsp;&nbsp;&nbsp;Moderator participation</h3>
    <p></p>
    <h4>Amount of moderators that logged in within the last 4 months</h4>
    <p></p>
    <?php

    // percentage of mods that logedin in the last 4 months
    $moderatorParticipation = $loggedinModeratorCounts[4][1] / $moderators;
    if ($moderatorParticipation > 0.7) {
        $imageName = "traffic_light_green.png";
    } elseif ($moderatorParticipation > 0.5) {
        $imageName = "traffic_light_yellow.png";
    } else {
        $imageName = "traffic_light_red.png";
    }
    ?>

    <table>
        <tr>
            <td style="padding: 10px">
                <?php
                echo $this->Html->Image($imageName);    // , array('height' => '170', 'width' => '132')
                ?></td>
            <td>

                Green: More than 70%<br>
                Yellow: More than 50%<br>
                Red: 50% or less<br>
            </td>
        </tr>
    </table>
    <p></p>
    <hr>
    <p></p>
    *Available users meet the following criteria:
    <ol>
        <li>Email verified</li>
        <li>Password set</li>
        <li>Approved (by moderator)</li>
        <li>Account not disabled</li>
    </ol>
    <p><i>Note: These statistics can change at any time.</i></p>
</div>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script>
    google.charts.load('current', {
        packages: ['corechart', 'bar']
    });
    google.charts.setOnLoadCallback(drawChartUsers);
    google.charts.setOnLoadCallback(drawChartModerators);

    function drawChartUsers() {
        var data1 = google.visualization.arrayToDataTable(<?php echo json_encode($loggedinUserCounts) ?>);
        var options1 = {
            hAxis: {
                title: 'Until months ago',
                viewWindow: {
                    min: [7, 30, 0],
                    max: [17, 30, 0]
                },
            },
            vAxis: {
                title: 'Logged in users',
                maxValue: <?= $usersAvailable ?>,
            },
            legend: {
                position: "none"
            },
        };
        var chart1 = new google.visualization.ColumnChart(
            document.getElementById('chart_users'));
        chart1.draw(data1, options1);
    }

    function drawChartModerators() {
        var data2 = google.visualization.arrayToDataTable(<?php echo json_encode($loggedinModeratorCounts) ?>);
        var options2 = {
            hAxis: {
                title: 'Until months ago',
                viewWindow: {
                    min: [7, 30, 0],
                    max: [17, 30, 0]
                }
            },
            vAxis: {
                title: 'Logged in moderators',
                maxValue: <?= $moderators ?>,
            },
            legend: {
                position: "none"
            },
        };
        var chart2 = new google.visualization.ColumnChart(
            document.getElementById('chart_moderators'));
        chart2.draw(data2, options2);
    }
</script>