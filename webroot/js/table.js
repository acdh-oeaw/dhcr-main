
'use strict';

class Table {

    constructor(elm) {
        // store the native DOM element, not jQuery
        this.element = elm;
        this.entries = {};
    }

    setData(courses) {
        if(courses.length == 0) {
            this.setErrorMessage('Your query returned no results.');
            return;
        }
        // remove all content
        $(this.element).empty();
        let table = $('<table></table>');
        table.append(
            $('<tr></tr>').append(
                $('<th class="name">Name <span></span></th>'),
                $('<th class="university">University <span></span></th>'),
                $('<th class="location">Location <span></span></th>'),
                $('<th class="period">Period <span></span></th>'),
                $('<th class="type">Type <span></span></th>')
            )
        );
        for(let k in courses) {
            let entry = this.createCourseEntry(courses[k]);
            this.entries[courses[k].id] = {
                entry: entry,
                course: courses[k]
            };
            table.append(entry);
        }
        $(this.element).append(table);
    }

    createCourseEntry(course) {
        let tr = $('<tr></tr>');
        let duration = course.start_date;
        let split = duration.split(/[;,]/);
        duration = '';
        for(let i = 0; split.length > i; i++) {
            let date = new Date(split[i].trim())
            //if(date < new Date()) continue;     // omit past dates
            if(duration != '') duration += ', ';
            duration += split[i].trim();
        }
        if(duration != '') duration += ' ';
        if(course.recurring) duration += '<span class="recurring tooltip" data-tooltip="recurring course">recurring</span>';
        if(course.duration != null) {
            if(duration != '') duration += '<br />';
            duration += course.duration + ' ' + course.course_duration_unit.name;
        }
        let type = course.course_type.name;
        if(course.online) type += ' <span class="online">online</span>';
        tr.append(
            $('<td class="name">' + course.name + '</td>'),
            $('<td class="university">' + course.institution.name + '</td>'),
            $('<td class="location">' + course.country.name + ',<br />' + course.city.name + '</td>'),
            $('<td class="enrollment">' + duration + '</td>'),
            $('<td class="type">' + type + '</td>')
        );
        return tr;
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
