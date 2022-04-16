
'use strict';

class Sitemap extends Modal {


    constructor() {
        super('Sitemap', 'sitemap', null);
        this.add($('<hr>'));
        this.add($('#sitemap').html());
    }

    show(e) {
        e.preventDefault();
        super.create();
        this.addAccordeonHandlers();
    }

    addAccordeonHandlers() {
        if ($('#accordeon').length) {
            $.each($('#modal-wrapper.sitemap ul.' + this.sitemapClassname + ' li a'), function (i, item) {
                $(item).on('click', function (e) {
                    e.preventDefault();
                    let href = $(e.target).attr("href");
                    this.accordeon.openHash(href.substring(href.indexOf('#') + 1));
                    this.close();
                }.bind(this));
            }.bind(this));
        }
    }

    setAccordeonHandler(accordeon, sitemapClassname) {
        this.accordeon = accordeon;
        this.sitemapClassname = sitemapClassname;
    }
}
