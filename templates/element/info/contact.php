<h3>National Moderators</h3>
<p>
    The course entries in the DH course registry are moderated by a group of national moderators who review and approve newly entered courses,
    provide assistance with registration issues and disseminate the DHCR activities among the institutions of their countries.
</p>
<p>
    Click
    <?= $this->Html->link('here', ['controller' => 'Pages', 'action' => 'nationalModerators']) ?>
    for an overview of all national moderators.
</p>

<h3>Administrators</h3>
<p>If you have any other questions about the DH course registry, please check the
    <?= $this->Html->link('FAQ page', ['controller' => 'faqQuestions', 'action' => 'faqList', 'public']) ?>
    or contact us here: dhcr-helpdesk /at/ clarin-dariah.eu
</p>

<h3>Bug Report</h3>
<p>Click the button below to create a bug report on GitHub. In case you don't have a GitHub account, you can create one
    <a href="https://github.com/signup">here</a>. Alternatively, you can contact us via dhcr-helpdesk /at/ clarin-dariah.eu.
</p>
<a class="small blue button right" href="https://github.com/acdh-oeaw/dhcr-main/issues/new" target="_blank">Report Bug</a>