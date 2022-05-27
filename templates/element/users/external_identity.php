<?php
$name = '';
if (!empty($identity['first_name']) or !empty('sn')) $name = '<dt>Name:</dt><dd>';
if (!empty($identity['first_name'])) $name .= $identity['first_name'] . ' ';
if (!empty($identity['last_name'])) $name .= $identity['last_name'];
$name = trim($name) . '</dd>';
$mail = '';
if (!empty($identity['email'])) $mail = '<dt>Email:</dt><dd>' . $identity['email'] . '</dd>';
if (empty($mail) and preg_match("/^[^@]+@[^@]+\.[a-z]{2,6}$/i", $identity['shib_eppn']))
    $mail = '<dt>Email:</dt><dd>' . $identity['shib_eppn'] . '</dd>';
?>
<div class="notice">
    <p>We receive the following data from your provider:</p>
    <dl>
        <?= ($name) ?? '' ?>
        <?= ($mail) ?? '' ?>
        <dt>Identifier:</dt>
        <dd><?= $identity['shib_eppn'] ?></dd>
    </dl>
</div>