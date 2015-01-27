<?php //debug($data);      ?>
<div class="col-lg-3">
    <div class="box box-primary" id="content">
        <div class="box-header">
            <h3 class="box-title">
                Make a Ping!
            </h3>
        </div>
        <div class="box-body">
            <?php if ($current_user['group_id'] == 1) : ?>
                <div class="callout callout-warning">
                    <h4>Known Issue</h4>
                    <p>When creating a ping you will be logged out for some reason. The ping will be still be created though. It's advised to create a ping from the 'Projects' link on the left.</p>
                </div>
            <?php endif; ?>
            <div class="thumbnail" style="background-color: #e8535d">
                <?php echo $this->Html->image('pingster.png'); ?>
            </div>
            The Ping world awaits you...
        </div>
        <div class="box-footer">
            <p> 
                This is a list of all the Pings that are set to 'Public'. 
                This means that they are viewable, commentable and their assets are downloadable to anyone on Pingster. 
                Want to upload a Ping?
            </p>
            <p style="text-align: right">
                <?php
                echo $this->Html->link('Create new Ping', array('controller' => 'Projects', 'action' => 'addPing'), array('title' => 'Create a Ping project', 'class' => 'btn btn-default'));
                ?>
            </p>
        </div>
    </div>      
</div>
<?php if (!empty($data)): ?>
    <?php foreach (array_reverse($data) as $projectKey => $projectData) : ?>
        <div class="col-lg-3">

            <div class="box box-primary">
                <div class="box-header">
                    <i class="fa fa-folder-o"></i>
                    <h3 class="box-title">
                        <?php echo h(preg_replace('/(\w+)([A-Z])/U', '\\1 \\2', ucfirst($projectData['Project']['title']))); ?>
                        <small><?php echo h(ucfirst($projectData['Project']['status']) . ' ' . ucfirst($projectData['Project']['kind'])); ?></small>
                    </h3>
                </div>

                <div class="box-body">
                    <div class="thumbnail">
                        <?php echo $this->Html->image($projectData['Project']['image_url']); ?>
                    </div>
                    <?php if ($projectData['Tag'] != null) : ?>
                        <?php foreach ($projectData['Tag'] as $tag) : ?>
                            <?php echo '<br>#' . h($tag['tag_content']); ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <div class="box-footer">
                    <p style="text-align: right">
                        <?php
                        echo $this->Html->link('View', array('controller' => 'Projects', 'action' => 'viewPing', $projectData['Project']['id']), array('title' => 'View this Ping', 'class' => 'btn btn-primary'));
                        ?>
                    </p>
                </div>

            </div>      
        </div>
    <?php endforeach; ?>

    <p>
        <?php
        echo $this->Paginator->counter(array(
            'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
        ));
        ?>	</p>
    <div class="paging">
        <?php
        echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
        echo $this->Paginator->numbers(array('separator' => ''));
        echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
        ?>
    </div>

<?php endif;