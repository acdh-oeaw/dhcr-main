<?php

use Cake\Core\Configure;
?>
<div class="flex-columns">
    <div class="flex-item">
        <h3>Administrators</h3>
        <p>For technical questions or yet not moderated countries, please seek contact to the administration board.</p>
        <p>Before you contact us, please check the
            <?= $this->Html->link('FAQ page', ['controller' => 'faqQuestions', 'action' => 'faqList', 'public']) ?>
            to see if your enquiry has already been answered.</p>
        <div class="css-columns admins">
            <p>
                <?php
                foreach ($userAdmins as $i => $mod) {
                    echo $this->Html->link(
                        $mod['first_name'] . ' ' . $mod['last_name'],
                        'mailto:' . $mod['email']
                    );
                    echo '<br>';
                }
                ?>
            </p>
        </div>
        <h3>Bug Report</h3>
        <p>
            In case you find a bug, please file a report here:
        </p>
        <a class="small blue button right" href="https://github.com/hashmich/DHCR-Frontend/issues" target="_blank">Bug Report</a>
    </div>
</div>