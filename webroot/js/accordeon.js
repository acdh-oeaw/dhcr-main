

'use strict';



class Accordeon {

    constructor(identifier) {
        this.element = document.getElementById(identifier);
        this.handles = $(this.element).find(".accordeon-item > h2");
        for(let i = 0; this.handles.length > i; i++) {
            $(this.handles[i]).click(function() {
                this.clickHandler(this.handles[i]);
            }.bind(this));
        }

        let hash = window.location.hash.substr(1);
        if(hash.length > 0) {
            this.openHash(hash);
        }
    }

    closeAll() {
        $('.accordeon-item.open').removeClass('open');
    }

    clickHandler(handle) {
        // this.closeAll();
        this.toggleItem(handle);
    }

    openItem(handle) {
        let item = $(handle).closest('.accordeon-item');
        item.addClass('open');
        this.removeHash();
        window.location.hash = $(item).attr('id');
    }

    openHash(hash) {
        $('#' + hash).addClass('open');
        location.href = '#' + hash;
    }

    removeHash () {
        // https://stackoverflow.com/questions/1397329/how-to-remove-the-hash-from-window-location-url-with-javascript-without-page-r/5298684#5298684
        let scrollV, scrollH, loc = window.location;
        if ("pushState" in history) {
            history.pushState("", document.title, loc.pathname + loc.search);
        }else{
            // Prevent scrolling by storing the page's current scroll offset
            scrollV = document.body.scrollTop;
            scrollH = document.body.scrollLeft;
            loc.hash = "";
            // Restore the scroll offset, should be flicker free
            document.body.scrollTop = scrollV;
            document.body.scrollLeft = scrollH;
        }
    }

    closeItem(handle) {
        $(handle).closest('.accordeon-item').removeClass('open');
        this.removeHash();
    }

    toggleItem(handle) {
        if($(handle).closest('.accordeon-item').hasClass('open')) {
            this.closeItem(handle);
        }else{
            this.openItem(handle);
        }
    }
}
