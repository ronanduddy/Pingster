<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<?php
echo $this->Html->css('jQueryUI/jquery-ui-1.10.3.custom.min');
echo $this->Html->script('Projects');
?>

<script language="Javascript">

    $(document).ready(function() {
                 docRoot = '<?php echo FULL_BASE_URL; ?>';
    });
</script>

<div class="col-lg-6 col-lg-offset-3">
    <div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title"><?php echo h(preg_replace('/(\w+)([A-Z])/U', '\\1 \\2', ucfirst($this->params['action']))); ?></h3>
        </div>
        <div class="box-body">
            <?php
            // create form to add a team up
            echo $this->Form->create('Project', array(
                'action' => 'addTeamUp',
                'type' => 'file'
            ));

            // for User model:
            // for hidden input to contain user.id for user-project join/link table
            echo $this->Form->input('User.id', array('value' => $user['id']));

            // for project model:            
            // hidden input to contain project type/kind
            echo $this->Form->input('Project.kind', array('value' => 'team_up', 'type' => 'hidden'));

            // for project model:
            // title
            echo $this->Form->input('Project.title', array(
                'label' => 'Give your Team Up a name',
                'placeholder' => 'Bebop'));
            ?>
            <div class="form-group required">
                <label class="control-label col-lg-4" for="ProjectDescription">Description</label>
                <div class="col-lg-8">
                    <?php
                    // for Project model:
                    // description 
                    echo $this->Form->textarea('Project.description', array(
                        'class' => 'form-control',
                        'style' => 'resize: vertical;',
                        'rows' => '5',
                        'maxlength' => '140',
                        'placeholder' => 'What\'s it all about?'
                    ));
                    ?>  
                </div>
            </div>
            <?php

            echo $this->Form->input('Project.tags', array(
                'class' => 'form-control',
                'maxlength' => '140',
                'placeholder' => 'Adventure, Game, Fun, Space'
            ));

            echo $this->Form->input('Project.members', array(
                'label' => 'Team Members',
                'class'=>'form-control'));

            echo $this->Form->input('Project.user_ids', array(
                 'type' => 'hidden'));

            echo $this->Form->input('Project.status', array(
                'options' => array(
                    'private' => 'Private',
                    'public' => 'Public'
                ),
                'label' => 'Visibility',
            ));

            echo $this->Form->input('Project.image', array(
                'type' => 'file',
                'label' => 'Take a screen shot and upload it',
                'class' => '',
                'required' => true,
            ));

            // for Project model:
            // image_url
            echo $this->Form->input('Project.image_url', array('type' => 'hidden', 'required' => true,));
            ?>
        </div>

        <div class="box-footer" style="text-align: right">
            <div class="btn-group">
                <?php
                // submit
                echo $this->Form->submit('Create Ping', array(
                    'class' => 'btn btn-primary',
                    'div' => false,
                ));

                if (isset($namedParams['community'])) {
                    echo $this->Html->link('Back', array('controller' => 'communities', 'action' => 'view', $namedParams['community']), array('title' => 'Go back to your community', 'class' => 'btn btn-default'));
                } else {
                    echo $this->Html->link('Back', array('controller' => 'Projects', 'action' => 'myPings'), array('title' => 'Go back to the Ping page', 'class' => 'btn btn-default'));
                }

                // end
                echo $this->Form->end();
                ?>
            </div>
        </div>
    </div>

</div>

<?php echo $this->Js->writeBuffer(); ?>