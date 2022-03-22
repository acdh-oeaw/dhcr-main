<div class="languages index content">
    <p></p>
    <h2><span class="glyphicon glyphicon-text-background"></span>&nbsp;&nbsp;&nbsp;Languages</h2>
    <?= $this->Html->link(__('Add Language'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <p></p>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th align="left" style="padding: 5px"><?= $this->Paginator->sort('id') ?></th>
                    <th align="left" style="padding: 5px"><?= $this->Paginator->sort('name') ?></th>
                    <th class="actions" align="left" style="padding: 5px"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($languages as $language) : ?>
                    <tr>
                        <td align="left" style="padding: 5px"><?= $this->Number->format($language->id) ?></td>
                        <td align="left" style="padding: 5px"><?= h($language->name) ?></td>
                        <td class="actions" align="left" style="padding: 5px">
                            <?= $this->Html->link(__('Edit'), ['action' => 'edit', $language->id]) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <?= $this->Paginator->first('<< ' . __('first')) ?>
        <?= $this->Paginator->prev('< ' . __('previous')) ?>
        <?= $this->Paginator->numbers() ?>
        <?= $this->Paginator->next(__('next') . ' >') ?>
        <?= $this->Paginator->last(__('last') . ' >>') ?>
        <p>&nbsp;</p>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>