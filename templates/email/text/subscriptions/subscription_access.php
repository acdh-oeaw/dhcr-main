<?php
use Cake\Core\Configure;
?>
Dear Subscriber,

your subscription is <?php if($isNew) echo 'now '; ?>active and you
can manage your subscription by clicking on the links below.

Click here to edit the filter settings of your subscription:
<?php echo Configure::read("dhcr.baseUrl")."subscriptions/edit/".$subscription->confirmation_key; ?>

Delete your subscription:
<?php echo Configure::read("dhcr.baseUrl")."subscriptions/delete/".$subscription->confirmation_key; ?>

--

Your current filter criteria:

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
