

'use strict';

class FilterHelper {

    constructor(app, filter) {
        this.app = app;
        this.filter = filter;
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

        let wrapper = $('<div></div>').addClass('selector-wrapper');
        let selectDiv = $('<div></div>').addClass('input select');
        wrapper.append(selectDiv);
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

        selectDiv.append(select);    // first child is always an empty option "choose..."
        //wrapper.append(this.createSelection(category));
        if(Object.keys(this.filter.selected[category]).length > 0) {
            for(let id in this.filter.selected[category]) {
                let item = $('<div></div>')
                    .addClass('selection-item')
                    .attr('data-category', category).attr('data-id', id)
                    .text(this.filter.selected[category][id]);
                wrapper.append(item);
            }
        }
        return wrapper[0];
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
        if(Object.keys(this.filter.selected[category]).length > 0) {
            //let selection = $('<ul></ul>').addClass('selection').attr('id', category + '-selection');
            for(let id in this.filter.selected[category]) {
                let item = $('<div></div>')
                    .addClass('selection-item')
                    .attr('data-category', category).attr('data-id', id)
                    .text(this.filter.selected[category][id].name);
                selection.append(item);
            }
            return selection[0].outerHTML;
        }
        return '';
    }

    createPresenceTypeSelector() {
        let options = [
            {label: 'yes', value: true},
            {label: 'no', value: false},
            {label: 'both', value: 'null'}
        ];
        return this.createRadioSelector('filter', 'presence-type',
            'Online', options, 'online');
    }

    createOccurrenceSelector() {
        let options = [
            {label: 'yes', value: true},
            {label: 'no', value: false},
            {label: 'both', value: 'null'}
        ];
        return this.createRadioSelector('filter', 'recurring',
            '<span class="recurring">Recurring</span>', options, 'recurring');
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
        $(document).on('change', 'select.filter', function(e) {
            let selection = $("option:selected", e.target);
            let id = selection.attr('data-id');
            let category = selection.attr('data-category');
            if(!(id in this.filter.selected[category])) {
                this.filter.selected[category][id] = this.filter[category][id].name;
                //delete this.filter[category][id];
                let wrapper = $(e.target).closest('.selector-wrapper');
                wrapper.replaceWith(this.createSelector(category));
            }
            this.filter.app.hash.pushQuery(this.filter.createQuery());
        }.bind(this));
    }

    unselectEvent() {
        $(document).on('click', '.selection-item', function(e) {
            let category = $(e.target).attr('data-category');
            let id = $(e.target).attr('data-id');
            if(id in this.filter.selected[category]) {
                //this.filter[category][id] = this.filter.selected[category][id];
                delete this.filter.selected[category][id];
                let wrapper = $(e.target).closest('.selector-wrapper');
                wrapper.replaceWith(this.createSelector(category));
            }
            this.filter.app.hash.pushQuery(this.filter.createQuery());
        }.bind(this));
    }

    radioFilterEvent() {
        $(document).on('click', '.radio-selector.filter li.option:not(.selected)', function(e) {
            let selector = $(e.target).closest('.radio-selector');
            let target = $(e.target).closest('li.option');
            let filterKey = selector.attr('data-filter-key');
            selector.find('li.selected').removeClass('selected');
            target.addClass('selected');
            let value = FilterHelper.parseValue(target.attr('data-value'));
            this.filter.selected[filterKey] = value;
            this.filter.app.hash.pushQuery(this.filter.createQuery());
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
        }.bind(this));
    }

    closeEvent() {
        this.filter.app.getCourses();
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
        let modal = new Modal('Filter Options', 'filter', this.closeEvent.bind(this));
        let form = $('<form id="filter-modal"></form>');

        if(this.filter.isEmpty('institution')) {
            if(this.filter.isEmpty('city')) {
                form.append(this.createSelector('countries'));
            }
            if(Object.keys(this.filter.selected.countries).length < 2)
                form.append(this.createSelector('cities'));
        }
        if(Object.keys(this.filter.selected.countries).length < 2
            && Object.keys(this.filter.selected.cities).length < 2)
            form.append(this.createSelector('institutions'));
        form.append(this.createSelector('languages'));
        form.append('<hr />');
        form.append(this.createSelector('disciplines'));
        form.append(this.createSelector('techniques'));
        form.append(this.createSelector('objects'));
        form.append(this.createSelector('types'));
        form.append('<hr />');
        form.append(this.createPresenceTypeSelector());
        form.append(this.createOccurrenceSelector());

        modal.add(form);
        modal.create();

        // having issues...
        //let scrollable = new Scrollable(container[0]);
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

        let modal = new Modal('Sort Options','sort', this.closeEvent.bind(this));
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
