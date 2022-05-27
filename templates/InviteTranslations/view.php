<div class="row">
    <p></p>
    <h2><span class="glyphicon glyphicon-text-color"></span>&nbsp;&nbsp;&nbsp;Translation Details</h2>
    <div class="column-responsive column-80">
        <div class="inviteTranslations view content">
            <h3><?= h($inviteTranslation->language->name) ?></h3>
            <p></p>
            <b><u>Subject</u></b></br>
            <?= h($inviteTranslation->subject) ?>
            <p></p>
            <b><u>Message</u></b></br>
            <?php
            $messageBody = $inviteTranslation->messageBody;
            if ($user->academic_title != null) {
                $fullName = h(ucfirst($user->academic_title)) . ' ';
            } else {
                $fullName = '';
            }
            $fullName = $fullName . h(ucfirst($user->first_name)) . ' ' . h(ucfirst($user->last_name));
            $messageBody = str_replace('-fullname-', $fullName, $messageBody);
            echo $this->Text->autoParagraph(h($messageBody));
            ?>
            <p></p>
            --<br>
            The Digital Humanities Course Registry:<br>
            <?= env('DHCR_BASE_URL'); ?>
        </div>
    </div>
</div>