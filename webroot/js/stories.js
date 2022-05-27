
'use strict';

class Content {

    constructor() {
        this.entries = [{
            title: "DH Course Registry Hackathon: The Winners & their Projects",
            link: "https://digital-humanities.at/en/dha/s-project/acdh-ch-open-data-virtual-hackathon-round-two"
        }, {
            title: "Invitation: DH Course Regsitry open WG meeting",
            link: "https://www.dariah.eu/2021/04/22/dh-course-registry-open-working-group-meeting/"
        }, {
            title: "New Languages for NLP - Building Lingusitic Diversity in DH",
            link: "https://www.dariah.eu/2020/10/30/dariah-partners-up-with-princeton-university-to-deliver-nlp-training-for-humanists/"
        }, {
            title: "Position Paper on digitised Cultural Heritage",
            link: "https://hal.archives-ouvertes.fr/hal-02961317/document"
        }, {
            title: "Teaching Digital Humanities Around the World: An Infrastructural Approach to a Community-Driven DH Course Registry",
            link: "https://hal.archives-ouvertes.fr/hal-02500871/document"
        }, {
            title: "What's DH and how did it get there?",
            link: "https://blogs.brandeis.edu/library/2012/10/09/whats-digital-humanities-and-how-did-it-get-here/"
        }, {
            title: "Digging into the Past - Tara Andrews (Semesterfrage)",
            link: "https://medienportal.univie.ac.at/uniview/semesterfrage/ws-201617/detailansicht/artikel/digital-digging-into-the-past/"
        }, {
            title: "Digital Humanities Course Registry",
            link: "https://dhcr.clarin-dariah.eu/"
        }, {
            title: "Mapping the gay guides: Visualizing Queer Space &amp; American Life",
            link: "https://www.mappingthegayguides.org/",
            publication_date: "2021-06-02 17:25:00"
        }, {
            title: "Lesbian and Gay Liberation in Canada",
            link: "https://lglc.ca/",
            publication_date: "2021-06-07 14:45:00"
        }, {
            title: "The Intersex Mapping Study",
            link: "https://www.dcu.ie/intersex",
            publication_date: "2021-06-09 15:45:00"
        }];
    }

    load() {
        let today = new Date();
        let ci = 0;
        for (var i = 0, len = this.entries.length; i < len; i++) {
            if (typeof this.entries[i].publication_date != 'undefined'
                && new Date(this.entries[i].publication_date) > today) continue;

            let classname = (ci % 2 == 0) ? 'linklist-list-element-green' : 'linklist-list-element-blue';
            let item = '<li class="' + classname + '"><a href="' + this.entries[i].link + '">' + this.entries[i].title + '</a></li>';
            $("#stories").append(item);
            ci++;
        }
    }
}
