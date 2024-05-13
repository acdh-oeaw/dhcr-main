<div class="countries index content">
    <p></p>
    <h2><span class="glyphicon glyphicon-flag"></span>&nbsp;&nbsp;&nbsp;Countries</h2>
    <?= $this->Html->link('Add Country', ['action' => 'add'], ['class' => 'button float-right']) ?>
    <p></p>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th align="left" style="padding: 5px"><?= $this->Paginator->sort('id') ?></th>
                    <th align="left" style="padding: 5px"><?= $this->Paginator->sort('name') ?></th>
                    <th class="actions" align="left" style="padding: 5px">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($countries as $country) : ?>
                    <tr>
                        <td style="padding: 5px"><?= h($country->id) ?></td>
                        <td style="padding: 5px"><?= h($country->name) ?></td>
                        <td class="actions" style="padding: 5px">
                            <?= $this->Html->link('Edit', ['action' => 'edit', $country->id]) ?>
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