
'use strict';

class Sharing {

    constructor(app) {
        this.app = app;
        this.addHandlers();
    }

    addHandlers() {
        // open dialogue
        $(document).on('click', '.sharing.button', function(e) {
            e.preventDefault();
            let id = $(e.target).attr('data-id');
            let course = this.app.data[id];
            let body = '\n' + course.name
                + '\n' + course.institution.name + ', ' + course.department
                + '\n' + course.city.name + ', ' + course.country.name;
            if(navigator.share) {
                navigator.share({
                    title: 'The Digital Humanities Course Registry',
                    text: 'Look at this this DH course: ' + body,
                    url: BASE_URL + 'courses/view/' + id
                }).then(() => {
                    //console.log('Thanks for sharing!');
                }).catch(console.error);
            }else{
                $('body').append(Sharing.createSharingDialog(this.app.data[id]));
            }
        }.bind(this));

        // close dialogue
        $(document).on('click', '#sharing-wrapper', function(e) {
            if($(e.target).is('#sharing-wrapper, #sharing-wrapper .close'))
                $('#sharing-wrapper').remove();
        });

        // copy link
        $(document).on('click', '#copy-link', function(e) {
            this.copyLink();
        }.bind(this));
    }

    copyLink() {
        let text = document.getElementById("sharing-link");
        text.select();
        text.setSelectionRange(0, 99999);
        let feedback = 'Copied to clipboard!';
        if(typeof document.execCommand === 'function')
            document.execCommand("copy");
        else
            feedback = 'Unable to copy text'
        let tooltip = $('#copy-tooltip');
        tooltip.text(feedback);
        tooltip.css({
            visibility: 'visible',
            opacity: 1
        });
        setTimeout(function() {
            $(tooltip).animate({ opacity: 0 }, 1000)
        }, 1000);
    }

    static createSharingButton(classes, course) {
        classes = (typeof classes == 'undefined' || typeof classes != 'string' || classes == '')
            ? 'sharing button'
            : classes + ' sharing button';
        let share = $('<a></a>').addClass(classes).text('Share')
            .attr('href', BASE_URL + 'courses/view/' + course.id)
            .attr('data-id', course.id);
        return share;
    }

    static createSharingDialog(course) {
        let wrapper = $('<div></div>').attr('id', 'sharing-wrapper');
        let content = $('<div></div>').attr('id', 'sharing-content');
        let close = $('<span>Close</span>').addClass('close');
        let headline = $('<h1>Share this course</h1>');
        let title = $('<p></p>').html('<span>Title: </span>' + course.name).addClass('title');

        content.append(close,headline, Sharing.createCopyToClipboard(course));

        let mail = Sharing.createMail(course);
        let twitter = Sharing.createTwitter(course);
        content.append($('<div></div>').addClass('row').append(mail, twitter));

        wrapper.append(content);
        return wrapper;
    }

    static createMail(course) {
        let body = BASE_URL + 'courses/view/' + course.id + '\n\n' + course.name
            + '\n\n' + course.institution.name + ', ' + course.department
            + '\n\n' + course.city.name + ', ' + course.country.name
            + '\n\n' + course.description;
        let href = 'mailto:?subject=The Digital Humanities Course Registry&body=' + body;
        let button = $('<a></a>').addClass('sharing-option')
            .attr('href', encodeURI(href))
            .html('<svg><use href="#email"></use></svg><span>Email</span>');
        return button;
    }

    static createTwitter(course) {
        let url = '&url=' + BASE_URL + 'courses/view/' + course.id;
        let body = course.name
            + '\n' + course.institution.name + ', ' + course.department
            + '\n' + course.city.name + ', ' + course.country.name;
        let href = 'https://twitter.com/intent/tweet?text=' + body + url;

        let button = $('<a></a>').addClass('sharing-option')
            .attr('href', encodeURI(href))
            .attr('target', '_blank')
            .html('<svg><use href="#twitter"></use></svg></span><span>Tweet</span>');
        return button;
    }

    static createCopyToClipboard(course) {
        let tooltip = $('<span></span>').addClass('tooltiptext').attr('id', 'copy-tooltip');
        let input = $('<input>').attr('id', 'sharing-link').val(BASE_URL + 'courses/view/' + course.id);
        let button = $('<button></button>').attr('id', 'copy-link')
            .addClass('small blue tooltip')
            .text('Copy').append(tooltip);
        return $('<div></div>').addClass('copy_to_clipboard row').append(input, button);
    }


}
