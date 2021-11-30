<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Institution[]|\Cake\Collection\CollectionInterface $institutions
 */
?>
<div class="institutions index content">
    <?= $this->Html->link(__('Add Institution'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <p>&nbsp;</p>
    <h3><?= __('Institutions') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th align="left" style="padding: 5px"><?= $this->Paginator->sort('id') ?></th>
                    <th align="left" style="padding: 5px"><?= $this->Paginator->sort('name') ?></th>
                    <th align="left" style="padding: 5px">City</th>
                    <th align="left" style="padding: 5px">Country</th>
                    <th class="actions" align="left" style="padding: 5px"><?= __('Action') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($institutions as $institution): ?>
                <tr>
                    <td style="padding: 5px"><?= h($institution->id) ?></td>
                    <td style="padding: 5px"><?= $this->Html->link(__($institution->name), ['action' => 'view', $institution->id]) ?>
                    <td style="padding: 5px"><?= $institution->city->name ?></td>
                    <td style="padding: 5px"><?= $institution->country->name ?></td>
                    <td class="actions" style="padding: 5px">
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $institution->id]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
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
