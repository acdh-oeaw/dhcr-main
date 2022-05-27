
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

        this.position = 0;

        this.control.addEventListener('click', function () {
            this.toggle();
        }.bind(this));

        this.dragStartListener = function (e) {
            this.dragStart(e)
        }.bind(this);

        this.dragMoveListener = function (e) {
            this.dragMove(e)
        }.bind(this);

        this.dragEndListener = function (e) {
            this.dragEnd(e)
        }.bind(this);
    }

    // dragging is not a good idea on a map!!! further problem is the toggle control...
    enableDragging() {
        this.container.addEventListener('mousedown', this.dragStartListener, { passive: true });
        window.addEventListener('mousemove', this.dragMoveListener);
        window.addEventListener('mouseup', this.dragEndListener, { passive: true });
        this.container.addEventListener('touchstart', this.dragStartListener, { passive: true });
        window.addEventListener('touchmove', this.dragMoveListener);
        window.addEventListener('touchend', this.dragEndListener, { passive: true });
    }

    disableDragging() {
        this.container.removeEventListener('mousedown', this.dragStartListener);
        window.removeEventListener('mousemove', this.dragMoveListener);
        window.removeEventListener('mouseup', this.dragEndListener);
        this.container.removeEventListener('touchstart', this.dragStartListener);
        window.removeEventListener('touchmove', this.dragMoveListener);
        window.removeEventListener('touchend', this.dragEndListener);
    }

    showControl() {
        $(this.control).show();
    }

    hideControl() {
        $(this.control).hide();
    }

    updateSize() {
        this.viewportWidth = parseInt(this.container.clientWidth);
        this.cssMargin = parseInt(window.getComputedStyle(this.slide).getPropertyValue('margin-right'));
        if (parseInt(this.slide.style.marginLeft) != 0) {
            this.slide.style.marginLeft = - (this.viewportWidth + this.cssMargin) + 'px';
        }
    }

    toggle() {
        if (this.sliding) return;
        this.sliding = true;

        let margin = 0;
        let iconPosition = 'left';
        this.position = 0;
        if (parseInt(this.slide.style.marginLeft) == 0) {
            // "map" state
            margin = - (this.viewportWidth + this.cssMargin);
            iconPosition = 'right';
            this.position = 1;
        }

        $(this.slide).animate({
            "margin-left": margin + "px"
        }, 500, function () {
            this.sliding = false;
            this.control.style.backgroundPositionX = iconPosition;
        }.bind(this));
    }

    reset() {
        this.slide.style.marginLeft = 0;
        this.control.style.backgroundPositionX = 'left';
        this.position = 0;
    }

    setPosition(position = 0) {
        if (position == 0 || position == 'table') {
            if (this.position == 1) this.toggle();
        }
        if (position == 1 || position == 'map') {
            if (this.position == 0) this.toggle();
        }
    }


    dragStart(event) {
        this.dragging = true;
        this.container.style.pointerEvents = "none";
        this.container.style.userSelect = "none";
        this.move = 0;

        this.lastX =
            event.clientX || event.clientX === 0
                ? event.clientX
                : event.touches[0].clientX
    }

    dragMove(event) {
        if (!this.dragging) return;
        event.preventDefault();

        let clientX =
            event.clientX || event.clientX === 0
                ? event.clientX
                : event.touches[0].clientX;

        this.move += clientX - this.lastX;
        this.lastX = clientX;

        let sensitivity = 3;

        // swipe to right - show left screen
        if (this.move > (this.viewportWidth + this.cssMargin) / sensitivity) {
            if (this.position == 1) this.toggle();
        }
        // swipe to left (negative) - show rihgt screen
        if (this.move < - (this.viewportWidth + this.cssMargin) / sensitivity) {
            if (this.position == 0) this.toggle();
        }
    }

    dragEnd(event) {
        this.dragging = false;
        this.container.style.pointerEvents = "initial";
        this.container.style.userSelect = "initial"
        this.move = 0;
    }
}

