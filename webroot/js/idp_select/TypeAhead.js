'use strict';
class TypeAhead {

    constructor(context, configOptions) {
        let defaultConfig = {
            textBox:    '#ta-textbox',
            submit:     '#ta-submit',
            matcherCallbackName:    'match',
            selectionCallbackName:  'select',
            unselectionCallbackName:'unselect',
            optionFactoryName:      'createOption',
            emptyOptionlistContent: false
        }
        this.config = {
            ...defaultConfig,
            ...configOptions
        }

        this.context = context
        this.textBox = $(this.config.textBox)
        //this.submit = this.config.submit
        // matching callback name, returning matchingOptions
        this.matcherCallbackName = this.config.matcherCallbackName
        // option creation callback name, returning an option
        this.optionFactoryName = this.config.optionFactoryName
        // do things in the calling context on select
        this.selectionCallbackName = this.config.selectionCallbackName
        this.unselectionCallbackName = this.config.unselectionCallbackName
        // optional - provide some html with advice what to do, if no option can be found
        this.emptyOptionlistContent = this.config.emptyOptionlistContent

        //this.options = options
        //this.optionsIndex = optionsIndex
        this.dropDown = null
        this.matchingOptions = []
        this.matchingHtmlOptions = []
        this.selected = false
        this.inputValue = ''

        this._init()
    }

    _init() {
        this.createDropdown()

        this.textBox.keyup(function(event) {
            this.inputValue = this.textBox.val()
            this.matchingOptions = this.context[this.matcherCallbackName](this.inputValue)
            let keycode = (event.keyCode ? event.keyCode : event.which)
            // exclude all modifier keys from re-drowing the option list (show())
            let excludeKeys = [38,40,223,16,225,17,91,18,93]
            if(this.inputValue.length === 0) {
                this.unselect()
                this.hide()
            }else if(!excludeKeys.includes(keycode)) {
                this.unselect()
                this.populate()
            }
            if(!this.emptyOptionlistContent && this.matchingOptions.length > 0) {
                this.show()
            }else if(this.emptyOptionlistContent && this.inputValue.length > 0) {
                this.show()
            }
        }.bind(this))

        // handle arrow up/down
        this.textBox.keydown(function(event) {
            let keycode = (event.keyCode ? event.keyCode : event.which);
            if(38 == keycode) {   // up
                event.preventDefault()
                this.upSelect()
            }
            if(40 == keycode) {   // down
                event.preventDefault()
                this.downSelect()
            }
        }.bind(this))

        // handle return event
        this.textBox.keydown(function(event) {
            let keycode = (event.keyCode ? event.keyCode : event.which);
            if(keycode == 13) {
                event.preventDefault()
                this.textBox.blur()
            }
        }.bind(this))

        this.textBox.blur(function(event) {
            this.hide()
        }.bind(this))

        this.textBox.focus(function() {
            this.textBox.val(this.inputValue)
            this.show()
        }.bind(this))

        this.textBox.blur(function(event) {
            let text = ''
            if(this.selected !== false)
                text = this.matchingHtmlOptions[this.selected].text()
            this.textBox.val(text)
        }.bind(this))

        this.textBox.focus()
    }

    createDropdown() {
        this.dropDown = $('<ul></ul>')
        this.dropDown.addClass('idpSelectDropDown')
        this.dropDown.css('display','none')
        this.dropDown.insertAfter(this.textBox)
    }

    populate() {
        this.dropDown.empty()
        this.matchingHtmlOptions = []
        for(let i = 0; i < this.matchingOptions.length; i++) {
            // retrieve option html from callback function, passing on the matching data object
            let option = this.context[this.optionFactoryName](this.matchingOptions[i], '<li></li>')
            this.dropDown.append(option)
            this.matchingHtmlOptions.push(option)
            // prevent the click event stealing focus (textbox blur handler firing)
            option.on('mousedown', function(event) {
                event.preventDefault()
            }.bind(this))
            option.on('click', function(event) {
                this.select(i)
                this.textBox.blur()
            }.bind(this))
        }

        if(this.emptyOptionlistContent && this.matchingOptions.length == 0)
            this.dropDown.append(this.emptyOptionlistContent)
    }

    show() {
        if(this.matchingOptions.length < 1) return
        this.dropDown.css('display','block')
        this.dropDown.css('width', this.textBox.offsetWidth + "px")
        this.textBox.attr("aria-expanded", "true")
    }

    hide() {
        this.dropDown.css('display','none')
        this.textBox.attr("aria-expanded", "false");
    }

    upSelect() {
        if(this.selected === false)
            this.select(this.matchingOptions.length - 1)
        else if(this.selected === 0)
            this.unselect()
        else
            this.select(this.selected - 1)
    }

    downSelect() {
        if(this.selected === false && this.matchingOptions.length >= 1)
            this.select(0)
        else if(this.selected === this.matchingOptions.length - 1)
            this.unselect()
        else
            this.select(this.selected + 1)
    }

    select(index) {
        this.selected = index;
        this.dropDown.children().attr('aria-selected', false)
        this.dropDown.children().removeClass('selected')
        if(index === false) return
        let target = $(this.matchingHtmlOptions[index])
        target.addClass('selected')
        target.attr('aria-selected', true)

        if(this._isCallable(this.selectionCallbackName))
            this.context[this.selectionCallbackName](target.attr('aria-value'))
    }

    unselect() {
        this.selected = false;
        this.dropDown.children().attr('aria-selected', false)
        this.dropDown.children().removeClass('selected')

        if(this._isCallable(this.unselectionCallbackName))
            this.context[this.unselectionCallbackName]()
    }

    _isCallable(name) {
        if(typeof name !== 'undefined'
            && name
            && typeof this.context[name] === 'function')
            return true
        return false
    }
}
