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