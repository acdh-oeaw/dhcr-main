<?php use Cake\Routing\Router;

$this->set('bodyClasses', 'login'); ?>




<div id="idpSelect"></div>

<div id="classicLogin">
    <h2>Classic Login</h2>
    <p>
        Use your e-mail address and DHRC password to log in. <br>
        Reset your password if you forgot it or never set one.
    </p>
    <div class="users form">
        <?= $this->Form->create() ?>

        <?= $this->Form->control('email') ?>
        <?= $this->Form->control('password') ?>

        <?= $this->Form->button(__('Login'), ['class' => 'right']); ?>
        <?= $this->Form->end() ?>
    </div>

    <div id="login-alternatives">
        <?= $this->Html->link('Reset Password', '/users/reset_password', ['class' => 'blue button small']) ?>
        <?= $this->Html->link('Registration', '/users/register', ['class' => 'small button']) ?>
        <?= $this->Html->link('Federated Login', '/users/signIn/#idpSelect', ['class' => 'blue button small']) ?>
    </div>
</div>


<?php $this->Html->script(['idp_select/IdpSelector.js','idp_select/TypeAhead.js'], ['block' => true]); ?>
<?php $this->Html->scriptStart(['block' => true]); ?>
let IdpSelectorClass = new IdpSelector('#idpSelect',
    '<?= $idpSelectReturnParameter ?>',
    '<?= Router::url("/js/idp_select/DiscoFeed.json") ?>');


function IdPSelectUIParms(){
    //
    // Adjust the following to fit into your local configuration
    //
    this.alwaysShow = true;          // If true, this will show results as soon as you start typing
    this.dataSource = '<?= Router::url("/js/idp_select/DiscoFeed.json") ?>';
    this.defaultLogo = 'blank.gif';  // Replace with your own logo
    this.defaultLogoWidth = 1;
    this.defaultLogoHeight = 1 ;
    this.ignoreURLParams = true;
    this.defaultReturn = '<?= $idpSelectReturnParameter ?>';
    //this.defaultReturn = "https://example.org/Shibboleth.sso/DS?SAMLDS=1&target=https://example.org/secure";
    this.defaultReturnIDParam = null;
    //this.returnWhiteList = [ "^https:\/\/example\.org\/Shibboleth\.sso\/Login.*$" , "^https:\/\/example\.com\/Shibboleth\.sso\/Login.*$" ];
    this.returnWhiteList = [ "^https:\/\/(acdh|clarin)\.oeaw\.ac\.at\/.*$" , "^https:\/\/(arche|redmine|delt)\.acdh\.oeaw\.ac\.at\/.*$" , "^https:\/\/dhcr\.clarin-dariah\.eu\/.*$" , "^https:\/\/delt\.acdh-dev\.oeaw\.ac\.at\/.*$", "^https:\/\/teach\.dariah\.eu\/.*$" ];
    this.insertAtDiv = 'idpSelect';  // The div where we will insert the data
    this.maxResults = 10;            // How many results to show at once or the number at which to
    // start showing if alwaysShow is false
    this.hiddenIdPs = null;          // Array of entityIds to delete
    this.ignoreKeywords = false;     // Do we ignore the <mdui:Keywords/> when looking for candidates
    this.showListFirst = false;      // Do we start with a list of IdPs or just the dropdown
    this.samlIdPCookieTTL = 730;     // in days
    this.setFocusTextBox = true;     // Set to false to supress focus
    this.testGUI = false;

    //
    // The following should not be changed without changes to the css.  Consider them as mandatory defaults
    //
    this.maxPreferredIdPs = 3;
    this.maxIdPCharsButton = 33;
    this.maxIdPCharsDropDown = 58;
    this.maxIdPCharsAltTxt = 60;

    this.minWidth = 20;
    this.minHeight = 20;
    this.maxWidth = 115;
    this.maxHeight = 69;
    this.bestRatio = Math.log(80 / 60);
}
<?php $this->Html->scriptEnd(); ?>


