
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
        this.addTableClickHandler();
    }

    addTableClickHandler() {
        $('.course-row').on('click', function(e) {
            let targetRow = $(e.delegateTarget);
            let id = targetRow.attr('data-id');
            if(this.toggleRow(id))
                this.app.map.openMarker(id);
            else
                this.app.map.closeMarker();
        }.bind(this));
    }

    toggleRow(id) {
        // TODO: scroll to top
        $('.expansion-row').remove();
        if(typeof id != 'undefined') {
            let targetRow = $('tr[data-id=' + id + ']');
            $('.expanded[data-id!=' + id + ']').removeClass('expanded');
            targetRow.toggleClass('expanded');
            if(targetRow.hasClass('expanded')) {
                // opening
                let course = this.app.data[id];
                let expansion = this.createExpansionRow(course);
                targetRow.after(expansion);
                return true;
            }
        }else{
            // close all
            $('.expanded').removeClass('expanded');
        }
        return false;
    }

    openRow(id) {
        if(typeof id != 'undefined') {
            let targetRow = $('tr[data-id=' + id + ']');
            if(!targetRow.hasClass('expanded')) {
                // remove others
                $('.expansion-row').remove();
                $('.expanded').removeClass('expanded');
                // opening
                targetRow.addClass('expanded');
                let course = this.app.data[id];
                let expansion = this.createExpansionRow(course);
                targetRow.after(expansion);
                return true;
            }
        }
    }

    createExpansionRow(course) {
        let mediaQuery = window.matchMedia('(max-width: ' + this.app.breakPoint + 'px)');
        let colspan = 5;
        if(mediaQuery.matches) colspan = 4;
        let content = $('<td></td>').attr('colspan', colspan);
        content.append(this.createSharingButton('blue', course));
        let expansionRow = $('<tr></tr>').addClass('expansion-row').append(content);
        return expansionRow[0];
    }

    createTableRow(course) {
        let tr = $('<tr></tr>').addClass('course-row').attr('data-id', course.id);
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

    createSharingButton(classes, course) {
        classes = (typeof classes == 'undefined' || classes == '') ? 'sharing button' : classes + ' sharing button';
        let share = $('<a class="' + classes + '" href="' + BASE_URL + 'courses/view/' + course.id + '">Share</a>')
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
        return share[0];
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
        let share = this.createSharingButton('blue', course);
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
