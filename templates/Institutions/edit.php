<div class="row">
    <p></p>
    <h2><span class="glyphicon glyphicon-book"></span>&nbsp;&nbsp;&nbsp;Edit Institution</h2>
    <div class="column-responsive column-80">
        <div class="institutions form content">
            <?= $this->Form->create($institution) ?>
            <fieldset>
                <legend><?= __('Edit Institution') ?></legend>
                <?php
                echo $this->Form->control('city_id', ['options' => $cities, 'empty' => true]);
                echo $this->Form->control('country_id', ['options' => $countries, 'empty' => true]);
                echo $this->Form->control('name');
                echo $this->Form->control('description');
                echo $this->Form->control('url');
                echo $this->Form->hidden('lon', ['id' => 'lon', 'default' => $mapInit['lon']]);
                echo $this->Form->hidden('lat', ['id' => 'lat', 'default' => $mapInit['lat']]);
                ?>
                <b>Location</b><br>
                Select the location on the map below.<br>
                -You can zoom using the scroll wheel.<br>
                -You can move the map, by dragging with the mouse.<br>
                -Place the blue marker on the correct position, it will be saved automatically.
                <p></p>
                <?php
                echo $this->element('locationpicker');  // include locationpicker
                ?>
            </fieldset>
            <p>&nbsp;</p>
            <?= $this->Form->button(__('Edit Institution')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>