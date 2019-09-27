
'use strict';

class Table {

    constructor(elm) {
        // store the native DOM element, not jQuery
        this.element = elm;
        this.entries = {};
        this.months = ['Jan','Feb','Mar','Apr','May','June','July','Aug','Sept','Oct','Nov','Dec'];
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
                $('<th class="period">Date <span></span></th>'),
                $('<th class="type">Type <span></span></th>')
            )
        );
        for(let k in courses) {
            let row = this.createTableRow(courses[k]);
            this.entries[courses[k].id] = row;
            table.append(row);
        }
        $(this.element).append(table);
    }

    createTableRow(course) {
        let tr = $('<tr></tr>');
        let duration = this.getTiming(course, ',<br />', ' ', '<br />');
        let type = course.course_type.name;
        if (course.online) type += ' <span class="online">online</span>';
        let limit = 59;
        let courseName = (course.name.length <= limit + 4)
            ? course.name
            : course.name.substr(0, limit) + ' ...';
        tr.append(
            $('<td class="name">' + courseName + '</td>'),
            $('<td class="university">' + course.institution.name + '</td>'),
            $('<td class="location">' + course.city.name + ',<br />' + course.country.name + '</td>'),
            $('<td class="period">' + duration + '</td>'),
            $('<td class="type">' + type + '</td>')
        );
        return tr;
    }

    getTiming(course, dateSeparator = ', ', recurringSeparator = ', ', durationSeparator = '<br />') {
        let split = course.start_date.split(/[;,]/);
        let duration = '';
        let lastMonth;
        for (let i = 0; split.length > i; i++) {
            let date = new Date(split[i].trim())
            if ((!course.recurring && date < new Date()) || (course.recurring && lastMonth == date.getMonth())) continue;     // omit past dates except for recurring starts
            lastMonth = date.getMonth()
            if (duration != '') duration += dateSeparator;
            let day = (date.getDay() == 0) ? 1 : date.getDay();
            duration += day + ' ' + this.months[date.getMonth()];
            if (!course.recurring) duration += ' ' + date.getFullYear();
        }
        if (course.recurring) {
            if (duration != '') duration += recurringSeparator;
            duration += '<span class="recurring tooltip" data-tooltip="recurring">recurring</span>';
        }
        if (course.duration != null) {
            if (duration != '') duration += durationSeparator;
            duration += course.duration + ' ' + course.course_duration_unit.name;
        }
        return duration;
    }

    createView(course) {
        let el = $('<div id="view"></div>');
        let timing = this.getTiming(course, ', ', ', ', '<br />');

        el.append($('<h1>' + course.name + '</h1>'));
        el.append($('<p class="subtitle">' + course.course_type.name + ', ' + timing + '</p>'));
        if(course.description.length > 0)
            el.append($('<div class="text"><p class="strong">Description:</p>' + course.description + '</div>'));
        if(course.access_requirements.length > 0)
            el.append($('<div class="text"><p class="strong">Access Requirements:</p>' + course.access_requirements + '</div>'));

        el.append($('<hr />'));

        let country = '<div class="flex-item"><p class="term">Country</p><p class="data">' + course.country.name + '</p></div>';
        let city = '<div class="flex-item"><p class="term">City</p><p class="data">' + course.city.name + '</p></div>';
        el.append($('<div class="flex-columns">' + country + city + '</div>'));
        let uni = '<div class="flex-item"><p class="term">University</p><p class="data">' + course.institution.name + '</p></div>';
        let dep = '<div class="flex-item"><p class="term">Department</p><p class="data">' + course.department + '</p></div>';
        el.append($('<div class="flex-columns">' + uni + dep + '</div>'));
        let lecturer = '<div class="flex-item"><p class="term">Lecturer</p><p class="data">' + course.contact_name + '</p></div>';
        let credits = '<div class="flex-item"><p class="term">Credits</p><p class="data">' + course.ects + '</p></div>';
        el.append($('<div class="flex-columns">' + lecturer + credits + '</div>'));
        let language = '<div class="flex-item"><p class="term">Language</p><p class="data">' + course.language.name + '</p></div>';
        let online = (course.online) ? '<div class="flex-item"><p class="term">Online</p><p class="data">yes</p></div>' : '';
        el.append($('<div class="flex-columns">' + language + online + '</div>'));

        let back = '<a class="button flex-item" href="' + BASE_URL + '">Back to List</a>';
        let share = '<button class="button blue flex-item">Share</button>';
        el.append($('<div class="flex-columns">' + back + share + '</div>'));

        el.append($('<hr />'));

        $(this.element).empty();
        $(this.element).append(el);
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
