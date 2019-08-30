
'use strict';

class App {

    constructor(scrollable) {
        this.apiUrl = 'http://localhost/DH-API/';
        this.filter = {
            recent: true
        };
        this.map = new Map('map');
        this.scrollable = new Scrollable(document.getElementById('table'), {trackWidth: 1, trackColor: 'blue'});
        this.table = new Table('#table .scroll-container');

        // load data
        this.getCourses()
    }

    getCourses() {
        $.ajax({
            url: this.apiUrl + 'courses/index' + this.filterToQuery(),
            cache: true,
            context: this,
        }).done(function( data ) {
            this.data = data;
            this.setCourses();
        }).fail(function() {
            console.log('ajax error');
        });
    }

    filterToQuery() {
        let retval = '';
        $.each(this.filter, function(key, value) {
            if(retval == '') retval = '?';
            else retval += '&';
            retval += key + '=' + value;
        });
        return retval;
    }

    setCourses() {
        this.map.setMarkers(this.data);
        this.table.setData(this.data);
        this.scrollable.updateSize();
    }
}
