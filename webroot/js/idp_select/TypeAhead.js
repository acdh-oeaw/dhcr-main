'use strict';
class TypeAhead {

    constructor(textboxSelector, submitSelector, options, optionsIndex, matcher, optionFactory) {
        this.textBox = $(textboxSelector)
        this.submit = $(submitSelector)
        this.dropDown = null
        this.dropDown.className = 'idpSelectDropDown'
        this.selected = null
        this.options = options
        this.optionsIndex = optionsIndex
        this.matchingOptions = []
        this.matcher = matcher  // matching callback
        this.optionFactory = optionFactory
    }

    _init() {
        this.textBox.change(function() {
            let value = this.textBox.val();
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
        var b;
        var f;
        for(let i = 0; i < this.matchingOptions.length; i++) {
            let item = $('<li></li>')
            item.append(this.optionsFactory(this.matchingOptions[i]))
            item.attr("role", "option");
            this.dropDown.append(item);
        }
    }
}
