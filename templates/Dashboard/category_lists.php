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
            '<p></p><span class="glyphicon glyphicon-flag"></span><br>
            Countries<br>
            <font color="#81d41a">(&nbsp;' . $totalCountries . '&nbsp;)</font><p></p>',
            [
                'controller' => 'Countries',
                'action' => 'index'
            ],
            [
                'class' => 'blue button',
                'title' => 'Countries',
                'escape' => false
            ]
        );
    }
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
    if ($user->is_admin) {
        echo $this->Html->link(
            '<p></p><span class="glyphicon glyphicon-question-sign"></span><br>
            FAQ Questions<br>
            <font color="#81d41a">(&nbsp;' . $totalFaqQuestions . '&nbsp;)</font><p></p>',
            [
                'controller' => 'Dashboard',
                'action' => 'faqQuestions'
            ],
            [
                'class' => 'blue button',
                'title' => 'FAQ Questions',
                'escape' => false
            ]
        );
    }
    if ($user->is_admin) {
        echo $this->Html->link(
            '<p></p><span class="glyphicon glyphicon-folder-open"></span><br>
            Log Entries<p></p>',
            [
                'controller' => 'Logentries',
                'action' => 'index'
            ],
            [
                'class' => 'blue button',
                'title' => 'Log Entries',
                'escape' => false
            ]
        );
    }
    ?>
</div>