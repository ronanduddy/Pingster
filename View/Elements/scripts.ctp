<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
<?php
// list of scripts to include in page footer
echo $this->Html->script(
        array(
            'bootstrap.min',
            'jquery-ui-1.10.3.min',
            'AdminLTE/app.js',
//            'plugins/input-mask/jquery.inputmask.numeric.extensions',
//            'plugins/input-mask/jquery.inputmask',
//            'plugins/input-mask/jquery.inputmask.date.extensions',
//            'plugins/input-mask/jquery.inputmask.regex.extensions'
        )
);
?>
