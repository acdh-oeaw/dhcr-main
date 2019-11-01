

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
            'institutions'      : {},
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
            'institutions'    : 'institution_id',
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

        this.getCountries();
        this.getCities();
        this.getInstitutions();

        //TODO: evaluate query -> selected!!!
        let pattern = /[0-9]|^[0-9]+[0-9,]*[0-9]+$/g;
        for(let category in this.selected) {
            let value = Filter.getParameterByName(this.mapping[category]);
            if(typeof this.selected[category] == 'object' && pattern.test(value)) {
                value = value.split(',');
                value.forEach(function(id) {
                    if(typeof this[category][id] != 'undefined')
                        this.selected[category][id] = this[category][id].name;
                }.bind(this));
            }
        }
    }

    getCountries() {
        this.countries = {};
        for(let i = 0; countries.length > i; i++) {
            if(countries[i].course_count > 0)
                this.countries[countries[i].id] = countries[i];
        }
    }

    getCities() {
        this.cities = {};
        for(let country in cities) {
            for(let i = 0; cities[country].length > i; i++) {
                if(cities[country][i].course_count > 0)
                    this.cities[cities[country][i].id] = cities[country][i];
            }
        }
    }

    getInstitutions() {
        this.institutions = {};
        for(let country in institutions) {
            for(let i = 0; institutions[country].length > i; i++) {
                if(institutions[country][i].course_count > 0)
                    this.institutions[institutions[country][i].id] = institutions[country][i];
            }
        }
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
        return '<option class="filter-option" '
            + 'data-category="' + category + '" data-id="'
            + id + '">' + label + '</option>';
    }

    createSelector(category) {
        if(category == 'cities' || category == 'institutions') return;
        let retval = '<div class="styled-select selected"><select>';
        retval += '<option selected disabled hidden>Choose Country</option>';
        for(let i = 0; window[category].length > i; i++) {
            let id = window[category][i].id;
            if(typeof this[category][id] != 'undefined' && !this.selected[category].hasOwnProperty(id)) {
                retval += this.createSelectorOption(category, id);
            }
        }
        retval += '</select></div>';
        if(!this.isEmpty(category)) {
            retval += '<ul class="selection">';
            for(let id in this.selected[category]) {
                retval += '<li>' + this.selected[category][id] + '</li>';
            }
            retval += '</ul>';
        }
        return retval;
    }

    createHtml() {
        let filter = $('<div id="filter"></div>');
        let form = $('<form></form>');
        form.append(this.createSelector('countries'));
        form.append(this.createSelector('cities'));
        form.append(this.createSelector('institutions'));
        filter.append(form);
        return filter;
    }

    addHandler() {
        $('select').on('change', function(e) {
            let selection = $("option:selected", e.target);
            let id = selection.attr('data-id');
            let category = selection.attr('data-category');
            this.selected[category][id] = this[category][id].name;
            window.location = BASE_URL + this.getQuery();
        }.bind(this));
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
        if(Object.keys(this.selected.countries).length > 0)
            return true;
        if(Object.keys(this.selected.cities).length > 0)
            return true;
        if(Object.keys(this.selected.institutions).length > 0)
            return true;
        return false;
    }

    isEmpty(category) {
        if(typeof category != 'undefined') {
            if(Object.keys(this.selected[category]).length > 0)
                return false;
            return true;
        }
        if(Object.keys(this.selected.countries).length > 0)
            return false;
        if(Object.keys(this.selected.cities).length > 0)
            return false;
        if(Object.keys(this.selected.institutions).length > 0)
            return false;
        if(Object.keys(this.selected.languages).length > 0)
            return false;
        if(Object.keys(this.selected.disciplines).length > 0)
            return false;
        if(Object.keys(this.selected.techniques).length > 0)
            return false;
        if(Object.keys(this.selected.objects).length > 0)
            return false;
        if(this.selected.recent == false)
            return false;
        if(this.selected.online != null)
            return false;
        if(this.selected.start != null)
            return false;
        if(this.selected.end != null)
            return false;
        if(this.selected.sort != null)
            return false;
        return true;
    }

    static getParameterByName(name, url) {
        if (!url) url = window.location.href;
        name = name.replace(/[\[\]]/g, '\\$&');
        var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
            results = regex.exec(url);
        if (!results) return null;
        if (!results[2]) return '';
        return decodeURIComponent(results[2].replace(/\+/g, ' '));
    }
}
