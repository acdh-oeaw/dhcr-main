<?php

use Cake\Core\Configure;
use Cake\Routing\Router;
?>
<div class="flex-columns">
    <div class="flex-item">
        <h3>Data Model</h3>
        <p>
            The following entity relationship diagram gives an overview of entities
            in the DHCR. For a full description of their fields, please visit the
            API documentation on
            <?= $this->Html->link(
                'SwaggerHub',
                'https://app.swaggerhub.com/apis/hashmich/DHCR-API',
                ['target' => '_blank']
            ) ?>.
        </p>
        <p><?= $this->Html->image('DHCR_ERD.png', ['url' => '/img/DHCR ERD.png']) ?></p>
        <h3>Data API</h3>
        <p>
            For data export, analysis or custom visualisations, a public JSON data API is available.
            Examples and further documentation can be found on the API homepage<br />
            <?php $url = Configure::read('api.baseUrl'); ?>
            <a href="<?= $url ?>" target="_blank"><?= $url ?></a>.
        </p>
        <p>
            The API follows the same REST principles to filter and sort the resulting set
            as the web UI does. There are two important differences:<br />
            By default, the API returns both historical and current records at once, unless the
            parameter "recent" is added to the query.
            Default sorting of courses in the API is primary id ascending,
            while courses in the web UI appear sorted by their modification date descending.
            To achive the same results, both parameters "recent" and "sort=Courses.updated:desc"
            have to be explicitly set in API calls.
        </p>
    </div>
    <div class="flex-item">
        <h3>Data Life Cycle</h3>
        <p>
            Course data in the DHCR is being reviewed on a regular basis by contributors.
            Records not updated for a certain amount of time do not appear in the DHCR website,
            but are being archived as historical data.
            National moderators are also requested to approve newly created entries.
        </p>
        <p><?= $this->Html->image('DHCR_processes.png', ['url' => '/img/DHCR processes.png']) ?></p>
        <h3>Embedding and Filtering</h3>
        <p>
            The DHCR can be embedded into any other website by using an iframe.
            As the app follows a REST-ful URL-schema, one can pass any filter setting to the
            iframe by just copying the URL from your browser address bar,
            as you set the filters using the filter pane.
        </p>
        <p>
            Legacy information: a special iframe embedding layout is not supported any more,
            the special iframe path parameter will be ignored.
            Also, the URL filter schema has changed due to the introduction of the new data API.
        </p>
    </div>
</div>