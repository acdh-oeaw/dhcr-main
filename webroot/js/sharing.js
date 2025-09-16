
'use strict';

class Sharing {

    constructor(app) {
        this.app = app;
        this.addHandlers();
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
        let modal = new Modal('Share this course', 'sharing');
        let mail = Sharing.createMail(course);
        modal.add(Sharing.createCopyToClipboard(course));
        modal.add($('<div></div>').addClass('row').append(mail));
        modal.create();
    }

    addHandlers() {
        // open dialogue
        $(document).on('click', '.sharing.button', function (e) {
            e.preventDefault();
            let id = $(e.target).attr('data-id');
            Sharing.createSharingDialog(this.app.data[id]);
        }.bind(this));

        // copy link
        $(document).on('click', '#copy-link', function (e) {
            this.copyLink();
        }.bind(this));
    }

    static createCopyToClipboard(course) {
        let tooltip = $('<span></span>').addClass('tooltiptext').attr('id', 'copy-tooltip');
        let input = $('<input>').attr('id', 'sharing-link').val(BASE_URL + 'courses/view/' + course.id);
        let button = $('<button></button>').attr('id', 'copy-link')
            .addClass('small blue tooltip')
            .text('Copy').append(tooltip);
        return $('<div></div>').addClass('copy_to_clipboard row').append(input, button);
    }

    copyLink() {
        let text = document.getElementById("sharing-link");
        text.select();
        text.setSelectionRange(0, 99999);
        let feedback = 'Copied to clipboard!';
        if (typeof document.execCommand === 'function')
            document.execCommand("copy");
        else
            feedback = 'Unable to copy text'
        let tooltip = $('#copy-tooltip');
        tooltip.text(feedback);
        tooltip.css({
            visibility: 'visible',
            opacity: 1
        });
        setTimeout(function () {
            $(tooltip).animate({ opacity: 0 }, 1000)
        }, 1000);
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
}
