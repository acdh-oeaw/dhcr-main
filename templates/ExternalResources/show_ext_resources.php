<div class="courses edit content">
    <p></p>
    <h2><span class="glyphicon glyphicon-th-list"></span>&nbsp;&nbsp;&nbsp;Show External Resources per Course</h2>
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
    <p><i>As of May 2025, the course contributors can add CLARIN and DARIAH external resources they use in their course / programme / summer school.
        An external resource can be "Dataset, Training Material, Service or Software". Course contributors can add as many resources as they need.</i></p>
    <?= $this->Html->link('Add External Resource', ['action' => 'addExtResource', $course->id], ['class' => 'button float-right']) ?>
    <p></p>
    <?php foreach ($course->external_resources as $externalResource) : ?>
        <?= h($externalResource->affiliation) ?> <?= h($externalResource->type) ?>: <?= h($externalResource->label) ?><br>
        <?= $this->Html->link($externalResource->url) ?><br>
        <?php
        if ($externalResource->visible) {
            echo '<span class="glyphicon glyphicon-ok-circle"></span>&nbsp;&nbsp;Public visible';
        } else {
            echo '<span class="glyphicon glyphicon-ban-circle"></span>&nbsp;&nbsp;Not visible';
        }
        ?><br>
        <?= $this->Html->link('<span class="glyphicon glyphicon-pencil"></span> Edit', ['action' => 'editExtResource', $externalResource->id], ['escape' => false]) ?>
        <p></p>
        <hr>
        <p></p>
    <?php endforeach; ?>
    <?= $this->Html->link('Back to Edit Course', ['controller' => 'Courses', 'action' => 'edit', $course->id], ['class' => 'button float-right']) ?>
    <p></p>
    <?= $this->Html->link('Back to Administrate Courses', ['controller' => 'Dashboard', 'action' => 'adminCourses'], ['class' => 'button float-right']) ?>
</div>