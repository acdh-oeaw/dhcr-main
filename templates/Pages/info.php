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
        <h2><span>Purpose and Audience</span></h2>
        <div class="item-content">
            <?= $this->Element('info/purpose') ?>
        </div>
    </div>
    <div class="accordeon-item" id="contact">
        <h2><span>Join Our Network</span></h2>
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
        <h2><span>Data and API</span></h2>
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
</div>
<?php $this->Html->script(['accordeon', 'hash'], ['block' => true]); ?>
<?php $this->Html->scriptStart(['block' => true]); ?>
$(document).ready( function() {
let accordeon = new Accordeon('accordeon');
$('#imprint-content').load('https://shared.acdh.oeaw.ac.at/acdh-common-assets/api/imprint.php?serviceID=7435');
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