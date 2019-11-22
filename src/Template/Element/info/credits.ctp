
<?php
$o = array('target' => '_blank');
?>

<div class="flex-columns">
    <div class="flex-item wide">
        <h3>Initiative</h3>
        <p>
            Created on behalf of a consortium of partners in
            <?= $this->Html->link('DARIAH-RE VCC2', 'https://dariahre.hypotheses.org/about/dariah_vcc2', $o) ?>
            “Research and Education”: <br>
        
            European Research Infrastructure for Language Resources and Technology
            <?= $this->Html->link('CLARIN ERIC', 'https://www.clarin.eu/', $o) ?>,
            Austrian Academy of Sciences
            <?php echo $this->Html->link('ÖAW', 'https://www.oeaw.ac.at/', $o); ?>,
            Royal Netherlands Academy of Arts and Sciences
            (<?php echo $this->Html->link('KNAW', 'https://www.knaw.nl', $o); ?>),
            <?php echo $this->Html->link('eHumanities Group', 'http://www.ehumanities.nl/', $o); ?>,
            Data Archiving and Networked Services
            (<?php echo $this->Html->link('DANS', 'https://dans.knaw.nl', $o); ?>),
            <?php echo $this->Html->link('Erasmus University Rotterdam', 'https://www.eur.nl/', $o); ?>,
            <?php echo $this->Html->link('University of Cologne', 'https://www.uni-koeln.de/', $o); ?>,
            Pôle Informatique de Recherche et d'Enseignement en Histoire
            (<?php echo $this->Html->link('PIREH / University Paris 1', 'http://www.univ-paris1.fr/axe-de-recherche/pireh/', $o); ?>),
            <?php echo $this->Html->link('Georg-August-Universität Göttingen', 'http://www.uni-goettingen.de/', $o); ?>,
            <?php echo $this->Html->link('University of Graz', 'https://www.uni-graz.at/', $o); ?>.
        </p>
    </div>
    <div class="flex-item narrow">
        <h3>Screen Design</h3>
        <p>Lea Giesecke</p>
        <h3>Software Development</h3>
        <p>Hendrik Schmeer</p>
    </div>
</div>


