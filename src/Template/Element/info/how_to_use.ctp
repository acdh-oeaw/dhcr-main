<div class="flex-columns">
    <div class="flex-item">
        <?= $this->Html->image('students.png', ['class' => 'illustration', 'alt' => 'illustration']); ?>
        <h3>Students</h3>
        <p>
            Starting a university programme in digital humanities
            or want to study one semester abroad,
            students can find information about programmes
            and courses offered in various places and universities.
        </p>
        <p>
            The collection of courses and programs can be searched without registration.
            To hold only useful and most up-to-date content, all data in the DHCR
            is actively maintained by the lecturers or departments themselves.
            Courses can be searched based on location, disciplines, research techniques
            or objects and degrees awarded.
        </p>
        <p>
            Historical data or very specific queries can be retrieved using
            the open DHCR-API for research or programme decisions.
            The DHCR is collecting course data starting from 2014.
        </p>
    </div>
    <div class="flex-item">
        <?= $this->Html->image('lecturers.png', ['class' => 'illustration', 'alt' => 'illustration']); ?>
        <h3>Lecturers</h3>
        <p>
            Lecturers or progamm administrators can promote their DH-related
            teaching activities on the Digital Humanities Course Registry.
            To add data, lecturers need to sign in. We require all data
            contributors to actively maintain their data at least once per year.
        </p>
        <p>
            The system will regularly send out email reminders, whenever a data set
            is about to expire. Course data not revised for one and half a year
            will disappear from the public listing and remains archived
            for later research. The system also performs regular link checking
            on URLs provided with the data.
        </p>
        <div class="buttons">
            <button id="login">Login</button>
            <button id="register" class="blue">Register</button>
        </div>
    </div>
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
