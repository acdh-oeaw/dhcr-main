<?php
use Cake\Core\Configure;

$this->Html->css('https://use.fontawesome.com/releases/v5.8.2/css/all.css', ['block' => true]);
?>

<h3 class="follow">
    <a href="https://instagram.com/dhcourseregistry" target="_blank">
       <span class="fab fa-instagram"></span>
       Instagram
    </a>
</h3>
<h3 class="follow">
    <a href="https://twitter.com/hashtag/dhcourseregistry?src=hash" target="_blank">
        <span class="fab fa-twitter"></span>
        Twitter
    </a>
</h3>
<h3 class="follow">
    <a href="https://www.facebook.com/hashtag/dhcourseregistry" target="_blank">
        <span class="fab fa-facebook"></span>
        Facebook
    </a>
</h3>
<h3 class="follow">
    <a href="https://www.youtube.com/watch?v=D-5kmQoPvOU&list=PLfWGHIkSIx0V2mYqdbfRHOHuBz-CbX4EW" target="_blank">
        <span class="fab fa-youtube"></span>
        YouTube
    </a>
</h3>


<h3>Collection of links featured in our social media posts</h3>
<ul id="stories" class="custom-bullets"></ul>

<?php
if(Configure::read('debug'))
    $this->Html->script('https://shared.acdh.oeaw.ac.at/dhcr/content.js', ['block' => true]);
else
    $this->Html->script('stories.js', ['block' => true]);
$this->Html->scriptStart(['block' => true]);
?>
$(document).ready(function(){
    let content = new Content();
    content.load();
});
<?php $this->Html->scriptEnd(); ?>
