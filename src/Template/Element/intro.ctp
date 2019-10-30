<?php
use Cake\Routing\Router;
?>

<div id="intro" class="overlay">
    <div class="overlay-container">
        <h1>
            <a href="<?= Router::url('/') ?>">
                <span id="h1">Digital Humanities</span><br>
                <span id="h2">Course</span><span id="h3">Registry</span>
            </a>
        </h1>
        <?= $this->Html->link($this->Html->image('CLARIN-DARIAH-joint-logo-big.png', [
            'alt' => 'CLARIN-DARIAH joint logo',
            'width' => 256,
            'height' => 200]), '/', ['escape' => false, 'class' => 'clarin-dariah-logo']) ?>
        <p class="intent">
            The Digital Humanities Course Registry is a joint effort of two
            European research infrastructures:
            <em>CLARIN ERIC</em> and <em>DARIAH-EU</em>.
        </p>
        <p class="intent">
            It provides a curated database of teaching activities in the
            field of digital humanities worldwide.
        </p>
    </div>
    <div class="overlay-container transparent" id="transparent"></div>
    <div class="overlay-container">
        <div class="flex-columns">
            <div class="flex-item">
                <h2>Students</h2>
                <?= $this->Html->image('students.png', ['class' => 'illustration', 'alt' => 'illustration']); ?>
                <p>
                    Students can find information about programmes and courses
                    in digital humanities, offered in various places and universities.
                </p>
            </div>
            <div class="flex-item">
                <h2>Lecturers</h2>
                <?= $this->Html->image('lecturers.png', ['class' => 'illustration', 'alt' => 'illustration']); ?>
                <p>
                    Lecturers or programme directors can promote their teaching
                    activities on the platform.
                    To add data, lecturers need to sign in.
                </p>
            </div>
        </div>
        <div class="flex-columns buttons">
            <div class="flex-item">
                <?= $this->Html->link('Go to Start', '/', ['class' => 'left blue button', 'id' => 'start']) ?>
            </div>
            <div class="flex-item">
                <?= $this->Html->link('More Information', '/pages/info', ['class' => 'right button']) ?>
            </div>
        </div>
    </div>
</div>
