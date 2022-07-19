<div class="row">
    <p></p>
    <h2><span class="glyphicon glyphicon-folder-open"></span>&nbsp;&nbsp;&nbsp;Log Entry Details</h2>
    <div class="column-responsive column-80">
        <div class="logentries view content">
            <?php
            if ($logentry->id > 1) {
                echo $this->Html->link(__('< Previous'), ['action' => 'view', $logentry->id - 1], ['class' => 'button float-right']) . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
            }
            if ($logentry->id < $logentriesMax) {
                echo $this->Html->link(__('Next >'), ['action' => 'view', $logentry->id + 1], ['class' => 'button float-right']);
            }
            ?>
            <p></p>
            <h3>Log Entry ID: <?= $this->Number->format($logentry->id) ?></h3>
            <p></p>
            <table>
                <tr>
                    <th align="left" style="padding: 5px"><?= __('Type') ?></th>
                    <td align="left" style="padding: 5px"><?= $logentry->logentry_code->id . ' - ' . $logentry->logentry_code->name ?></td>
                </tr>
                <tr>
                    <th align="left" style="padding: 5px"><?= __('User') ?></th>
                    <td align="left" style="padding: 5px"><?= $this->Html->link(
                                                                $logentry->user->id . ' - ' . $logentry->user->first_name . ' ' . $logentry->user->last_name,
                                                                ['controller' => 'Users', 'action' => 'view', $logentry->user->id]
                                                            ) ?></td>
                </tr>
                <tr>
                    <th align="left" style="padding: 5px"><?= __('Source') ?></th>
                    <td align="left" style="padding: 5px"><?= h($logentry->source_name) ?></td>
                </tr>
                <tr>
                    <th align="left" style="padding: 5px"><?= __('Subject') ?></th>
                    <td align="left" style="padding: 5px"><?= h($logentry->subject) ?></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <hr>
                    </td>
                </tr>
                <tr>
                    <th align="left" style="padding: 5px"><?= __('Description') ?></th>
                    <td align="left" style="padding: 5px"><?= $this->Text->autoParagraph($logentry->description) ?></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <hr>
                    </td>
                </tr>
                <tr>
                    <th align="left" style="padding: 5px"><?= __('Created') ?></th>
                    <td align="left" style="padding: 5px"><?= h($logentry->created->i18nFormat('yyyy-MM-dd HH:mm')) ?> UTC</td>
                </tr>
                <tr>
                    <th align="left" style="padding: 5px"><?= __('Updated') ?></th>
                    <td align="left" style="padding: 5px"><?= h($logentry->updated->i18nFormat('yyyy-MM-dd HH:mm')) ?> UTC</td>
                </tr>
                <tr>
                    <th align="left" style="padding: 5px"><?= __('Cleared') ?></th>
                    <td align="left" style="padding: 5px"><?= $logentry->cleared ? __('Yes') : __('No'); ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>