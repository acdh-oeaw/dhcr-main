
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

        // on pageload, courses need not to be loaded using ajax
        this.pageload = true;
        this.lastMobileScreen = 0;  // table

        if(typeof options == 'object')
            options = Object.assign(this.defaults(), options);
        else options = this.defaults();

        for(var key in options) {
            this[key] = options[key];
        }

        this.hash = new Hash();
        this.sharing = new Sharing(this);

        // apply layout first, then populate blocks
        this.slider = new Slider(document.getElementById('container'));
        this.scrollable = new Scrollable(document.getElementById('table'));

        this.map = new Map({
            htmlIdentifier: 'map',
            apiKey: this.mapApiKey,
            app: this
        });

        this.view = new View(this.scrollable.getContentContainer(), this);

        this.status = 'index';
        // load data
        if(this.action == 'index') {
            this.filter = new Filter(this);
            this.getCourses();
        }
        if(this.action == 'view') {
            this.getCourse();
            this.status = 'view';
            this.hash.remove();
        }

        window.addEventListener('resize', function () {
            this.resizeListener();
        }.bind(this));

        this.resizeListener();
    }

    resizeListener() {
        let mediaQuery = window.matchMedia('(max-width: ' + this.breakPoint + 'px)');
        if(!mediaQuery.matches)  {
            this.layout = 'screen';
            $('.expansion-row td').attr('colspan', 5);
            this.slider.reset();
        }else{
            this.layout = 'mobile';
            $('.expansion-row td').attr('colspan', 4);
            this.slider.updateSize();
            if(this.layout == 'mobile') {
                if(this.status == 'view') {
                    this.slider.setPosition('table');
                    this.slider.hideControl();
                }
                if(this.status == 'index') this.slider.showControl();
            }
        }
        this.updateSize();
        this.scrollable.updateSize();
    }

    updateSize() {
        let bottom = 20;
        if(this.layout == 'mobile') bottom += parseInt($('#slide-control').css('bottom')) + 5;
        $('#container').css({
            // get header outer height including margins (true)
            height: $('body').height() - ($('#header').outerHeight(true) + bottom) + 'px'
        });

        if(this.layout == 'mobile') this.scrollFix();
    }

    // experimental!
    scrollFix() {
        let height = document.body.clientHeight;
        let styleHeight = document.body.style.height;
        if(document.height <= window.outerHeight)
            document.body.style.height = (height + 50) + 'px';
        setTimeout( function(){
            window.scrollTo(0, 1);
            document.body.style.height = styleHeight;
        }, 50 );
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
        if(this.pageload) {
            this.pageload = false;
            if (courses.length > 0) {
                this.data = {};
                for (var i = 0; courses.length > i; i++) {
                    this.data[courses[i].id] = courses[i];
                }
                this.map.setMarkers(this.data);
                this.setTable();
            }else{
                this.handleError('No course matches your filter conditions.');
            }
        }else{
            // load data using ajax
            this.view.setLoader();
            let query = this.filter.createQuery();
            query += (query.length > 0) ? '&recent' : '?recent';
            $.ajax({
                url: this.apiUrl + 'courses/index' + query,
                accept: 'application/json',
                method: 'GET',
                cache: true,
                context: this,
                crossDomain: true
            }).done(function( data ) {
                this.data = {};
                if(data.length <= 0) {
                    this.handleError('No course matches your filter conditions.');
                }else{
                    // global variable courses is available anyhow,
                    // but _be_ sure to keep re-generation of the view in callback
                    courses = data; // courses is required next to data to keep the order of entries
                    for(var i = 0; data.length > i; i++) {
                        this.data[data[i].id] = data[i];
                    }
                    this.map.setMarkers(this.data);
                    this.setTable();
                }
            }).fail(function (jqXHR, textStatus, errorThrown) {
                this.handleError('Error loading data');
            });
        }
    }

    setTable() {
        this.map.closeMarker();
        this.view.createTable();
        this.scrollable.updateSize();
        this.status = 'index';
        if(this.layout == 'mobile') {
            this.slider.setPosition(this.lastMobileScreen);
            this.slider.showControl();
        }
    }

    setCourse(id) {
        id = id || this.id;
        this.view.createView(this.data[id]);
        if(this.action == 'index' && this.status == 'view') this.map.openMarker(id);
        if(this.action == 'view') this.map.map.setView([this.data[id].lat, this.data[id].lon], 5);
        this.scrollable.updateSize();
        this.status = 'view';
        if(this.layout == 'mobile') {
            this.lastMobileScreen = this.slider.position;
            this.slider.setPosition('table');
            this.slider.hideControl();
        }
    }

    handleError(data) {
        console.log(data);
        let msg = (typeof data == 'string') ? data : 'Something went wrong';
        this.view.setErrorMessage(msg);
    }
}
