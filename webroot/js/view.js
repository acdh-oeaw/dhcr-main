
'use strict';

class View {

    constructor(elm, app) {
        // store the native DOM element, not jQuery
        this.element = elm;
        this.app = app;
    }

    createTable() {
        // check the global courses variable
        if(typeof courses == 'undefined' || courses.length == 0) {
            this.setErrorMessage('Your query returned no results.');
            return;
        }
        this.clearView();

        // create filter
        this.app.filter.helper.createHtml(this.element);

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
        for(let i = 0; courses.length > i; i++) {
            let id = courses[i].id;
            let row = this.createTableRow(this.app.data[id]);
            table.append(row);
        }
        $(this.element).append(table);
        if(this.app.hash.fragment.length > 0 && !isNaN(this.app.hash.fragment)) {
            let id = this.app.hash.fragment;
            if(this.openRow(id)) {
                this.scrollToRow(id);
                // we need a timeout to wait until map has stopped moving (and closing open popups)
                setTimeout(function(){
                    this.app.map.openMarker(id);
                }.bind(this), 1500);
            }
        }
    }

    scrollToRow(id) {
        let row = document.getElementById('course-row-' + id);
        if(typeof row != 'undefined' && row)
            $(this.element).animate({scrollTop: row.offsetTop}, 1000 );
    }

    toggleRow(id) {
        $('.expansion-row').remove();
        if(typeof id != 'undefined') {
            let targetRow = $('tr[data-id=' + id + ']');
            // close all others
            $('.expanded[data-id!=' + id + ']').removeClass('expanded');
            targetRow.toggleClass('expanded');
            if(targetRow.hasClass('expanded')) {
                // opening
                let course = this.app.data[id];
                let expansion = this.createExpansionRow(course);
                targetRow.after(expansion);     // insert
                return true;    // wheter or not to open popups on map
            }
        }else{
            // close all
            $('.expanded').removeClass('expanded');
        }
        return false;   // no popups
    }

    openRow(id) {
        if(typeof id != 'undefined' && id > 0 && !isNaN(id)) {
            let targetRow = $('tr[data-id=' + id + ']');
            if(!targetRow.hasClass('expanded')) {
                // remove others
                $('.expansion-row').remove();
                $('.expanded').removeClass('expanded');
                // opening
                targetRow.addClass('expanded');
                let course = this.app.data[id];
                let colspan = (this.app.layout == 'mobile') ? 4 : 5;
                let expansion = ViewHelper.createExpansionRow(course, colspan);
                targetRow.after(expansion);
            }
            return true;
        }
        return false;
    }

    createTableRow(course) {
        let tr = $('<tr></tr>').addClass('course-row').attr('data-id', course.id).attr('id', 'course-row-' + course.id);
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
        return tr[0];
    }

    createView(course) {
        let el = $('<div id="view"></div>');
        let helper = new ViewHelper();
        let timing = ViewHelper.getTiming(course, ', ', ', ', '<br />', true);

        let backActionLabel = (this.app.action == 'view') ? 'Go to Start' : 'Back to List';
        let back = $('<a class="back button small close_view" href="' + BASE_URL + '">' + backActionLabel + '</a>');
        let share = Sharing.createSharingButton('blue small', course);
        el.append($('<div class="buttons"></div>').append(back, share));

        el.append($('<h1>' + course.name + '</h1>'));
        el.append($('<p class="subtitle">' + course.course_type.name + ', ' + timing + '</p>'));
        if(course.description != null && course.description.length > 0)
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
            helper.createTermData('Source URL', link).createGridItem('single-col');
        }
        el.append($(helper.createGridContainer().result));

        // locationMap is a second map only shown on mobile devices
        let location = $('<div id="locationMap"></div>');
        el.append(location);

        el.append($('<hr />'));

        $(this.element).empty();
        $(this.element).append(el);

        this.app.scrollable.top();
        this.app.hash.push(course.id);

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
        $(this.element).empty().removeClass('loading');
        $(this.element).addClass('error').text(msg);
    }

    setLoader() {
        $(this.element).empty();
        $(this.element).addClass('loading').text('loading...');
    }

    clearView() {
        $(this.element).empty().removeClass('loading');
    }


}
