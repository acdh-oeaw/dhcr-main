<div class="row">
    <p></p>
    <h2><span class="glyphicon glyphicon-book"></span>&nbsp;&nbsp;&nbsp;Institution Details</h2>
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
                <tr>
                    <th align="left" style="padding: 5px"><?= __('Lat') ?></th>
                    <td style="padding: 5px"><?= $this->Number->format($institution->lat) ?></td>
                </tr>
                <tr>
                    <th align="left" style="padding: 5px"><?= __('Lon') ?></th>
                    <td style="padding: 5px"><?= $this->Number->format($institution->lon) ?></td>
                </tr>
            </table>
            <div class="text" style="padding: 5px">
                <strong><?= __('Description') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($institution->description)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>