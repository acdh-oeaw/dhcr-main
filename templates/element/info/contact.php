<style>
    .card {
        -moz-border-radius: 2%;
        -webkit-border-radius: 2%;
        border-radius: 2%;
        box-shadow: 5px 5px 0 rgba(0, 0, 0, 0.08);
    }

    .profile .profile-body {
        padding: 20px;
        background: #f7f7f7;
    }

    .profile .profile-bio {
        background: #fff;
        position: relative;
        padding: 15px 10px 5px 15px;
    }

    .profile .profile-bio a {
        left: 50%;
        bottom: 20px;
        margin: -62px;
        text-align: center;
        position: absolute;
    }

    .profile .profile-bio h2 {
        margin-top: 0;
        font-weight: 200;
    }
</style>
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