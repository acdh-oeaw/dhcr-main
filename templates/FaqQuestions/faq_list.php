<?php
switch ($categoryId) {
    case 2:
        $icon = 'education';
        break;
    case 3:
        $icon = 'list-alt';
        break;
    default:
        $icon = 'question-sign';
}
if ($categoryName == 'Public') {
    echo '<div class="title intent">';
}
?>
<div class="faq content">
    <p></p>
    <h2><span class="glyphicon glyphicon-<?= $icon ?>"></span>&nbsp;&nbsp;&nbsp;
        <?= ($categoryName != 'Public') ? $categoryName . ' ' : '' ?>FAQ</h2>
    <?php
    if (sizeof($faqQuestions) > 0) {
        echo '<strong><u>Contents</u></strong>';
        echo '<ul>';
        foreach ($faqQuestions as $faqQuestion) {
            echo '<li><a href="#question' . $faqQuestion->id . '">' . $faqQuestion->question . '</a></li>';
        }
        echo '</ul>';
    } else {
        echo 'Currently no questions available for this list.';
    }
    ?>
    <p>&nbsp;</p>
    <?php
    foreach ($faqQuestions as $faqQuestion) {
        echo '<h3 id="question' . $faqQuestion->id . '">' . $faqQuestion->question . '</h3>';
        echo '<h4>' . $this->Text->autoParagraph(h($faqQuestion->answer));
        if (strlen($faqQuestion->link_url) > 0) {
            echo 'Link: ' . $this->Html->link($faqQuestion->link_title, $faqQuestion->link_url);
        }
        echo '</h4>';
        echo '<p>&nbsp;</p>';
    }
    ?>
</div>
<?php
if ($categoryName == 'Public') {
    echo '</div>';
}
?>