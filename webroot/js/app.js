
'use strict';
// requires Cookies: /npm/js-cookie@2.2.1/src/js.cookie.js

class App {

    defaults() {
        return {
            apiUrl:     'http://localhost/DH-API/',
            mapApiKey:  'pass key using constructor options',
            filter:     {},
            breakPoint: 750,
            id: false,
            action: 'index',    // the controller action called. the app will behave differently...
            layout: 'screen'
        };
    }

    constructor(options) {
        this.data = {};
        this.layout = this.action = this.id = this.filter = null;
        this.mapApiKey = this.apiUrl = this.breakPoint = null;

        if(typeof options == 'object')
            options = Object.assign(this.defaults(), options);
        else options = this.defaults();

        for(var key in options) {
            this[key] = options[key];
        }

        setTimeout(function(){
            // This hides the address bar:
            window.scrollTo(0, 1);
        }, 0);

        // apply layout first, then populate blocks
        this.slider = new Slider(document.getElementById('container'));
        this.scrollable = new Scrollable(document.getElementById('table'));
        this.intro = document.getElementById('intro');
        if(this.intro != undefined) {
            // the intro page is loaded
            this.scrollListener = function() {
                this.introScrollAnimationListener()
            }.bind(this);
            let f = function(e) {
                e.preventDefault();
                this.hideIntro();
            }.bind(this);
            document.getElementById('start').addEventListener('click', f);
        }

        this.map = new Map({
            htmlIdentifier: 'map',
            apiKey: this.mapApiKey,
            app: this
        });

        this.view = new View(this.scrollable.getContentContainer(), this);

        this.status = 'index';
        // load data
        if(this.action == 'index') {
            this.view.setLoader();
            this.filter = new Filter(this);
            this.getCourses();
        }
        if(this.action == 'view') {
            this.getCourse();
            $('#intro').css({display: 'none'});
            this.status = 'view';
        }

        window.addEventListener('resize', function () {
            this.resizeListener();
        }.bind(this));

        this.resizeListener();

        // intro related code
        if(Cookies.get('hideIntro') == 'true') {
            // renew the cookie on each pageview, so pagevisits after one year will be seen as first-timers
            this.setintroCookie();
        }
    }

    introScrollAnimationListener() {
        let container = document.getElementById('container');
        let intro = document.getElementById('transparent');
        if(intro.getBoundingClientRect().top <= container.offsetTop) {
            let maxMargin = - (this.slider.viewportWidth + this.slider.cssMargin);
            let iconPosition = 'left';
            let margin = 1.8 * (intro.getBoundingClientRect().top - container.offsetTop);
            if(margin <= maxMargin) {
                // "map" state
                this.slider.slide.style.marginLeft = 0;
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
            if(this.intro != undefined) {
                this.intro.removeEventListener('scroll', this.scrollListener);
            }
            this.slider.reset();
        }else{
            this.layout = 'mobile';
            this.slider.updateSize();
            if(this.intro != undefined) {
                // activate the map/table slider while overscrolling
                this.intro.addEventListener('scroll', this.scrollListener);
            }
        }
        this.updateSize();
        this.scrollable.updateSize();
    }

    updateSize() {
        let bottom = 20;
        if(this.layout == 'mobile') bottom = 35;
        $('#container').css({
            // get header outer height including margins (true)
            height: $('body').height() - ($('#header').outerHeight(true) + bottom) + 'px'
        });
    }

    getCourse() {
        // called on view action only, show error if no data available
        if(typeof course != 'undefined' && Object.keys(course).length > 0) {
            this.data = {};
            this.data[course.id] = course;
            this.map.setMarkers(this.data, false);
            this.setCourse();
        }else{
            // course is not found
            this.handleError('The record you are looking for does not exist');
        }
    }

    getCourses() {
        // check for preset object served on pageload to speed up loading time
        if(typeof courses != 'undefined') {
            if (courses.length > 0) {
                this.data = {};
                for (var i = 0; courses.length > i; i++) {
                    this.data[courses[i].id] = courses[i];
                }
                this.map.setMarkers(this.data);
                this.setTable();
            }else{
                this.handleError('No course matches your filter conditions.')
            }
        }else{
            this.handleError('Sorry, something went definitely wrong.')
        }
    }

    setTable() {
        this.view.createTable(this.data);
        this.map.closeMarker();
        this.scrollable.updateSize();
        this.status = 'index';
    }

    setCourse(id) {
        id = id || this.id;
        this.view.createView(this.data[id]);
        if(this.action == 'index') this.map.openMarker(id);
        if(this.action == 'view') this.map.map.setView([this.data[id].lat, this.data[id].lon], 5);
        this.scrollable.updateSize();
        this.status = 'view';
        if(this.layout == 'mobile') {
            this.slider.setPosition('table');
        }
    }

    closeView() {
        if(this.action == 'index') {
            this.setTable();
        }
        if(this.action == 'view') {
            // reload
            window.location = BASE_URL;
        }
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
        Cookies.set('hideIntro', 'true', {expires: 365});
    }

    delCookie() {
        Cookies.remove('hideIntro');
    }

    handleError(data) {
        console.log(data);
        let msg = (typeof data == 'string') ? data : 'Something went wrong';
        this.view.setErrorMessage(msg);
    }
}
