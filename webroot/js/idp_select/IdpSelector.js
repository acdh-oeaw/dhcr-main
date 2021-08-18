'use strict';

class IdpSelector {

    constructor(elementSelector, returnTo, dataSource) {
        this.element = $(elementSelector)
        this.returnTo = returnTo
        this.formAction = returnTo
        this.returnQuery = []
        this.idpList = {}
        this.idpIndex = []
        this.defaultLang = 'en'
        this.maxResults = 10
        this.typeAhead
        this._init(dataSource)
    }

    _init(dataSource) {
        this._getReturnQuery()

        $.getJSON(dataSource, function (data) {
            // file should be free of doublettes and sorted
            this.idpList = data
            this.idpIndex = Object.keys(this.idpList)
        }.bind(this))

        this.draw()

        this.typeAhead = new TypeAhead(
            '#idpSelectTextBox',
            '#idpSelectSubmit',
            this.idpList,
            this.idpIndex,
            this.match,
            this.createOption
        )
    }

    draw() {
        this.element.append($('<h2>Federated Login</h2>'))
        this.element.append($('<p></p>').append('Use your institutional account to log in.<br>\n' +
            'If your organisation is not available in the list of institutions below, \n' +
            'please use the <a href="/users/register" className="small button">registration form</a> ' +
            'and classic login.'))
        this.element.append($('<div class="users form"></div>')
            .append($('<form method="get" accept-charset="utf-8" autocomplete="off" action="https://dhcr.clarin-dariah.eu/Shibboleth.sso/Login"></form>')
                .append($('<div class="input text"></div>')
                    .append($('<label for="ta-box">Your Organisation</label>'))
                    .append($('<input type="text" name="ta_box" placeholder="Type to search..." id="idpSelectTextBox">')))
                .append($('<input type="hidden" name="SAMLDS" id="samlds" value="1">'))
                .append($('<input type="hidden" name="target" id="target">'))
                .append($('<input type="hidden" name="entityID" id="entityid">'))
                .append($('<button class="right" disabled="disabled" type="submit" id="idpSelectSubmit">Continue</button>'))
            ))
        this.element.append($('<div id="login-alternatives"></div>')
            .append($('<a href="#" class="blue button small">Organization List</a>'))
            .append($('<a href="/users/register" class="small button">Registration</a>'))
            .append($('<a href="/users/signIn#classic" class="blue button small">Classic Login</a>')))
    }

    createOption(entity) {
        let result = []
        /*
        let logo = this._getLogo16x16(entity)
        if(logo) {
            let img = $('<img>').src = logo
            img.width = 16
            img.height = 16
            result.push(img)
        }
         */
        result.push($('<span></span>').innerText = this._getDisplayName(entity))
    }
    /*
    _getLogo16x16(entity) {
        if (null == entity.Logos) {
            return null
        }
        for (let i = 0; i < entity.Logos.length; i++) {
            var logo = entity.Logos[i];
            if (logo.height == "16" && logo.width == "16") {
                if (null == logo.lang)
                    return logo.value
                if(this.defaultLang == logo.lang || this.clientLang == logo.lang)
                    return logo.value
            }
        }
        return null
    }
    */
    // matching handler to be called by the TypeAhead on change
    match(value) {
        let result = [];
        let c = 0;
        value = value.toLowerCase()
        for (let i = 0; c <= this.maxResults && i < this.idpList.length; i++) {
            let matching = false;
            let option = this.idpList.length[i];
            if(this._getDisplayName(option).toLowerCase().indexOf(value) != -1) {
                matching = true
            }
            if(!matching && option.entityID.toLowerCase().indexOf(value) != -1) {
                matching = true
            }
            if(!matching) {
                var keywords = this._getKeywords(option);
                if (null != keywords && keywords.toLowerCase().indexOf(value) != -1) {
                    matching = true
                }
            }
            if(matching) {
                result.push(option);
                c++
            }
        }
        return result
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
        for (let i in entity.Keywords) {
            if (entity.Keywords[i].lang == this.clientLang)
                return entity.Keywords[i].value
        }
        return entity.Keywords[0].value
    }

    _getReturnQuery() {
        if (this.returnTo.indexOf("?") > 0) {
            this.formAction = this.returnTo.substring(0, this.returnTo.indexOf("?"));
            let queryString = this.returnTo.substring(this.returnTo.indexOf("?") + 1);
            let querySplit = queryString.split("&");
            for (let i = 0; i < querySplit.length; i++) {
                let paramSplit = querySplit[i].split("=");
                if (typeof paramSplit[1] == 'undefined' || !paramSplit[1])
                    paramSplit[1] = null
                else paramSplit[1] = decodeURIComponent(paramSplit[1]);
                this.returnQuery.push(paramSplit)
            }
        }
    }

}
