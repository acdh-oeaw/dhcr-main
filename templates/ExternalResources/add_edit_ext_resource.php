<div class="courses edit content">
    <p></p>
    <h2><span class="glyphicon glyphicon-<?= $icon ?>"></span>&nbsp;&nbsp;&nbsp;<?= $action ?> External Resource</h2>
    <table>
        <tr>
            <td>
                <h3>Course name&nbsp;&nbsp;&nbsp;</h3>
            </td>
            <td><?= $course->name ?>
            </td>
        </tr>
        <tr>
            <td>
                <h3>Course ID</h3>
            </td>
            <td><?= $course->id ?>
            </td>
        </tr>
    </table>
    <p></p>
    <div class="row">
        <div class="column-responsive column-80">
            <div class="courses form content">
                <?= $this->Form->create($externalResource) ?>
                <fieldset>
                    <legend><?= $action ?> External Resource</legend>
                    <?php
                    echo $this->Form->hidden('course_id', [
                        'val' => $course->id
                    ]);
                    echo $this->Form->control('label');
                    echo 'Start with https:// if possible, otherwise with http://';
                    echo $this->Form->control('url', [
                        'label' => 'URL*',
                        'placeholder' => 'Start with https:// if possible, otherwise with http://'
                    ]);
                    echo $this->Form->control('type', [
                        'options' => [
                            'Dataset' => 'Dataset',
                            'Training Material' => 'Training Material',
                            'Service' => 'Service',
                            'Software' => 'Software'
                        ],
                    ]);
                    echo $this->Form->control('affiliation', [
                        'options' => [
                            'CLARIN' => 'CLARIN',
                            'DARIAH' => 'DARIAH',
                            'CLARIN & DARIAH' => 'CLARIN & DARIAH',
                        ]
                    ]);
                    echo $this->Form->control('visible', [
                        'label' => 'Public visible'
                    ]);
                    ?>
                </fieldset>

            </div>
        </div>
    </div>
    <p>&nbsp;</p>
    <?= $this->Form->button($submit_label) ?>
    <?= $this->Form->end() ?>
</div>