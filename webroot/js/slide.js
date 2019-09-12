
'use strict';

class Slider {
    constructor(elm) {
        this.sliding = false;
        this.element = elm;
        this.slide = this.element.firstElementChild;
        this.slide.style.marginLeft = 0;
        this.viewportWidth = parseInt(this.element.clientWidth);
        this.control = document.getElementById("slide-control");
        this.control.addEventListener('click', function() {
            this.toggle();
        }.bind(this));
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
        let cssMargin = parseInt(window.getComputedStyle(this.slide).getPropertyValue('margin-right'));
        if (parseInt(this.slide.style.marginLeft) == 0) {
            margin = - (this.viewportWidth + cssMargin);
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

