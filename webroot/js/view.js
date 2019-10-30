
'use strict';

class View {

    constructor(elm, app) {
        // store the native DOM element, not jQuery
        this.element = elm;
        this.entries = {};
        this.app = app;
    }

    createTable(courses) {
        if(courses.length == 0) {
            this.setErrorMessage('Your query returned no results.');
            return;
        }
        // remove all content
        $(this.element).empty();
        // create filter
        $(this.element).append(this.app.filter.createHtml());
        // create table
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
        let duration = ViewHelper.getTiming(course, ',<br />', ' ', '<br />');
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



    createView(course) {
        let el = $('<div id="view"></div>');
        let helper = new ViewHelper();
        let timing = ViewHelper.getTiming(course, ', ', ', ', '<br />', true);

        let backActionLabel = (this.app.action == 'view') ? 'Go to Start' : 'Back to List';
        let back = $('<a class="back button" href="' + BASE_URL + '">' + backActionLabel + '</a>')
            .on('click', function(e) {
                e.preventDefault();
                this.app.closeView();
            }.bind(this));
        let share = $('<a class="blue sharing button" href="' + BASE_URL + 'courses/view/' + course.id + '">Share</a>')
            .on('click', function(e) {
                e.preventDefault();
                if (navigator.share) {
                    console.log('navi')
                    navigator.share({
                        title: 'The Digital Humanities Course Registry',
                        text: course.name,
                        url: BASE_URL + 'courses/view/' + course.id
                    }).then(() => {
                        console.log('Thanks for sharing!');
                    }).catch(console.error);
                } else {
                    shareDialog.classList.add('is-open');
                    console.log('fallback')
                }
            }.bind(this));
        el.append($('<div class="buttons"></div>').append(back, share));

        el.append($('<h1>' + course.name + '</h1>'));
        el.append($('<p class="subtitle">' + course.course_type.name + ', ' + timing + '</p>'));
        if(course.description.length > 0)
            el.append($('<div class="text"><p class="strong">Description:</p>' + course.description + '</div>'));
        if(course.access_requirements.length > 0)
            el.append($('<div class="text"><p class="strong">Access Requirements:</p>' + course.access_requirements + '</div>'));

        el.append($('<hr />'));

        helper.createTermData('Country', course.country.name).createGridItem();
        helper.createTermData('City', course.city.name).createGridItem();

        helper.createTermData('University', course.institution.name).createGridItem();
        helper.createTermData('Department', course.department).createGridItem();

        helper.createTermData('Lecturer', course.contact_name).createGridItem();
        helper.createTermData('Credits (ECTS)', course.ects).createGridItem();

        helper.createTermData('Language', course.language.name).createGridItem();
        if(course.online) helper.createTermData('Online Course', 'yes').createGridItem();

        helper.createTermData('Record Id', course.id).createGridItem();

        if(course.info_url.length > 0 && course.info_url != 'null') {
            let link = ViewHelper.createLink(course.info_url);
            helper.createTermData('Information', link).createGridItem('single-col');
        }
        el.append($(helper.createGridContainer().result));

        // locationMap is a second map only shown on mobile devices
        let location = $('<div id="locationMap"></div>');
        el.append(location);

        el.append($('<hr />'));

        $(this.element).empty();
        $(this.element).append(el);

        // init mobile auxiliary map after adding it to document
        let map = new Map({
            htmlIdentifier: 'locationMap',
            apiKey: this.app.mapApiKey,
            scrollWheelZoom: false,
            app: this.app
        });
        let id = course.id;
        map.setMarkers({id: course}, false);
        map.map.setView([course.lat, course.lon], 5);
        map.map.on('click', function() { map.map.scrollWheelZoom.enable(); });
        map.map.on('focus', function() { map.map.scrollWheelZoom.enable(); });
        map.map.on('mouseout', function() { map.map.scrollWheelZoom.disable()});
        map.map.on('blur', function() { map.map.scrollWheelZoom.disable()});
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
