<div class="row">
    <p></p>
    <h2><span class="glyphicon glyphicon-book"></span>&nbsp;&nbsp;&nbsp;Institution Details</h2>
    <?= $this->Html->link(__('Edit Institution'), ['action' => 'edit', $institution->id], ['class' => 'button float-right']) ?>
    <p></p>
    <div class="column-responsive column-80">
        <div class="institutions view content">
            <h3><?= h($institution->name) ?></h3>
            <p></p>
            <table>
                <tr>
                    <th align="left" style="padding: 5px"><?= __('City') ?></th>
                    <td style="padding: 5px"><?= $institution->city->name ?></td>
                </tr>
                <tr>
                    <th align="left" style="padding: 5px"><?= __('Country') ?></th>
                    <td style="padding: 5px"><?= $institution->country->name ?></td>
                </tr>
                <tr>
                    <th align="left" style="padding: 5px"><?= __('Url') ?></th>
                    <td style="padding: 5px"><?= h($institution->url) ?></td>
                </tr>
            </table>
            <div class="text" style="padding: 5px">
                <strong><?= __('Description') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($institution->description)); ?>
                </blockquote>
            </div>
            <strong>&nbsp;Location</strong>
            <?php
            echo $this->element('locationpicker');  // include locationpicker
            ?>
        </div>
    </div>
</div>