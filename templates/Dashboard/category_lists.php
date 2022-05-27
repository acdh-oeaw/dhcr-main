<p></p>
<h2><span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;&nbsp;Category Lists</h2>
<div id="dashboard">
    <?php
    echo $this->Html->link(
        '<p></p><span class="glyphicon glyphicon-home"></span><br>
        Cities<br>
        <font color="#81d41a">(&nbsp;' . $totalCities . '&nbsp;)</font><p></p>',
        [
            'controller' => 'cities',
            'action' => 'index'
        ],
        [
            'class' => 'blue button',
            'title' => 'Cities',
            'escape' => false
        ]
    );
    if ($user->is_admin) {
        echo $this->Html->link(
            '<p></p><span class="glyphicon glyphicon-text-background"></span><br>
            Languages<br>
            <font color="#81d41a">(&nbsp;' . $totalLanguages . '&nbsp;)</font><p></p>',
            [
                'controller' => 'languages',
                'action' => 'index'
            ],
            [
                'class' => 'blue button',
                'title' => 'Languages',
                'escape' => false
            ]
        );
    }
    echo $this->Html->link(
        '<p></p><span class="glyphicon glyphicon-book"></span><br>
        Institutions<br>
        <font color="#81d41a">(&nbsp;' . $totalInstitutions . '&nbsp;)</font><p></p>',
        [
            'controller' => 'institutions',
            'action' => 'index'
        ],
        [
            'class' => 'blue button',
            'title' => 'Institutions',
            'escape' => false
        ]
    );
    if ($user->is_admin) {
        echo $this->Html->link(
            '<p></p><span class="glyphicon glyphicon-text-color"></span><br>
            Translations<br>
            <font color="#81d41a">(&nbsp;' . $totalInviteTranslations . '&nbsp;)</font><p></p>',
            [
                'controller' => 'inviteTranslations',
                'action' => 'index'
            ],
            [
                'class' => 'blue button',
                'title' => 'Translations',
                'escape' => false
            ]
        );
    }
    ?>
</div>