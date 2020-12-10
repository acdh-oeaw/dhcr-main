<?php
use Cake\Core\Configure;
?>
Dear Subscriber,

we proudly inform you about the following new course<?php if(count($courses) > 1) echo "s"; ?>,
that match<?php if(count($courses) == 1) echo "es"; ?> the filter criteria you saved along with your subscription:

<?php
foreach($courses as $course) {
    echo $course->name.", ".$course->institution->name.", "
        .$course->city->name.", ".$course->country->name;
    echo "\n";
    echo Configure::read("dhcr.baseUrl")."courses/view/".$course->id;
    echo "\n\n";
}
?>
--

Your filter criteria:

<?php $presence = ($subscription->online_course !== null)
    ? ($subscription->online_course) ? "online" : "campus"
    : "online/campus"; ?>
Presence: <?= $presence."\n" ?>

<?php
if($subscription->course_types) {
    echo "Education Types:\n";
    foreach($subscription->course_types as $row) {
        echo '• '.$row->name;
        echo "\n";
    }
    echo "\n";
}
if($subscription->countries) {
    echo "Countries:\n";
    foreach($subscription->countries as $row) {
        echo '• '.$row->name;
        echo "\n";
    }
    echo "\n";
}
if($subscription->languages) {
    echo "Languages:\n";
    foreach($subscription->languages as $row) {
        echo '• '.$row->name;
        echo "\n";
    }
    echo "\n";
}
if($subscription->disciplines) {
    echo "Disciplines:\n";
    foreach($subscription->disciplines as $row) {
        echo '• '.$row->name;
        echo "\n";
    }
    echo "\n";
}
if($subscription->tadirah_techniques) {
    echo "Techniques:\n";
    foreach($subscription->tadirah_techniques as $row) {
        echo '• '.$row->name;
        echo "\n";
    }
    echo "\n";
}
if($subscription->tadirah_objects) {
    echo "Objects:\n";
    foreach($subscription->tadirah_objects as $row) {
        echo '• '.$row->name;
        echo "\n";
    }
    echo "\n";
}
?>
--

You can review the filter settings for your subscription here:
<?php echo Configure::read("dhcr.baseUrl")."subscriptions/edit/".$subscription->confirmation_key; ?>

To completely revoke your subscription, please click here:
<?php echo Configure::read("dhcr.baseUrl")."subscriptions/delete/".$subscription->confirmation_key; ?>
