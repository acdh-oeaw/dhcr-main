
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
        let twitter = Sharing.createTwitter(course);
        let fb = Sharing.createFaceBook(course);
        modal.add(Sharing.createCopyToClipboard(course));
        modal.add($('<div></div>').addClass('row').append(mail, twitter));
        modal.add($('<div></div>').addClass('row').append(fb));
        modal.create();
    }

    addHandlers() {
        // open dialogue
        $(document).on('click', '.sharing.button', function(e) {
            e.preventDefault();
            let id = $(e.target).attr('data-id');
            Sharing.createSharingDialog(this.app.data[id]);
        }.bind(this));

        // copy link
        $(document).on('click', '#copy-link', function(e) {
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

    // function for opening sharing links in a new window/popup
    // https://stackoverflow.com/questions/26547292/how-create-a-facebook-share-button-without-sdk-or-custom-app-id
    static openURLInPopup(url, windowId, width, height) {
        if (typeof(width) == "undefined") {
            width = 800;
            height = 600;
        }
        if (typeof(height) == "undefined") {
            height = 600;
        }
        window.open(url, windowId || 'window' + Math.floor(Math.random() * 10000 + 1),
            width, height, 'menubar=0,location=0,toolbar=0,status=0,scrollbars=1');
    }

    static createTwitter(course) {
        let url = '&url=' + BASE_URL + 'courses/view/' + course.id;
        let body = 'Look at this Course at in the Digital Humanities Course Registry:'
            + '\nTitle: ' + course.name
            + '\nAt: ' + course.institution.name + ', ' + course.department
            + '\nIn: ' + course.city.name + ', ' + course.country.name;
        let hashtags = '&hashtags=DHCR,DHCourseRegistry';
        let href = 'https://twitter.com/intent/tweet?text=' + body + hashtags + url;

        let button = $('<a></a>').addClass('sharing-option')
            .attr('href', encodeURI(href))
            .attr('target', '_blank')
            .html('<svg><use href="#twitter"></use></svg></span><span>Tweet</span>');
        button.on('click', function(e) {
            e.preventDefault();
            Sharing.openURLInPopup(href, '_blank');
        });
        return button;
    }

    static createFaceBook(course) {
        let url = BASE_URL + 'courses/view/' + course.id;
        let body = '&quote=Look at this Course at in the Digital Humanities Course Registry:'
        + '\nTitle: ' + course.name
        + '\nAt: ' + course.institution.name + ', ' + course.department
        + '\nIn: ' + course.city.name + ', ' + course.country.name;
        let href = 'https://www.facebook.com/sharer/sharer.php?u=' + url + body;

        let button = $('<a></a>').addClass('sharing-option single')
            .attr('href', encodeURI(href))
            .attr('target', '_blank')
            .html('<svg><use href="#facebook"></use></svg></span><span>Facebook</span>');
        button.on('click', function(e) {
            e.preventDefault();
            Sharing.openURLInPopup(href, '_blank');
        });
        return button;
    }
}
