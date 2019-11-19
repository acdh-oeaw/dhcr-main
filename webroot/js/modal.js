
'use strict';

class Modal {

    constructor(title, classname) {
        this.element = $('<div></div>')
            .attr('id', 'modal-wrapper');
        if(typeof classname === 'string') this.element.addClass(classname);
        this.content = $('<div></div>').attr('id', 'modal-content');
        this.content.append($('<span>Close</span>').addClass('close'));
        if(title)       this.content.append($('<h1></h1>').html(title));
    }

    add(object) {
        this.content.append(object);
    }

    create() {
        this.element.append(this.content);
        $('body').append(this.element);
    }

    close() {
        Modal.close();
    }

    static addHandlers() {
        $(document).on('click', '#modal-wrapper', function(e) {
            if($(e.target).is('#modal-wrapper, #modal-wrapper .close'))
                Modal.close();
        });
    }

    static close() {
        $('#modal-wrapper').remove();
    }
}
