
'use strict';

class Map {

    defaults() {
        return {
            apiKey:  'pass key using constructor options',
            htmlIdentifier: 'map',
            maxZoom: 18,
            minZoom: 1,
            scrollWheelZoom: true
        };
    }

    constructor(options) {
        this.apiKey = this.htmlIdentifier = this.maxZoom = null;
        this.minZoom = this.app = this.scrollWheelZoom = null;

        if(typeof options == 'object')
            options = Object.assign(this.defaults(), options);
        else options = this.defaults();

        for(var key in options) {
            this[key] = options[key];
        }

        let corner1 = L.latLng(90, 360),
            corner2 = L.latLng(-90, -360),
            maxBounds = L.latLngBounds(corner1, corner2);

        this.map = L.map(this.htmlIdentifier, {
            worldCopyJump: true,
            maxZoom: this.maxZoom,
            minZoom: this.minZoom,
            scrollWheelZoom: this.scrollWheelZoom,
            maxBounds: maxBounds,
            maxBoundsViscosity: 1
        });

        L.tileLayer('https://api.mapbox.com/styles/v1/'
            + 'hashmich/ciqhed3uq001ae6niop4onov3/tiles/256/{z}/{x}/{y}?access_token='
            + this.apiKey).addTo(this.map);

        window.addEventListener('resize', function () {
            this.map.invalidateSize();
            if(this.app.action == 'index')
                this.fitBounds();
        }.bind(this));

        // markers is set as a lookup table to get a single course record by ID
        this.markers = {};
        this.id = false;
    }


    setMarkers(courses, createPopups) {
        createPopups = (typeof createPopups == "undefined") ? true : createPopups;
        this.markers = {};
        this.cluster = new L.MarkerClusterGroup({
            spiderfyOnMaxZoom: true,
            //disableClusteringAtZoom: 14,
            showCoverageOnHover: false,
            zoomToBoundsOnClick: true,
            maxClusterRadius: 50,
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
            let course = courses[k];
            let icon = L.icon({
                iconUrl: BASE_URL + 'leaflet/images/dhcr-marker-icon.png',
                iconRetinaUrl: BASE_URL + 'leaflet/images/dhcr-marker-icon-2x.png',
                iconSize:     [25, 37], // size of the icon
                iconAnchor:   [12, 37], // point of the icon which will correspond to marker's location
                popupAnchor:  [0, -40] // point from which the popup should open relative to the iconAnchor
            });
            let marker = L.marker([course.lat, course.lon], {
                title: course.name,
                icon: icon
            });

            if(createPopups) {
                // prepare html content
                let content = '<h1>' + course.name + '</h1>'
                    + '<p>' + course.institution.name + ',<br />'
                    + course.department + '.</p>'
                    + '<p>Type: ' + course.course_type.name + '</p>'
                    + '<a class="show_view button" data-id="' + course.id
                    + '" href="' + BASE_URL + 'courses/view/' + course.id
                    + '">Show details</a>';
                marker.bindPopup(content);
            }

            this.cluster.addLayer(marker);
            this.markers[course.id] = marker;
        }

        this.map.addLayer(this.cluster);
        this.fitBounds();
        if(Object.entries(this.app.filter).length > 0 && !this.app.filter.isLocated() && createPopups) {
            let zoom = this.map.getZoom();
            // locate to user location
            this.map.locate({setView: true, maxZoom: zoom});
        }

        this.map.on('popupopen', function() {

            //TODO: animate table to scroll to record and open (prevent when triggered by table click)

            $('.show_view').on('click', function(e) {
                e.preventDefault();
                let id = $(e.target).attr('data-id');
                this.app.setCourse(id);
            }.bind(this))
        }.bind(this));
    }

    openMarker(id) {
        this.cluster.zoomToShowLayer(this.markers[id], function() {
            this.markers[id].openPopup();
            this.id = id;
        }.bind(this));
    }

    closeMarker() {
        if(!this.id) return;
        this.markers[this.id].closePopup();
        this.fitBounds(12);
        this.id = false;
    }

    fitBounds(maxZoom = 18) {
        this.map.options.maxZoom = maxZoom;
        this.map.options.minZoom = 2;
        this.map.fitBounds(this.cluster.getBounds(), {padding: [10, 10]});
        this.map.options.minZoom = this.minZoom;
    }

}
