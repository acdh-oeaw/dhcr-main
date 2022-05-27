<div class="row">
    <p></p>
    <h2><span class="glyphicon glyphicon-text-background"></span>&nbsp;&nbsp;&nbsp;Edit Language</h2>
    <div class="column-responsive column-80">
        <div class="languages form content">
            <?= $this->Form->create($language) ?>
            <fieldset>
                <legend><?= __('Edit Language') ?></legend>
                <?php
                echo $this->Form->control('name');
                ?>
            </fieldset>
            <p>&nbsp;</p>
            <?= $this->Form->button(__('Edit Language')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>