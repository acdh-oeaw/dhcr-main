<p></p>
<h2><span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;&nbsp;Category Lists</h2>
<div id="dashboard">
    <?php
    echo $this->Html->link(
        '<p></p><span class="glyphicon glyphicon-home"></span><br>
        Cities<br>( ' . $totalCities . ' )<p></p>',
        [
            'controller' => 'cities',
            'action' => 'index'
        ],
        [
            'class' => 'blue button',
            'title' => 'Cities',
            'escape' => false
        ]);
    echo $this->Html->link(
        '<p></p><span class="glyphicon glyphicon-text-background"></span><br>
        Languages<br>( ' . $totalLanguages . ' )<p></p>',
        [
            'controller' => 'languages',
            'action' => 'index'
        ],
        [
            'class' => 'blue button',
            'title' => 'Languages',
            'escape' => false
        ]);
    echo $this->Html->link(
        '<p></p><span class="glyphicon glyphicon-book"></span><br>
        Institutions<br>( ' . $totalInstitutions . ' )<p></p>',
        [
            'controller' => 'institutions',
            'action' => 'index'
        ],
        [
            'class' => 'blue button',
            'title' => 'Institutions',
            'escape' => false
        ]);
    echo $this->Html->link(
        '<p></p><span class="glyphicon glyphicon-text-color"></span><br>
        Invite Translations<br>( ' . $totalInviteTranslations . ' )<p></p>',
        [
            'controller' => 'inviteTranslations',
            'action' => 'index'
        ],
        [
            'class' => 'blue button',
            'title' => ' Invite Translations',
            'escape' => false
        ]);
    ?>
</div>