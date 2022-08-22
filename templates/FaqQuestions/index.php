<div class="faqQuestions index content">
    <p></p>
    <h2><span class="glyphicon glyphicon-question-sign"></span>&nbsp;&nbsp;&nbsp;FAQ Questions</h2>
    <?= $this->Html->link(__('Add FAQ Question'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <p></p>
    <p><u>When moving a question up or down, it will switch places with the nearest question in the same category.</u></p>
    <div class="table-responsive">
        <table width="100%">
            <thead>
                <tr>
                    <th align="left" style="padding: 5px"><?= $this->Paginator->sort('id') ?></th>
                    <th align="left" style="padding: 5px"><?= $this->Paginator->sort('sort_order') ?></th>
                    <th align="left" style="padding: 5px"><?= $this->Paginator->sort('faq_category_id', ['label' => 'Category']) ?></th>
                    <th align="left" style="padding: 5px"><?= $this->Paginator->sort('question') ?></th>
                    <th align="left" style="padding: 5px"><?= $this->Paginator->sort('published') ?></th>
                    <th align="left" style="padding: 5px">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($faqQuestions as $faqQuestion) : ?>
                    <tr>
                        <td align="left" style="padding: 5px"><?= $this->Number->format($faqQuestion->id) ?></td>
                        <td align="left" style="padding: 5px"><?= $this->Number->format($faqQuestion->sort_order) ?></td>
                        <td align="left" style="padding: 5px"><?= h($faqQuestion->faq_category->name) ?></td>
                        <td align="left" style="padding: 5px"><?= h($faqQuestion->question) ?></td>
                        <!-- TODO: add link to view here -->
                        <td align="left" style="padding: 5px"><?= ($faqQuestion->published) ? 'Yes' : 'No' ?></td>
                        <td align="left" style="padding: 5px" class="actions">
                            
                            <?= $this->Html->link('<span class="glyphicon glyphicon-eye-open"></span> View', ['action' => 'view', $faqQuestion->id], ['escape' => false]) ?><br>
                            <?= $this->Html->link('<span class="glyphicon glyphicon-pencil"></span> Edit', ['action' => 'edit', $faqQuestion->id], ['escape' => false]) ?><br>
                            <?= $this->Html->link('<span class="glyphicon glyphicon-circle-arrow-up"></span> Move up', ['action' => 'view', $faqQuestion->id], ['escape' => false]) ?><br>
                            <?= $this->Html->link('<span class="glyphicon glyphicon-circle-arrow-down"></span> Move down', ['action' => 'view', $faqQuestion->id], ['escape' => false]) ?><br>
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