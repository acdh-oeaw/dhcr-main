

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
        selection.append(this.createOccurrenceSelector());

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
        return this.createRadioSelector('filter', 'presence-type',
            'Presence Type', options, 'online');
    }

    createOccurrenceSelector() {
        let options = [
            {label: 'yes', value: true},
            {label: 'one-off', value: false},
            {label: 'both', value: 'null'}
        ];
        return this.createRadioSelector('filter', 'recurring',
            'Recurring', options, 'recurring');
    }

    createRadioSelector(classname, id, label, options, filterKey, selectFunction) {
        classname = (classname !== false)
            ? (typeof classname == 'string' && classname.length > 0)
                ? classname + ' radio-selector' : 'radio-selector'
            : '';
        selectFunction = selectFunction || function(filterKey, value) {
            return ((this.filter.selected[filterKey] === value)
                || ((typeof this.filter.selected[filterKey] == 'undefined'
                    || this.filter.selected[filterKey] == null) && value === 'null'))
        }.bind(this);

        let list = $('<ul></ul>').attr('data-filter-key', filterKey)
            .attr('id', id).addClass(classname);
        list.append($('<li></li>').addClass('label').html(label));
        for(let i = 0; i < options.length; i++) {
            let value = options[i].value;
            if(typeof value === 'undefined' || value == null) value = 'null';
            let option = $('<li></li>').html(options[i].label)
                .attr('data-value', value)
                .addClass('option');
            if(selectFunction(filterKey, value))
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
            this.filter.app.hash.pushQuery(this.filter.createQuery());
            this.filter.app.getCourses();
        }.bind(this));
    }

    radioFilterEvent() {
        $('.radio-selector.filter li.option:not(.selected)').on('click', function(e) {
            let selector = $(e.target).closest('.radio-selector');
            let target = $(e.target).closest('li.option');
            let filterKey = selector.attr('data-filter-key');
            selector.find('li.selected').removeClass('selected');
            target.addClass('selected');
            let value = FilterHelper.parseValue(target.attr('data-value'));
            this.filter.selected[filterKey] = value;
            this.filter.app.hash.pushQuery(this.filter.createQuery());
            this.filter.app.getCourses();
        }.bind(this));
    }

    radioSortEvent() {
        $(document).on('click', '.radio-selector.sort li.option:not(.selected)',function(e) {
            let selector = $(e.target).closest('.radio-selector');
            let target = $(e.target).closest('li.option');
            let filterKey = selector.attr('data-filter-key');
            let value = target.attr('data-value');
            selector.find('li.selected').removeClass('selected');
            target.addClass('selected');
            this.filter.setSorter(value, filterKey);
            this.filter.app.hash.pushQuery(this.filter.createQuery());
            this.filter.app.getCourses();
        }.bind(this));
    }

    getSortIndicator(filterKey) {
        let indicator = '';
        if(typeof this.filter.sort[filterKey] !== 'undefined') {
            let index = this.filter.sort[filterKey];
            if(this.filter.selected.sort[index] == filterKey + ':asc')
                indicator = ' <span class="asc">ascending</span>';
            if(this.filter.selected.sort[index] == filterKey + ':desc')
                indicator = ' <span class="desc">descending</span>';
        }
        return indicator;
    }

    static parseValue(value) {
        if(value == 'null') value = null;
        else if(value == 'false') value = false;
        else if(value == 'true') value = true;
        return value;
    }

    addHandlers() {
        this.selectEvent();
        this.unselectEvent();
        this.radioFilterEvent();
        this.radioSortEvent();
    }

    createFilterModal() {
        let modal = new Modal('Filter Options', 'filter');

        if(!this.filter.isEmpty())
            modal.add($('<a href="' + BASE_URL + '" id="reset">Clear Filters</a>').addClass('blue button'));

        if(this.filter.isEmpty('institution')) {
            if(this.filter.isEmpty('city')) {
                modal.add(this.createSelector('country'));
                modal.add(this.createSelection('country'));
            }
            modal.add(this.createSelector('city'));
            modal.add(this.createSelection('city'));
        }
        modal.add(this.createSelector('institution'));
        modal.add(this.createSelection('institution'));

        modal.add('<hr />');

        modal.add(this.createSelector('disciplines'));
        modal.add(this.createSelection('disciplines'));

        modal.add(this.createSelector('techniques'));
        modal.add(this.createSelection('techniques'));

        modal.add(this.createSelector('objects'));
        modal.add(this.createSelection('objects'));

        modal.add(this.createSelector('languages'));
        modal.add(this.createSelection('languages'));

        modal.add(this.createSelector('types'));
        modal.add(this.createSelection('types'));

        modal.add('<hr />');

        modal.add(this.createPresenceTypeSelector());
        modal.add(this.createOccurrenceSelector());

        modal.create();
    }

    createSortModal() {
        let options = [
            {label: '<span class="mobile">Asc</span><span class="screen">Ascending</span>', value: 'asc'},
            {label: '<span class="mobile">Desc</span><span class="screen">Descending</span>', value: 'desc'},
            {label: '<span class="mobile">-</span><span class="screen">None</span>', value: 'null'}
        ];

        let selectFunction = function(filterKey, value) {
            let index = this.filter.sort[filterKey];
            if(typeof index == 'undefined' && value == 'null') return true;
            return this.filter.selected.sort[index] == filterKey + ':' + value;
        }.bind(this);

        let modal = new Modal('Sort Options','sort');
        modal.add($('<p></p>').text('Default course order is most recent courses first.'));

        let selectors = [
            {id: 'sort-course-name', label: 'Course Name', filterKey: 'Courses.name'},
            {id: 'sort-country-name', label: 'Country', filterKey: 'Countries.name'},
            {id: 'sort-university-name', label: 'University', filterKey: 'Institutions.name'},
            //{id: 'sort-date', label: 'Start Date', filterKey: 'Courses.start_date'},
            {id: 'sort-education', label: 'Education', filterKey: 'CourseTypes.name'},
        ];

        // show selected options first
        if(this.filter.selected.sort.length > 0) {
            for(let i = 0; i < this.filter.selected.sort.length; i++) {
                let filterKey = this.filter.selected.sort[i].split(':')[0];
                selectors = selectors.filter(function(selector) {
                    if(selector.filterKey === filterKey) {
                        if(this.app.layout == 'screen'
                            || (selector.filterKey != 'Countries.name' && selector.filterKey != 'Cities.name'))
                            modal.add(this.createRadioSelector('sort', selector.id,
                            selector.label, options, selector.filterKey, selectFunction));
                        return false;
                    }
                    return true;
                }.bind(this));
            }
        }

        for(let i = 0; selectors.length > i; i++) {
            let selector = selectors[i];
            if(this.app.layout == 'screen'
                || (selector.filterKey != 'Countries.name' && selector.filterKey != 'Cities.name'))
                modal.add(this.createRadioSelector('sort', selector.id,
                selector.label, options, selector.filterKey, selectFunction));
        }

        modal.create();
    }
}
