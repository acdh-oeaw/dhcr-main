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
                    ['controller' => 'Dashboard', 'action' => 'index'],
                    ['escape' => false]
                ) ?>
            </p>
        </li>

        <li>
            <p>
                <?= $this->Html->link(
                    '<span class="glyphicon glyphicon-flag"></span>Needs Attention',
                    ['controller' => 'Dashboard', 'action' => 'needsAttention'],
                    ['escape' => false]
                ) ?>
            </p>
            <ul class="attention">
                <?php
                if( in_array($user_role_id, [1, 2] )) {
                    echo '<li>';
                        echo $this->Html->link('Account Approval', ['controller' => 'Users', 'action' => 'accountApproval']);
                    echo '</li>';
                    echo '<li>';
                        echo $this->Html->link('Course Approval', ['controller' => 'Courses', 'action' => 'courseApproval']);
                    echo '</li>';
                }
                ?>
                <li>
                    <?= $this->Html->link(
                        'Course Expiry',
                        ['controller' => 'Courses', 'action' => 'expired']
                    ) ?>
                </li>
            </ul>
        </li>

        <li>
            <p>
                <?= $this->Html->link(
                    '<span class="glyphicon glyphicon-education"></span>Administrate Courses',
                    ['controller' => 'Dashboard', 'action' => 'adminCourses'],
                    ['escape' => false]
                ) ?>
            </p>
            <ul class="dashboard">
                <li>
                    <?= $this->Html->link(
                        'Add Course',
                        ['controller' => 'Courses', 'action' => 'add']
                    ) ?>
                </li>
                <li>
                    <?= $this->Html->link(
                        'My Courses',
                        ['controller' => 'Courses', 'action' => 'myCourses']
                    ) ?>
                </li>
                <?php
                if( in_array($user_role_id, [1, 2] )) {
                echo '<li>';
                    echo $this->Html->link('Moderated Courses', ['controller' => 'Courses', 'action' => 'moderated'] );
                echo '</li>';
                }
                ?>
            </ul>
        </li>

        <?php
        if( in_array($user_role_id, [1, 2] )) {
        ?>
        <li>
            <p>
                <?= $this->Html->link(
                    '<span class="glyphicon glyphicon-user"></span>Contributor Network',
                    ['controller' => 'Dashboard', 'action' => 'contributorNetwork'],
                    ['escape' => false]
                ) ?>
            </p>
            <ul class="users">
                <li>
                    <?= $this->Html->link(
                        'Invite User',
                        ['controller' => 'Users', 'action' => 'invite']
                    ) ?>
                </li>
                <li>
                    <?= $this->Html->link(
                        'Administrate Users',
                        ['controller' => 'Users', 'action' => 'index']
                    ) ?>
                </li>
            </ul>
        </li>

        <li>
            <p>
                <?= $this->Html->link(
                    '<span class="glyphicon glyphicon-list"></span>Category Lists',
                    ['controller' => 'Dashboard', 'action' => 'categoryLists'],
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
        <?php
        }
        ?>

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
                        'Change Email Address',
                        ['controller' => 'Users', 'action' => 'changeEmail']
                    ) ?>
                </li>
                <li>
                    <?= $this->Html->link(
                        'Change Password',
                        ['controller' => 'Users', 'action' => 'changePassword']
                    ) ?>
                </li>
                <li>
                    <?= $this->Html->link(
                        'Contributor Mailing List',
                        ['controller' => 'Users', 'action' => 'newsletter']
                    ) ?>
                </li>
                <li>
                    <?= $this->Html->link(
                        'Edit Profile',
                        ['controller' => 'Users', 'action' => 'profile']
                    ) ?>
                </li>

            </ul>
        </li>

        <li>
            <p>
                <?= $this->Html->link(
                        '<span class="glyphicon glyphicon-log-out"></span>Logout',
                        ['controller' => 'Users', 'action' => 'logout'],
                        ['escape' => false]
                ) ?>
            </p>
        </li>

    </ul>
</div>