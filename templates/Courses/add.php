<div class="row">
    <p></p>
    <h2><span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;&nbsp;Add Course</h2>
    <div class="column-responsive column-80">
        Please provide the meta data in <b><u>English</u></b>, independent from the language the course is held in.
        <p>&nbsp;</p>
        <div class="courses form content">
            <?= $this->Form->create($course) ?>
            <fieldset>
                <legend><?= __('Add Course') ?></legend>
                <?php
                echo $this->Form->control('name', ['label' => 'Course Name* (in English)']);
                echo $this->Form->control('online_course');
                echo $this->Form->control('course_type_id', ['label' => 'Education Type*', 'options' => $course_types,  'empty' => true]);
                echo $this->Form->control('language_id', ['label' => 'Language*', 'options' => $languages, 'empty' => true]);
                ?>
                <p>&nbsp;</p>
                Credit points rewarded within the European Credit Transfer and Accumulation System (ECTS). Leave blank if not applicable:
                <?php
                echo $this->Form->control('ects');
                ?>
                <p>&nbsp;</p>
                Official publication location of your course information, where more detailed information like curricula or module handbooks 
                are available:
                <?php
                echo $this->Form->control('info_url', ['label' => 'Source URL*']);
                echo $this->Form->control('contact_name', ['label' => 'Lecturer Name']);
                echo $this->Form->control('contact_mail', ['label' => 'Lecturer E-Mail']);
                echo $this->Form->control('description', ['label' => 'Description (in English)']);
                echo $this->Form->control('access_requirements ', ['label' => 'Access Requirements (in English)']);
                ?>
                <p>&nbsp;</p>
                For recurring start dates, please enter all dates over one full year, when students can start the course. These dates only 
                consist of [month]-[day] and are meant to be valid in subsequent years. One-off start dates consist of a full date 
                [year]-[month]-[day] and invalidate the course entry after their expiry. Multiple dates can be separated by semicolon. <br>
                The course will disappear from the list, after the last one-off date has expired:
                <?php
                echo $this->Form->control('start_date', ['label' => 'Start Date*']);
                echo $this->Form->control('recurring', ['label' => 'Recurring']);
                echo $this->Form->control('duration', ['label' => 'Duration*']);
                echo $this->Form->control('course_duration_unit_id', ['label' => 'Duration type*', 'options' => $course_duration_units, 'empty' => true]);
                echo $this->Form->control('institution_id', ['label' => 'Institution*', 'options' => $institutions, 'empty' => true]);
                echo $this->Form->control('department', ['label' => 'Department*']);
                ?>
                <p>&nbsp;</p>
                <b>Location</b><br>
                 Coordinates can be drawn in from the institution selector above. If not applicable, adjust using the location picker. 
                 Changing your selection from the institutions list above will overwrite the current coordinate value. Zoom and pan the map 
                 until the crosshair is over the right place. Then click on the red marker icon to confirm your selection:
                <?php
                echo $this->Form->control('lon', ['label' => 'Lon*']);
                echo $this->Form->control('lat', ['label' => 'Lat*']);
                echo $this->Form->control('courses_disciplines', ['label' => 'Disciplines*', 'options' => $disciplines, 'multiple' => 'multiple']);
                echo $this->Form->control('courses_tadirah_techniques', ['label' => 'Tadirah Techniques*', 'options' => $tadirah_techniques, 'multiple' => 'multiple']);
                echo $this->Form->control('courses_tadirah_objects', ['label' => 'Tadirah Objects*', 'options' => $tadirah_objects, 'multiple' => 'multiple']);
                ?>
                <p>&nbsp;</p>
                Check this box to show the course in the registry. If you leave this box unchecked, the course will not appear in the public 
                listing, so you can complete editing later.
                <?php
                echo $this->Form->control('active', ['label' => 'Show course in the registry']);
                ?>
            </fieldset>
            <p>&nbsp;</p>
            <?= $this->Form->button(__('Add this Course')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>