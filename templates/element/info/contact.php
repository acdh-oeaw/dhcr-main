<?php

use Cake\Core\Configure;
?>

<div class="flex-columns">
    <div class="flex-item">
        <h3>National Moderators</h3>
        <p>
            The DHCR maintains a system of national moderators, who review newly entered courses,
            help with registration issues
            and are encouraged to disseminate the DHCR initiative among institutions of their countries.
        </p>
        <div class="css-columns moderators">
            <?php
            $last_country = null;
            if(!empty($moderators)) foreach($moderators as $i => $mod) {
                if(empty($mod['country_id'])) continue;
                if($mod['country_id'] == $last_country) {
                    echo ',<br />';
                }else{
                    if($i > 0) echo '</p></div>';
                    echo '<div class="item">';
                    echo '<p class="country">' . $mod['country']['name'] . '</p>';
                    echo '<p class="moderators">';
                }
                $last_country = $mod['country_id'];

                echo $this->Html->link(
                    $mod['first_name'] . ' ' . $mod['last_name'],
                    'mailto:' . $mod['email']);

            }
            echo '</div>';
            ?>
        </div>
    </div>
    <div class="flex-item">
        <h3>Administrators</h3>
        <p>
            For technical questions or yet not moderated countries, please seek contact to the administration board:
        </p>
        <div class="css-columns admins">
            <p>
                <?php
                foreach($userAdmins as $i => $mod) {
                    echo $this->Html->link(
                        $mod['first_name'] . ' ' . $mod['last_name'],
                        'mailto:' . $mod['email']);
                    echo '<br>';
                }
                ?>
            </p>
        </div>

        <?php
        // Hide contact form, because it does not work
        /*
        <h3>Contact Form</h3>
        <p>
            Please use our form to automatically let the system address
            all moderators or admins in charge of your concern.
        </p>

        <?php
        $options = [
            'Admin Staff' => ['administrators' => 'Administrators'],
            'National Moderators' => $countries
        ];

        echo $this->Form->create($email, [
            'novalidate' => false,
            'id' => 'ContactUsForm',
            'class' => 'captcha-form',
            'url' => [
                'controller' => 'pages',
                'action' => 'info',
                '#' => 'contact'
            ]
        ]);
        echo $this->Form->control('email', array(
            'label' => 'Your E-Mail',
            'autocomplete' => 'off',
            'required' => true
        ));
        echo $this->Form->control('country_id', [
            'empty' => '- choose one -',
            'required' => true,
            'label' => 'Send to',
            'options' => $options]);
        echo $this->Form->control('first_name');
        echo $this->Form->control('last_name');
        echo $this->Form->control('telephone', array(
            'type' => 'text'
        ));
        echo $this->Form->control('message', array(
            'type' => 'textarea',
            'required' => true
        ));
        echo $this->Form->submit('Submit', array(
            'class' => 'g-recaptcha small blue button right',
            'data-sitekey' => Configure::read('reCaptchaPublicKey'),
            'data-callback' => 'recaptchaCallback'
        ));
        echo $this->Form->end();
        ?>
        */
        // End of hiding
        ?>

        <h3>Bug Report</h3>
        <p>
            In case you find a bug, please file a report here:
        </p>
        <a class="small blue button right"
           href="https://github.com/hashmich/DHCR-Frontend/issues"
           target="_blank">Bug Report</a>
    </div>
</div>

