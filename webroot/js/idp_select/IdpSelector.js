'use strict';

class IdpSelector {

    constructor(elementSelector, target, dataSource) {
        this.element = $(elementSelector)
        this.target = target
        this.idpList = {}
        this.defaultLang = 'en'
        this.maxResults = 10
        this.typeAhead = null
        this._init(dataSource)
    }

    _init(dataSource) {
        $.getJSON(dataSource, function (data) {
            // file should be free of doublettes and sorted
            this.idpList = data
            this.draw()
            this.typeAhead = new TypeAhead(
                this, {
                    textBox:    '#idpSelectTextBox',
                    submit:     '#idpSelectSubmit',
                    matcherCallbackName:    'match',
                    selectionCallbackName:  'select',
                    optionFactoryName:      'createOption',
                    emptyOptionlistContent: $('<li aria-role="empty">Please use our <a href="/users/register">registration form</a>, if you cannot find your institution</li>')
                }
            )
        }.bind(this))
    }

    draw() {
        let options = [$('<option aria-value="empty" selected>-- Pick from List --</option>')]
        let keys = Object.keys(this.idpList)
        for (let i = 0; i < keys.length; i++) {
            let entity = this.idpList[keys[i]];
            options.push(this.createOption(entity, '<option></option>'))
        }
        let select = $('<select name="select_box" id="idpList" class="inputAlternative" style="display:none"></select>')
        select.append(options)
        select.on('change', function(event) {
            let value = $($('#idpList')[0].options[$('#idpList')[0].selectedIndex]).attr('aria-value')
            if(value !== 'empty') {
                this.select(value)
            }else {
                this.unselect()
            }
        }.bind(this))
        this.element.append($('<h2>Federated Login</h2>'))
        this.element.append($('<p></p>').append('Use your institutional account to log in.<br>\n' +
            'If your organisation is not available in the list of institutions below, \n' +
            'please use the <a href="/users/register" className="small button">registration form</a> ' +
            'and classic login.'))
        this.element.append($('<div class="users form"></div>')
            .append($('<form method="get" accept-charset="utf-8" autocomplete="off" action="https://dhcr.clarin-dariah.eu/Shibboleth.sso/Login"></form>')
                .append($('<div class="input text taWrapper"></div>')
                    .append($('<label for="ta-box">Your Organisation</label>'))
                    .append($('<input type="text" name="ta_box" placeholder="Type to search..." id="idpSelectTextBox" class="inputAlternative">'))
                    .append(select))
                .append($('<input type="hidden" name="SAMLDS" id="samlds" value="1">'))
                .append($('<input type="hidden" name="target" id="target" value="'+this.target+'">'))
                .append($('<input type="hidden" name="entityID" id="entityID">'))
                .append($('<button class="right" disabled="disabled" type="submit" id="idpSelectSubmit">Continue</button>'))
            ))
        let classicButton = $('<a href="/users/sign-in#classic" class="blue button small">Classic Login</a>')
        classicButton.click(function(e) {
            e.preventDefault()
            $('.loginAlternative').toggle()
        }.bind(this))
        let searchButton = $('<a href="#idpSearch" class="blue button small inputAlternativeButton" style="display:none">Organization Search</a>')
        let listButton = $('<a href="#idpList" class="blue button small inputAlternativeButton">Organization List</a>')
        listButton.click(function(e) {
            e.preventDefault()
            $('.inputAlternative').toggle()
            $('.inputAlternativeButton').toggle()
            this.unselect()
        }.bind(this))
        searchButton.click(function(e) {
            e.preventDefault()
            $('.inputAlternative').toggle()
            $('.inputAlternativeButton').toggle()
            this.unselect()
        }.bind(this))
        this.element.append($('<div id="login-alternatives"></div>')
            .append(searchButton)
            .append(listButton)
            .append($('<a href="/users/register" class="small button">Registration</a>'))
            .append(classicButton))
    }

    // matching handler to be called by the TypeAhead on change
    match(value) {
        if(value.length == 0) return []
        let result = [];
        let c = 0;
        value = value.toLowerCase()
        let keys = Object.keys(this.idpList)
        for (let i = 0; c < this.maxResults && i < keys.length; i++) {
            let matching = false;
            let entity = this.idpList[keys[i]];
            if(this._getDisplayName(entity).toLowerCase().indexOf(value) != -1) {
                matching = true
            }
            if(!matching && entity.entityID.toLowerCase().indexOf(value) != -1) {
                matching = true
            }
            if(!matching) {
                var keywords = this._getKeywords(entity);
                if (null != keywords && keywords.toLowerCase().indexOf(value) != -1) {
                    matching = true
                }
            }
            if(matching) {
                result.push(entity);
                c++
            }
        }
        return result
    }

    createOption(entity, tag) {
        return $(tag)
            .attr("role", "option")
            .attr('aria-value', entity.entityID)
            .html(this._getDisplayName(entity))
    }

    select(value) {
        $('#idpSelectSubmit').prop("disabled", false)
        $('#entityID').val(value)
    }

    unselect() {
        $('#idpSelectSubmit').prop("disabled", true)
        $('#entityID').val('')
    }

    _getDisplayName(entity) {
        if(typeof entity.DisplayNames == 'object'
            && entity.DisplayNames.length >= 1) {
            for (let i in entity.DisplayNames) {
                if (entity.DisplayNames[i].lang == this.defaultLang)
                    return entity.DisplayNames[i].value
            }
            return entity.DisplayNames[0].value
        }else{
            // in some cases there are no display names, just the Id (an URI)
            return entity.entityID
        }
    }

    _getKeywords(entity) {
        if (null == entity.Keywords) {
            return null
        }
        for (let i in entity.Keywords) {
            if (entity.Keywords[i].lang == this.defaultLang)
                return entity.Keywords[i].value
        }
        return entity.Keywords[0].value
    }
}
