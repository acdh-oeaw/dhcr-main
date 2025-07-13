
'use strict';

class Modal {

    constructor(title, classname, callback) {
        this.element = $('<div></div>')
            .attr('id', 'modal-wrapper');
        if (typeof classname === 'string') this.element.addClass(classname);

        this.content = $('<div></div>').attr('id', 'modal-content');
        if (title) this.content.append($('<h1 align="center"></h1>').html(title));

        this.scrollbox = $('<div></div>').attr('id', 'modal-scroll-container');
        this.content.append(this.scrollbox);

        console.dir(title);
        // decide which close button to use
        if (title.includes('Options')) { // || title == 'Sort Options'
            this.content.append('&nbsp;<a href="#" class="blue button" id="modal-go">GO</a>&nbsp;');
        } else {
            this.content.append($('<span>Close</span>').attr('id', 'modal-close'));
        }

        this.element.append(this.content);

        Modal.addHandlers(callback);
    }

    add(object) {
        this.scrollbox.append(object);
    }

    create() {
        $('body').append(this.element);
    }

    show(event) {
        // do other things here in extending classes:
        // animate, preventDefault etc
        this.create();
    }

    close() {
        Modal.close();
    }

    static addHandlers(callback) {
        $(document).on('click', '#modal-wrapper', function (e) {
            if ($(e.target).is('#modal-wrapper, #modal-close') || $(e.target).is('#modal-wrapper, #modal-go')) {
                Modal.close()
                if (typeof callback === 'function') callback();
            }
        });
    }

    static close() {
        $('#modal-wrapper').remove();
    }
}
