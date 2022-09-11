<div class="row">
    <p></p>
    <h2><span class="glyphicon glyphicon-pencil"></span>&nbsp;&nbsp;&nbsp;Edit FAQ Question</h2>
    <div class="column-responsive column-80">
        <div class="faqQuestions form content">
            <?= $this->Form->create($faqQuestion) ?>
            <fieldset>
                <legend><?= __('Edit FAQ Question') ?></legend>
                <?php
                echo $this->Form->control('faq_category_id', ['options' => $faqCategories, 'label' => 'Login Type']);
                echo $this->Form->control('question');
                echo $this->Form->control('answer');
                echo $this->Form->control('published');
                ?>
            </fieldset>
            <p>&nbsp;</p>
            <?= $this->Form->button(__('Update FAQ Question')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>