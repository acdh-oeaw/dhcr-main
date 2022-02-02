<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\InviteTranslation[]|\Cake\Collection\CollectionInterface $inviteTranslations
 */
?>
<div class="inviteTranslations index content">
    <p></p>
    <h2><span class="glyphicon glyphicon-text-color"></span>&nbsp;&nbsp;&nbsp;Invite Translations</h2>
    <?= $this->Html->link(__('Add Invite Translation'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <p></p>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th align="left" style="padding: 5px">Sort Order</th>
                    <th align="left" style="padding: 5px">Name</th>
                    <th align="left" style="padding: 5px">Subject</th>
                    <th align="left" style="padding: 5px">Active</th>
                    <th align="left" style="padding: 5px">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($inviteTranslations as $inviteTranslation): ?>
                <tr>
                    <td style="padding: 5px" align="center"><?= $this->Number->format($inviteTranslation->sortOrder) ?></td>
                    <td style="padding: 5px"><?= h($inviteTranslation->name) ?></td>
                    <td style="padding: 5px"><?= $this->Html->link(__(h($inviteTranslation->subject)), ['action' => 'view', $inviteTranslation->id]) ?></td>
                    <td style="padding: 5px" align="center"><?= ($inviteTranslation->active) ? 'Yes' : 'No' ?></td>
                    <td class="actions" style="padding: 5px" align="center"><?= $this->Html->link(__('Edit'), ['action' => 'edit', $inviteTranslation->id]) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>