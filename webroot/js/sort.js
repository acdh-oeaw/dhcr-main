
'use strict';

class Sort {
    constructor(app, column, label) {
        this.app = app;
        this.filterHelper = new FilterHelper(app.filter);

        let options = [
            {label: 'Ascending', value: 'asc'},
            {label: 'Descending', value: 'desc'},
            {label: 'None', value: null}
        ];


        this.modal = new Modal('SortOptions', 'Default sorting is most recent courses first.', 'sort');


        this.modal.add(this.filterHelper.createRadioSelector('sort-' + column,
            label, options, 'sort'));



        this.modal.create();
    }
}
