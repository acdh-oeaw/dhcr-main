
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

        // intro related code
        if(document.cookie.hideIntro) {
            // renew the cookie on each pageview, so pagevisits after one year will be seen as first-timers
            this.setintroCookie();
        }
        let f = function() { this.hideIntro() }.bind(this);
        let start = document.getElementById('start');
        if(start != undefined) {
            // the intro page is loaded
            start.addEventListener('click', f);
            // activate the map/table slider while overscrolling
            document.getElementById('intro').addEventListener('scroll', function() {
                this.scrollListener()
            }.bind(this));
        }
    }

    scrollListener() {
        let container = document.getElementById('container');
        let intro = document.getElementById('transparent');
        if(intro.getBoundingClientRect().top <= container.offsetTop) {
            let maxMargin = - (this.slider.viewportWidth + this.slider.cssMargin);
            let iconPosition = 'left';
            let margin = 1.5 * (intro.getBoundingClientRect().top - container.offsetTop);
            if(margin <= maxMargin) {
                margin = maxMargin;
                iconPosition = 'right';
            }
            if(margin > 0) margin = 0;

            this.slider.slide.style.marginLeft = margin + 'px';
            this.slider.control.style.backgroundPositionX = iconPosition;
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
        this.scrollable.updateSize();
    }

    hideIntro() {
        $('#intro').animate({
            'left': '100vw'
        }, 1000, function() {
            // animate doesn't handle scaling operations, thus an animated class adding hack is used
            $('#info-button').addClass('animate');
            setTimeout(function() {$('#info-button').removeClass('animate')}, 300);
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
