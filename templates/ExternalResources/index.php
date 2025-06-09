<div class="externalresources index content">
    <p></p>
    <h2><span class="glyphicon glyphicon-th-list"></span>&nbsp;&nbsp;&nbsp;External Resources Overview</h2>
    <p></p>
    <p>Hint: Click on the course name, to see an overview of all external resources for that course.</p>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th align="left" style="padding: 5px"><?= $this->Paginator->sort('id') ?></th>
                    <th align="left" style="padding: 5px"><?= $this->Paginator->sort('visible', 'Published') ?></th>
                    <th align="left" style="padding: 5px"><?= $this->Paginator->sort('label') ?></th>
                    <th align="left" style="padding: 5px">Course name</th>
                    <th align="left" style="padding: 5px"><?= $this->Paginator->sort('type') ?></th>
                    <th align="left" style="padding: 5px"><?= $this->Paginator->sort('created') ?></th>
                    <th align="left" style="padding: 5px"><?= $this->Paginator->sort('updated') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($externalResources as $externalResource) : ?>
                    <tr>
                        <td style="padding: 5px"><?= h($externalResource->id) ?></td>
                        <td style="padding: 5px">
                            <?php
                            if ($externalResource->visible) {
                                echo '<span class="glyphicon glyphicon-ok-circle"></span>&nbsp;&nbsp;Public visible';
                            } else {
                                echo '<span class="glyphicon glyphicon-ban-circle"></span>&nbsp;&nbsp;Not visible';
                            }
                            ?>
                        <td style="padding: 5px"><?= h($externalResource->label) ?></td>
                        <td style="padding: 5px">
                            <?php
                            echo $this->Html->link($externalResource->course->name, ['controller' => 'ExternalResources', 'action' => 'showExtResources', $externalResource->course_id]) . '<br>';
                            ?>
                        </td>
                        <td style="padding: 5px"><?= h($externalResource->type) ?></td>
                        <td style="padding: 5px"><?= h($externalResource->created) ?></td>
                        <td style="padding: 5px"><?= h($externalResource->updated) ?></td>
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