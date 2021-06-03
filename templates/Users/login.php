<?php $this->set('bodyClasses', 'login'); ?>

<h2>Login</h2>


<div class="users form">
    <?= $this->Form->create() ?>

    <?= $this->Form->control('email') ?>
    <?= $this->Form->control('password') ?>

    <?= $this->Form->button(__('Login'), ['class' => 'right']); ?>
    <?= $this->Form->end() ?>
</div>

<div id="login-alternatives">
    <?= $this->Html->link('Reset Password', '/users/reset_password', ['class' => 'blue button small']) ?>
    <?= $this->Html->link('Single Sign-On (eduGAIN)', '#', ['class' => 'blue button small']) ?>
</div>


<div id="idpSelectPreferredIdPTile">
    <div class="IdPSelectTextDiv">Vorherige Auswahl:</div>
    <div class="IdPSelectPreferredIdPButton" title="Österreichische Akademie der Wiss...">
        <a href="https://dhcr.clarin-dariah.eu/Shibboleth.sso/Login?SAMLDS=1&amp;target=ooo&amp;entityID=https%3A%2F%2Fweblogin.oeaw.ac.at%2Fidp%2Fshibboleth">
            <div class="IdPSelectPreferredIdPImg">
                <img class="IdPSelectIdPImg" src="logo-kurz.png">
            </div>
            <div class="IdPSelectTextDiv">Österreichische Akademie der Wiss...</div>
        </a>
    </div>
    <div id="idpSelectIdPEntryTile">
        <form action="https://dhcr.clarin-dariah.eu/Shibboleth.sso/Login" method="GET" autocomplete="OFF">
            <input type="hidden" name="SAMLDS" value="1">
            <input type="hidden" name="target" value="ss:mem:1c59559344fd7fc4855af6e3d095e4fc7e824539b4789bcd5b480b6cb3c7f061">
            <label for="idpSelectInput">
                <div class="IdPSelectTextDiv">Oder geben Sie den Namen (oder Teile davon) an:</div>
            </label>
            <input type="text" id="idpSelectInput" role="combobox" aria-controls="IdPSelectDropDown" aria-owns="IdPSelectDropDown" aria-expanded="false" aria-activedescendant="">
            <input type="hidden" name="entityID" value="-">
            <input type="submit" value="OK" id="idpSelectSelectButton" disabled="">
        </form>
        <a href="#" class="IdPSelectDropDownToggle">Choose from List</a>

    </div>

    <ul class="IdPSelectDropDown" style="visibility: hidden;"></ul>
</div>
