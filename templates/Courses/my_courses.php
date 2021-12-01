<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Courses[]|\Cake\Collection\CollectionInterface $courses
 */
?>
<div class="courses index content">
    <p>&nbsp;</p>
    <h3><span class="glyphicon glyphicon-education">&nbsp;</span><?= __('My Courses') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th align="left" style="padding: 5px"><?= $this->Paginator->sort('id') ?></th>
                    <th align="left" style="padding: 5px"><?= $this->Paginator->sort('name') ?></th>
                    <th align="left" style="padding: 5px"><?= $this->Paginator->sort('approved') ?></th>
                    <th align="left" style="padding: 5px"><?= $this->Paginator->sort('active') ?></th>
                    <th align="left" style="padding: 5px"><?= $this->Paginator->sort('created') ?></th>
                    <th align="left" style="padding: 5px"><?= $this->Paginator->sort('updated') ?></th>
                    <th class="actions" align="left" style="padding: 5px"><?= __('Action') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($courses as $course) : ?>
                    <tr>
                        <td style="padding: 5px"><?= h($course->id) ?></td>
                        <td style="padding: 5px"><?= $this->Html->link(__($course->name), ['action' => 'view', $course->id]) ?>
                        <td style="padding: 5px"><?= ($course->approved == 1 ? 'Yes' : 'No') ?></td>
                        <td style="padding: 5px"><?= ($course->active == 1 ? 'Yes' : 'No') ?></td>
                        <td style="padding: 5px"><?= ($course->created != null) ? $course->created->timeAgoInWords(['format' => 'MMM d, YYY', 'end' => '+1 year']) : '' ?></td>
                        <td style="padding: 5px"><?= $course->updated->timeAgoInWords(['format' => 'MMM d, YYY', 'end' => '+1 year']) ?></td>
                        <td class="actions" style="padding: 5px">
                            <?= $this->Html->link(__('Edit'), ['action' => 'edit', $course->id]) ?>
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