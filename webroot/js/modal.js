
'use strict';

class Modal {

    constructor(title, subtitle) {
        this.element = $('<div></div>').attr('id', 'modal-wrapper');
        this.content = $('<div></div>').attr('id', 'modal-content');
        let close = $('<span>Close</span>').addClass('close');
        let _title = $('<h1></h1>').html(title);
        let _subtitle = $('<h2></h2>').html(subtitle);
        this.content.append(close,_title,_subtitle);
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
