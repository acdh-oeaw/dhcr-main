<p></p>
<h2><span class="glyphicon glyphicon-question-sign"></span>&nbsp;&nbsp;&nbsp;FAQ Questions</h2>
<div id="dashboard">
    <?php
    echo $this->Html->link(
        '<p></p><span class="glyphicon glyphicon-plus"></span><br>
            Add Question<p></p>',
        [
            'controller' => 'FaqQuestions',
            'action' => 'add'
        ],
        [
            'class' => 'blue button',
            'title' => 'Add Question',
            'escape' => false
        ]
    );
    echo $this->Html->link(
        '<p></p><span class="glyphicon glyphicon-education"></span><br>
            Contributor Questions<br>
            <font color="#81d41a">(&nbsp;' . $contributorQuestions . '&nbsp;)</font><p></p>',
        [
            'controller' => 'FaqQuestions',
            'action' => 'index'
        ],
        [
            'class' => 'blue button',
            'title' => 'Contributor Questions',
            'escape' => false
        ]
    );
    echo $this->Html->link(
        '<p></p><span class="glyphicon glyphicon-eye-open"></span><br>
            Public Questions<br>
            <font color="#81d41a">(&nbsp;' . $publicQuestions . '&nbsp;)</font><p></p>',
        [
            'controller' => 'FaqQuestions',
            'action' => 'index'
        ],
        [
            'class' => 'blue button',
            'title' => 'Public Questions',
            'escape' => false
        ]
    );
    echo $this->Html->link(
        '<p></p><span class="glyphicon glyphicon-list-alt"></span><br>
            Moderator Questions<br>
            <font color="#81d41a">(&nbsp;' . $moderatorQuestions . '&nbsp;)</font><p></p>',
        [
            'controller' => 'FaqQuestions',
            'action' => 'index'
        ],
        [
            'class' => 'blue button',
            'title' => 'Moderator Questions',
            'escape' => false
        ]
    );
    ?>
</div>