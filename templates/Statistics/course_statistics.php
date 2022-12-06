<?php

use Cake\I18n\FrozenTime;
?>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script>
    google.charts.load('current', {
        packages: ['corechart', 'bar']
    });
    google.charts.setOnLoadCallback(drawChartUpdatedCourses);
    google.charts.setOnLoadCallback(drawChartArchivedSoonCourses);

    function drawChartUpdatedCourses() {
        var data1 = google.visualization.arrayToDataTable(<?php echo json_encode($updatedCourseCounts) ?>);
        var options1 = {
            hAxis: {
                title: 'Months ago',
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
        var chart1 = new google.visualization.ColumnChart(
            document.getElementById('chart_updated_courses'));
        chart1.draw(data1, options1);
    }

    function drawChartArchivedSoonCourses() {
        var data2 = google.visualization.arrayToDataTable(<?php echo json_encode($archivedSoonCourseCounts) ?>);
        var options2 = {
            hAxis: {
                title: 'Months from now',
                viewWindow: {
                    min: [7, 30, 0],
                    max: [17, 30, 0]
                }
            },
            vAxis: {
                title: 'Number of courses',
                minValue: 0,
            },
            legend: {
                position: "none"
            },
        };
        var chart2 = new google.visualization.ColumnChart(
            document.getElementById('chart_archived_soon_courses'));
        chart2.draw(data2, options2);
    }
</script>

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
    <div id="chart_updated_courses"></div>
    <p></p>
    <h3>Amount of courses that will be archived soon</h3>
    <div id="chart_archived_soon_courses"></div>
    <p></p>
    <p><i>Note: All statistics can change at any time. For example when a user makes changes to a course or when a certain
            expiration period has exceeded.</i></p>
    <p></p>
    <h3>New added courses - Top 15</h3>
    <p><i>Sorted by date added, descending</i></p>
    <table>
        <thead>
            <tr>
                <th align="left" style="padding: 5px">ID</th>
                <th align="left" style="padding: 5px">Created</th>
                <th align="left" style="padding: 5px">Published</th>
                <th align="left" style="padding: 5px">Course Name</th>
                <th align="left" style="padding: 5px">Institution</th>
                <th align="left" style="padding: 5px">Country</th>
                <th align="left" style="padding: 5px">Course Owner</th>
                <th align="left" style="padding: 5px">Approved</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($newAddedCourses as $newAddedCourse) : ?>
                <tr>
                    <td style="padding: 5px"><?= $newAddedCourse->id ?></td>
                    <td style="padding: 5px"><?= $newAddedCourse->created->timeAgoInWords(['format' => 'MMM d, YYY', 'end' => '+1 year']) ?></td>
                    <td style="padding: 5px">
                        <strong>
                            <font color="<?= ($newAddedCourse->active) ? 'green">Yes' : 'red">No' ?></font></strong>
                    </td>
                    <td style=" padding: 5px"><?= $newAddedCourse->name ?>
                    </td>
                    <td style="padding: 5px"><?= $newAddedCourse->institution->name ?></td>
                    <td style="padding: 5px"><?= $newAddedCourse->country->name ?></td>
                    <td style="padding: 5px"><?= ucfirst($newAddedCourse->user->academic_title) . ' ' . ucfirst($newAddedCourse->user->first_name)
                                                    . ' ' . ucfirst($newAddedCourse->user->last_name)  ?></td>
                    <td style="padding: 5px">
                        <strong>
                            <font color="<?= ($newAddedCourse->approved) ? 'green">Yes' : 'red">No' ?></font></strong></td>
                </tr>
                <tr>
                    <td colspan=8>
                        <hr>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>