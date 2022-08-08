<?php
if (sizeof($reminderItem) > 2) {
    $courseWord = 'courses';
} else {
    $courseWord = 'course';
}
?>
Dear <?= $reminderItem['name'] ?>,

The following <?= $courseWord ?> in the Digital Humanities Course Registry <?= (sizeof($reminderItem) > 2) ? 'have ' : 'has '; ?>
not been updated for a long while.

To prevent the registry from showing outdated information, please review the <?= $courseWord ?> below. Please note, that you 
must click "Update Course", even if the information did not change. This will update the 'last-modification-date' of your course.

In case your course or programme does not take place anymore, please uncheck the box "Show course in the registry".

<?php
foreach ($reminderItem as $key => $course) {
    if (!is_object($course)) {
        continue;
    }
    echo 'Course: ' . $course['name'] . "\n";
    echo env('DHCR_BASE_URL') . 'courses/edit/' . $course->id . "\n\n";
}
?>
Thank you for your effort,