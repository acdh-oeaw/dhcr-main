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
            Historical data or very specific queries can be retrieved using the open
            <?= $this->Html->link('DHCR-API', Configure::read('api.baseUrl'), ['target' => '_blank']) ?>.
        </p>
    </div>
    <div class="flex-item">
        <?= $this->Html->image('lecturers.png', ['class' => 'illustration', 'alt' => 'illustration']); ?>
        <h3>Lecturers</h3>
        <p>
            Lecturers or progamme administrators can promote their DH-related
            teaching activities on the Digital Humanities Course Registry.
            To add data, lecturers need to sign in. We require all data
            contributors to actively maintain their data at least once per year.
        </p>
        <p>
            The system will regularly send out email reminders, whenever a data set
            is about to expire. Course data that is not revised for one and a half year
            will disappear from the public listing and remains archived
            for later research. The system also performs a regular link checking
            on URLs provided with the data.
        </p>
        <div class="buttons">
            <?= $this->Html->link('Login', Configure::read('ops.baseUrl').'users/login',
                ['class' => 'button', 'id' => 'login-button']) ?>
            <?= $this->Html->link('Register', Configure::read('ops.baseUrl').'users/register',
                ['class' => 'blue button', 'id' => 'register-button']) ?>
        </div>
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
            <iframe src="https://www.youtube.com/embed/78TwdVY3LRc?rel=0"
                    allow="autoplay; encrypted-media" allowfullscreen></iframe>
        </div>
    </div>
    <div class="flex-item triple">
        <h4>How to use as a Lecturer</h4>
        <div class="iframe-container">
            <?= $this->Html->image('16x9.png', ['class' => 'ratio']) ?>
            <iframe src="https://www.youtube.com/embed/p_X7K2b1D9g?rel=0"
                    allow="encrypted-media" allowfullscreen></iframe>
        </div>
    </div>
</div>
