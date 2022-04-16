<?php
$this->Html->css('https://use.fontawesome.com/releases/v5.8.2/css/all.css', ['block' => true]);
?>
<h2>Collection of links featured in our social media posts</h2>
<ul id="stories" class="custom-bullets"></ul>
<hr style="margin-bottom: 2em">
<h2>Follow us</h2>
<?= $this->element('follow/social_media') ?>
<?php
$this->Html->script('https://shared.acdh.oeaw.ac.at/dhcr/content.js', ['block' => true]);
$this->Html->scriptStart(['block' => true]);
?>
$(document).ready(function(){
let content = new Content();
content.load();
});
<?php $this->Html->scriptEnd(); ?>