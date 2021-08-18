'use strict';
class TypeAhead {

    constructor(textboxSelector, submitSelector, options, optionsIndex, matcher, optionFactory) {
        this.textBox = $(textboxSelector)
        this.submit = $(submitSelector)
        this.dropDown = null
        this.selected = null
        this.options = options
        this.optionsIndex = optionsIndex
        this.matchingOptions = []
        this.matcher = matcher  // matching callback
        this.optionFactory = optionFactory

        this._init()
    }

    _init() {
        this.createDropdown()
        this.textBox.keyup(function() {
            let value = this.textBox.val();
            console.log(value)
            this.matchingOptions = this.matcher(value);
            if(0 === value.length || 0 === this.matchingOptions.length) {
                // hide
                this.hide()
            }else{
                // show
                this.show()
            }
        }.bind(this))

        this.textBox.keydown(function(event) {
            let keycode = (event.keyCode ? event.keyCode : event.which);
            if (38 == keycode)    // arrow-up
                this.upSelect()
            if (40 == keycode)    // arrow-down
                this.downSelect()
        }.bind(this))

        this.textBox.blur(this.hide())
    }

    createDropdown() {
        this.dropDown = $('<ul></ul>')
        this.dropDown.addClass('idpSelectDropDown')
        this.dropDown.css('display','none')
        for(let i = 0; i < this.matchingOptions.length; i++) {
            let item = $('<li></li>')
            item.append(this.optionsFactory(this.matchingOptions[i]))
            item.attr("role", "option");
            this.dropDown.append(item);
        }
    }

    show() {
        this.dropDown.css('display','block')
        this.dropDown.style.width = this.textBox.offsetWidth + "px";
        this.textBox.attr("aria-expanded", "true")
    }

    hide() {
        this.dropDown.css('display','none')
        this.textBox.attr("aria-expanded", "false");
        if (-1 == this.dropDown.current) {
            //this.doUnselected()
        }
    }
}
