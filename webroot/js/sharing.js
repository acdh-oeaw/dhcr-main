
'use strict';

class Sharing {

    constructor(course) {
        this.course = course
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

        let tooltip = document.getElementById("copy-tooltip");
        tooltip.innerHTML = feedback;
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
        let headline = $('<h1>Share this course</h1>')
        let input = $('<input>').attr('id', 'sharing-link').val(BASE_URL + 'courses/view/' + course.id);
        let button = $('<button>Copy</button>').attr('id', 'copy-link');
        content.append(input, button);
        wrapper.append(content);
        return wrapper;
    }


}
