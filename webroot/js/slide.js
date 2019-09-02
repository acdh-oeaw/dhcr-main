
'use strict';

class Slider {
    constructor(elm) {
        this.sliding = false;
        this.element = elm;
        this.element.style.marginLeft = 0;
        this.viewportWidth = parseInt(this.element.clientWidth);
    }

    updateSize() {
        this.viewportWidth = parseInt(this.element.clientWidth);
    }

    toggle() {
        if (this.sliding) return;
        this.sliding = true;

        let margin = 0;
        let slide = this.element.firstElementChild;
        if (parseInt(this.element.style.marginLeft) == 0) {
            margin = - this.viewportWidth;
        }

        $(this.element).animate( {
            "margin-left": margin + "px"
        }, 500, function() { this.sliding = false }.bind(this));
    }

    reset() {
        this.element.style.marginLeft = 0;
    }
}

