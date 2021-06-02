

<script type="text/javascript">
    var _paq = _paq || [];
    // tracker methods like "setCustomDimension" should be called before "trackPageView"
    _paq.push(['trackPageView']);
    _paq.push(['enableLinkTracking']);

    (function() {
        var u="//matomo.acdh.oeaw.ac.at/";
        _paq.push(['setTrackerUrl', u+'piwik.php']);
        _paq.push(['setSiteId', '21']);
        var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
        g.type='text/javascript'; g.async=true; g.defer=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);
    })();

    window.addEventListener('hashchange', function() {
        _paq.push(['setCustomUrl', '/' + window.location.hash.substr(1)]);
        _paq.push(['setDocumentTitle', window.location.hash.substr(1)]);
        _paq.push(['setGenerationTimeMs', 0]);
        if(typeof previousPageUrl != 'undefined')
            _paq.push(['setReferrerUrl', previousPageUrl]);
        _paq.push(['enableLinkTracking']);
        _paq.push(['trackPageView']);
    });
</script>
