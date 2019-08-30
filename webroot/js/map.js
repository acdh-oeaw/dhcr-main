
'use strict';

class Map {

    constructor(htmlIdentifier) {
        this.apiKey = 'pk.eyJ1IjoiaGFzaG1pY2giLCJhIjoiY2lxaGQ4eW01MDA5cWhybmhhOGpxODN1aiJ9.FS8KOKVrd6i-8Nd8q1XMmg';

        this.map = L.map(htmlIdentifier, {scrollWheelZoom: false});
        this.map.setView([50.000, 10.189551], 4);
        L.tileLayer('https://api.mapbox.com/styles/v1/'
            + 'hashmich/ciqhed3uq001ae6niop4onov3/tiles/256/{z}/{x}/{y}?access_token='
            + this.apiKey).addTo(this.map);

        this.map.addEventListener('click', function() {
            this.map.scrollWheelZoom.enable();
        }.bind(this));
        this.map.addEventListener('mouseout', function() {
            this.map.scrollWheelZoom.disable();
        }.bind(this));
        // markers is set as a lookup table to get a single course record by ID
        this.markers = {};
    }


    setMarkers(courses) {
        this.cluster = new L.MarkerClusterGroup({
            spiderfyOnMaxZoom: true,
            //disableClusteringAtZoom: 14,
            showCoverageOnHover: true,
            zoomToBoundsOnClick: true,
            maxClusterRadius: 30
        });
        for(let k in courses) {
            let marker = L.marker([courses[k].lat, courses[k].lon], {title: courses[k].name});

            // prepare html content
            //marker.bindPopup(courses[k].content);

            this.cluster.addLayer(marker);
            this.markers[courses[k].id] = {
                marker: marker,
                course: courses[k]
            };
            //this.map.addLayer(marker);
        }

        this.map.addLayer(this.cluster);
        this.fitBounds(10);
    }

    openMarker(id) {
        this.cluster.zoomToShowLayer(this.markers[id].marker, function() {
            this.markers[k].marker.openPopup();
        });
    }

    closeMarker(id) {
        for(let k in markers) {
            if(id == markers[k].id) {
                markers[k].marker.closePopup();
                this.fitBounds(12);
                break;
            }
        }
    }

    fitBounds(maxZoom) {
        this.map.options.maxZoom = maxZoom;
        //this.map.fitBounds(this.cluster.getBounds(), {padding: [10, 10]});
        this.map.options.maxZoom = 18;
    }

}
