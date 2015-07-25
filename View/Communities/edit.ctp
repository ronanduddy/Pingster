
<div class="col-lg-6 col-lg-offset-3">
    <div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title"><?php echo h(preg_replace('/(\w+)([A-Z])/U', '\\1 \\2', ucfirst($this->params['action']))); ?></h3>
        </div>
        <div class="box-body">
<?php echo $this->Form->create('Community'); ?>

        <div class="form-group required">
            <label class="control-label col-lg-4" for="ProjectDescription">Description</label>
            <div class="col-lg-8">
            <?php
                echo $this->Form->textarea('Community.description', array(
                    'class' => 'form-control',
                    'style' => 'resize: vertical;',
                    'rows' => '5',
                    'maxlength' => '250',
                    'placeholder' => 'What\'s it all about?'
                ));
            ?>
            </div>
        </div>
<?php echo $this->Form->end(__('Submit')); ?>
</div>