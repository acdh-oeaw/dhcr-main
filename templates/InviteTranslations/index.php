<div class="inviteTranslations index content">
    <p></p>
    <h2><span class="glyphicon glyphicon-text-color"></span>&nbsp;&nbsp;&nbsp;Translations</h2>
    <?= $this->Html->link(__('Add Translation'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <p></p>
    <p><u>List of translations for the user invitation email</u></p>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th align="left" style="padding: 5px">Sort Order</th>
                    <th align="left" style="padding: 5px">Language</th>
                    <th align="left" style="padding: 5px">Subject</th>
                    <th align="left" style="padding: 5px">Published</th>
                    <th align="left" style="padding: 5px">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($inviteTranslations as $inviteTranslation) : ?>
                    <tr>
                        <td style="padding: 5px" align="center"><?= $this->Number->format($inviteTranslation->sortOrder) ?></td>
                        <td style="padding: 5px"><?= h($inviteTranslation->language->name) ?></td>
                        <td style="padding: 5px"><?= $this->Html->link(__(h($inviteTranslation->subject)), ['action' => 'view', $inviteTranslation->id]) ?></td>
                        <td style="padding: 5px" align="center"><?= ($inviteTranslation->active) ? 'Yes' : 'No' ?></td>
                        <td class="actions" style="padding: 5px" align="center"><?= $this->Html->link(__('Edit'), ['action' => 'edit', $inviteTranslation->id]) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>