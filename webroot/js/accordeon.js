

'use strict';

let accordeon;

$(document).ready( function() {

    accordeon = new Accordeon('accordeon');

});


class Accordeon {

    constructor(identifier) {
        this.element = document.getElementById(identifier);
        this.handles = $(this.element).find(".accordeon-item > h2");
        for(let i = 0; this.handles.length > i; i++) {
            $(this.handles[i]).click(function() {
                this.clickHandler(this.handles[i]);
            }.bind(this));
        }
    }

    clickHandler(handle) {
        //$('.accordeon-item.open').removeClass('open')
        this.toggleItem(handle);
    }

    openItem(handle) {
        let item = $(handle).closest('.accordeon-item');
        item.addClass('open');
    }

    closeItem(handle) {
        $(handle).closest('.accordeon-item').removeClass('open');
    }

    toggleItem(handle) {
        if($(handle).closest('.accordeon-item').hasClass('open')) {
            this.closeItem(handle);
        }else{
            this.openItem(handle);
        }
    }
}
