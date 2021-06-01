<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

use Cake\Routing\Router;

$this->layout = false;

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?= $this->Element('meta') ?>

        <?= $this->Html->css('static_page.css') ?>
        <?= $this->Html->meta('icon') ?>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script src="https://shared.acdh.oeaw.ac.at/dhcr/content.js"></script>
        <script type="text/javascript">
            $(document).ready(function(){
                let content = new Content();
                content.load();
            });

        </script>
        <style>

        @font-face {
            font-family: Metropolis-SemiBold;
            src: url("/fonts/bebas_neue/BebasNeue-Regular.otf") format("opentype");
        }
        @font-face {
            font-family: Metropolis-SemiBold;
            src: url("/fonts/metropolis/Metropolis-SemiBold.otf") format("opentype");
        }
        @font-face {
            font-family: Metropolis-Regular;
            src: url("/fonts/metropolis/Metropolis-Regular.otf") format("opentype");
        }

        .linklist-container {
            width:100%;
            background-color: white;
        }

        .linklist-content-div {
            padding-left: 10px;
             text-align: center;

        }
        .linklist-content-div a {
            text-decoration:none;
            color: white;
            font-family: "Metropolis-Regular";
        }


        P.linklist-sub-title-light {
            text-align: center;
            color: #1e6ba3;
            font-family: "Metropolis-SemiBold";
        }


        #page-head {
            display: block !important;
        }

        #page-head h1 {
            margin: 0 auto !important;
            display: block !important;
        }

        #page-head .intent p {
            text-align: center;
            color: black !important;
            font-family: "Metropolis-SemiBold";
            font-size: 14px !important;
        }

        P.linklist-title-desc {
            text-align: center;
            color: black !important;
            font-family: "Metropolis-SemiBold";
            font-size: 14px !important;
            margin-top: 15px;
        }

        ul {
            list-style-type: none;
            display: inline-block !important;
            margin: 0;
            padding: 0;
            /* For IE, the outcast */
            zoom:1;
            display: inline;
        }
        li {
            max-width: 350px;
        }
        li:hover {
            opacity: 0.3;
            filter: alpha(opacity=30);
        }
        .linklist-list-element-blue {
            background-color: #1e6ba3;
            margin:10px;
            border-radius: 10px;
            text-align: center;
            padding:15px;
        }

        .linklist-list-element-green {
            background-color: #60a845;
            margin:10px;
            border-radius: 10px;
            text-align: center;
            padding:15px;
        }
    </style>
    </head>
    <body class="info">
        <div class="wrapper">
            <?= $this->Html->link('Back to Start', '/', ['class' => 'blue back button']); ?>
            <div id="page-head">
                <h1>
                    Digital Humanities Course Registry
                    <?= $this->Html->image('logo-500.png', [
                        'alt' => 'logo',
                        'width' => 500,
                        'height' => 114,
                        'url' => '/']) ?>
                </h1>

                <div class="intent">
                    <p class="linklist-title-desc">COLLECTION OF LINKS FEATURED IN OUR INSTAGRAM-POSTS</p>
                    <div class="linklist-content-div">
                        <ul>
                        </ul>
                    </div>
                </div>
            </div>








            <div id="footer" class="footer">
                <p class="imprint"><?= $this->Html->link('Imprint',
                        '/pages/info/#imprint') ?></p>
                <p class="license"><?= $this->Html->link('CC-BY 4.0',
                        'https://creativecommons.org/licenses/by/4.0/',
                        ['target' => '_blank']) ?></p>
                <p class="copyright">&copy;2014-<?= date('Y') ?></p>
            </div>
        </div>


        <?= $this->Flash->render('flash') ?>


        <!--<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>-->
        <?= $this->Html->script('jquery-3.4.1.min.js') ?>
        <?= $this->Html->script(['accordeon','hash']) ?>

        <script type="application/javascript">
            $(document).ready( function() {
                let accordeon = new Accordeon('accordeon');
                $('#imprint-content').load('https://shared.acdh.oeaw.ac.at/acdh-common-assets/api/imprint.php?serviceID=7435');
                $('#footer .imprint').on('click', function(e) {
                    e.preventDefault();
                    accordeon.openHash('imprint');
                });
                if($('.flash-message').length) {
                    $('.flash-message').slideDown('fast').delay(8000).fadeOut('slow');
                }
            });

            function recaptchaCallback(token) {
                document.getElementById("ContactUsForm").submit();
            }
        </script>

        <script src="https://www.google.com/recaptcha/api.js" type="application/javascript"/>
        <?= $this->element('matomo') ?>

    </body>
</html>
