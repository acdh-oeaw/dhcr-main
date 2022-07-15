<div class="logentries index content">
    <p></p>
    <h2><span class="glyphicon glyphicon-folder-open"></span>&nbsp;&nbsp;&nbsp;Log Entries</h2>
    <p></p>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th align="left" style="padding: 5px"><?= $this->Paginator->sort('id') ?></th>
                    <th align="left" style="padding: 5px"><?= $this->Paginator->sort('logentry_code_id') ?></th>
                    <th align="left" style="padding: 5px"><?= $this->Paginator->sort('user_id') ?></th>
                    <th align="left" style="padding: 5px"><?= $this->Paginator->sort('source_name') ?></th>
                    <th align="left" style="padding: 5px"><?= $this->Paginator->sort('subject') ?></th>
                    <th align="left" style="padding: 5px"><?= $this->Paginator->sort('description') ?></th>
                    <th align="left" style="padding: 5px"><?= $this->Paginator->sort('cleared') ?></th>
                    <th align="left" style="padding: 5px"><?= $this->Paginator->sort('created') ?></th>
                    <th align="left" style="padding: 5px"><?= $this->Paginator->sort('updated') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($logentries as $logentry) : ?>
                    <tr>
                        <td align="left" style="padding: 5px"><?= $this->Number->format($logentry->id) ?></td>
                        <td align="left" style="padding: 5px"><?= $logentry->logentry_code->id .' - ' .$logentry->logentry_code->name ?></td>
                        <td align="left" style="padding: 5px"><?= $this->Html->link($logentry->user->id . ' - ' . $logentry->user->first_name . ' ' .$logentry->user->last_name, ['controller' => 'Users', 'action' => 'view', $logentry->user->id])?></td>
                        <td align="left" style="padding: 5px"><?= h($logentry->source_name) ?></td>
                        <td align="left" style="padding: 5px"><?= h($logentry->subject) ?></td>
                        <td align="left" style="padding: 5px"><?= h($logentry->description) ?></td>
                        <td align="left" style="padding: 5px"><?= (h($logentry->cleared) ? "Yes" : "No")?></td>
                        <td align="left" style="padding: 5px"><?= h($logentry->created->i18nFormat('yyyy-MM-dd HH:mm')) ?> UTC</td>
                        <td align="left" style="padding: 5px"><?= h($logentry->updated->i18nFormat('yyyy-MM-dd HH:mm')) ?> UTC</td>
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