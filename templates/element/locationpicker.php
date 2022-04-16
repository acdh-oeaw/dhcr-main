<?php

use Cake\Core\Configure;

echo $this->Html->script('https://api.mapbox.com/mapbox-gl-js/v2.8.0/mapbox-gl.js');
echo $this->Html->css('https://api.mapbox.com/mapbox-gl-js/v2.8.0/mapbox-gl.css');
?>
<div id='map' style='width: 600px; height: 450px;'></div>
<script>
    mapboxgl.accessToken = '<?= Configure::read('map.apiKey') ?>';
    const map = new mapboxgl.Map({
        container: 'map', // container ID
        style: 'mapbox://styles/mapbox/streets-v11', // style URL
        center: [<?= $userInstitution->lon ?>, <?= $userInstitution->lat ?>], // starting position [lng, lat]
        zoom: 9 // starting zoom
    });
    // add zoom controls to the map
    map.addControl(new mapboxgl.NavigationControl());
    // add draggable marker (blue)
    const marker = new mapboxgl.Marker({
            draggable: true
        })
        .setLngLat([<?= $userInstitution->lon ?>, <?= $userInstitution->lat ?>])
        .addTo(map);

    function onDragEnd() {
        // update hidden form fields with the location selected by user
        const lngLat = marker.getLngLat();
        document.getElementById('lon').value = lngLat.lng;
        document.getElementById('lat').value = lngLat.lat;
    }
    marker.on('dragend', onDragEnd);
</script>
<!-- update map when an institution is selected -->
<script>
    var institutionSelector = document.getElementById("institution-id");
    var institutionsLocations = <?php echo json_encode($institutionsLocations); ?>

    institutionSelector.addEventListener(
        'change',
        function() {
            map.setCenter([
                institutionsLocations[institutionSelector.value]['lon'],
                institutionsLocations[institutionSelector.value]['lat']
            ]);
            map.setZoom(9);
            marker.setLngLat([
                institutionsLocations[institutionSelector.value]['lon'],
                institutionsLocations[institutionSelector.value]['lat']
            ]);
        }
    );
</script>