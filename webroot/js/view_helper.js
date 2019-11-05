

'use strict';

class ViewHelper {

    static months() {
        return ['Jan','Feb','Mar','Apr','May','June','July','Aug','Sept','Oct','Nov','Dec'];
    }

    constructor(result = '', collection = []) {
        this._result = result;  // the resulting html string
        this._collection = collection;  // collection of html string items to wrap in a container
    }

    reset() {
        this._result = '';
        this._collection = [];
    }

    copy() {
        return new ViewHelper(this._result, this._collection);
    }

    get result() {
        let result = this._result;
        this.reset();
        return result;
    }


    static createLink(href, text, external = true) {
        text = text || href;
        if(text == href && text.length > 60)
            text = text.substr(0, 60) + '...';
        let attributes = 'href="' + href + '"';
        if(external) attributes += ' target="_blank"';
        let result = '<a ' + attributes + '>';
        result += text + '</a>';
        return result;
    }

    createLink(href, text, external) {
        this._result = ViewHelper.createLink(href, text, external);
        return this;
    }


    static createTermData(term, data) {
        let empty = '-';
        data = data || empty;
        if(typeof data == 'string' && data.match(/^null$|^nan$/i)) data = empty;
        let result = '<p class="term">' + term + '</p>';
        result += '<p class="data">' + data + '</p>';
        return result;
    }

    createTermData(term, data) {
        this._result = ViewHelper.createTermData(term, data);
        return this;
    }


    static createGridItem(content, classes = '') {
        classes = (classes == '') ? 'item' : 'item ' + classes;
        let result = '<div class="' + classes + '">' + content + '</div>';
        return result;
    }

    createGridItem(classes) {
        this._collection.push(ViewHelper.createGridItem(this._result, classes));
        this._result = '';
        return this;
    }


    static createGridContainer(items = [], classes = '') {
        classes = (classes == '') ? 'grid-container' : 'grid-container ' + classes;
        let result = '<div class="' + classes + '">';
        for(let i = 0; i < items.length; i++) result += items[i];
        result += '</div>';
        return result;
    }

    createGridContainer(classes) {
        this._result = ViewHelper.createGridContainer(this._collection, classes);
        this._collection = [];
        return this;
    }


    static getTiming(course, dateSeparator = ', ', recurringSeparator = ', ', durationSeparator = '<br />', verbose = false) {
        let result = '';
        if(course.start_date) {
            let split = course.start_date.split(/[;,]/);
            let lastMonth;
            let start = '';
            for (let i = 0; split.length > i; i++) {
                let date = new Date(split[i].trim())
                if ((!course.recurring && date < new Date()) || (course.recurring && lastMonth == date.getMonth())) continue;     // omit past dates except for recurring starts
                lastMonth = date.getMonth()
                if (start != '') start += dateSeparator;
                let day = (date.getDay() == 0) ? 1 : date.getDay();
                start += day + ' ' + ViewHelper.months()[date.getMonth()];
                if (!course.recurring) start += ' ' + date.getFullYear();
            }
            if(verbose && start.length > 0 && course.recurring) start = 'each ' + start;
            result = start;
        }
        if(course.recurring) {
            if (result != '') result += recurringSeparator;
            result += '<span class="recurring">recurring</span>';
        }
        if(course.duration) {
            if (result != '') result += durationSeparator;
            result += course.duration + ' ' + course.course_duration_unit.name;
        }
        return result;
    }

}
