
'use strict';

class Sitemap extends Modal{


    constructor() {
        super('Sitemap', 'sitemap', null);
        this.add($('<hr>'));
        this.add($('#sitemap').html());
    }

    show(e) {
        e.preventDefault();
        super.create();
    }
}
