<p>
    Lecturers or progamme administrators can promote their DH-related
    teaching activities on the Digital Humanities Course Registry.
    To add data, lecturers need to sign in. We require all data
    contributors to actively maintain their data at least once per year.
</p>
<p>
    The system will regularly send out email reminders, whenever a data set
    is about to expire. Course data that is not revised for one and a half year
    will disappear from the public listing and remains archived
    for future research. The system also performs regular link checking
    on URLs provided with the data.
</p>
<div class="buttons">
    <?= $this->Html->link(
        'Login',
        ['controller' => 'Users', 'action' => 'signIn'],
        ['class' => 'button', 'id' => 'login-button']
    ) ?>
    <?= $this->Html->link(
        'Contact Us',
        ['controller' => 'Pages', 'action' => 'info', '#' => 'contact'],
        ['class' => 'blue button', 'id' => 'contact-button']
    ) ?>
</div>