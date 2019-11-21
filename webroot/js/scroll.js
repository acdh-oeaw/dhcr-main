'use strict';

class Scrollable {

    defaults() {
        return {
            //selector: '#table',
            thumbWidth: 7,
            thumbColor: '#1E6BA3',
            trackWidth: 1,
            trackColor: '#6d7278',
            contentContainerClass: 'scroll-container'
        }
    }

    constructor(elm, options) {
        if (!options) options = this.defaults();
        else options = {...this.defaults(), ...options};

        this.thumbWidth = options.thumbWidth;
        this.thumbColor = options.thumbColor;
        this.trackWidth = options.trackWidth;
        this.trackColor = options.trackColor;
        this.contentContainerClass = options.contentContainerClass;

        this.dragging = false;
        this.lastY = 0;

        // store the container the behavior is created on, get important box dimensions like padding
        // content will be moved to an inner container, while scrollbar is created in the outer container
        this.element = elm;
        let outerStyles = window.getComputedStyle(this.element, null);
        this.systemScrollbarWidth = Scrollable.getSystemScrollbarWidth();
        this.paddingTop = parseInt(outerStyles.getPropertyValue('padding-top'));
        this.paddingBottom = parseInt(outerStyles.getPropertyValue('padding-bottom'));
        this.paddingRight = parseInt(outerStyles.getPropertyValue('padding-right'));
        this.margin = 50 + this.systemScrollbarWidth;
        this.backPadding = this.margin + this.trackWidth - this.systemScrollbarWidth + this.paddingRight;
        if (this.thumbWidth > this.trackWidth)
            this.backPadding = this.margin + this.thumbWidth - this.systemScrollbarWidth + this.paddingRight;
        Object.assign(this.element.style, {
            position: 'relative',
            overflow: 'hidden'
        });

        this.track = document.createElement("div");
        this.track.classList.add("track");
        let offsetRight = 0;
        if (this.trackWidth < this.thumbWidth) offsetRight = (this.thumbWidth - this.trackWidth) / 2;
        Object.assign(this.track.style, {
            width: this.trackWidth + 'px',
            height: this.element.clientHeight - this.paddingTop - this.paddingBottom + 'px',
            backgroundColor: this.trackColor,
            right: offsetRight + this.paddingRight / 2 + 'px',
            position: 'absolute',
            display: 'none'
        });

        this.thumb = document.createElement("div");
        this.thumb.classList.add("thumb");
        offsetRight = 0;
        if (this.trackWidth > this.thumbWidth) offsetRight = (this.trackWidth - this.thumbWidth) / 2;
        Object.assign(this.thumb.style, {
            width: this.thumbWidth + 'px',
            borderRadius: Math.floor(this.thumbWidth / 2) + 'px',
            backgroundColor: this.thumbColor,
            position: 'absolute',
            transformOrigin: 'top right',
            top: this.paddingTop + 'px',
            right: offsetRight + this.paddingRight / 2 + 'px',
            cursor: 'pointer',
            pointerEvents: 'initial',
            display: 'none'
        });

        this.container = document.createElement('div');
        this.container.classList.add(this.contentContainerClass);

        this.container.innerHTML = this.element.innerHTML;
        this.element.innerHTML = this.container.outerHTML;
        this.element.insertBefore(this.thumb, this.element.firstElementChild);
        this.element.insertBefore(this.track, this.element.firstElementChild);
        // pick the rendered container from the DOM to retrieve proper box sizing!
        this.container = this.element.lastElementChild;

        // We are on Safari, where we need to use the sticky trick!
        if (getComputedStyle(this.element).webkitOverflowScrolling) {
            this.container.isIOS = true;
            this.thumb.style.right = "";
            this.thumb.style.left = "100%";
            this.thumb.style.position = "-webkit-sticky";
        }

        this.scrollState = false;

        this.scrollListener = function () {
            this.updateScrollPosition()
        }.bind(this);

        this.dragStartListener = function (e) {
            this.dragStart(e)
        }.bind(this);

        this.dragMoveListener = function (e) {
            this.dragMove(e)
        }.bind(this);

        this.dragEndListener = function (e) {
            this.dragEnd(e)
        }.bind(this);

        let f = function () {
            this.updateSize()
        };

        requestAnimationFrame(f.bind(this));
        window.addEventListener("resize", f.bind(this));

        // updateSize will test for scrollable content and will enable/disable the scroller
        //this.updateSize();
        // make first call to updateSize programmatically in App class
    }

    getContentContainer() {
        return this.container;
    }

    dragStart(event) {
        this.dragging = true;
        this.container.style.pointerEvents = "none";
        this.container.style.userSelect = "none";

        this.lastY =
            event.clientY || event.clientY === 0
                ? event.clientY
                : event.touches[0].clientY
    }

    dragMove(event) {
        if (!this.dragging) return;
        let clientY =
            event.clientY || event.clientY === 0
                ? event.clientY
                : event.touches[0].clientY;
        this.container.scrollTop += (clientY - this.lastY) / this.thumbScaling;
        this.lastY = clientY;
        event.preventDefault()
    }

    dragEnd(event) {
        this.dragging = false;
        this.container.style.pointerEvents = "initial";
        this.container.style.userSelect = "initial"
    }

    // The point of this function is to update the thumb's geometry to reflect
    // the amount of overflow.
    updateSize() {
        let style = {
            overflowX: this.container.style.overflowX,
            overflowY: this.container.style.overflowY,
            marginRight: this.container.style.marginRight,
            paddingRight: this.container.style.paddingRight,
            height: this.container.style.height
        };
        // apply styles for testing
        Object.assign(this.container.style, {
            overflowX: 'hidden',
            overflowY: 'hidden',
            marginRight: -this.margin + 'px',
            paddingRight: this.backpadding + 'px',
            height: '100%'
        });

        let scrollHeight = this.container.scrollHeight;
        let maxScrollTop = scrollHeight - this.container.clientHeight;
        let thumbHeight = parseInt(this.track.style.height) * this.container.clientHeight / scrollHeight;
        //let thumbHeight = Math.pow(this.container.clientHeight, 2) / scrollHeight;
        let maxTopOffset = this.container.clientHeight - thumbHeight;

        let test = this.isScrollable();
        // revert styles after test isScrollable
        Object.assign(this.container.style, style);

        let newScrollbarWidth = Scrollable.getSystemScrollbarWidth();

        if(this.systemScrollbarWidth != newScrollbarWidth) {
            // after zooming, recalculate the negative margin effect, as scrollbar width changes
            this.systemScrollbarWidth = newScrollbarWidth;
            this.margin = 50 + this.systemScrollbarWidth + this.paddingRight;
            this.backPadding = this.margin + this.trackWidth - this.systemScrollbarWidth;
            if(this.thumbWidth > this.trackWidth)
                this.backPadding = this.margin + this.thumbWidth - this.systemScrollbarWidth;
            if(this.scrollState) {
                Object.assign(this.container.style, {
                    marginRight: -this.margin + 'px',
                    paddingRight: this.backpadding + 10 + 'px'
                });
            }
        }

        if(test) {
            // test for prior state
            if(!this.scrollState) this.enable();
            // if outer styles have changed...
            let outerStyles = window.getComputedStyle(this.element, null);
            this.paddingTop = parseInt(outerStyles.getPropertyValue('padding-top'));
            this.paddingBottom = parseInt(outerStyles.getPropertyValue('padding-bottom'));
            this.thumbScaling = maxTopOffset / maxScrollTop;
            //this.thumbScaling = thumbHeight / this.container.clientHeight;
            this.thumb.style.height = `${thumbHeight}px`;
            this.track.style.height = this.element.clientHeight - this.paddingTop - this.paddingBottom + 'px';
            this.updateScrollPosition();
        }else{
            if(this.scrollState) this.disable();
        }
    }

    isScrollable() {
        let outerStyles = window.getComputedStyle(this.container, null);
        let height = parseInt(outerStyles.getPropertyValue('height'));
        let viewport = this.container.getBoundingClientRect();
        let scrollHeight = this.container.scrollHeight;
        let maxScrollTop = scrollHeight - viewport.height;
        // for modal, this test seems not to get the correct box sizes

        return (maxScrollTop >= 1);
    }

    top() {
        $(this.container).animate({
            scrollTop: 0
        }, 1000);
    }

    updateScrollPosition() {
        let height = this.container.clientHeight;
        let thumbHeight = this.thumb.clientHeight;
        let maxScrollTop = height - thumbHeight;

        // do not scroll over maxScrollTop in viewport container
        let thumbScrollTop = this.container.scrollTop * this.thumbScaling;
        thumbScrollTop = (thumbScrollTop <= maxScrollTop)
            ? thumbScrollTop
            : maxScrollTop;

        this.thumb.style.top = thumbScrollTop + this.paddingTop + 'px';
    }

    static getSystemScrollbarWidth() {
        // if no scrollbar is present, we need to trigger display of the scrollbar for this test
        let height = document.body.style.height;
        let overflow = document.body.style.overflowY;
        document.body.style.height = '200vh';
        document.body.style.overflowY = 'scroll';
        let retval = window.innerWidth - document.documentElement.clientWidth;
        document.body.style.height = height;
        document.body.style.overflowY = overflow;
        return retval;
    }

    disable() {
        Object.assign(this.container.style, {
            overflowX: 'hidden',
            overflowY: 'hidden',
            marginRight: 0,
            paddingRight: 0,
            height: '100%',     // height: auto - set to 100% in favour of loading animation
            webkitOverflowScrolling: 'none'
        });

        this.track.style.display = 'none';
        this.thumb.style.display = 'none';

        this.scrollState = false;

        this.container.removeEventListener('scroll', this.scrollListener);
        this.thumb.removeEventListener('mousedown', this.dragStartListener);
        window.removeEventListener('mousemove', this.dragMoveListener);
        window.removeEventListener('mouseup', this.dragEndListener);
        this.thumb.removeEventListener('touchstart', this.dragStartListener);
        window.removeEventListener('touchmove', this.dragMoveListener);
        window.removeEventListener('touchend', this.dragEndListener)
    }

    enable() {
        Object.assign(this.container.style, {
            overflowX: 'hidden',
            overflowY: 'scroll',
            marginRight: -this.margin + 'px',
            paddingRight: this.backPadding + 10 + 'px',
            height: '100%',
            webkitOverflowScrolling: 'touch'
        });

        this.track.style.display = 'block';
        this.thumb.style.display = 'block';

        this.container.addEventListener('scroll', this.scrollListener);
        this.thumb.addEventListener('mousedown', this.dragStartListener, {passive: true});
        window.addEventListener('mousemove', this.dragMoveListener);
        window.addEventListener('mouseup', this.dragEndListener, {passive: true});
        this.thumb.addEventListener('touchstart', this.dragStartListener, {passive: true});
        window.addEventListener('touchmove', this.dragMoveListener);
        window.addEventListener('touchend', this.dragEndListener, {passive: true});

        this.scrollState = true
    }

}


