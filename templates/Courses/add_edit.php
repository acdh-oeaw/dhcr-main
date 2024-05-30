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
                echo $this->Form->control('description', ['label' => 'Description *', 'placeholder' => 'Please add in English the general aims of the course/programme and the learning outcomes.']);
                echo $this->Form->control('access_requirements', ['label' => 'Entry Requirements', 'placeholder' => 'For instance: if you want to enroll in this MA module, you need to hold a BA degree in X, Y, Z']);
                echo '<p id="start_date">&nbsp;</p>';   // internal url
                echo $this->Form->control('start_date', ['label' => 'Start Date*', 'onclick' => 'openForm()', 'placeholder' => 'YYYY-MM-DD']);
                ?>
                <p>At least one valid date in the format YYYY-MM-DD is needed. It's possible to enter multiple dates. Preferbly use the pop-up datepicker 
                    if your browser supports this. Otherwise you can enter the dates manually, separated by a semicolon. <br>Example: 2024-03-15;2024-06-15</p>
                <p>For <strong><u>recurring</u></strong> start dates, please enter all dates over one full year and check the box "Recurring".</p>
                <p>A <strong><u>non-recurring</u></strong> course will be removed from the public list 16 months after the last date has
                    been expired. Multiple dates can be entered.</p>
                <?php
                echo $this->Form->control('recurring', ['label' => 'Recurring (Does the course start on the same date(s) next year)?', 'default' => false]);
                echo '<p>&nbsp;</p>';
                echo $this->Form->control('duration', ['label' => 'Duration*']);
                echo $this->Form->control('course_duration_unit_id', ['label' => 'Duration type*', 'options' => $course_duration_units, 'empty' => true]);
                echo $this->Form->control('institution_id', ['label' => 'Institution*', 'options' => $institutions, 'default' => $user->institution_id]);
                echo '<p>If your institution is not listed, please contact your '
                    . $this->Html->link('national moderator', ['controller' => 'Pages', 'action' => 'nationalModerators']) . '.</p>';
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

<!-- Startdate popup begin -->
<style>
    * {
        box-sizing: border-box;
    }

    .startdatePopup {
        position: relative;
        text-align: center;
        width: 100%;
    }

    .formPopup {
        display: none;
        position: fixed;
        left: 45%;
        top: 5%;
        transform: translate(-50%, 5%);
        border: 3px solid #999999;
        z-index: 9;
    }

    .formContainer {
        min-width: 310px;
        padding: 20px;
        background-color: #fff;
    }

    .formContainer .btn {
        padding: 12px 20px;
        border: none;
        background-color: #1E6BA3;
        color: #fff;
        cursor: pointer;
        width: 100%;
        margin-bottom: 15px;
        opacity: 0.8;
    }

    .formContainer .cancel {
        background-color: #cc0000;
    }


    .formContainer .btn:hover {
        opacity: 1;
    }
</style>
<div class="startdatePopup">
    <div class="formPopup" id="popupForm">
        <form class="formContainer">
            <h2>Start date</h2>
            <span class="glyphicon glyphicon-plus"></span>&nbsp;<a href="#start_date" onclick="addDate()">Add date</a>
            <div id="datepicker" hidden="true">
                <p></p>
            </div>
            <p></p>
            <p id="dateList"></p>
            <p></p>
            <button type="button" class="btn cancel" onclick="closeForm()">Cancel</button>
            <button type="button" class="btn" onclick="save()">Finish</button>
        </form>
    </div>
</div>
<script>
    var startdates = [];

    function updateDateListHtml(startdates) {
        var dateList = '';
        id = 0;
        for (startdate of startdates) {
            dateList += startdate + '&nbsp;&nbsp;&nbsp;<a href="#start_date" onclick="removeDate(' + id + ')">Remove</a><br>';
            id++;
        }
        document.getElementById("dateList").innerHTML = dateList;
    }

    function openForm() {
        var startdateField = document.getElementById("start-date").value;
        if (startdateField.length > 0) {
            startdates = startdateField.split(';')
            startdates.sort();
        }
        updateDateListHtml(startdates);
        document.getElementById("popupForm").style.display = "block";
    }

    function addDate() {
        document.getElementById('datepicker').hidden = false;
    }

    function removeDate(id) {
        startdates.splice(id, 1);
        updateDateListHtml(startdates);
    }

    function closeForm() {
        document.getElementById("popupForm").style.display = "none";
    }

    function save() {
        var startdateField = '';
        var isFirst = true;
        for (startdate of startdates) {
            if (isFirst) {
                isFirst = false;
            } else {
                startdateField += ';';
            }
            startdateField += startdate;
        }
        document.getElementById("start-date").value = startdateField;
        closeForm();
    }
</script>
<!-- Startdate popup end -->

<!-- Datepicker begin -->
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script>
    var $j = jQuery.noConflict();
    $j(function() {
        $j("#datepicker").datepicker({
            showWeek: true,
            firstDay: 1,
            dateFormat: "yy-mm-dd",
            onSelect: function(dateText, inst) {
                startdates.push(dateText);
                startdates.sort();
                updateDateListHtml(startdates);
                document.getElementById('datepicker').hidden = true;
            }
        });
    });
</script>
<!-- Datepicker end -->