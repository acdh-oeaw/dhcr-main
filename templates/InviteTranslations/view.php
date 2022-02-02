<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\InviteTranslation $inviteTranslation
 */
?>
<div class="row">
    <p></p>
    <h2><span class="glyphicon glyphicon-text-color"></span>&nbsp;&nbsp;&nbsp;Invite Translations </h2>
    <div class="column-responsive column-80">
        <div class="inviteTranslations view content">
            <h3><?= h($inviteTranslation->name) ?></h3>
            <p></p>
            <b><u>Subject</u></b></br>
            <?= h($inviteTranslation->subject) ?>
            <p></p>
            <b><u>Message</u></b></br>
            <?= $this->Text->autoParagraph(h($inviteTranslation->messageBody)); ?>
            <p></p>
            <?= h(ucfirst($user->academic_title)) .' ' .h(ucfirst($user->first_name))  .' ' 
                .h(ucfirst($user->last_name)) . ' ' .h($inviteTranslation->messageSignature) ?>
        </div>
    </div>
</div>
