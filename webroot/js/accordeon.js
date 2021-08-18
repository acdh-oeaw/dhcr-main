

'use strict';



class Accordeon {

    constructor(identifier) {
        this.element = document.getElementById(identifier);
        this.handles = $(this.element).find(".accordeon-item > h2");


        this.hash = new Hash();
        // open current fragment, if any
        if(this.hash.fragment.length > 0) {
            $('#' + this.hash.fragment).addClass('open');
            location.href = '#' + this.hash.fragment;   // scroll page to section
        }

        this.addHandlers();
    }

    addHandlers() {
        for(let i = 0; this.handles.length > i; i++) {
            $(this.handles[i]).click(function() {
                this.clickHandler(this.handles[i]);
            }.bind(this));
        }
    }

    openHash(hash) {
        this.closeAll();
        this.hash.push(hash);
        $('#' + hash).addClass('open');
        sleep(1000).then(() => {
            // scroll page to location
            location.href = '#' + hash;
        })
    }

    closeAll() {
        $('.accordeon-item.open').removeClass('open');
        this.hash.remove();
    }

    clickHandler(handle) {
        let item = $(handle).closest('.accordeon-item');
        //let wasOpen = (item.hasClass('open')) ? true : false;
        //this.closeAll();
        //if(!wasOpen) this.openItem(handle);
        this.toggleItem(handle);
    }

    openItem(handle) {
        let item = $(handle).closest('.accordeon-item');
        item.addClass('open');

        this.hash.remove();
        this.hash.push($(item).attr('id'));
    }

    closeItem(handle) {
        $(handle).closest('.accordeon-item').removeClass('open');
        this.hash.remove();
    }

    toggleItem(handle) {
        if($(handle).closest('.accordeon-item').hasClass('open')) {
            this.closeItem(handle);
        }else{
            this.openItem(handle);
        }
    }
}
