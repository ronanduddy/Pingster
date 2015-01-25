<?php
// list of styles to include in page header
echo $this->Html->css(
        array(
            'AdminLTE',
            'bootstrap.min',
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