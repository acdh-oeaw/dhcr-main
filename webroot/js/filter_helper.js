

'use strict';

class FilterHelper {

    constructor(app, filter) {
        this.app = app;
        this.filter = filter;
    }

    createHtml(element) {
        let filter = $('<div id="filter"></div>');
        let form = $('<form></form>');

        if(!this.filter.isEmpty()) {
            filter.addClass('not-empty');
            filter.append($('<a href="' + BASE_URL + '" id="reset">Clear Filters</a>'));
        }

        let selection = $('<div id="selection"></div>');
        selection.append(this.createPresenceTypeSelector());

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
        if(!this.filter.isEmpty('disciplines')) {
            selection.append(this.createSelector('disciplines'));
            selection.append(this.createSelection('disciplines'));
        }
        if(!this.filter.isEmpty('techniques')) {
            selection.append(this.createSelector('techniques'));
            selection.append(this.createSelection('techniques'));
        }
        if(!this.filter.isEmpty('objects')) {
            selection.append(this.createSelector('objects'));
            selection.append(this.createSelection('objects'));
        }
        if(!this.filter.isEmpty('languages')) {
            selection.append(this.createSelector('languages'));
            selection.append(this.createSelection('languages'));
        }
        if(!this.filter.isEmpty('types')) {
            selection.append(this.createSelector('types'));
            selection.append(this.createSelection('types'));
        }

        let selectors = $('<div id="selectors"></div>');
        if(this.filter.isEmpty('countries')) selectors.append(this.createSelector('countries'));
        if(Object.keys(this.filter.selected.countries).length <= 1) {
            if(this.filter.isEmpty('cities')) selectors.append(this.createSelector('cities'));
            if(Object.keys(this.filter.selected.cities).length <= 1) {
                if(this.filter.isEmpty('institutions')) selectors.append(this.createSelector('institutions'));
            }
        }
        if(this.filter.isEmpty('types')) selectors.append(this.createSelector('types'));
        if(this.filter.isEmpty('disciplines')) selectors.append(this.createSelector('disciplines'));
        if(this.filter.isEmpty('languages')) selectors.append(this.createSelector('languages'));
        if(this.filter.isEmpty('techniques')) selectors.append(this.createSelector('techniques'));
        if(this.filter.isEmpty('objects')) selectors.append(this.createSelector('objects'));

        form.append(selection, selectors);
        filter.append(form);

        // handlers can only be added after appending markup
        $(element).append(filter);
        this.addHandlers();
    }

    createSelector(category) {
        let choose;
        if(category == 'countries') choose = 'Choose Country';
        if(category == 'cities') choose = 'Choose City';
        if(category == 'institutions') choose = 'Choose Institution';
        if(category == 'types') choose = 'Choose Education';
        if(category == 'disciplines') choose = 'Choose Discipline';
        if(category == 'languages') choose = 'Choose Language';
        if(category == 'techniques') choose = 'Choose Technique';
        if(category == 'objects') choose = 'Choose Object';

        let wrapper = $('<div></div>').addClass('styled-select');
        let select = $('<select></select>').addClass('filter');
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
            let selection = $('<ul></ul>').addClass('selection');
            for(let id in this.filter.selected[category]) {
                let item = $('<li></li>')
                    .addClass('selection-item')
                    .attr('data-category', category).attr('data-id', id)
                    .text(this.filter.selected[category][id]);
                selection.append(item);
            }
            return selection[0];
        }
        return '';
    }

    createPresenceTypeSelector() {
        let options = [
            {label: 'online', value: true},
            {label: 'campus', value: false},
            {label: 'both', value: 'null'}
        ];
        return this.createRadioSelector('presence-type',
            'Presence Type', options, 'online');
    }

    createOccurrenceSelector() {
        let options = [
            {label: 'yes', value: true},
            {label: 'one-off', value: false},
            {label: 'both', value: 'null'}
        ];
        return this.createRadioSelector('recurring',
            'Recurring', options, 'recurring');
    }

    createRadioSelector(id, label, options, filterKey) {
        let list = $('<ul></ul>').attr('data-filter-key', filterKey)
            .attr('id', id).addClass('radio-selector');
        list.append($('<li></li>').addClass('label').html(label));
        for(let i = 0; i < options.length; i++) {
            let value = options[i].value;
            if(typeof value === 'undefined' || value == null) value = 'null';
            let option = $('<li></li>').html(options[i].label)
                .attr('data-value', value)
                .addClass('option');
            if((this.filter.selected[filterKey] === options[i].value)
                || ((typeof this.filter.selected[filterKey] == 'undefined'
                    || this.filter.selected[filterKey] == null) && value === 'null'))
                option.addClass('selected');

            list.append(option);
        }
        return list;
    }

    selectEvent() {
        $('select.filter').on('change', function(e) {
            let selection = $("option:selected", e.target);
            let id = selection.attr('data-id');
            let category = selection.attr('data-category');
            if(!(id in this.filter.selected[category])) {
                this.filter.selected[category][id] = this.filter[category][id].name;
                delete this.filter[category][id]
            }
            //window.location = BASE_URL + this.filter.createQuery();
            this.filter.app.hash.pushQuery(this.filter.createQuery());
            this.filter.app.getCourses();
        }.bind(this));
    }

    unselectEvent() {
        $('li.selection-item').on('click', function(e) {
            let category = $(e.target).attr('data-category');
            let id = $(e.target).attr('data-id');
            if(id in this.filter.selected[category]) {
                this.filter[category][id] = this.filter.selected[category][id];
                delete this.filter.selected[category][id];
            }
            //window.location = BASE_URL + this.filter.createQuery();
            this.filter.app.hash.pushQuery(this.filter.createQuery());
            this.filter.app.getCourses();
        }.bind(this));
    }

    radioEvent() {
        $('.radio-selector li.option:not(.selected)').on('click', function(e) {
            let selector = $(e.target).closest('.radio-selector');
            let filterKey = selector.attr('data-filter-key');
            $('.radio-selector li.selected').removeClass('selected');
            $(e.target).addClass('selected');
            let value = $(e.target).attr('data-value');
            if(value == 'null') value = null;
            else if(value == 'false') value = false;
            else if(value == 'true') value = true;
            this.filter.selected[filterKey] = value;

            selector.replaceWith(this.createPresenceTypeSelector());

            this.filter.app.hash.pushQuery(this.filter.createQuery());
            this.filter.app.getCourses();
        }.bind(this));
    }

    addHandlers() {
        this.selectEvent();
        this.unselectEvent();
        this.radioEvent();
    }

    createFilterModal() {
        
    }

    createSortModal() {
        let options = [
            {label: '<span class="mobile">Asc</span><span class="screen">Ascending</span>', value: 'asc'},
            {label: '<span class="mobile">Desc</span><span class="screen">Descending</span>', value: 'desc'},
            {label: '<span class="mobile">-</span><span class="screen">None</span>', value: 'null'}
        ];

        this.modal = new Modal('SortOptions','sort');
        this.modal.add($('<p></p>').text('Default course order is most recent courses first.'));

        this.modal.add(this.createRadioSelector('sort-name',
            'Course Name', options, 'sort'));
        if(this.app.layout == 'screen') {
            this.modal.add(this.createRadioSelector('sort-country-name',
                'Country', options, 'sort'));
            this.modal.add(this.createRadioSelector('sort-city-name',
                'City', options, 'sort'));
        }
        this.modal.add(this.createRadioSelector('sort-university-name',
            'University', options, 'sort'));
        this.modal.add(this.createRadioSelector('sort-date',
            'Start Date', options, 'sort'));
        this.modal.add(this.createRadioSelector('sort-type',
            'Education', options, 'sort'));

        this.modal.create();
    }
}
