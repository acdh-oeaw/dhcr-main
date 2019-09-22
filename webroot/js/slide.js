
'use strict';

class Slider {
    constructor(elm) {
        this.sliding = false;
        this.element = elm;
        this.slide = this.element.firstElementChild;
        this.slide.style.marginLeft = 0;
        this.cssMargin = parseInt(window.getComputedStyle(this.slide).getPropertyValue('margin-right'));
        this.viewportWidth = parseInt(this.element.clientWidth);
        this.control = document.getElementById("slide-control");
        this.control.addEventListener('click', function() {
            this.toggle();
        }.bind(this));
    }

    updateSize() {
        this.viewportWidth = parseInt(this.element.clientWidth);
        this.cssMargin = parseInt(window.getComputedStyle(this.slide).getPropertyValue('margin-right'));
        if(parseInt(this.slide.style.marginLeft) != 0) {
            this.slide.style.marginLeft = - (this.viewportWidth + this.cssMargin) + 'px';
        }
    }

    toggle() {
        if (this.sliding) return;
        this.sliding = true;

        let margin = 0;
        let iconPosition = 'left';
        if (parseInt(this.slide.style.marginLeft) == 0) {
            margin = - (this.viewportWidth + this.cssMargin);
            iconPosition = 'right';
        }

        $(this.slide).animate( {
            "margin-left": margin + "px"
        }, 500, function() {
            this.sliding = false;
            this.control.style.backgroundPositionX = iconPosition;
        }.bind(this));
    }

    reset() {
        this.slide.style.marginLeft = 0;
        this.control.style.backgroundPositionX = 'left';
    }
}

