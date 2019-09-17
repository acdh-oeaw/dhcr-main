
'use strict';

class Map {

    constructor(htmlIdentifier) {
        this.apiKey = 'pk.eyJ1IjoiaGFzaG1pY2giLCJhIjoiY2lxaGQ4eW01MDA5cWhybmhhOGpxODN1aiJ9.FS8KOKVrd6i-8Nd8q1XMmg';

        this.map = L.map(htmlIdentifier, {
            worldCopyJump: true
        });
        this.map.setView([50.000, 10.189551], 4);
        L.tileLayer('https://api.mapbox.com/styles/v1/'
            + 'hashmich/ciqhed3uq001ae6niop4onov3/tiles/256/{z}/{x}/{y}?access_token='
            + this.apiKey).addTo(this.map);

        window.addEventListener('resize', function () {
            this.map.invalidateSize();
            this.fitBounds();
        }.bind(this));

        // markers is set as a lookup table to get a single course record by ID
        this.markers = {};
    }


    setMarkers(courses) {
        this.cluster = new L.MarkerClusterGroup({
            spiderfyOnMaxZoom: true,
            //disableClusteringAtZoom: 14,
            showCoverageOnHover: false,
            zoomToBoundsOnClick: true,
            maxClusterRadius: 30,
            iconCreateFunction: function(cluster) {
                let childCount = cluster.getChildCount();
                let c = ' marker-cluster-';
                let size = 40;
                if (childCount < 10) {
                    c += 'small';
                    size = 40;
                } else if (childCount < 100) {
                    c += 'medium';
                    size = 50;
                } else {
                    c += 'large';
                    size = 60
                }
                return new L.DivIcon({
                    html: '<div><span>' + childCount + '</span></div>',
                    className: 'marker-cluster' + c,
                    iconSize: new L.Point(size, size)
                });
            }
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
        }

        this.map.addLayer(this.cluster);
        this.fitBounds();
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

    fitBounds(maxZoom = 18) {
        this.map.options.maxZoom = maxZoom;
        this.map.options.minZoom = 2;
        this.map.fitBounds(this.cluster.getBounds(), {padding: [10, 10]});
    }

}
