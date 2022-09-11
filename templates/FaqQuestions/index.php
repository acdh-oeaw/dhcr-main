<?php
switch ($categoryId) {
    case 1:
        $icon = 'eye-open';
        break;
    case 2:
        $icon = 'education';
        break;
    case 3:
        $icon = 'list-alt';
        break;
    default:
        $icon = 'question-sign';
}
?>
<div class="faqQuestions index content">
    <p></p>
    <h2><span class="glyphicon glyphicon-<?= $icon ?>"></span>&nbsp;&nbsp;&nbsp;<?= $categoryName ?> Questions</h2>
    <!-- <?= $this->Html->link(__('Add FAQ Question'), ['action' => 'add'], ['class' => 'button float-right']) ?> -->
    <p></p>
    <div class="table-responsive">
        <table width="100%">
            <thead>
                <tr>
                    <th align="left" style="padding: 5px"><?= $this->Paginator->sort('id') ?></th>
                    <th align="left" style="padding: 5px"><?= $this->Paginator->sort('question') ?></th>
                    <th align="left" style="padding: 5px"><?= $this->Paginator->sort('published') ?></th>
                    <th align="left" style="padding: 5px">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($faqQuestions as $faqQuestion) : ?>
                    <tr>
                        <td align="left" style="padding: 5px"><?= $this->Number->format($faqQuestion->id) ?></td>
                        <td align="left" style="padding: 5px">
                            <?= $this->Html->link($faqQuestion->question, ['action' => 'view', $faqQuestion->id]) ?></td>
                        <td align="left" style="padding: 5px">
                            <span class="glyphicon glyphicon-<?= ($faqQuestion->published) ? 'ok' : 'remove' ?>"></span>
                        </td>
                        <td align="left" style="padding: 5px" class="actions">
                            <?= $this->Html->link('<span class="glyphicon glyphicon-eye-open"></span> View', ['action' => 'view', $faqQuestion->id], ['escape' => false]) ?><br>
                            <?= $this->Html->link('<span class="glyphicon glyphicon-pencil"></span> Edit', ['action' => 'edit', $faqQuestion->id], ['escape' => false]) ?><br>
                            <?= $this->Html->link('<span class="glyphicon glyphicon-circle-arrow-up"></span> Move up', ['action' => 'moveUp', $faqQuestion->id], ['escape' => false]) ?><br>
                            <?= $this->Html->link('<span class="glyphicon glyphicon-circle-arrow-down"></span> Move down', ['action' => 'moveDown', $faqQuestion->id], ['escape' => false]) ?><br>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="6">
                            <hr>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php
        if (sizeof($faqQuestions) < 1) {
            echo '<p>No questions for this login type.</p>';
        }
        ?>
    </div>
    <p></p>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>