<p></p>
<h2><span class="glyphicon glyphicon-stats"></span>&nbsp;&nbsp;&nbsp;Statistics</h2>
<div id="dashboard">
    <?php
    echo $this->Html->link(
        '<p></p><span class="glyphicon glyphicon-stats"></span><br>
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
    echo $this->Html->link(
        '<p></p><span class="glyphicon glyphicon-user"></span><br>
            User Statistics<p>&nbsp;</p>',
        [
            'controller' => 'statistics',
            'action' => 'userStatistics'
        ],
        [
            'class' => 'blue button',
            'title' => 'User Statistics',
            'escape' => false
        ]
    );
    echo $this->Html->link(
        '<p></p><span class="glyphicon glyphicon-education"></span><br>
            Course Statistics<p>&nbsp;</p>',
        [
            'controller' => 'statistics',
            'action' => 'courseStatistics'
        ],
        [
            'class' => 'blue button',
            'title' => 'Course Statistics',
            'escape' => false
        ]
    );
    echo $this->Html->link(
        '<p></p><span class="glyphicon glyphicon-wrench"></span><br>
            App Info<p>&nbsp;</p>',
        [
            'controller' => 'statistics',
            'action' => 'appInfo'
        ],
        [
            'class' => 'blue button',
            'title' => 'App Info',
            'escape' => false
        ]
    );
    ?>
</div>