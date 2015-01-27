<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js" type="text/javascript"></script>
<script src="//code.jquery.com/ui/1.11.1/jquery-ui.min.js" type="text/javascript"></script>
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
