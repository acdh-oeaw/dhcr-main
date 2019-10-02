

'use strict';

class Filter {

    constructor(app) {
        this.app = app;

        this.institutions       = {};
        this.cities             = {};
        this.countries          = {};
        this.languages          = {};
        this.disciplines        = {};
        this.techniques         = {};
        this.objects            = {};
        this.types              = {};

        this.selected = {
            'instititutions'    : {},
            'cities'            : {},
            'countries'         : {},
            'languages'         : {},
            'disciplines'       : {},
            'techniques'        : {},
            'objects'           : {},
            'types'             : {},
            'recent'            : true,
            'online'            : false
        };
    }

    getInstitutions() {
        $.ajax({
            url: this.app.apiUrl + 'institutions/index?sort_count',
            accept: 'application/json',
            method: 'GET',
            cache: true,
            context: this,
            crossDomain: true
        }).done(function( data ) {
            this.institutions = {};
            for(var i = 0; data.length > i; i++) {
                this.institutions[data[i].id] = data[i];
            }
        }).fail(function (jqXHR, textStatus, errorThrown) {
            this.handleError(jqXHR);
        });
    }

    getCities() {
        $.ajax({
            url: this.app.apiUrl + 'cities/index?sort_count',
            accept: 'application/json',
            method: 'GET',
            cache: true,
            context: this,
            crossDomain: true
        }).done(function( data ) {
            this.cities = {};
            for(var i = 0; data.length > i; i++) {
                this.cities[data[i].id] = data[i];
            }
        }).fail(function (jqXHR, textStatus, errorThrown) {
            this.handleError(jqXHR);
        });
    }

    getCountries() {
        $.ajax({
            url: this.app.apiUrl + 'countries/index?sort_count',
            accept: 'application/json',
            method: 'GET',
            cache: true,
            context: this,
            crossDomain: true
        }).done(function( data ) {
            this.countries = {};
            for(var i = 0; data.length > i; i++) {
                this.countries[data[i].id] = data[i];
            }
        }).fail(function (jqXHR, textStatus, errorThrown) {
            this.handleError(jqXHR);
        });
    }

    getDisciplines() {
        $.ajax({
            url: this.app.apiUrl + 'disciplines/index?sort_count',
            accept: 'application/json',
            method: 'GET',
            cache: true,
            context: this,
            crossDomain: true
        }).done(function( data ) {
            this.disciplines = {};
            for(var i = 0; data.length > i; i++) {
                this.disciplines[data[i].id] = data[i];
            }
        }).fail(function (jqXHR, textStatus, errorThrown) {
            this.handleError(jqXHR);
        });
    }

    getTechniques() {
        $.ajax({
            url: this.app.apiUrl + 'techniques/index?sort_count',
            accept: 'application/json',
            method: 'GET',
            cache: true,
            context: this,
            crossDomain: true
        }).done(function( data ) {
            this.techniques = {};
            for(var i = 0; data.length > i; i++) {
                this.techniques[data[i].id] = data[i];
            }
        }).fail(function (jqXHR, textStatus, errorThrown) {
            this.handleError(jqXHR);
        });
    }

    getObjects() {
        $.ajax({
            url: this.app.apiUrl + 'objects/index?sort_count',
            accept: 'application/json',
            method: 'GET',
            cache: true,
            context: this,
            crossDomain: true
        }).done(function( data ) {
            this.objects = {};
            for(var i = 0; data.length > i; i++) {
                this.objects[data[i].id] = data[i];
            }
        }).fail(function (jqXHR, textStatus, errorThrown) {
            this.handleError(jqXHR);
        });
    }

    getLanguages() {
        $.ajax({
            url: this.app.apiUrl + 'languages/index?sort_count',
            accept: 'application/json',
            method: 'GET',
            cache: true,
            context: this,
            crossDomain: true
        }).done(function( data ) {
            this.languages = {};
            for(var i = 0; data.length > i; i++) {
                this.languages[data[i].id] = data[i];
            }
        }).fail(function (jqXHR, textStatus, errorThrown) {
            this.handleError(jqXHR);
        });
    }

    getTypes() {
        $.ajax({
            url: this.app.apiUrl + 'types/index?sort_count',
            accept: 'application/json',
            method: 'GET',
            cache: true,
            context: this,
            crossDomain: true
        }).done(function( data ) {
            this.types = {};
            for(var i = 0; data.length > i; i++) {
                this.types[data[i].id] = data[i];
            }
        }).fail(function (jqXHR, textStatus, errorThrown) {
            this.handleError(jqXHR);
        });
    }

    select(category, id) {
        if(!(id in this.selected[category])) {
            this.selected[category][id] = this[category][id];
            delete this[category][id]
        }
    }

    unselect(category, id) {
        if(id in this.selected[category]) {
            this[category][id] = this.selected[category][id];
            delete this.selected[category][id];
        }
    }

    createSelector(category) {

    }

    createSelection(category) {
        
    }
}
