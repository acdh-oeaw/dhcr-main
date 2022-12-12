<div class="faq content">
    <p></p>
    <h2><span class="glyphicon glyphicon-wrench"></span>&nbsp;&nbsp;&nbsp;Users, Access and Workflows</h2>
    <p>For moderators & admins</p>
    <p>Version: 2022-08-19</p>
    <h4>Contents</h4>
    <ol>
        <li><a href="#user_roles">Access and User Roles</a></li>
        <li><a href="#account_creation">How to Create an Account</a></li>
        <li><a href="#course_expiry">Course expiry process</a></li>
        <!-- <li><a href="#emails_from_application">Emails sent by the application</a></li> -->
    </ol>
    <p>&nbsp;</p>
    <ol>
        <h3 id="user_roles">
            <li>Access and User Roles</li>
        </h3>
        <p>The registry is publicly available to everyone. Users can browse the registry and view the course metadata
            without creating an account. Watch this <a href="https://www.youtube.com/embed/s-YsnpKCaUE">video tutorial</a>
            to learn how to browse or filter the courses in the registry.</p>
        <p>The users who either contribute with new courses to the registry or are involved in the curation or
            administration process need to create an account first. See more information below.</p>
        <p>We distinguish between three types of users:</p>
        <ol type="a">
            <li><u>Contributor:</u> any user who adds course metadata to the registry.</li>
            <li><u>Moderator:</u> a user from a specific country that moderates the DH registry users from that respective
                country and curates the submitted course metadata.</li>
            <li><u>Administrator:</u> any user who manages the technical infrastructure and the DH Course Registry network.
                Administrators may also moderate the DH courses submitted from those countries which do not have a
                national moderator.</li>
        </ol>
        <p>&nbsp;</p>
        <h3 id="account_creation">
            <li>How to Create an Account</li>
        </h3>
        <p>There are two ways to create an account on the DH Course Registry website:</p>
        <p><strong><u>Option 1: Fill in the Registration Form</u></strong><br>
            Contributors, e.g. lecturers and programme administrators, who would like to add their DH-related activities
            to the registry need to proceed as follows:
        <ol>
            <li>Create an account by filling in the
                <?= $this->Html->link('User Registration form', ['controller' => 'Users', 'action' => 'register']) ?>.</li>
            <li>After submitting the registration form, you need to:
                <ol type="a">
                    <li>Confirm the email address</li>
                    <li>Set a password</li>
                    <li>Wait for account approval by the moderator</li>
                </ol>
            <li>Once the moderator has approved your account, you can add a new course to the registry by going to
                <strong>Dashboard > Administrate Courses > Add Course</strong>.
            </li>
        </ol>
        <p><strong><u>Option 2: By invitation</u></strong><br>
            Moderators can invite new users to contribute to the registry directly through the application.
        <ol>
            <li>As a moderator, log in to the DH Course Registry.</li>
            <li>Go to the Contributor Network and click on
                <?= $this->Html->link('Invite User', ['controller' => 'Users', 'action' => 'invite']) ?> to fill in the
                invitation form:
                <ol type="a">
                    <li>Select the institution of the new user</li>
                    <li>Enter the details of the user</li>
                    <li>If available, select the email invitation template in the local language of the invited user. Otherwise,
                        use the English.</li>
                    <ul>
                        <li>Moderators can translate the English version of the email template and send it to the administrators.</li>
                        <li>Administrators can add the translation by going to <strong>Category Lists > Translations</strong>. </li>
                    </ul>
                    <li>Send the invitation to the new user.</li>
                </ol>
            <li>The invited user receives an email with a link to set a password. This link is valid for 24 hours.</li>
        </ol>
        <p>&nbsp;</p>
        <h3 id="course_expiry">
            <li>Course expiry process</li>
        </h3>
        <p>To help the course maintainers, a traffic-light colour is used in the list of courses to indicate their status:
            <i>actively maintained</i>, <i>needs to be updated</i> or <i>is not shown in the registry</i>. Reminder emails
            are sent to the course owners regularly to update the metadata of their courses.
        </p>
        <ol>
            <li>When new course metadata is entered into the registry, its status is <font color="green"><strong>green
                    </strong></font> on the list.</li>
            <li>After <u>10 months</u>, the course owner receives emails to update the course metadata. The course status
                stays <font color="green"><strong>green</strong></font> on the list.</li>
            <li>After <u>12 months</u>, the moderator will be on the CC of the reminder emails. The course status is
                <font color="orange"><strong>orange</strong></font>.
            </li>
            <li>After <u>16 months</u>, the course is not shown in the public registry anymore, but it is still available
                in the backend. The course status turns <font color="red"><strong>red</strong></font> in the list.</li>
            <li>After <u>24 months</u>, the course is archived: it is not visible in the public registry or accessible in
                the backend. The course is still available through the API to keep the history available.</li>
        </ol>
        <!-- <p>&nbsp;</p>
        <h3 id="emails_from_application">
            <li>Emails sent by the application</li>
        </h3>
        <u>Invitation</u><br>
        <p>To be added</p>
        <u>Reminder</u><br>
        <p>To be added</p>
        <u>Contact form</u><br>
        <p>To be added</p>
        <u>Subscriptions</u><br>
        <p>To be added</p>
        <u>Contributor mailing list</u><br>
        <p>To be added</p> -->
    </ol>
</div>