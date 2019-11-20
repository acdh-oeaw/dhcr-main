
'use strict';

class Hash {

    constructor() {
        this.fragment = window.location.hash.substr(1);
    }

    // pushes fragment to browser history and adds it to browser address bar
    push(hash) {
        this.fragment = String(hash);
        if(history.pushState)
            history.pushState(null, document.title, '#' + hash);
        else
            window.location.hash = hash;
    }

    pushQuery(query) {
        if(history.pushState) {
            history.pushState(null, document.title, window.location.pathname + query);
        }else {
            window.location = BASE_URL + query;
        }
    }

    // removes fragment and query from URL string in browser address bar
    remove() {
        // https://stackoverflow.com/questions/1397329/how-to-remove-the-hash-from-window-location-url-with-javascript-without-page-r/5298684#5298684
        this.fragment = null;
        let scrollV, scrollH, loc = window.location;
        if (history.pushState) {
            history.pushState(null, document.title, loc.pathname);
        }else{
            // Prevent scrolling by storing the page's current scroll offset
            scrollV = document.body.scrollTop;
            scrollH = document.body.scrollLeft;
            loc.hash = "";
            // Restore the scroll offset, should be flicker free
            document.body.scrollTop = scrollV;
            document.body.scrollLeft = scrollH;
        }
        this.fragment = null;
    }
}
