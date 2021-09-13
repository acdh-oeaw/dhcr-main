
<?php
$o = array('target' => '_blank');
?>

<div class="flex-columns">
    <div class="flex-item wide">
        <h3>Initiative</h3>
        <p>
            The DHCR is supported by these institutions and project grants:
            <?= $this->Html->link('CLARIN ERIC', 'https://www.clarin.eu/', $o) ?>,
            <?= $this->Html->link('DARIAH-EU', 'https://www.dariah.eu/', $o); ?>,
            PARTHENOS (H2020 Grant Agreement n. 654119),
            CLARIN-PLUS (H2020 Grant Agreement n. 676529),
            DHCR Sustain – Improving Sustainability through Usability (DARIAH Theme 2018 (S34D)),
            CLARIAH-AT, CLARIAH (NL).
        </p>
        <p>
            Since 2014, a broader variety of institutios has contributed to the DHCR project:<br>
            DARIAH-EU, CLARIN ERIC, Austrian Academy of Sciences
            (<?= $this->Html->link('ÖAW', 'https://www.oeaw.ac.at/', $o) ?>),
            Royal Netherlands Academy of Arts and Sciences
            (<?= $this->Html->link('KNAW', 'https://www.knaw.nl', $o) ?>),
            <?= $this->Html->link('eHumanities Group', 'http://www.ehumanities.nl/', $o) ?>,
            Data Archiving and Networked Services
            (<?= $this->Html->link('DANS', 'https://dans.knaw.nl', $o) ?>),
            <?= $this->Html->link('Erasmus University Rotterdam', 'https://www.eur.nl/', $o) ?>,
            <?= $this->Html->link('University of Cologne', 'https://www.uni-koeln.de/', $o) ?>,
            Pôle Informatique de Recherche et d'Enseignement en Histoire
            (<?= $this->Html->link('PIREH / University Paris 1', 'http://www.univ-paris1.fr/axe-de-recherche/pireh/', $o) ?>),
            <?= $this->Html->link('Georg-August-Universität Göttingen', 'http://www.uni-goettingen.de/', $o) ?>,
            <?= $this->Html->link('University of Graz', 'https://www.uni-graz.at/', $o) ?>.
        </p>
    </div>
    <div class="flex-item narrow">
        <h3>Coordination</h3>
        <p>
            DARIAH-EU Working Group.
            <a href="https://www.dariah.eu/activities/working-groups/dh-course-registry/" target="_blank">Website</a>
        </p>
        <p class="coordinator">
            Tanja Wissik
        </p>
        <p>
            Administrative co-chair of the working group.<br />
            General coordination, user management, dissemination and acquisition of
            third party funding
            (<?= $this->Html->link('list of projects', '/files/DHCR-third-party-funding.pdf') ?>).
            <a href="https://www.oeaw.ac.at/acdh/team/current-team/tanja-wissik/" target="_blank">Website</a>
        </p>
        <p class="coordinator">
            Hendrik Schmeer
        </p>
        <p>
            Technical co-chair of the working group. <br />
            Coordination of software development, user support and maintenance of the platform.
            <a href="http://hendrikschmeer.de" target="_blank">Website</a>
        </p>
        
        <h3>Screen Design</h3>
        <p>
            Lea Giesecke - <a href="https://linia-design.de/info/" target="_blank">Linia Design</a><br />
            Nicolai Herzog - <a href="http://www.nicolaiherzog.de" target="_blank">Website</a>
        </p>
        
    </div>
</div>


