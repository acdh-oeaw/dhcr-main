
'use strict';

class Slider {
    constructor(elm) {
        this.sliding = false;
        this.element = elm;
        this.slide = this.element.firstElementChild;
        this.slide.style.marginLeft = 0;
        this.viewportWidth = parseInt(this.element.clientWidth);
    }

    updateSize() {
        this.viewportWidth = parseInt(this.element.clientWidth);
        if(parseInt(this.slide.style.marginLeft) != 0) {
            this.slide.style.marginLeft = - this.viewportWidth + 'px';
        }
    }

    toggle() {
        if (this.sliding) return;
        this.sliding = true;

        let margin = 0;
        if (parseInt(this.slide.style.marginLeft) == 0) {
            margin = - this.viewportWidth;
        }

        $(this.slide).animate( {
            "margin-left": margin + "px"
        }, 500, function() {
            this.sliding = false;
        }.bind(this));
    }

    reset() {
        this.slide.style.marginLeft = 0;
    }
}

