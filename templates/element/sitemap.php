

<div id="sitemap">
    <ul>
        <li>
            <p>
                <?= $this->Html->link(
                    '<span class="glyphicon glyphicon-home"></span>Recent Courses on DH, worldwide',
                    ['controller' => 'Courses', 'action' => 'index'],
                    ['escape' => false]) ?>
            </p>
        </li>

        <li>
            <p>
                <?= $this->Html->link(
                    '<span class="glyphicon glyphicon-info-sign"></span>About the DH Course Registry',
                    ['controller' => 'Pages', 'action' => 'info'],
                    ['escape' => false]) ?>
            </p>
            <ul>
                <li>
                    <?= $this->Html->link(
                        'Purpose and Audience',
                        ['controller' => 'Pages', 'action' => 'info', '#' => 'purpose']) ?>
                </li>
                <li>
                    <?= $this->Html->link(
                        'Contact Us',
                        ['controller' => 'Pages', 'action' => 'info', '#' => 'contact']) ?>
                </li>
                <li>
                    <?= $this->Html->link(
                        'Publications and Dissemination',
                        ['controller' => 'Pages', 'action' => 'info', '#' => 'publications']) ?>
                </li>
                <li>
                    <?= $this->Html->link(
                        'Data Export and API',
                        ['controller' => 'Pages', 'action' => 'info', '#' => 'data']) ?>
                </li>
                <li>
                    <?= $this->Html->link(
                        'CLARIN and DARIAH',
                        ['controller' => 'Pages', 'action' => 'info', '#' => 'clarin-dariah']) ?>
                </li>
                <li>
                    <?= $this->Html->link(
                        'Credits',
                        ['controller' => 'Pages', 'action' => 'info', '#' => 'credits']) ?>
                </li>
                <li>
                    <?= $this->Html->link(
                        'Imprint',
                        ['controller' => 'Pages', 'action' => 'info', '#' => 'imprint']) ?>
                </li>
            </ul>
        </li>

        <li>
            <p>
                <?= $this->Html->link(
                    '<span class="glyphicon glyphicon-bell"></span>Follow',
                    ['controller' => 'Subscriptions', 'action' => 'add'],
                    ['escape' => false]) ?>
            </p>
            <ul>
                <li>
                    <?= $this->Html->link(
                        'New Courses Alert',
                        ['controller' => 'Subscriptions', 'action' => 'add', '#' => 'course-alert']) ?>
                </li>
                <li>
                    <?= $this->Html->link(
                        'Stories on Social Media',
                        ['controller' => 'Subscriptions', 'action' => 'add', '#' => 'news']) ?>
                </li>
                <li>
                    <?= $this->Html->link(
                        'Newsletter for Contributors',
                        ['controller' => 'Subscriptions', 'action' => 'add', '#' => 'newsletter']) ?>
                </li>
            </ul>
        </li>

        <li>
            <p>
                <?= $this->Html->link(
                    '<span class="glyphicon glyphicon-off"></span>Contribute to the DHCR',
                    ['controller' => 'Pages', 'action' => 'contribute'],
                    ['escape' => false]) ?>
            </p>
            <ul>
                <li>
                    <?= $this->Html->link(
                        'Register',
                        ['controller' => 'Users', 'action' => 'register']) ?>
                </li>
                <li>
                    <?= $this->Html->link(
                        'Login',
                        ['controller' => 'Users', 'action' => 'login']) ?>
                </li>
            </ul>
        </li>
    </ul>
</div>
