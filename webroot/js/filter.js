

'use strict';

class Filter {

    constructor(app) {
        this.app = app;

        this.institutions       = {};
        this._institutions      = {};
        this.cities             = {};
        this._cities            = {};
        this.countries          = {};
        this.languages          = {};
        this.disciplines        = {};
        this.techniques         = {};
        this.objects            = {};
        this.types              = {};

        this.selected = {
            'institutions'    : {},
            'cities'            : {},
            'countries'         : {},
            'languages'         : {},
            'disciplines'       : {},
            'techniques'        : {},
            'objects'           : {},
            'types'             : {},
            'recent'            : true,
            'online'            : null,
            'start'             : null,
            'end'               : null,
            'sort'              : null
        };
        // a mapping for the query keys
        this.mapping = {
            'instititutions'    : 'institution_id',
            'cities'            : 'city_id',
            'countries'         : 'country_id',
            'languages'         : 'language_id',
            'disciplines'       : 'discipline_id',
            'techniques'        : 'tadirah_technique_id',
            'objects'           : 'tadirah_object_id',
            'types'             : 'course_type_id',
            'recent'            : 'recent',
            'online'            : 'online',
            'start'             : 'start_date',
            'end'               : 'end_date',
            'sort'              : 'sort'
        };
    }

    getInstitutions() {
        $.ajax({
            url: this.app.apiUrl + 'institutions/index?sort_count&group',
            accept: 'application/json',
            method: 'GET',
            cache: true,
            context: this,
            crossDomain: true
        }).done(function( data ) {
            this.institutions = {};
            this._institutions = data;
            for(var i = 0; data.length > i; i++) {
                // country level
                for(var n = 0; data[i].length > n; n++) {
                    this.institutions[data[i][n].id] = data[i][n];
                }
            }
        }).fail(function (jqXHR, textStatus, errorThrown) {
            this.app.handleError(jqXHR);
        });
    }

    getCities() {
        $.ajax({
            url: this.app.apiUrl + 'cities/index?sort_count&group',
            accept: 'application/json',
            method: 'GET',
            cache: true,
            context: this,
            crossDomain: true
        }).done(function( data ) {
            this.cities = {};
            this._cities = data;
            for(var i = 0; data.length > i; i++) {
                // country level
                for(var n = 0; data[i].length > n; n++) {
                    this.cities[data[i][n].id] = data[i][n];
                }
            }
        }).fail(function (jqXHR, textStatus, errorThrown) {
            this.app.handleError(jqXHR);
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
            this.app.handleError(jqXHR);
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
            this.app.handleError(jqXHR);
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
            this.app.handleError(jqXHR);
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
            this.app.handleError(jqXHR);
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
            this.app.handleError(jqXHR);
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
            this.app.handleError(jqXHR);
        });
    }


    listenerSelect(category, id) {
        if(!(id in this.selected[category])) {
            this.selected[category][id] = this[category][id];
            delete this[category][id]
        }
    }

    listenerUnselect(category, id) {
        if(id in this.selected[category]) {
            this[category][id] = this.selected[category][id];
            delete this.selected[category][id];
        }
    }

    createSelectorOption(category, id) {
        let label = this[category][id].name + ' (' + this[category][id].course_count + ')';
        return '<li class="select" data-category="' + category + '" data-id="' + id + '">' + label + '</li>';
    }

    createSelector(category) {
        let retval = '';
        Object.keys(this[category]).forEach(function(id,index) {
            if(!this.selected[category].hasOwnProperty(id)) {
                retval += this.createSelectorOption(category, id);
            }
        });
        return retval;
    }

    createSelection(category) {
        let result = '';
        let catSelection = this.selected[category];
        // categoryName: <ul>
        Object.keys(catSelection).forEach(function(id,index) {
            result += '<li><span class="unselect" data-category="' + category + '"></span>' + catSelection[id].name + '</li>';
        });
        // </ul> ?
        return result;
    }

    getQuery() {
        let retval = '';
        Object.keys(this.selected).forEach(function(category,index) {
            let value = getValue(this.selected[category]);
            if(value !== null) {
                if(retval == '') retval = '?';
                else retval += '&';
                retval += this.mapping[category] + '=' + getValue(this.selected[category]);
            }
        }.bind(this));

        function getValue(selection) {
            if(selection === null || typeof selection == 'undefined') return null;
            if(typeof selection == 'object') {
                if(Object.keys(selection).length === 1) return Object.keys(selection)[0];
                if(Object.keys(selection).length > 1) return Object.keys(selection).join(',');
            }
            if(typeof selection == 'string' && selection.match(/^true$|^false$/i).length == 1)
                return selection;
            if(typeof selection == 'boolean')   // typeof null is 'object'
                return selection;               // will convert to string
            return null;
        }

        return retval;
    }

    isLocated() {
        if(Object.keys(this.selected.countries) > 0)
            return true;
        if(Object.keys(this.selected.cities) > 0)
            return true;
        if(Object.keys(this.selected.institutions) > 0)
            return true;
        return false;
    }
}
