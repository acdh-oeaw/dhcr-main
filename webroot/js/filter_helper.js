

'use strict';

class FilterHelper {

    constructor(app, filter) {
        this.app = app;
        this.filter = filter;
    }

    createHtml(element) {
        let filter = $('<div id="filter"></div>');
        let form = $('<form></form>');

        let selection = $('<div id="selection"></div>');
        // get all non-empty selections first
        if(!this.filter.isEmpty('countries')) {
            selection.append(this.createSelector('countries'));
            selection.append(this.createSelection('countries'));
        }
        if(!this.filter.isEmpty('cities')) {
            selection.append(this.createSelector('cities'));
            selection.append(this.createSelection('cities'));
        }
        if(!this.filter.isEmpty('institutions')) {
            selection.append(this.createSelector('institutions'));
            selection.append(this.createSelection('institutions'));
        }

        let selectors = $('<div id="selectors"></div>');
        if(this.filter.isEmpty('countries')) selectors.append(this.createSelector('countries'));
        if(Object.keys(this.filter.selected.countries).length <= 1) {
            if(this.filter.isEmpty('cities')) selectors.append(this.createSelector('cities'));
            if(Object.keys(this.filter.selected.cities).length <= 1) {
                if(this.filter.isEmpty('institutions')) selectors.append(this.createSelector('institutions'));
            }
        }

        form.append(selection, selectors);
        filter.append(form);

        // handlers can only be added after appending markup
        $(element).append(filter);
        this.addHandler();
    }

    createSelector(category) {
        let choose;
        if(category == 'countries') choose = 'Choose Country';
        if(category == 'cities') choose = 'Choose City';
        if(category == 'institutions') choose = 'Choose Institution';

        let wrapper = $('<div></div>').addClass('styled-select');
        let select = $('<select></select>');
        select.append('<option selected disabled hidden>' + choose + '</option>');

        // loop through raw object to keep order of elements
        if(category == 'cities' || category == 'institutions') {
            for(let country in window[category]) {
                let options = window[category][country];
                let optgroup = $('<optgroup></optgroup>');
                optgroup.attr('label', country);
                for (let i = 0; options.length > i; i++) {
                    let id = options[i].id;
                    let option = this.createSelectOption(category, id);
                    if(option) optgroup.append(option);
                }
                if(optgroup.children().length > 0) select.append(optgroup);
            }
        }else{
            for(let i = 0; window[category].length > i; i++) {
                let country = false;
                let id = window[category][i].id;
                let option = this.createSelectOption(category, id);
                if(option) select.append(option);
            }
        }

        if(select.children().length > 1) wrapper.append(select);    // first child is always an empty option "choose..."
        if(wrapper.children().length > 0) return wrapper[0];
        return false;
    }

    createSelectOption(category, id) {
        // test if category id is a valid option - raw options may not be in sync with filter state
        if(typeof this.filter[category][id] != 'undefined' && !this.filter.selected[category].hasOwnProperty(id)) {
            // reduce optoions for cities and institutions, if country is set
            if(category == 'cities' || category == 'institutions') {
                if(!this.filter.isEmpty('countries')) {
                    let countryId = this.filter[category][id].country_id;
                    if(!this.filter.selected.countries.hasOwnProperty(countryId)) return false;
                }
            }
            let label = this.filter[category][id].name + ' (' + this.filter[category][id].course_count + ')';
            let option = $('<option></option>').text(label)
                .attr('data-category', category).attr('data-id', id);
            return option
        }
        return false;
    }

    createSelection(category) {
        if(typeof this.filter.selected[category] == 'object') {
            let selection = $('<ul></ul>');
            for(let id in this.filter.selected[category]) {
                selection.append($('<li></li>').text(this.filter.selected[category][id]));
            }
            return selection[0];
        }
        return '';
    }

    listenerSelect(category, id) {
        if(!(id in this.filter.selected[category])) {
            this.filter.selected[category][id] = this.filter[category][id].name;
            delete this.filter[category][id]
        }
    }

    listenerUnselect(category, id) {
        if(id in this.filter.selected[category]) {
            this.filter[category][id] = this.filter.selected[category][id];
            delete this.filter.selected[category][id];
        }
    }

    addHandler() {
        $('select').on('change', function(e) {
            let selection = $("option:selected", e.target);
            let id = selection.attr('data-id');
            let category = selection.attr('data-category');
            this.listenerSelect(category, id);
            window.location = BASE_URL + this.filter.createQuery();
        }.bind(this));
    }
}
