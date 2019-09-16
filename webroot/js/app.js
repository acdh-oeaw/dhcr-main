
'use strict';

class App {

    defaults() {
        return {
            apiUrl:     'http://localhost/DH-API/',
            filter:     { recent: true },
            breakPoint: '750px'
        };
    }

    constructor() {
        this.apiUrl = 'http://localhost/DH-API/';
        this.filter = {
            recent: true
        };
        this.breakPoint = 750;

        // apply layout first, then populate blocks
        this.slider = new Slider(document.getElementById('container'));
        this.scrollable = new Scrollable(document.getElementById('table'));
        this.resizeListener();
        this.map = new Map('map');
        this.table = new Table(this.scrollable.getContentContainer());

        // load data
        this.getCourses();

        this.map.map.setMaxZoom(3);
        this.map.map.locate({setView: true});
        this.map.map.setMaxZoom(18);

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
            //this.applyScreenLayout();
            this.slider.reset();
        }else{
            //this.applyMobileLayout();
            this.slider.updateSize();
        }
        this.scrollable.updateSize();
        //this.updateSize();
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

    updateSize() {
        // calculate logo height and scaling
        /*let scale = $('#header').height() / $('#logo').height();
        $('#logo').css({
            transform: 'scale(' + scale + ')',
            transformOrigin: '0 0'
        });*/
        // dynamically adjust container height
        $('#container').css({
            height: $('body').height() - $('#header').outerHeight()
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
        //let callback = this.scrollable.updateSize.bind(this.scrollable);
        //setTimeout(callback, 3000);
        this.scrollable.updateSize();
    }

    hideIntro() {
        $('#intro').animate({'height': 0}, 1000, function() {
            $('#info-button').animate({borderWidth: '10px'}, 300, function() {
                $('#info-button').animate({borderWidth: '2px'}, 300);
            });
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
