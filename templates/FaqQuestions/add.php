<div class="row">
    <p></p>
    <h2><span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;&nbsp;Add FAQ Question</h2>
    <div class="column-responsive column-80">
        <div class="faqQuestions form content">
            <?= $this->Form->create($faqQuestion) ?>
            <fieldset>
                <legend><?= __('Add FAQ Question') ?></legend>
                <?php
                echo $this->Form->control('faq_category_id', ['label' => 'Login Type', 'options' => $faqCategories]);
                echo $this->Form->control('question', ['label' => 'Question*']);
                echo $this->Form->control('answer', ['label' => 'Answer*']);
                echo $this->Form->control('link_title');
                echo $this->Form->control('link_url');
                echo $this->Form->control('published', ['default' => true]);
                ?>
            </fieldset>
            <p>&nbsp;</p>
            <?= $this->Form->button('Add FAQ Question') ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>