<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js" type="text/javascript"></script>
<script src="//code.jquery.com/ui/1.11.1/jquery-ui.min.js" type="text/javascript"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/excite-bike/jquery-ui.css" type="text/css" />
<script src="//cdnjs.cloudflare.com/ajax/libs/masonry/3.2.2/masonry.pkgd.min.js" type="text/javascript"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/holder/2.5.2/holder.min.js" type="text/javascript"></script>
<script src="holder.js"></script>
<script>
    $(window).load(function () {

        var container = document.querySelector('#masonryContainer');
        var msnry = new Masonry(container, {
            itemSelector: '.masonryItem',
            columnWidth: 135,
            // isFitWidth: true,
            gutter: 40
        });

    });

    $(function () {
        $("img.lazy").lazyload({effect: "fadeIn", threshold: 200, skip_invisible:false});
    });
</script>
<?php
// list of scripts to include in page footer
echo $this->Html->script(
        array(
            'AdminLTE/app.js',
            'lazy.min.js'
//            'plugins/input-mask/jquery.inputmask.numeric.extensions',
//            'plugins/input-mask/jquery.inputmask',
//            'plugins/input-mask/jquery.inputmask.date.extensions',
//            'plugins/input-mask/jquery.inputmask.regex.extensions'
        )
);
