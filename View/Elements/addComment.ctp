<div class="col-lg-6">

    <div class="box box-success">

        <div class="box-header">
            <i class="fa fa-comments-o"></i>
            <h3 class="box-title">Comments</h3>
        </div>

        <div class="box-body">
            <?php
            // create form
            echo $this->Form->create('Comment', array(
                'action' => 'commentOnPing',
                'type' => 'file'
            ));

            // for Comment model
            // user_id
            echo $this->Form->input('Comment.user_id', array(
                //'value' => $project['User'][0]['id'],
                'value' => $current_user['id'],
                'type' => 'hidden',
            ));

            // for Comment model
            // project_id
            echo $this->Form->input('Comment.project_id', array(
                'value' => $project['Project']['id'],
                'type' => 'hidden',
            ));

            // for Comment model
            // project_id
            echo $this->Form->input('Comment.project_id', array(
                'value' => $project['Project']['id'],
                'type' => 'hidden',
            ));

            // for Comment model:
            // comment 
            echo $this->Form->input('Comment.comment', array(
                'class' => 'form-control',
                'label' => 'Comment'
            ));

            // for Asset model
            // user_id
            echo $this->Form->input('Asset.user_id', array(
                //'value' => $project['User'][0]['id'],
                'value' => $current_user['id'],
                'type' => 'hidden',
            ));

            // for Asset model:
            // add asset to ping through comment (image)
            echo $this->Form->input('Asset.asset', array(
                'type' => 'file',
                'label' => 'Upload something',
                'class' => '',
                'required' => false
            ));

            // for Asset model:
            // add asset_url to ping through comment (image)
            echo $this->Form->input('Asset.asset_url', array('type' => 'hidden'));

            // project id for project-asset join table
            // helps during asset->saveAssociated(..)
            echo $this->Form->input('Project.id', array(
                'value' => $project['Project']['id'],
                'type' => 'hidden',
            ));
            ?>
        </div>

        <div class="box-footer">
            <div style="text-align: right">
                <?php
                // submit
                echo $this->Form->submit('Add', array(
                    'class' => 'btn btn-success',
                    'div' => false,
                ));

                // end form
                echo $this->Form->end();
                ?>
            </div>
        </div>

    </div>

    <div class="content" id="commentsBlock">
      <?php echo $this->element('getComments'); ?>
    </div>

</div>
