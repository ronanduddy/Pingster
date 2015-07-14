<?php
// list of styles to include in page header
echo $this->Html->css(
        array(
            'AdminLTE',
            'ionicons.min',
            'font-awesome.min',
        //'generic'
        )
);
echo $this->Html->charset();
echo $this->fetch('meta');
echo $this->fetch('css');
echo $this->fetch('script');
?>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<meta name="robots" content="noindex, nofollow">
<meta name="robots" content="noimageindex">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
<link rel="shortcut icon" href="<?php echo $this->webroot . 'favicon.ico'; ?>">

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
  <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
<![endif]-->

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
