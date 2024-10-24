<?= $this->Html->image('CLARIN-DARIAH-joint-logo-big.png', [
    'alt' => 'CLARIN-DARIAH joint logo',
    'width' => 256,
    'height' => 200,
    'class' => 'joint-logo'
]) ?>
<h1>
    Digital Humanities Course Registry
    <?= $this->Html->image('logo-500.png', [
        'alt' => 'logo',
        'width' => 500,
        'height' => 114,
        'url' => '/'
    ]) ?>
</h1>
<div class="title intent">
    <p>
        The Digital Humanities Course Registry is a curated platform that provides
        an overview of the growing range of teaching activities in the field
        of digital humanities worldwide.
    </p>
    <p>
        The platform is a joint effort of two European research infrastructures: <br />
        <?= $this->Html->link('CLARIN-ERIC', 'https://www.clarin.eu/', ['target' => '_blank']); ?> and
        <?= $this->Html->link('DARIAH-EU', 'https://www.dariah.eu/', ['target' => '_blank']); ?>.
    </p>
</div>
<div id="accordeon">
    <div class="accordeon-item" id="purpose">
        <h2><span>How to Use DHCR</span></h2>
        <div class="item-content">
            <?= $this->Element('info/purpose') ?>
        </div>
    </div>
    <div class="accordeon-item" id="contact">
        <h2><span>Contact Us</span></h2>
        <div class="item-content">
            <?= $this->Element('info/contact'); ?>
        </div>
    </div>
    <div class="accordeon-item" id="publications">
        <h2><span>Dissemination and Impact</span></h2>
        <div class="item-content">
            <?= $this->Element('info/publications') ?>
        </div>
    </div>
    <div class="accordeon-item" id="data">
        <h2><span>Data Export and API</span></h2>
        <div class="item-content">
            <?= $this->Element('info/data-api') ?>
        </div>
    </div>
    <div class="accordeon-item" id="clarin-dariah">
        <h2><span>CLARIN and DARIAH</span></h2>
        <div class="item-content">
            <?= $this->Element('info/clarin-dariah') ?>
        </div>
    </div>
    <div class="accordeon-item" id="social-media">
        <h2><span>Social Media</span></h2>
        <div class="item-content">
            <?= $this->Element('info/social-media') ?>
        </div>
    </div>
    <div class="accordeon-item" id="faq-public">
        <h2><span>FAQ</span></h2>
        <div class="item-content">
            <?= $this->Element('info/faq-public') ?>
        </div>
    </div>
    <div class="accordeon-item" id="credits">
        <h2><span>Credits</span></h2>
        <div class="item-content">
            <?= $this->Element('info/credits'); ?>
        </div>
    </div>
    <div class="accordeon-item" id="imprint">
        <h2><span>Imprint</span></h2>
        <div class="item-content" id="imprint-content"></div>
    </div>
    <div class="accordeon-item" id="release-notes">
        <h2><span>Version & Release Notes</span></h2>
        <div class="item-content" id="release-notes">
            <?= $this->Element('info/release-notes'); ?>
        </div>
    </div>
</div>
<?php $this->Html->script(['accordeon', 'hash'], ['block' => true]); ?>
<?php $this->Html->scriptStart(['block' => true]); ?>
$(document).ready( function() {
let accordeon = new Accordeon('accordeon');
$('#imprint-content').load('https://imprint.acdh.oeaw.ac.at/7435');
$('#footer .imprint').on('click', function(e) {
e.preventDefault();
accordeon.openHash('imprint');
});
$('#contact-button').on('click', function(e) {
e.preventDefault();
accordeon.openHash('contact');
});
sitemap.setAccordeonHandler(accordeon, 'info');
});
<?php $this->Html->scriptEnd(); ?>
<?php $this->Html->css('info', ['block' => true]); ?>