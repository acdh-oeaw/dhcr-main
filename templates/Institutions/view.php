<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Institution $institution
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <p>&nbsp;</p>
            <h4 class="heading"><u><?= __('Actions') ?></u></h4>
            <ul>
                <li><?= $this->Html->link(__('Edit Institution'), ['action' => 'edit', $institution->id], ['class' => 'side-nav-item']) ?></li>
                <li><?= $this->Html->link(__('List Institutions'), ['action' => 'index'], ['class' => 'side-nav-item']) ?></li>
            </ul>
            <p>&nbsp;</p>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="institutions view content">
            <h3><?= h($institution->name) ?></h3>
            <table>
                <tr>
                    <th align="left" style="padding: 5px"><?= __('Id') ?></th>
                    <td style="padding: 5px"><?= $institution->id ?></td>
                </tr>
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
                <p>&nbsp;</p>
            </div>
            <div class="related">
                <h4><u><?= __('Related Courses') ?></u></h4>
                <?php if (!empty($institution->courses)) : ?>
                    <div class="table-responsive">
                        <table width="80%">
                            <tr>
                                <th align="left" style="padding: 5px"><?= __('Id') ?></th>
                                <th align="left" style="padding: 5px"><?= __('Active') ?></th>
                                <th align="left" style="padding: 5px"><?= __('Name') ?></th>
                                <th class="actions" align="left" style="padding: 5px"><?= __('Actions') ?></th>
                            </tr>
                            <?php foreach ($institution->courses as $courses) : ?>
                                <tr>
                                    <td style="padding: 5px"><?= h($courses->id) ?></td>
                                    <td style="padding: 5px"><?= ($courses->active == 1 ? 'Yes' : 'No') ?>
                                    <td style="padding: 5px"><?= $this->Html->link(__($courses->name), ['controller' => 'Courses', 'action' => 'view', $courses->id]) ?>
                                    <td class="actions" style="padding: 5px">
                                        <?= $this->Html->link(__('Edit'), ['controller' => 'Courses', 'action' => 'edit', $courses->id]) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>