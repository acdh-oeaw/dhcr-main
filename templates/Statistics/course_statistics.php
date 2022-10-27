<?php

use Cake\I18n\FrozenTime;
?>
<div class="statistics content">
    <p></p>
    <h2><span class="glyphicon glyphicon-education"></span>&nbsp;&nbsp;&nbsp;Course Statistics</h2>
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
        Total: <?= $coursesTotal ?><br>
        In backend & published: <?= $coursesBackend ?><br>
        Public visible: <?= $coursesPublic ?><br>
        Public as part of backend: <?= (int) ($coursesPublic / $coursesBackend * 100) ?>%
    </p>
    <h3>Total updated courses until months ago</h3>
    <div id="chart_div"></div>
    <p></p>
    <p><i>Note: These statistics can change at any time. For example when a user makes changes to a course or when a certain
            expiration period has exceeded.</i></p>
</div>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script>
    google.charts.load('current', {
        packages: ['corechart', 'bar']
    });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = google.visualization.arrayToDataTable(<?php echo json_encode($updatedCourseCounts) ?>);
        var options = {
            hAxis: {
                title: 'Until months ago',
                viewWindow: {
                    min: [7, 30, 0],
                    max: [17, 30, 0]
                }
            },
            vAxis: {
                title: 'Total updated courses',
                maxValue: <?= $coursesBackend ?>,
            },
            legend: {
                position: "none"
            },
        };
        var chart = new google.visualization.ColumnChart(
            document.getElementById('chart_div'));
        chart.draw(data, options);
    }
</script>