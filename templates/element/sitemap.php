

<div id="sitemap">
    <ul>
        <li>
            <p>
                <?= $this->Html->link(
                    '<span class="glyphicon glyphicon-home"></span>Worldwide DH Courses',
                    ['controller' => 'Courses', 'action' => 'index'],
                    ['escape' => false]) ?>
            </p>
        </li>

        <li>
            <p>
                <?= $this->Html->link(
                    '<span class="glyphicon glyphicon-bell"></span>Follow',
                    ['controller' => 'Pages', 'action' => 'follow'],
                    ['escape' => false]) ?>
            </p>
            <ul class="follow">
                <li>
                    <?= $this->Html->link(
                        'New Course Alert',
                        ['controller' => 'Pages', 'action' => 'follow', '#' => 'course-alert']) ?>
                </li>
                <li>
                    <?= $this->Html->link(
                        'Social Media',
                        ['controller' => 'Pages', 'action' => 'follow', '#' => 'news']) ?>
                </li>
                <li>
                    <?= $this->Html->link(
                        'Join Our Network',
                        ['controller' => 'Pages', 'action' => 'info', '#' => 'contact']) ?>
                </li>
                <li>
                    <?= $this->Html->link(
                        'Contributor Newsletter',
                        ['controller' => 'Pages', 'action' => 'follow', '#' => 'newsletter']) ?>
                </li>
            </ul>
        </li>

        <li>
            <p>
                <?= $this->Html->link(
                    '<span class="glyphicon glyphicon-info-sign"></span>About the DH Course Registry',
                    ['controller' => 'Pages', 'action' => 'info'],
                    ['escape' => false]) ?>
            </p>
            <ul class="info">
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
                    '<span class="glyphicon glyphicon-off"></span>Contribute to the DHCR',
                    ['controller' => 'Pages', 'action' => 'contribute'],
                    ['escape' => false]) ?>
            </p>
            <ul class="contribute">
                <li>
                    <?= $this->Html->link(
                        'Sign-In',
                        '/ops/users/login') ?>
                </li>
            </ul>
        </li>
    </ul>
</div>
