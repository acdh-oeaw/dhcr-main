<?php
use Cake\Core\Configure;
?>

<div class="flex-columns">
    <div class="flex-item">
        <?= $this->Html->image('students.png', ['class' => 'illustration', 'alt' => 'illustration']); ?>
        <h3>Students</h3>
        <p>
            Do you want to start a university programme in digital humanities
            or want to study one semester abroad?
            Find all information about programmes and courses offered in
            various places and universities here on the DHCR.
        </p>
        <p>
            The collection of courses and programmes can be viewed without registration.
            To ensure all content is up to date, all data in the DHCR is actively
            maintained by the lecturers or departments themselves.
            You can search for courses based on different criteria, for example
            location, disciplines, or degrees awarded.
        </p>
        <p>
            The DHCR has been collecting course data since 2014.
            Historical data can be retrieved using the open
            <?= $this->Html->link('DHCR-API', Configure::read('api.baseUrl'), ['target' => '_blank']) ?>.
        </p>
    </div>
    <div class="flex-item">
        <?= $this->Html->image('lecturers.png', ['class' => 'illustration', 'alt' => 'illustration']); ?>
        <h3>Lecturers</h3>
        <?= $this->element('info/lecturers') ?>
    </div>
</div>
<hr>
<div class="">
    <h3>What type of courses can be submitted?</h3>
    <ul class="custom-bullets css-columns">
        <li>Online courses</li>
        <li>On-site courses</li>
        <li>One-off workshops or recurring courses</li>
        <li>BA or MA programmes</li>
        <li>PhD programmes or seminars</li>
        <li>Courses or modules</li>
        <li>Training of professionals (continuing education)</li>
        <li>Summer schools within DH</li>
    </ul>
    <p>
        Courses held in any language or country can be submitted.
        We recommend providing English metadata to increase international accessibility.
    </p>
</div>
<hr />
<div class="flex-columns">
    <div class="flex-item triple">
        <h4>The Course Registry</h4>
        <div class="iframe-container">
            <?= $this->Html->image('16x9.png', ['class' => 'ratio']) ?>
            <iframe src="https://www.youtube.com/embed/pvFKq67-21I?rel=0"
                    allow="encrypted-media" allowfullscreen></iframe>
        </div>
    </div>
    <div class="flex-item triple">
        <h4>How to use as a Student</h4>
        <div class="iframe-container">
            <?= $this->Html->image('16x9.png', ['class' => 'ratio']) ?>
            <iframe src="https://www.youtube.com/embed/s-YsnpKCaUE?rel=0"
                    allow="autoplay; encrypted-media" allowfullscreen></iframe>
        </div>
    </div>
    <div class="flex-item triple">
        <h4>How to use as a Lecturer</h4>
        <div class="iframe-container">
            <?= $this->Html->image('16x9.png', ['class' => 'ratio']) ?>
            <iframe src="https://www.youtube.com/embed/X87p0XoBlZo?rel=0"
                    allow="encrypted-media" allowfullscreen></iframe>
        </div>
    </div>
</div>
