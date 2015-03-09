<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js" type="text/javascript"></script>
<script src="//code.jquery.com/ui/1.11.1/jquery-ui.min.js" type="text/javascript"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/masonry/3.2.2/masonry.pkgd.min.js" type="text/javascript"></script>
<script src="//www.appelsiini.net/projects/lazyload/jquery.lazyload.min.js" type="text/javascript"></script>
<script>
    $(window).load(function () {

        var container = document.querySelector('#masonryContainer');
        var msnry = new Masonry(container, {
            itemSelector: '.masonryItem',
            columnWidth: 135,
            // isFitWidth: true,
            gutter: 40
        });

        $("img.lazy").lazyload();
        threshold : 200;
        effect: "fadeIn";

    });
</script>
<?php
// list of scripts to include in page footer
echo $this->Html->script(
        array(
            'AdminLTE/app.js',
//            'plugins/input-mask/jquery.inputmask.numeric.extensions',
//            'plugins/input-mask/jquery.inputmask',
//            'plugins/input-mask/jquery.inputmask.date.extensions',
//            'plugins/input-mask/jquery.inputmask.regex.extensions'
        )
);
?>
<script>
    (function (i, s, o, g, r, a, m) {
        i['GoogleAnalyticsObject'] = r;
        i[r] = i[r] || function () {
            (i[r].q = i[r].q || []).push(arguments)
        }, i[r].l = 1 * new Date();
        a = s.createElement(o),
                m = s.getElementsByTagName(o)[0];
        a.async = 1;
        a.src = g;
        m.parentNode.insertBefore(a, m)
    })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

    ga('create', 'UA-60541550-1', 'auto');
    ga('send', 'pageview');

</script>