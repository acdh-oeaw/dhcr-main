<p></p>
<h2><span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;&nbsp;Category Lists</h2>

<div id="dashboard">

    <?= $this->Html->link(
        '<p></p><span class="glyphicon glyphicon-home"></span><br>
        Cities<br>' . $totalCities . '<p></p>',
        [
            'controller' => 'cities',
            'action' => 'index'
        ],
        [
            'class' => 'blue button',
            'title' => 'Cities',
            'escape' => false
        ]
    ) ?>
    <?= $this->Html->link(
        '<p></p><span class="glyphicon glyphicon-text-background"></span><br>
        Languages<br>' . $totalLanguages . '<p></p>',
        [
            'controller' => 'languages',
            'action' => 'index'
        ],
        [
            'class' => 'blue button',
            'title' => 'Languages',
            'escape' => false
        ]
    ) ?>
    <?= $this->Html->link(
        '<p></p><span class="glyphicon glyphicon-book"></span><br>
        Institutions<br>' . $totalInstitutions . '<p></p>',
        [
            'controller' => 'institutions',
            'action' => 'index'
        ],
        [
            'class' => 'blue button',
            'title' => 'Institutions',
            'escape' => false
        ]
    ) ?>
</div>