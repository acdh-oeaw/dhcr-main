'use strict';

class IdpSelector {

    constructor(elementSelector, returnTo, dataSource) {
        this.element = $(elementSelector)
        this.returnTo = returnTo
        this.formAction = returnTo
        this.returnQuery = []
        this.idpList = []
        this.idpIndex = {}
        this.defaultLang = 'en'
        this.clientLang = 'en'
        this.maxResults = 10

        //this.window = window
        //this.location = this.window.location

        this.typeAhead = null

        this._init(dataSource)
    }

    _init(dataSource) {
        while (null !== this.window.parent && this.window !== this.window.parent) {
            this.window = this.window.parent
        }

        this._getReturnQuery()

        if (typeof navigator != "undefined")
            this.clientLang = navigator.language || navigator.userLanguage || this.defaultLang
        this.clientLang = this.clientLang.toLowerCase();
        if (this.clientLang.indexOf("-") > 0)
            this.clientLang = this.clientLang.substring(0, this.clientLang.indexOf("-"))


        $.getJSON(dataSource, function (data) {
            this.idpList = data
            // remove doublettes and create index
            // TODO: move this task to cron for import of organisation list
            let c = 0;
            for (let i = 0; i < data.length; i++) {
                let id = data[i].entityID;
                if(!this.idpIndex[id]) {
                    this.idpIndex[id] = c;
                    this.idpList.push(data[i])
                    c++
                }
            }
            this.idpList.sort(function (a, b) {
                return this._getDisplayName(a).localeCompare(this._getDisplayName(b))
            }.bind(this));
        }.bind(this))

        this.typeAhead = new TypeAhead(
            '#idpSelectTextBox',
            '#idpSelectSubmit',
            this.idpList,
            this.idpIndex,
            this.match,
            this.createOption
        )
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
    match(value, list) {
        let result = [];
        let c = 0;
        value = value.toLowerCase()
        for (let i = 0; c <= this.maxResults && i < this.list.length; i++) {
            let matching = false;
            let option = list[i];
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
        for (let i in entity.DisplayNames) {
            if (entity.DisplayNames[i].lang == this.defaultLang)
                return entity.DisplayNames[i].value
        }
        for (let i in entity.DisplayNames) {
            if (entity.DisplayNames[i].lang == this.clientLang)
                return entity.DisplayNames[i].value
        }
        return entity.DisplayNames[0].value
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
