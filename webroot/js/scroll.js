class Scrollable {

  defaults() {
    return {
      thumbWidth: 9,
      thumbColor: '#00aa00',
      trackWidth: 1,
      trackColor: '#1b6d85'
    }
  }

  constructor(elm, options) {
    if(!options) options = this.defaults();
    else options = {...this.defaults(), ...options};

    this.thumbWidth = options.thumbWidth;
    this.thumbColor = options.thumbColor;
    this.trackWidth = options.trackWidth;
    this.trackColor = options.trackColor;

    this.dragging = false;
    this.lastY = 0;

    // store the element the behavior is created on, get important box dimensions like padding
    // content will be moved to an inner container, while scrollbar is created in the outer element
    this.element = elm;
    let outerStyles = window.getComputedStyle(this.element, null);
    this.systemScrollbarWidth = Scrollable.getSystemScrollbarWidth();
    this.paddingTop = parseInt(outerStyles.getPropertyValue('padding-top'));
    this.paddingBottom = parseInt(outerStyles.getPropertyValue('padding-bottom'));
    this.paddingRight = parseInt(outerStyles.getPropertyValue('padding-right'));
    this.margin = 50 + this.systemScrollbarWidth + this.paddingRight;
    this.backPadding = this.margin + this.trackWidth - this.systemScrollbarWidth;
    if(this.thumbWidth > this.trackWidth)
      this.backPadding = this.margin + this.thumbWidth - this.systemScrollbarWidth;
    Object.assign(this.element.style, {
      position: 'relative',
      overflow: 'hidden'
    });

    let padding = this.paddingTop + this.paddingBottom;
    this.track = document.createElement("div");
    this.track.classList.add("track");
    let offsetRight = 0;
    if(this.trackWidth < this.thumbWidth) offsetRight = (this.thumbWidth - this.trackWidth) / 2;
    Object.assign(this.track.style, {
      width: this.trackWidth + 'px',
      height: this.element.clientHeight - padding + 'px',
      backgroundColor: this.trackColor,
      right: offsetRight + this.paddingRight / 2 + 'px',
      position: 'absolute',
      display: 'none'
    });

    this.thumb = document.createElement("div");
    this.thumb.classList.add("thumb");
    offsetRight = 0;
    if(this.trackWidth > this.thumbWidth) offsetRight = (this.trackWidth - this.thumbWidth) / 2;
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
    this.container.classList.add('scroll-container');

    this.container.innerHTML = this.element.innerHTML;
    this.element.innerHTML = this.container.outerHTML;
    this.element.insertBefore(this.thumb, this.element.firstChild);
    this.element.insertBefore(this.track, this.element.firstChild);
    // pick the rendered element from the DOM to retrieve proper box sizing!
    this.container = this.element.lastChild;

    // We are on Safari, where we need to use the sticky trick!
    if (getComputedStyle(this.element).webkitOverflowScrolling) {
      this.container.isIOS = true;
      this.thumb.style.right = "";
      this.thumb.style.left = "100%";
      this.thumb.style.position = "-webkit-sticky";
    }

    this.scrollState = false;

    this.scrollListener = function() {
      this.updateScrollPosition()
    }.bind(this);

    this.dragStartListener = function(e) {
      this.dragStart(e)
    }.bind(this);

    this.dragMoveListener = function(e) {
      this.dragMove(e)
    }.bind(this);

    this.dragEndListener = function(e) {
      this.dragEnd(e)
    }.bind(this);

    let f = function() {
      this.updateSize()
    };

    requestAnimationFrame(f.bind(this));
    window.addEventListener("resize", f.bind(this));

    // updateSize will test for scrollable content and will enable/disable the scroller
    this.updateSize();
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
      marginRight: - this.margin + 'px',
      paddingRight: this.backpadding + 'px',
      height: '100%'
    });

    let viewport = this.container.getBoundingClientRect();
    let scrollHeight = this.container.scrollHeight;
    let maxScrollTop = scrollHeight - viewport.height;
    let thumbHeight = Math.pow(viewport.height, 2) / scrollHeight;
    let maxTopOffset = viewport.height - thumbHeight;

    let test = this.isScrollable();
    // revert styles after test isScrollable
    Object.assign(this.container.style, style);

    let newScrollbarWidth = Scrollable.getSystemScrollbarWidth();
    if(this.systemScrollbarWidth != newScrollbarWidth) {
      this.systemScrollbarWidth = newScrollbarWidth;
      this.margin = 50 + this.systemScrollbarWidth + this.paddingRight;
      this.backPadding = this.margin + this.trackWidth - this.systemScrollbarWidth;
      if(this.thumbWidth > this.trackWidth)
        this.backPadding = this.margin + this.thumbWidth - this.systemScrollbarWidth;
      if(this.scrollState) {
          Object.assign(this.container.style, {
              marginRight: -this.margin + 'px',
              paddingRight: this.backpadding + 'px'
          });
      }
    }

    if(test) {
      // test for prior state
      if(!this.scrollState) this.enable();
      this.thumbScaling = maxTopOffset / maxScrollTop;
      this.thumb.style.height = `${thumbHeight}px`
    }else{
      if(this.scrollState) this.disable()
    }
  }

  isScrollable() {
    let viewport = this.container.getBoundingClientRect();
    let scrollHeight = this.container.scrollHeight;
    let maxScrollTop = scrollHeight - viewport.height;

    return (maxScrollTop >= 1)
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

    this.thumb.style.top = thumbScrollTop + this.paddingTop + 'px'
  }

  static getSystemScrollbarWidth() {
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
      height: 'auto',
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
      marginRight: - this.margin + 'px',
      paddingRight: this.backPadding + 'px',
      height: '100%',
      webkitOverflowScrolling: 'touch'
    });

    this.track.style.display = 'block';
    this.thumb.style.display = 'block';

    this.container.addEventListener('scroll', this.scrollListener);
    this.thumb.addEventListener('mousedown', this.dragStartListener, { passive: true });
    window.addEventListener('mousemove', this.dragMoveListener);
    window.addEventListener('mouseup', this.dragEndListener, { passive: true });
    this.thumb.addEventListener('touchstart', this.dragStartListener, { passive: true });
    window.addEventListener('touchmove', this.dragMoveListener);
    window.addEventListener('touchend', this.dragEndListener, { passive: true });

    this.scrollState = true
  }

}


