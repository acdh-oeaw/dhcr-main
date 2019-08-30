
'use strict';

class Table {

    constructor(selector) {
        // store the native DOM element, not jQuery
        this.element = $(selector)[0];
        this.entries = {};
    }

    setData(courses) {
        if(courses.length == 0) {
            this.setErrorMessage('Your query returned no results.');
        }

        // remove all content
        $(this.element).empty();

        for(let k in courses) {
            let entry = $('<div></div>').addClass('entry');
            entry.append('<h1>' + courses[k].name + '</h1>');
            this.entries[courses[k].id] = {
                entry: entry,
                course: courses[k]
            };
            $(this.element).append(entry);
        }
    }

    setErrorMessage(msg) {
        msg = msg || 'Something went wrong';
        $(this.element).empty();
        let error = $('<div></div>').addClass('error').text(msg);
        $(this.element).append(error);
    }

    setLoader() {
        $(this.element).empty();
        let loader = $('<div></div>').addClass('loading').text('loading...');
        $(this.element).append(loader);
    }

}
