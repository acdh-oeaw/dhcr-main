<div class="cities index content">
    <p></p>
    <h2><span class="glyphicon glyphicon-home"></span>&nbsp;&nbsp;&nbsp;Cities</h2>
    <?= $this->Html->link(__('Add City'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <p></p>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th align="left" style="padding: 5px"><?= $this->Paginator->sort('id') ?></th>
                    <th align="left" style="padding: 5px"><?= $this->Paginator->sort('name') ?></th>
                    <th align="left" style="padding: 5px">Country</th>
                    <th class="actions" align="left" style="padding: 5px"><?= __('Action') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cities as $city) : ?>
                    <tr>
                        <td style="padding: 5px"><?= h($city->id) ?></td>
                        <td style="padding: 5px"><?= h($city->name) ?></td>
                        <td style="padding: 5px"><?= h($city->country->name)  ?></td>
                        <td class="actions" style="padding: 5px">
                            <?= $this->Html->link(__('Edit'), ['action' => 'edit', $city->id]) ?>
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