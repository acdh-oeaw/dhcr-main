
class Map {

    constructor(htmlIdentifier) {
        this.apiKey = 'pk.eyJ1IjoiaGFzaG1pY2giLCJhIjoiY2lxaGQ4eW01MDA5cWhybmhhOGpxODN1aiJ9.FS8KOKVrd6i-8Nd8q1XMmg';

        this.map = L.map(htmlIdentifier, {scrollWheelZoom: false});
        this.map.setView([50.000, 10.189551], 4);
        L.tileLayer('https://api.mapbox.com/styles/v1/'
            + 'hashmich/ciqhed3uq001ae6niop4onov3/tiles/256/{z}/{x}/{y}?access_token='
            + this.apiKey).addTo(this.map);
        this.map.on('click', function () {
            this.map.scrollWheelZoom.enable();
        });
        this.map.on('mouseout', function () {
            this.map.scrollWheelZoom.disable();
        });

        this.cluster = new L.MarkerClusterGroup({
            spiderfyOnMaxZoom: true,
            //disableClusteringAtZoom: 14,
            showCoverageOnHover: true,
            zoomToBoundsOnClick: true,
            maxClusterRadius: 30
        });
    }


    addMarkers(courses) {
        for(var k in courses) {
            let marker = L.marker([courses[k].coordinates.lat, courses[k].coordinates.lon], {title: courses[k].title});
            marker.bindPopup(courses[k].content);
            this.cluster.addLayer(marker);
            markers[k] = {
                marker: marker,
                id: courses[k].id
            };
        }

        this.map.addLayer(cluster);
        fitBounds(10)
    }

    openMarker(id) {
        for(var k in markers) {
            if(id == markers[k].id) {
                this.cluster.zoomToShowLayer(markers[k].marker, function() {
                    markers[k].marker.openPopup();
                });
                break;
            }
        }
    }

    closeMarker(id) {
        for(var k in markers) {
            if(id == markers[k].id) {
                markers[k].marker.closePopup();
                fitBounds(12);
                break;
            }
        }
    }

    fitBounds(maxZoom) {
        this.map.options.maxZoom = maxZoom;
        this.map.fitBounds(cluster.getBounds(), {padding: [10, 10]});
        this.map.options.maxZoom = 18;
    }

}
