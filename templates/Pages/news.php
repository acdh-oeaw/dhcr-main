<?php
$this->Html->css('https://use.fontawesome.com/releases/v5.8.2/css/all.css', ['block' => true]);
?>

<h2>Collection of links featured in our social media posts</h2>
<ul id="stories" class="custom-bullets"></ul>

<hr style="margin-bottom: 2em">

<h2>Follow us here</h2>
<div class="grid-columns" style="grid-row-gap: 0">
    <h3 class="follow grid-item">
        <a href="https://instagram.com/dhcourseregistry" target="_blank">
            <span class="fab fa-instagram"></span>
            Instagram
        </a>
    </h3>
    <h3 class="follow grid-item">
        <a href="https://twitter.com/hashtag/dhcourseregistry?src=hash" target="_blank">
            <span class="fab fa-twitter"></span>
            Twitter
        </a>
    </h3>
    <h3 class="follow grid-item">
        <a href="https://www.facebook.com/hashtag/dhcourseregistry" target="_blank">
            <span class="fab fa-facebook"></span>
            Facebook
        </a>
    </h3>
    <h3 class="follow grid-item">
        <a href="https://www.youtube.com/watch?v=D-5kmQoPvOU&list=PLfWGHIkSIx0V2mYqdbfRHOHuBz-CbX4EW" target="_blank">
            <span class="fab fa-youtube"></span>
            YouTube
        </a>
    </h3>
</div>





<?php
$this->Html->script('https://shared.acdh.oeaw.ac.at/dhcr/content.js', ['block' => true]);
$this->Html->scriptStart(['block' => true]);
?>
$(document).ready(function(){
    let content = new Content();
    content.load();
});
<?php $this->Html->scriptEnd(); ?>
