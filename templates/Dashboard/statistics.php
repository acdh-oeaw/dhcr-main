<p></p>
<h2><span class="glyphicon glyphicon-stats"></span>&nbsp;&nbsp;&nbsp;Statistics</h2>
<div id="dashboard">
    <?php
    echo $this->Html->link(
        '<p></p><span class="glyphicon glyphicon-scale"></span><br>
            Summary Statistics<p>&nbsp;</p>',
        [
            'controller' => 'statistics',
            'action' => 'summaryStatistics'
        ],
        [
            'class' => 'blue button',
            'title' => 'Summary Statistics',
            'escape' => false
        ]
    );
    ?>
</div>