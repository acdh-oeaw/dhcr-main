<?php $this->set('bodyClasses', 'info'); ?>
<?php $this->start('page_head'); ?>
    <?= $this->Html->image('CLARIN-DARIAH-joint-logo-big.png', [
        'alt' => 'CLARIN-DARIAH joint logo',
        'width' => 256,
        'height' => 200,
        'class' => 'joint-logo']) ?>

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
<?php $this->end(); ?>



<div id="accordeon">
    <div class="accordeon-item" id="how-to-use">
        <h2><span>How to Use</span></h2>
        <div class="item-content">
            <?= $this->Element('info/how_to_use') ?>
        </div>
    </div>

    <div class="accordeon-item" id="contact">
        <h2><span>Contact Us</span></h2>
        <div class="item-content">
            <?= $this->Element('info/contact'); ?>
        </div>
    </div>

    <div class="accordeon-item" id="publications">
        <h2><span>Publications and Dissemination</span></h2>
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


<?php $this->Html->scriptStart(['block' => true]); ?>
    $(document).ready( function() {
        let accordeon = new Accordeon('accordeon');
        $('#imprint-content').load('https://shared.acdh.oeaw.ac.at/acdh-common-assets/api/imprint.php?serviceID=7435');
        $('#footer .imprint').on('click', function(e) {
            e.preventDefault();
            accordeon.openHash('imprint');
        });
    });
<?php $this->Html->scriptEnd(); ?>



