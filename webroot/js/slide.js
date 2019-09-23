
'use strict';

class Slider {
    constructor(elm) {
        this.sliding = false;
        this.container = elm;
        this.slide = this.container.firstElementChild;
        this.slide.style.marginLeft = 0;
        this.cssMargin = parseInt(window.getComputedStyle(this.slide).getPropertyValue('margin-right'));
        this.viewportWidth = parseInt(this.container.clientWidth);
        this.control = document.getElementById("slide-control");
        this.control.addEventListener('click', function() {
            this.toggle();
        }.bind(this));
    }

    updateSize() {
        this.viewportWidth = parseInt(this.container.clientWidth);
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

    setPosition(position = 0) {
        if(position == 0 || position == 'table') {
            this.slide.style.marginLeft = 0;
            this.control.style.backgroundPositionX = 'left';
        }
        if(position == 1 || position == 'map') {
            this.slide.style.marginLeft = - (this.viewportWidth + this.cssMargin) + 'px';
            this.control.style.backgroundPositionX = 'right';
        }
    }


    dragStart(event) {
        this.dragging = true;
        this.container.style.pointerEvents = "none";
        this.container.style.userSelect = "none";

        this.lastX =
            event.clientX || event.clientX === 0
                ? event.clientX
                : event.touches[0].clientX
    }

    dragMove(event) {
        if (!this.dragging) return;
        let clientX =
            event.clientX || event.clientX === 0
                ? event.clientX
                : event.touches[0].clientX;
    //this.container.scrollTop += (clientX - this.lastY) / this.thumbScaling;
        this.lastX = clientX;
        event.preventDefault()
    }

    dragEnd(event) {
        this.dragging = false;
        this.container.style.pointerEvents = "initial";
        this.container.style.userSelect = "initial"
    }
}

