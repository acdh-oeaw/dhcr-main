<div id="sitemap">
    <ul>
        <li>
            <p>
                <?= $this->Html->link(
                    '<span class="glyphicon glyphicon-home"></span>Course Registry',
                    ['controller' => 'Courses', 'action' => 'index'],
                    ['escape' => false]
                ) ?>
            </p>
        </li>

        <li>
            <p>
                <?= $this->Html->link(
                    '<span class="glyphicon glyphicon-star"></span>Dashboard',
                    ['controller' => 'Users', 'action' => 'dashboard'],
                    ['escape' => false]
                ) ?>
            </p>
        </li>

        <li>
            <p>
                <?= $this->Html->link(
                    '<span class="glyphicon glyphicon-flag"></span>Needs Attention',
                    ['controller' => 'Users', 'action' => 'needsAttention'],
                    ['escape' => false]
                ) ?>
            </p>
            <ul class="attention">
                <li>
                    <?= $this->Html->link(
                        'Account Approval ',
                        ['controller' => 'Users', 'action' => 'newUsers']
                    ) ?>
                </li>
                <li>
                    <?= $this->Html->link(
                        'Course Approval',
                        ['controller' => 'Courses', 'action' => 'newCourses']
                    ) ?>
                </li>
                <li>
                    <?= $this->Html->link(
                        'Course Expiry',
                        ['controller' => 'Courses', 'action' => 'expiredCourses']
                    ) ?>
                </li>
            </ul>
        </li>

        <li>
            <p>
                <?= $this->Html->link(
                    '<span class="glyphicon glyphicon-education"></span>Courses',
                    ['controller' => 'Courses', 'action' => 'index'],
                    ['escape' => false]
                ) ?>
            </p>
            <ul class="dashboard">
                <li>
                    <?= $this->Html->link(
                        'My Courses',
                        ['controller' => 'Courses', 'action' => 'myCourses']
                    ) ?>
                </li>
                <li>
                    <?= $this->Html->link(
                        'Moderated Courses',
                        ['controller' => 'Courses', 'action' => 'moderatedCourses']
                    ) ?>
                </li>
            </ul>
        </li>


        <li>
            <p>
                <?= $this->Html->link(
                    '<span class="glyphicon glyphicon-user"></span>Contributor Network',
                    ['controller' => 'Users', 'action' => 'index'],
                    ['escape' => false]
                ) ?>
            </p>
            <ul class="users">
                <li>
                    <?= $this->Html->link(
                        'Invite ',
                        ['controller' => 'Users', 'action' => 'invite']
                    ) ?>
                </li>
                <li>
                    <?= $this->Html->link(
                        'Users',
                        ['controller' => 'Users', 'action' => 'index']
                    ) ?>
                </li>
            </ul>
        </li>
        <li>
            <p>
                <?= $this->Html->link(
                    '<span class="glyphicon glyphicon-list"></span>Category Lists',
                    ['controller' => 'Pages', 'action' => 'tables'],
                    ['escape' => false]
                ) ?>
            </p>
            <ul class="tables">
                <li>
                    <?= $this->Html->link(
                        'Cities',
                        ['controller' => 'Cities', 'action' => 'index']
                    ) ?>
                </li>
                <li>
                    <?= $this->Html->link(
                        'Institutions',
                        ['controller' => 'Institutions', 'action' => 'index']
                    ) ?>
                </li>
                <li>
                    <?= $this->Html->link(
                        'Languages',
                        ['controller' => 'Languages', 'action' => 'index']
                    ) ?>
                </li>
            </ul>
        </li>

        <li>
            <p>
                <?= $this->Html->link(
                    '<span class="glyphicon glyphicon-cog"></span>Profile Settings',
                    ['controller' => 'Users', 'action' => 'profile'],
                    ['escape' => false]
                ) ?>
            </p>
            <ul class="profile">
                <li>
                    <?= $this->Html->link(
                        'Newsletter',
                        ['controller' => 'Users', 'action' => 'newsletterPrefs']
                    ) ?>
                </li>
                <li>
                    <?= $this->Html->link(
                        'Log Out',
                        ['controller' => 'Users', 'action' => 'logout']
                    ) ?>
                </li>
            </ul>
        </li>

    </ul>
</div>