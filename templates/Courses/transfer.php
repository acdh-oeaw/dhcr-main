<div class="row">
    <p></p>
    <h2><span class="glyphicon glyphicon-transfer"></span>&nbsp;&nbsp;&nbsp;Transfer Course</h2>
    <div class="column-responsive column-80">
        <p style="padding: 1.2em; border: 1px solid #ffbf01; border-radius: 5px; background-color: #ffe59cf7; font-weight: bolder; color: #6d7278; font-size: 0.8rem; margin-bottom: 2em; ">
            The <strong><u><i>course owner</i></u></strong> is the person who has entered the course in the registry, can see
            it in My Courses and receives the reminder emails. These details are not public visible.
            <br>&nbsp;<br>
            The <strong><u><i>lecturer</i></u></strong> name and email address are shown public in the course detail page.
            <br>&nbsp;<br>
            <u>Please mind checking / updating both of them, when transfering a course.</u>
            <br>&nbsp;<br>
            Moderators can transfer courses between users within their moderated country. Admins can transfer between all users.
            <br>&nbsp;<br>
            Transfering a course does not update the course. If the course is outdated you need to update it separately.
        </p>
        <strong><u>Course details</u></strong>
        <table>
            <tr>
                <td style="padding: 5px">Course name:</th>
                <td style="padding: 5px"><?= h($course->name) ?></td>
            </tr>
            <tr>
                <td style="padding: 5px">Course <u>owner</u> name:</th>
                <td style="padding: 5px"><?= ucfirst($course->user->academic_title) . ' ' . ucfirst($course->user->first_name) . ' ' . ucfirst($course->user->last_name) ?></td>
            </tr>
            <tr>

                <td style="padding: 5px">Course <u>owner</u> email address:</th>
                <td style="padding: 5px"><?= h($course->user->email) ?></td>
            </tr>
            <tr>

                <td style="padding: 5px">Lecturer name:</th>
                <td style="padding: 5px"><?= h($course->contact_name) ?></td>
            </tr>
            <tr>
                <td style="padding: 5px">Lecturer email address:</th>
                <td style="padding: 5px"><?= h($course->contact_mail) ?></td>
            </tr>
        </table>
        <p></p>
        <div class="courses form content">
            <?= $this->Form->create($course) ?>
            <fieldset>
                <legend><?= __('Transfer Course') ?></legend>
                <p></p>
                <?php
                echo $this->Form->control('user_id', ['label' => 'Select new course owner by lastname', 'options' => $usersList,  'empty' => true]);
                echo '<p></p>';
                echo '<strong>Check / update lecturer details:</strong><p></p>';
                echo $this->Form->control('contact_name', ['label' => 'Lecturer Name']);
                echo $this->Form->control('contact_mail', ['label' => 'Lecturer Email Address']);
                ?>
                <p></p>
            </fieldset>
            <p>&nbsp;</p>
            <?= $this->Form->button(__('Transfer Course')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>