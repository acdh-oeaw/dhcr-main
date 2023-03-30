<h3>National Moderators</h3>
<p>Click
    <?= $this->Html->link('here', ['controller' => 'Pages', 'action' => 'nationalModerators']) ?>
    for an overview of all national moderators.
</p>
<h3>Administrators</h3>
<p>If you have any other questions about the DH course registry, please check the
    <?= $this->Html->link('FAQ page', ['controller' => 'faqQuestions', 'action' => 'faqList', 'public']) ?>
    or contact us here: dhcr-helpdesk /at/ clarin-dariah.eu
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