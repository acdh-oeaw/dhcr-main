<div class="row">
    <p></p>
    <h2><span class="glyphicon glyphicon-<?= $course_icon ?>"></span>&nbsp;&nbsp;&nbsp;<?= $course_action ?></h2>
    <div class="column-responsive column-80">
        Please provide the metadata in <b><u>English</u></b>, independent from the language the course is held in.
        <p>&nbsp;</p>
        <div class="courses form content">
            <?= $this->Form->create($course) ?>
            <fieldset>
                <legend><?= __($course_action) ?></legend>
                <?php
                echo $this->Form->control('name', ['label' => 'Course Name*', 'placeholder' => 'Please provide the course name in English']);
                echo $this->Form->control('online_course');
                echo $this->Form->control('course_type_id', ['label' => 'Education Type*', 'options' => $course_types,  'empty' => true]);
                echo $this->Form->control('language_id', ['label' => 'Language*', 'options' => $languages, 'empty' => true]);
                echo $this->Form->control('ects', ['label' => 'ECTS', 'placeholder' => 'Leave blank if not applicable']);
                ?>
                Credit points rewarded within the European Credit Transfer and Accumulation System (ECTS).
                <p>&nbsp;</p>
                <?php
                echo $this->Form->control('info_url', ['label' => 'Course URL*', 'placeholder' => 'The public web address of the course description and syllabus']);
                echo $this->Form->control('contact_name', ['label' => 'Lecturer Name']);
                echo $this->Form->control('contact_mail', ['label' => 'Lecturer E-Mail']);
                echo $this->Form->control('description', ['label' => 'Description', 'placeholder' => 'Please provide the course description in English']);
                echo $this->Form->control('access_requirements', ['label' => 'Entry Requirements', 'placeholder' => 'For instance: if you want to enroll in this MA module, you need to hold a BA degree in X, Y, Z']);
                ?>
                <p>&nbsp;</p>
                <p>For <strong><u>recurring start dates</u></strong>, please enter all dates over one full year, when students can start the course.
                    These dates only consist of [month]-[day] and are meant to be valid in subsequent years.</p>
                <p><strong><u>One-off start dates</u></strong> consist of a full date
                    [year]-[month]-[day] and invalidate the course entry after their expiry. Multiple dates can be separated by semicolon.<br>
                    The course will disappear from the list after the last one-off date has expired.</p>
                <?php
                echo $this->Form->control('start_date', ['label' => 'Start Date*']);
                echo $this->Form->control('recurring', ['label' => 'Recurring']);
                echo $this->Form->control('duration', ['label' => 'Duration*']);
                echo $this->Form->control('course_duration_unit_id', ['label' => 'Duration type*', 'options' => $course_duration_units, 'empty' => true]);
                echo $this->Form->control('institution_id', ['label' => 'Institution*', 'options' => $institutions, 'default' => $user->institution_id]);
                echo $this->Form->control('department', ['label' => 'Department*']);
                echo $this->Form->hidden('lon', ['id' => 'lon', 'default' => $mapInit['lon']]);
                echo $this->Form->hidden('lat', ['id' => 'lat', 'default' => $mapInit['lat']]);
                ?>
                <strong><u>Location</u></strong><br>
                Coordinates can be drawn in from the institution selector above. If not applicable, adjust using the location picker.<br>
                Changing your selection from the institutions list above will overwrite the current coordinate value.<br>
                -You can zoom using the scroll wheel.<br>
                -You can move the map, by dragging with the mouse.<br>
                -Place the blue marker on the correct position, it will be saved automatically.
                <p></p>
                <?php
                echo $this->element('locationpicker');  // include locationpicker
                echo $this->element('update_map_by_institution');  // include handling of institution selector
                echo '<p></p>';
                echo $this->Form->control('disciplines._ids', [
                    'label' => 'Disciplines*',
                    'options' => $disciplines,
                    'multiple' => 'multiple',
                    'val' => $selectedDisciplines
                ]);
                echo '<i>You can select more than one item.</i><p></p>';
                echo '<p></p>';
                echo $this->Form->control('tadirah_techniques._ids', [
                    'label' => 'TaDiRAH Techniques*',
                    'options' => $tadirah_techniques,
                    'multiple' => 'multiple',
                    'val' => $selectedTadirahTechniques
                ]);
                echo '<i>You can select more than one item.</i><p></p>';
                echo '<p></p>';
                echo $this->Form->control('tadirah_objects._ids', [
                    'label' => 'TaDiRAH Objects*', 
                    'options' => $tadirah_objects, 
                    'multiple' => 'multiple',
                    'val' => $selectedTadirahObjects
                ]);
                echo '<i>You can select more than one item.</i><p></p>';
                ?>
                <strong><u>TaDiRAH</u></strong> is a taxonomy of Digital Research Activities in the Humanities that includes labels for tasks, techniques and objects,
                and other sub-disciplines from the field of Social Sciences and the Humanities. Learn more at:
                <a href="https://tadirah.info">https://tadirah.info</a>
                <p>&nbsp;
                    <?= $this->Form->control('active', ['label' => 'Show course in the registry']); ?>
                    Check this box if your course is ready to be published in the registry.<br>
                    When unchecked, you will be able to complete the course description later.
                </p>
            </fieldset>
            <p>&nbsp;</p>
            <?= $this->Form->button(__($course_submit_label)) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>