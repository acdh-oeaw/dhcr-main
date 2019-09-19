
'use strict';

class App {

    defaults() {
        return {
            apiUrl:     'http://localhost/DH-API/',
            mapApiKey:  'pass key using constructor options',
            filter:     { recent: true },
            breakPoint: '750px'
        };
    }

    constructor(options) {
        if(typeof options == 'object')
            options = Object.assign(this.defaults(), options);
        else options = this.defaults();

        for(var key in options) {
            this[key] = options[key];
        }

        // apply layout first, then populate blocks
        this.slider = new Slider(document.getElementById('container'));
        this.scrollable = new Scrollable(document.getElementById('table'));
        this.resizeListener();
        this.map = new Map({
            htmlIdentifier: 'map',
            apiKey: this.mapApiKey
        });
        this.table = new Table(this.scrollable.getContentContainer());

        // load data
        this.getCourses();

        window.addEventListener('resize', function () {
            this.resizeListener();
        }.bind(this));

        if(document.cookie.hideIntro) {
            // renew the cookie on each pageview, so pagevisits after one year will be seen as first-timers
            this.setintroCookie();
        }
        let f = function() { this.hideIntro() }.bind(this);
        let start = document.getElementById('start');
        if(start != undefined) {
            start.addEventListener('click', f);
        }
    }

    resizeListener() {
        // we should test for #container innerWidth
        if(document.getElementById('container').clientWidth > this.breakPoint) {
            this.layout = 'screen';
            this.slider.reset();
        }else{
            this.layout = 'mobile';
            this.slider.updateSize();
        }
        this.scrollable.updateSize();
        this.updateSize();
    }

    updateSize() {
        let bottom = 10;
        if(this.layout == 'mobile') bottom = 35;
        $('#container').css({
            // get header outer height including margins (true)
            height: $('body').height() - ($('#header').outerHeight(true) + bottom) + 'px'
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

    getCourses() {
        this.table.setLoader();
        $.ajax({
            url: this.apiUrl + 'courses/index' + this.filterToQuery(),
            cache: true,
            context: this,
        }).done(function( data ) {
            this.data = data;
            this.setCourses();
        }).fail(function() {
            this.table.setError('Failure while loading data.');
        });
    }

    setCourses() {
        this.map.setMarkers(this.data);
        this.table.setData(this.data);
        //let callback = this.scrollable.updateSize.bind(this.scrollable);
        //setTimeout(callback, 3000);
        this.scrollable.updateSize();
    }

    hideIntro() {
        $('#intro').animate({'height': 0}, 1000, function() {
            $('#info-button').addClass('animate');
            $('#info-button').removeClass('animate');
            // one year
            let expiry = new Date(Date.now() + 31536000);
            document.cookie = "hideIntro=true; expires="+expiry.toUTCString()+";";
        }.bind(this));
    }

    setintroCookie() {
        // one year
        let expiry = new Date(Date.now() + 31536000);
        document.cookie = "hideIntro=true; expires="+expiry.toUTCString()+";";
    }

    delCookie() {
       document.cookie = "hideIntro=";
    }
}
