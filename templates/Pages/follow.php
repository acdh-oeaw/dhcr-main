<div class="title">
    <h2>Follow the DH Course Registry</h2>
    <p>Check the options below to learn how you can stay informed about new courses or the latest technical enhancements.</p>
</div>
<div id="accordeon">
    <div class="accordeon-item" id="course-alert">
        <h2><span>Course Alert</span></h2>
        <div class="item-content">
            <p>Enter your e-mail address here to subscribe for new course alerts.</p>
            <?= $this->Element('follow/subscription') ?>
        </div>
    </div>
    <div class="accordeon-item" id="news">
        <h2><span>News on Social Media</span></h2>
        <div class="item-content">
            <?= $this->Element('follow/social_media'); ?>
        </div>
    </div>
    <div class="accordeon-item" id="newsletter">
        <h2><span>Contributor Mailing List</span></h2>
        <div class="item-content">
            <?= $this->Element('follow/newsletter') ?>
        </div>
    </div>
</div>
<?php $this->Html->script(['accordeon', 'hash'], ['block' => true]); ?>
<?php $this->Html->scriptStart(['block' => true]); ?>
$(document).ready( function() {
let accordeon = new Accordeon('accordeon');
sitemap.setAccordeonHandler(accordeon, 'follow');
});
<?php $this->Html->scriptEnd(); ?>